<?php

namespace App\Services;

use App\Models\DeductionCard;
use App\Models\UserBadge;
use App\Models\UserInsignia;
use App\Models\UserLevelHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeductionCardService
{
    protected UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    /**
     * تطبيق أفضل بطاقة خصم على المستخدم أو المجموعة
     */
    public function applyBestCard(Model $issuedTo)
    {
        return DB::transaction(function () use ($issuedTo) {

            // ✅ تحقق من أن المستخدم لديه نقاط مرنة أو ثابتة سالبة
            $isNegative = $issuedTo->flexible_points < 0 || $issuedTo->fixed_points < 0;

            if ($isNegative) {
                // 🔴 نحضر الكرت الأحمر فقط
                $redCard = DeductionCard::where('deduction_percent', 100)->first();

                // تحقق من وجود الكرت الأحمر
                if (! $redCard) {
                    return null;
                }

                // ✅ نطبق الكرت الأحمر فقط إذا وصلت النقاط السالبة إلى الحد الأدنى الخاص به
                if (abs($issuedTo->current_negative_points) < $redCard->threshold) {
                    return null; // لم يصل بعد إلى الحد
                }

                // ✅ تأكد أن الكرت لم يُصدر سابقًا في نفس الدورة
                if (! $issuedTo->deductionCards()
                    ->wherePivot('cycle_number', $issuedTo->current_cycle)
                    ->where('deduction_card_id', $redCard->id)
                    ->exists()) {

                    $issuedTo->deductionCards()->attach($redCard->id, [
                        'applied_at' => now(),
                        'cycle_number' => $issuedTo->current_cycle,
                        'negative_points_at_time' => $issuedTo->current_negative_points,
                    ]);
                }

                // 🔹 تنفيذ إجراءات الكرت الأحمر
                $this->applyRedCardEffect($issuedTo);

                return [
                    'card' => $redCard,
                    'deducted' => true,
                    'reset_cycle' => true,
                ];
            }

            // ✅ في حالة النقاط الموجبة أو الصفر → يطبق الكروت الطبيعية
            $card = DeductionCard::where('threshold', '<=', abs($issuedTo->current_negative_points))
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

            // تأكد من عدم تكرار البطاقة في نفس الدورة
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

            // 🔹 تطبيق التأثير
            if ($card->deduction_percent >= 100) {
                $this->applyRedCardEffect($issuedTo);
            } else {
                $deduction = intval($issuedTo->flexible_points * ($card->deduction_percent / 100));
                $issuedTo->flexible_points = max(0, $issuedTo->flexible_points - $deduction);
                $issuedTo::withoutEvents(fn () => $issuedTo->save());
            }

            return [
                'card' => $card,
                'deducted' => $card->deduction_percent > 0,
                'reset_cycle' => $card->deduction_percent >= 100,
            ];
        });
    }

    /**
     * 🔴 تطبيق إجراءات الكرت الأحمر
     */
    protected function applyRedCardEffect(Model $issuedTo)
    {
        // تصفير النقاط
        $issuedTo->flexible_points = 0;
        $issuedTo->fixed_points = 0;
        $issuedTo->current_negative_points = 0;
        $issuedTo->current_cycle += 1;

        // حذف السجلات
        UserBadge::where('issued_to_id', $issuedTo->id)
            ->where('issued_to_type', $issuedTo->getMorphClass())
            ->delete();

        UserInsignia::where('issued_to_id', $issuedTo->id)
            ->where('issued_to_type', $issuedTo->getMorphClass())
            ->delete();

        UserLevelHistory::where('issued_to_id', $issuedTo->id)
            ->where('issued_to_type', $issuedTo->getMorphClass())
            ->delete();

        if ($issuedTo instanceof \App\Models\User) {
            $this->userServices->suspendUser($issuedTo);
        }

        $issuedTo::withoutEvents(fn () => $issuedTo->save());
    }
}
