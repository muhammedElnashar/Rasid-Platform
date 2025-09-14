<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RechargeCardUser extends Model
{
    protected $table = 'recharge_card_users';

    protected $fillable = [
        'card_id',
        'user_id',
        'max_uses',
        'used_count',
        'is_active',
        'created_by',
    ];

    public function card()
    {
        return $this->belongsTo(RechargeCard::class, 'card_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Assigner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
