<?php

namespace App\Services;

use App\Enum\DeductionTypeEnum;
use App\Enum\PointTransactionTypeEnum;
use App\Enum\StatusCardEnum;
use App\Models\CardIssues;
use App\Models\CardItem;
use App\Models\PointTransaction;
use App\Models\User;

class CardIssueService
{


    public function updateIssueCard(array $data,User $issuer , CardIssues $cardIssue)
    {
        $cardItem = CardItem::findOrFail($data['card_item_id']);
        $cardIssue->update([
            'issued_to_type' => $data['issued_to_type'],
            'issued_to_id'   => $data['issued_to_id'],
            'issued_by' => $issuer->id,
            'card_item_id' => $cardItem->id,
            'points' => $cardItem->points,
            'deduction_type' => $data['deduction_type'] ?? null,
            'deduction_duration_days' => $data['deduction_duration_days'] ?? null,
            'is_restricted' => $data['is_restricted'] ?? false,
        ]);
        return $cardIssue;
    }

    public function issueCard(array $data, User $issuer)
    {
        $cardItem = CardItem::findOrFail($data['card_item_id']);
        $status = StatusCardEnum::Pending;

        $deductionDeadline = null;

        $cardIssue = CardIssues::create([
            'issue_number' => $this->generateUniqueIssueNumber(),
            'issued_to_type' => $data['issued_to_type'],
            'issued_to_id'   => $data['issued_to_id'],
            'card_item_id' => $cardItem->id,
            'issued_by' => $issuer->id,
            'points' => $cardItem->points,
            'deduction_type' => $data['deduction_type'] ?? null,
            'issue_date' => now(),
            'deduction_duration_days' => $data['deduction_duration_days'] ?? null,
            'deduction_deadline' => $deductionDeadline,
            'status' => $status,
            'is_restricted' => $data['is_restricted'] ?? false,
        ]);

        return $cardIssue;
    }

    public function approve(CardIssues $cardIssue)
    {
        $updateData = ['status' => StatusCardEnum::Approved];

        if ($cardIssue->deduction_type === DeductionTypeEnum::Deferred && !$cardIssue->deduction_deadline) {
            $updateData['deduction_deadline'] = $this->calculateDeadline($cardIssue->deduction_duration_days);
        }

        $cardIssue->update($updateData);

        $signedAmount = $cardIssue->points;
        if ($signedAmount < 0) {
            $recipient = $cardIssue->issuedTo; // يمكن أن يكون User أو Group
            $recipient->current_negative_points += abs($signedAmount);
            $recipient->save();
        }

        if ($cardIssue->deduction_type === DeductionTypeEnum::Immediate || is_null($cardIssue->deduction_type)) {
            $this->applyPoints($cardIssue);
        }
    }



    public function reject(CardIssues $cardIssue)
    {
        $cardIssue->update(['status' => StatusCardEnum::Rejected]);
    }

    public function settle(CardIssues $cardIssue, ?int $amount = null)
    {
        if ($cardIssue->deduction_type === DeductionTypeEnum::Deferred &&
            $cardIssue->status === StatusCardEnum::Approved) {

            $this->applyPoints($cardIssue, $amount);
        }
    }

    public function processDeferredDiscounts()
    {
        CardIssues::where('deduction_type', DeductionTypeEnum::Deferred)
            ->where('status', StatusCardEnum::Approved)
            ->where('deduction_deadline', '<=', now())
            ->whereNull('applied_at')
            ->chunk(100, function ($expiredCards) {
                foreach ($expiredCards as $card) {
                    try {
                        // ✅ خصم كامل المتبقي حتى لو الرصيد صفر
                        $this->applyPoints($card, $card->remaining_points ?? abs($card->points));
                    } catch (\Throwable $e) {
                        \Log::error("Failed to apply deferred discount for card {$card->id}: {$e->getMessage()}");
                    }
                }
            });
    }




    private function applyPoints(CardIssues $cardIssue, ?int $amount = null)
    {
        $recipient = $cardIssue->issuedTo; // User أو Group

        if (!$recipient) {
            return;
        }

        // النقاط السالبة مع Deferred
        if ($cardIssue->points < 0 && $cardIssue->deduction_type === DeductionTypeEnum::Deferred) {
            if ($cardIssue->is_restricted) {
                throw new \DomainException('لا يمكنك السداد حالياً، الكرت مقيد');
            }

            $remaining = $cardIssue->remaining_points ?? abs($cardIssue->points);

            if ($remaining <= 0) return;

            $amountToApply = $amount ?? $remaining;
            $amountToApply = min($amountToApply, $remaining);

            if ($recipient->fixed_points < $amountToApply && !($cardIssue->deduction_deadline && now()->gte($cardIssue->deduction_deadline))) {
                throw new \DomainException('ليس لديك رصيد كافي');
            }

            $signedAmount = -$amountToApply;
            $recipient->fixed_points += $signedAmount;
            $recipient->flexible_points += $signedAmount;
            $recipient->save();

            $this->recordTransaction($recipient, $cardIssue, $signedAmount);


            $cardIssue->remaining_points = $remaining - $amountToApply;
            if ($cardIssue->remaining_points <= 0) {
                $cardIssue->applied_at = now();
            }
            $cardIssue->save();
            return;
        }

        // باقي الحالات (Support أو Immediate)
        $signedAmount = $cardIssue->points;
        $recipient->fixed_points += $signedAmount;
        $recipient->flexible_points += $signedAmount;
        $recipient->save();

        $this->recordTransaction($recipient, $cardIssue, $signedAmount);


        $cardIssue->applied_at = now();
        $cardIssue->save();
    }

    private function recordTransaction($recipient, CardIssues $cardIssue, int $signedAmount)
    {
        PointTransaction::create([
            'user_id' => $recipient->id,
            'card_issue_id' => $cardIssue->id,
            'type' => $signedAmount > 0 ? PointTransactionTypeEnum::Support : PointTransactionTypeEnum::Discount,
            'points' => $signedAmount,
            'balance_after' => $recipient->fixed_points,
        ]);
    }
    private function generateUniqueIssueNumber()
    {
        do {
            $number = 'CA' . str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (CardIssues::where('issue_number', $number)->exists());

        return $number;
    }

    private function calculateDeadline(?int $days): ?\Carbon\Carbon
    {
        if (empty($days)) {
            return null;
        }
        return now()->addDays($days);
    }

    public function unrestricted(CardIssues $cardIssue)
    {
       return $cardIssue->update(['is_restricted' => false]);
    }
}

