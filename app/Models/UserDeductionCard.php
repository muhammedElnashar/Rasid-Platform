<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeductionCard extends Model
{
    protected $fillable = [
        'user_id',
        'deduction_card_id',
        'applied_at',
        'cycle_number',
        'negative_points_at_time',
    ];
    protected $casts=[
        'applied_at'=>'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deductionCard()
    {
        return $this->belongsTo(DeductionCard::class);
    }


}
