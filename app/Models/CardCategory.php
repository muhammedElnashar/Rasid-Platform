<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardCategory extends Model
{
    protected $fillable = ['card_id', 'name'];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function items()
    {
        return $this->hasMany(CardItem::class);
    }
}
