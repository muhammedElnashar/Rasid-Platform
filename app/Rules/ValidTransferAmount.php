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
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->sender->flexible_points < 0) {
            $fail(__('message.negative_balance'));
            return;
        }

        if ($this->sender->flexible_points < $value) {
            $fail(__('message.not_enough_balance'));
            return;
        }

        $weekly = PointTransfer::where('sender_id', $this->sender->id)
            ->where('status', StatusEnum::Approved)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('amount');

        if ($weekly + $value > 300) {
            $fail(__('message.weekly_limit_exceeded'));
            return;
        }

        // الحد الشهري
        $monthly = PointTransfer::where('sender_id', $this->sender->id)
            ->where('status', StatusEnum::Approved)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum('amount');

        if ($monthly + $value > 1000) {
            $fail(__('message.monthly_limit_exceeded'));
            return;
        }
    }
}
