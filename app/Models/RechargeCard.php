<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RechargeCard extends Model
{
    protected $fillable = [
        'name',
        'points',
        'card_item_id',
    ];

    public function issuedTo()
    {
        return $this->morphedByMany(User::class, 'issued_to', 'recharge_card_users')
            ->withPivot(['max_uses', 'used_count', 'is_active'])
            ->withTimestamps();
    }

    public function issuedToGroups()
    {
        return $this->morphedByMany(Group::class, 'issued_to', 'recharge_card_users')
            ->withPivot(['max_uses', 'used_count', 'is_active'])
            ->withTimestamps();
    }



    public function cardItem()
    {
        return $this->belongsTo(CardItem::class);
    }
}
