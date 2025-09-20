<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardItem extends Model
{
    protected $fillable = ['card_category_id', 'name', 'points'];

    public function category()
    {
        return $this->belongsTo(CardCategory::class, 'card_category_id');
    }
    public function issues()
    {
        return $this->hasMany(CardIssues::class, 'card_item_id');
    }

}
