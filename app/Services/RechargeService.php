<?php

namespace App\Services;

use App\Models\RechargeCard;
use App\Models\RechargeCardUser;
use Illuminate\Support\Facades\DB;

class RechargeService
{
    protected UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    /**
     * تنفيذ عملية الشحن سواء للمستخدم أو المجموعة
     */
    public function recharge($entity, string $code, string $settlementCode): array
    {
        // ✅ التحقق من كود التسوية
        if ($entity->settlement_code !== $settlementCode) {
            $this->logFailedAttempt($entity, $code);
            return $this->checkLock($entity, 'كود الشحن غير صحيح');
        }

        // ✅ البحث عن الكرت
        $userCard = RechargeCardUser::where('code', $code)->first();
        if (!$userCard) {
            $this->logFailedAttempt($entity, $code);
            return $this->checkLock($entity, 'الكرت غير صحيح');
        }

        // ✅ جلب الكرت الأساسي
        $card = RechargeCard::find($userCard->card_id);
        if (!$card) {
            $this->logFailedAttempt($entity, $code);
            return $this->checkLock($entity, 'بيانات الكرت غير موجودة');
        }

        // ✅ التأكد من أن الكرت مخصص للكيان الحالي
        if (
            $userCard->issued_to_id !== $entity->id ||
            $userCard->issued_to_type !== get_class($entity)
        ) {
            $this->logFailedAttempt($entity, $code);
            return $this->checkLock($entity, 'هذا الكرت غير مخصص لك');
        }

        if (!$userCard->is_active) {
            $this->logFailedAttempt($entity, $code);
            return $this->checkLock($entity, 'الكرت غير مفعل');
        }

        if ($userCard->used_count >= $userCard->max_uses) {
            $this->logFailedAttempt($entity, $code);
            return $this->checkLock($entity, 'تم استهلاك الكرت بالكامل');
        }

        // ✅ تنفيذ عملية الشحن داخل معاملة
        DB::transaction(function () use ($entity, $card, $userCard) {
            $entity->increment('fixed_points', $card->points);
            $entity->increment('flexible_points', $card->points);

            $userCard->increment('used_count');

            // ✅ تصفير المحاولات السابقة بعد نجاح الشحن
            DB::table('recharge_failed_attempts')
                ->where('issued_to_id', $entity->id)
                ->where('issued_to_type', get_class($entity))
                ->delete();
        });

        return [
            'status' => true,
            'message' => 'تم شحن الرصيد بنجاح ✅ (' . $card->points . ' نقطة)'
        ];
    }

    /**
     * تسجيل المحاولة الفاشلة
     */
    protected function logFailedAttempt($entity, string $code): void
    {
        DB::table('recharge_failed_attempts')->insert([
            'issued_to_id' => $entity->id,
            'issued_to_type' => get_class($entity),
            'code_attempted' => $code,
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * فحص عدد المحاولات وتجميد الحساب
     */
    protected function checkLock($entity, string $message): array
    {
        $failedCount = DB::table('recharge_failed_attempts')
            ->where('issued_to_id', $entity->id)
            ->where('issued_to_type', get_class($entity))
            ->count();

        if ($failedCount >= 3) {
            // ✅ حذف السجل بعد القيد
            DB::table('recharge_failed_attempts')
                ->where('issued_to_id', $entity->id)
                ->where('issued_to_type', get_class($entity))
                ->delete();

            if ($entity instanceof \App\Models\Group) {
                $entity->update(['active' => false]);
            } else {
                $this->userServices->suspendUser($entity);
            }

            return [
                'status' => false,
                'message' => 'تم قيد المعاملات بعد 3 محاولات فاشلة. تواصل مع الإدارة لإعادة التفعيل.',
            ];
        }

        return [
            'status' => false,
            'message' => $message,
        ];
    }
}
