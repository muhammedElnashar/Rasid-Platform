<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeductionCard extends Model
{
    protected $fillable = [
        'issued_to_type',
        'issued_to_id',
        'deduction_card_id',
        'applied_at',
        'cycle_number',
        'negative_points_at_time',
    ];
    protected $casts=[
        'applied_at'=>'datetime',
    ];

    public function issuedTo()
    {
        return $this->morphTo();
    }

    public function deductionCard()
    {
        return $this->belongsTo(DeductionCard::class);
    }


}
