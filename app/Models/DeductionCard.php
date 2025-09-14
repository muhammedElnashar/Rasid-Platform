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
        'color',
        'type',
        'description',
        'threshold',
        'deduction_percent',
    ];
    protected $casts = [
        'type' => DeductionCardTypeEnum::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_deduction_cards', 'deduction_card_id', 'user_id')
            ->withPivot(['applied_at', 'cycle_number', 'negative_points_at_time'])
            ->withTimestamps();
    }

}
