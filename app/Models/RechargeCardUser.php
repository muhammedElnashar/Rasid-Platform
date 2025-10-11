<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RechargeCardUser extends Model
{
    protected $table = 'recharge_card_users';

    protected $fillable = [
        'card_id',
        'issued_to_id',
        'issued_to_type',
        'code',
        'max_uses',
        'used_count',
        'is_active',
        'created_by',
    ];

    public function card()
    {
        return $this->belongsTo(RechargeCard::class, 'card_id');
    }

    public function issuedTo()
    {
        return $this->morphTo();
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public static function generateUniqueCode($length = 10)
    {
        do {
            $code = Str::upper(Str::random($length));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
