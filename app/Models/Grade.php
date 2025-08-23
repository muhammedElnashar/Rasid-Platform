<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['stage_id', 'name'];

    // الصف ينتمي لمرحلة
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    // الصف يحتوي على شعب
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }
}
