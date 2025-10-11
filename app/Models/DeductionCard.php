<?php

namespace App\Models;

use App\Enum\DeductionCardTypeEnum;
use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Model;

class DeductionCard extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'type',
        'description',
        'threshold',
        'deduction_percent',
    ];
    protected $casts = [
        'type' => DeductionCardTypeEnum::class,
    ];

    // جميع المستخدمين اللي عندهم البطاقة
    public function users()
    {
        return $this->morphedByMany(User::class, 'issued_to', 'user_deduction_cards')
            ->withPivot(['applied_at', 'cycle_number', 'negative_points_at_time'])
            ->withTimestamps();
    }

    // جميع المجموعات اللي عندها البطاقة
    public function groups()
    {
        return $this->morphedByMany(Group::class, 'issued_to', 'user_deduction_cards')
            ->withPivot(['applied_at', 'cycle_number', 'negative_points_at_time'])
            ->withTimestamps();
    }

    public function userDeductionCards()
    {
        return $this->hasMany(UserDeductionCard::class);
    }
}
