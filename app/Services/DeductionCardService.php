<?php

namespace App\Services;

use App\Models\User;
use App\Models\DeductionCard;
use Illuminate\Support\Facades\DB;

class DeductionCardService
{
    public function applyBestCard(User $user)
    {
        return DB::transaction(function () use ($user) {
            if ($user->flexible_points <= 0) {
                return null;
            }

            $negativePoints = abs($user->current_negative_points);

            $card = DeductionCard::where('threshold', '<=', $negativePoints)
                ->where('deduction_percent', '>', 0) // تجاهل البطاقات التي لا تخصم نقاط (alert)
                ->whereDoesntHave('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('cycle_number', $user->current_cycle);
                })
                ->orderBy('deduction_percent', 'desc')
                ->first();

            if (!$card) {
                return null;
            }

            $user->deductionCards()->attach($card->id, [
                'applied_at' => now(),
                'cycle_number' => $user->current_cycle,
                'negative_points_at_time' => $user->current_negative_points,
            ]);

            if ($card->deduction_percent >= 100) {
                $user->flexible_points = 0;
                $user->current_negative_points = 0;
                $user->current_cycle += 1;
            } elseif ($card->deduction_percent > 0) {
                $deduction = intval($user->flexible_points * ($card->deduction_percent / 100));
                $user->flexible_points = max(0, $user->flexible_points - $deduction);
            }

            $user->save();

            return $card;
        });
    }
}
