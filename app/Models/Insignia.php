<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Image;
use Storage;

class Insignia extends Model
{
    protected $fillable = ['school_id', 'name', 'points_value','image'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('images')->url($this->image) : null;
    }
}
