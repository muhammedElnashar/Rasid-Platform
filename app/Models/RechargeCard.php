<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RechargeCard extends Model
{
    protected $fillable = [
        'code',
        'points',
        'card_item_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'recharge_card_users', 'card_id', 'user_id')
            ->withPivot(['max_uses', 'used_count', 'is_active', 'created_by'])
            ->withTimestamps();
    }
    public static function generateUniqueCode($length = 10)
    {
        do {
            // ممكن تغير Str::upper أو تخليه بدون uppercase
            $code = Str::upper(Str::random($length));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function cardItem()
    {
        return $this->belongsTo(CardItem::class);
    }
}
