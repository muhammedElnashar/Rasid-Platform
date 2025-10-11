<?php

namespace App\Services;

use App\Enum\StatusEnum;
use App\Models\RedemptionRequest;
use App\Models\StoreItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RedemptionRequestServices
{

    public function exchangeItem(int $itemId,$model)
    {
        $item = StoreItem::findOrFail($itemId);

        if ($model->flexible_points < $item->points_required) {
            return [
                'success' => false,
                'message' => 'رصيدك من النقاط غير كافي لتبديل هذا المنتج'
            ];
        }

        if ($item->stock <= 0) {
            return [
                'success' => false,
                'message' => 'هذا المنتج غير متوفر حاليًا'
            ];
        }

        if ($item->target_role && $item->target_role != Auth::id()){
            return [
                'success' => false,
                'message' => 'الجائزه غير متاحه لك'
            ];
        }
        if ($item->target_level_id) {
            if ($model->currentLevel === null) {
                return [
                    'success' => false,
                    'message' => 'لا يوجد مستوى حالي للمستخدم، لا يمكن استبدال الجائزة'
                ];
            }

            // الحالة الثانية: مستوى المستخدم لا يطابق مستوى الجائزة المطلوب
            if ($item->target_level_id != $model->currentLevel->id) {
                return [
                    'success' => false,
                    'message' => 'المستوى الحالي غير متاح له هذه الجائزة'
                ];
            }
        }



        DB::transaction(function () use ($item, $model) {
            $item->decrement('stock', 1);
            $model->decrement('flexible_points', $item->points_required);

            RedemptionRequest::create([
                'school_id' => $model->school_id,
                'issued_to_id'   => $model->id,
                'issued_to_type' => get_class($model),
                'item_id' => $item->id,
                'request_date' => now(),
                'status' => StatusEnum::Pending,
            ]);
        });

        return [
            'success' => true,
            'message' => 'تم تقديم طلب التبديل بنجاح'
        ];
    }


    public function approvedRequest(RedemptionRequest $request)
    {
        $delivery_code = $this->generateUniqueCode();
        $request->update([
           'status' => StatusEnum::Approved,
           'delivery_code' => $delivery_code,
        ]);
        return $request ;
    }

    public function rejectRequest(RedemptionRequest $request)
    {

        $item = StoreItem::findOrFail($request->item_id);
        $entity = $request->issuedTo; // سواء User أو Group

        DB::transaction(function () use ($item, $entity, $request) {
            $item->increment('stock', 1);
            $entity->increment('flexible_points', $item->points_required);
            $request->update(['status' => StatusEnum::Rejected]);
        });

        return $request;
    }

    private function generateUniqueCode()
    {
        do {
            $number = 'GI' . str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (RedemptionRequest::where('delivery_code', $number)->exists());

        return $number;
    }

}
