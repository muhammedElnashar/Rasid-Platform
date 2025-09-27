<?php

namespace App\Services;

use App\Enum\LogsTypeEnum;
use App\Enum\StatusEnum;
use App\Models\BehaviorLog;
use App\Models\CardItem;
use App\Models\User;

class LogServices
{
    private function generateUniqueIssueNumber()
    {
        do {
            $number = 'Re' . str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (BehaviorLog::where('issue_number', $number)->exists());

        return $number;
    }

    public function storeLogs(array $data, User $issuer)
    {
        $item = CardItem::find($data['card_item_id']);
        $status = StatusEnum::Pending;
        $logs = BehaviorLog::create([
            'school_id' => $issuer->school_id,
            'user_id' => $data['user_id'],
            'issuer_by' => $issuer->id,
            'card_item_id'=> $item->id,
            'issue_number' => $this->generateUniqueIssueNumber(),
            'points_value' => $item->points,
            'active' => $data['active'],
            'log_date' => now(),
            'status' => $status,
        ]);
        return $logs;
    }

    public function updateLogs(array $data, User $issuer, BehaviorLog $logs)
    {
        $item = CardItem::find($data['card_item_id']);

        $logs->update([
            'user_id' => $data['user_id'],
            'issuer_by' => $issuer->id,
            'card_item_id' =>$item->id,
            'points_value' => $item->points,
            'active' => $data['active'],
        ]);
        return $logs;
    }

    public function approve(BehaviorLog $log)
    {
        if ($log->active) {
            $user = $log->user;
            $value = abs($log->points_value);
            if ($log->points_value > 0){
                $user->increment('fixed_points', $value);
                $user->increment('flexible_points', $value);
            }else{
                $user->decrement('fixed_points', $value);
                $user->decrement('flexible_points', $value);
            }

        }
        $log->update(['status' => StatusEnum::Approved]);

        return $log;
    }

    public function reject(BehaviorLog $log)
    {
        $log->update(['status'=> StatusEnum::Rejected]);
    }


    public function activation(BehaviorLog $log): void
    {
        $newActive = !$log->active;

        if ($log->status === StatusEnum::Approved) {
            $user  = $log->user;
            $value = abs($log->points_value);

            if ($newActive) {
                $this->applyPoints($user, $log->points_value, $value);
            } else {
                $this->applyPoints($user, -$log->points_value, $value);
            }
        }

        $log->update(['active' => $newActive]);
    }

    private function applyPoints(User $user, int $points, int $value): void
    {
        if ($points > 0) {
            $user->increment('fixed_points', $value);
            $user->increment('flexible_points', $value);
        } else {
            $user->decrement('fixed_points', $value);
            $user->decrement('flexible_points', $value);
        }
    }

}
