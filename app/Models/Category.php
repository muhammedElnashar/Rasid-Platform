<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'school_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function layers()
    {
        return $this->hasMany(Layer::class);
    }

}
