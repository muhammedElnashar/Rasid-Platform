<?php

namespace App\Services;

use App\Models\RechargeCard;
use App\Models\RechargeCardUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RechargeService
{
    protected $userService;

    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
    }
    /**
     * تنفيذ عملية الشحن
     */
    public function recharge(User $user, string $code, string $settlementCode): array
    {
        // التحقق من كود التسوية
        if ($user->settlement_code !== $settlementCode) {
            $this->logFailedAttempt($user, $code);
            return $this->checkAccountLock($user, 'كود الشحن غير صحيح');
        }

        // التحقق من الكرت
        $card = RechargeCard::where('code', $code)->first();
        if (!$card) {
            $this->logFailedAttempt($user, $code);
            return $this->checkAccountLock($user, 'الكرت غير موجود');
        }

        $rechargeCardUser = RechargeCardUser::where('card_id', $card->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$rechargeCardUser) {
            $this->logFailedAttempt($user, $code);
            return $this->checkAccountLock($user, 'هذا الكرت غير موجه لك');
        }

        if (!$rechargeCardUser->is_active) {
            $this->logFailedAttempt($user, $code);
            return $this->checkAccountLock($user, 'الكرت غير مفعل');
        }

        if ($rechargeCardUser->used_count >= $rechargeCardUser->max_uses) {
            $this->logFailedAttempt($user, $code);
            return $this->checkAccountLock($user, 'تم استهلاك الكرت بالكامل');
        }

        // ✅ الكود صحيح → نصفر المحاولات
        DB::transaction(function () use ($user, $card, $rechargeCardUser) {
            $user->fixed_points += $card->points;
            $user->flexible_points += $card->points;
            $user->save();

            $rechargeCardUser->increment('used_count');

            // تصفير المحاولات الفاشلة
            DB::table('recharge_failed_attempts')->where('user_id', $user->id)->delete();
        });

        return ['status' => true, 'message' => 'تم شحن الرصيد بنجاح'];
    }

    /**
     * تسجيل المحاولة الفاشلة
     */
    protected function logFailedAttempt(User $user, string $code): void
    {
        DB::table('recharge_failed_attempts')->insert([
            'user_id' => $user->id,
            'code_attempted' => $code,
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * فحص عدد المحاولات وتجميد الحساب لو لزم
     */
    protected function checkAccountLock(User $user, string $message): array
    {
        $failedCount = DB::table('recharge_failed_attempts')
            ->where('user_id', $user->id)
            ->count();

        if ($failedCount >= 3) {
            $this->userService->suspendUser($user);

            return [
                'status' => false,
                'message' => 'تم إيقاف حسابك بعد 3 محاولات فاشلة. تواصل مع الإدارة لإعادة التفعيل.'
            ];
        }

        return ['status' => false, 'message' => $message];
    }
}
