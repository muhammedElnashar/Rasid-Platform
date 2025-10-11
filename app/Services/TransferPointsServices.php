<?php

namespace App\Services;

use App\Enum\StatusEnum;
use App\Models\Group;
use App\Models\PointTransfer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransferPointsServices
{
    public function transferPoint(array $data)
    {
        if ($data['sender_type'] === Group::class){
            $group= Group::find($data['sender_id']);

            if (!$group->active){
                return back()->with('error','المجموعه مقيده الرجاء التواصل مع الإدارة لإعادة التفعيل');
            }
            if ($group->leader_id !== Auth::id()){
                return back()->with('error','القائد فقط هوا من له هذة الصلاحية');
            }
        }
        return PointTransfer::create([
            'sender_id'     => $data['sender_id'],
            'sender_type'   => $data['sender_type'],
            'receiver_id'   => $data['receiver_id'],
            'receiver_type' => $data['receiver_type'],
            'amount'      => $data['amount'],
            'reason'      => $data['reason'],
            'purpose'     => $data['purpose'],
            'status'      => StatusEnum::Pending,
        ]);
    }

    public function addPoint(PointTransfer $transfer)
    {
        $receiver = $transfer->receiver;
        $sender = $transfer->sender;

        \DB::transaction(function () use ($transfer, $sender, $receiver) {
            $sender->decrement('flexible_points', $transfer->amount);

            $receiver->increment('flexible_points', $transfer->amount);

            $transfer->update(['status' => StatusEnum::Approved]);
        });

        return $transfer->fresh();
    }
    public function approved(PointTransfer $transfer)
    {
        if ($transfer->status !== StatusEnum::Pending) {
            return false;
        }
        return $this->addPoint($transfer);
    }
    public function rejected(PointTransfer $transfer)
    {
        if ($transfer->status !== StatusEnum::Pending) {
            return false;
        }
        return  $transfer->update(['status' => StatusEnum::Rejected]);
    }


}
