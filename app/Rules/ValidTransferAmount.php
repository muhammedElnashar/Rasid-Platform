<?php

namespace App\Rules;

use App\Models\PointTransfer;
use App\Enum\StatusEnum;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidTransferAmount implements ValidationRule
{
    protected $sender;

    public function __construct($sender)
    {
        $this->sender = $sender;
    }

    /**
     * التحقق من صلاحية المبلغ للتحويل
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 🔹 تحقق من أن المرسل موجود فعلاً
        if (!$this->sender) {
            $fail(__('message.sender_not_found'));
            return;
        }

        // 🔹 تحقق من وجود عمود الرصيد
        if (!isset($this->sender->flexible_points)) {
            $fail(__('message.sender_no_balance_field'));
            return;
        }

        // 🔹 الرصيد لا يمكن أن يكون سالب
        if ($this->sender->flexible_points < 0) {
            $fail(__('message.negative_balance'));
            return;
        }

        // 🔹 تحقق من كفاية الرصيد
        if ($this->sender->flexible_points < $value) {
            $fail(__('message.not_enough_balance'));
            return;
        }

        // ✅ حدود التحويل الأسبوعية والشهرية
        $this->checkTransferLimits($value, $fail);
    }

    /**
     * التحقق من الحد الأسبوعي والشهري
     */
    protected function checkTransferLimits($value, Closure $fail)
    {
        $senderClass = get_class($this->sender);

        // 🔹 مجموع تحويلات الأسبوع الحالي
        $weekly = PointTransfer::where('sender_id', $this->sender->id)
            ->where('sender_type', $senderClass)
            ->where('status', StatusEnum::Approved)
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->sum('amount');

        if ($weekly + $value > 300) {
            $fail(__('message.weekly_limit_exceeded', ['limit' => 300]));
            return;
        }

        // 🔹 مجموع تحويلات الشهر الحالي
        $monthly = PointTransfer::where('sender_id', $this->sender->id)
            ->where('sender_type', $senderClass)
            ->where('status', StatusEnum::Approved)
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->sum('amount');

        if ($monthly + $value > 1000) {
            $fail(__('message.monthly_limit_exceeded', ['limit' => 1000]));
        }
    }
}
