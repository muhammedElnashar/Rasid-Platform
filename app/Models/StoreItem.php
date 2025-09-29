<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreItem extends Model
{
    protected $fillable = [
        'name',
        'image_url',
        'points_required',
        'stock',
        'school_id',
        'target_role',
        'target_level_id'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'target_role');
    }


    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'target_level_id');
    }

}
