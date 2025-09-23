<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Badge extends Model
{
    protected $fillable = ['name', 'description', 'image', 'required_points', 'points_awarded','school_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('images')->url($this->image) : null;
    }
}
