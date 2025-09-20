<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layer extends Model
{
    protected $fillable = ['name', 'category_id','reward_value'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }
}
