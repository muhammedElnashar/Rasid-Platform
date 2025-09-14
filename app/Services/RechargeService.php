<?php

namespace App\Services;

use App\Models\RechargeCard;
use App\Models\RechargeCardUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RechargeService
{
    /**
     * تنفيذ عملية الشحن
     */
    public function recharge(User $user, string $code, string $settlementCode): array
    {
        if ($user->settlement_code !== $settlementCode) {
            return ['status' => false, 'message' => 'كود الشحن غير صحيح'];
        }

        $card = RechargeCard::where('code', $code)->first();
        if (!$card) {
            return ['status' => false, 'message' => 'الكرت غير موجود'];
        }

        $rechargeCardUser = RechargeCardUser::where('card_id', $card->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$rechargeCardUser) {
            return ['status' => false, 'message' => 'هذا الكرت غير موجه لك'];
        }

        if (!$rechargeCardUser->is_active) {
            return ['status' => false, 'message' => 'الكرت غير مفعل'];
        }

        if ($rechargeCardUser->used_count >= $rechargeCardUser->max_uses) {
            return ['status' => false, 'message' => 'تم استهلاك الكرت بالكامل'];
        }

        DB::transaction(function () use ($user, $card, $rechargeCardUser) {
            $user->fixed_points += $card->points;
            $user->flexible_points += $card->points;
            $user->save();
            $rechargeCardUser->increment('used_count');
        });

        return ['status' => true, 'message' => 'تم شحن الرصيد بنجاح'];
    }
}
