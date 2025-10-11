<?php

namespace App\Services;

use App\Models\DeductionCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeductionCardService
{
    /**
     * تطبيق أفضل بطاقة خصم على المستخدم أو المجموعة
     */
    public function applyBestCard(Model $issuedTo)
    {
        return DB::transaction(function () use ($issuedTo) {
            if ($issuedTo->fixed_points <= 0) {
                return null;
            }

            $negativePoints = abs($issuedTo->current_negative_points);
            // اختيار أفضل بطاقة بناءً على الشروط
            $card = DeductionCard::where('threshold', '<=', $negativePoints)
                ->whereDoesntHave('userDeductionCards', function ($query) use ($issuedTo) {
                    $query->where('issued_to_id', $issuedTo->id)
                        ->where('issued_to_type', $issuedTo->getMorphClass())
                        ->where('cycle_number', $issuedTo->current_cycle);
                })
                ->orderBy('deduction_percent', 'desc')
                ->first();

            if (! $card) {
                return null;
            }

            // تأكيد عدم تكرار نفس البطاقة في نفس الدورة
            if (! $issuedTo->deductionCards()
                ->wherePivot('cycle_number', $issuedTo->current_cycle)
                ->where('deduction_card_id', $card->id)
                ->exists()) {

                $issuedTo->deductionCards()->attach($card->id, [
                    'applied_at' => now(),
                    'cycle_number' => $issuedTo->current_cycle,
                    'negative_points_at_time' => $issuedTo->current_negative_points,
                ]);
            }

            // تطبيق التأثير
            if ($card->deduction_percent >= 100) {
                $issuedTo->flexible_points = 0;
                $issuedTo->current_negative_points = 0;
                $issuedTo->current_cycle += 1;
            } elseif ($card->deduction_percent > 0) {
                $deduction = intval($issuedTo->flexible_points * ($card->deduction_percent / 100));
                $issuedTo->flexible_points = max(0, $issuedTo->flexible_points - $deduction);
            }

            $issuedTo::withoutEvents(function () use ($issuedTo) {
                $issuedTo->save();
            });

            return [
                'card' => $card,
                'deducted' => $card->deduction_percent > 0,
                'reset_cycle' => $card->deduction_percent >= 100,
            ];
        });
    }
}
