<?php

namespace App\Services;

use App\Enum\StatusEnum;
use App\Models\BehaviorLog;
use App\Models\CardItem;
use App\Models\User;
use App\Models\Group;
use App\Traits\HasIssuedModel;

class LogServices
{
    use HasIssuedModel;

    private function generateUniqueIssueNumber(): string
    {
        do {
            $number = 'Re' . str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (BehaviorLog::where('issue_number', $number)->exists());

        return $number;
    }

    public function storeLogs(array $data, User $issuer)
    {
        $item = CardItem::findOrFail($data['card_item_id']);
        $issuedModel = $this->getIssuedModel($data['issued_to_type'], $data['issued_to_id']);

        return BehaviorLog::create([
            'school_id' => $issuer->school_id,
            'issued_to_id' => $issuedModel->id,
            'issued_to_type' => $data['issued_to_type'],
            'issuer_by' => $issuer->id,
            'card_item_id' => $item->id,
            'issue_number' => $this->generateUniqueIssueNumber(),
            'points_value' => $item->points,
            'active' => $data['active'] ?? true,
            'log_date' => now(),
            'status' => StatusEnum::Pending,
        ]);
    }

    public function updateLogs(array $data, User $issuer, BehaviorLog $log)
    {
        $item = CardItem::findOrFail($data['card_item_id']);
        $issuedModel = $this->getIssuedModel($data['issued_to_type'], $data['issued_to_id']);

        $log->update([
            'issued_to_id' => $issuedModel->id,
            'issued_to_type' => $data['issued_to_type'],
            'issuer_by' => $issuer->id,
            'card_item_id' => $item->id,
            'points_value' => $item->points,
            'active' => $data['active'] ?? true,
        ]);

        return $log;
    }

    public function approve(BehaviorLog $log)
    {
        if (!$log->active) {
            return $log;
        }

        $issuedModel = $this->getIssuedModel($log->issued_to_type, $log->issued_to_id);
        $value = abs($log->points_value);

        $this->applyPoints($issuedModel, $log->points_value, $value);

        $log->update(['status' => StatusEnum::Approved]);
        return $log;
    }

    public function reject(BehaviorLog $log)
    {
        $log->update(['status' => StatusEnum::Rejected]);
    }

    public function activation(BehaviorLog $log): void
    {
        $newActive = !$log->active;

        if ($log->status === StatusEnum::Approved) {
            $issuedModel = $this->getIssuedModel($log->issued_to_type, $log->issued_to_id);
            $value = abs($log->points_value);

            if ($newActive) {
                $this->applyPoints($issuedModel, $log->points_value, $value);
            } else {
                $this->applyPoints($issuedModel, -$log->points_value, $value);
            }
        }

        $log->update(['active' => $newActive]);
    }

    private function applyPoints($model, int $points, int $value): void
    {
        if (!in_array('fixed_points', $model->getFillable()) || !in_array('flexible_points', $model->getFillable())) {
            return;
        }

        if ($points > 0) {
            $model->increment('fixed_points', $value);
            $model->increment('flexible_points', $value);
        } else {
            $model->decrement('fixed_points', $value);
            $model->decrement('flexible_points', $value);
        }
    }
}
