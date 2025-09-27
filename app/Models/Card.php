<?php

namespace App\Models;

use App\Enum\CardNameEnum;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['school_id', 'name'];

    protected $casts = [
        'name' => CardNameEnum::class,

    ];
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function categories()
    {
        return $this->hasMany(CardCategory::class);
    }
}
