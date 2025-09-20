<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RechargeFailedAttempts extends Model
{
    protected $fillable = [
        'user_id',
        'attempts',
        'user_agent',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
