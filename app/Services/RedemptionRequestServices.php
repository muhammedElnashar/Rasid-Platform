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

    public function exchangeItem(int $itemId)
    {
        $user = Auth::user();
        $item = StoreItem::findOrFail($itemId);

        if ($user->flexible_points < $item->points_required) {
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

        if ($item->target_level_id && $item->target_level_id != Auth::user()->currentLevel->id){
            return [
                'success' => false,
                'message' => 'المستوي الحالي غير متاح له هذة الجائزة'
            ];
        }


        DB::transaction(function () use ($item, $user) {
            $item->decrement('stock', 1);
            $user->decrement('flexible_points', $item->points_required);

            RedemptionRequest::create([
                'user_id' => $user->id,
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
        $item=StoreItem::findOrFail($request->item_id);
        $user = User::findOrFail($request->user_id);
        $item->increment('stock',1);
        $user->increment('flexible_points',$item->points_required);
        $request->update([
            'status' => StatusEnum::Rejected
        ]);
        return $request ;

    }
    private function generateUniqueCode()
    {
        do {
            $number = 'GI' . str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (RedemptionRequest::where('delivery_code', $number)->exists());

        return $number;
    }

}
