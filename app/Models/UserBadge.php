<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    protected $fillable = [
        'issued_to_id',
        'issued_to_type',
        'badge_id',
        'award_date'
    ];

    public function issued_to()
    {
        return $this->morphTo();
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
}
