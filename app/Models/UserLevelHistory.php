<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLevelHistory extends Model
{
    protected $fillable = [
        'issued_to_type','issued_to_id', 'category_id', 'layer_id', 'level_id',
        'change_date', 'notification_sent', 'is_upgrade',
    ];

    public function issuedTo()
    {
        return $this->morphTo();
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function layer()
    {
        return $this->belongsTo(Layer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
