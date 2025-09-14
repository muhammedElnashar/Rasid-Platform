<?php

namespace App\Services;

use App\Enum\StatusEnum;
use App\Models\PointTransfer;
use App\Models\User;

class TransferPointsServices
{
    public function transferPoint(array $data, User $sender)
    {
        return PointTransfer::create([
            'sender_id'   => $sender->id,
            'receiver_id' => $data['user_id'],
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
            $sender->flexible_points -= $transfer->amount;
            $receiver->flexible_points += $transfer->amount;

            $sender->save();
            $receiver->save();

            $transfer->status = StatusEnum::Approved;
            $transfer->save();
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
