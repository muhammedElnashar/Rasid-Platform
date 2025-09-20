<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['name', 'layer_id','points_required','reward_value'];

    public function layer()
    {
        return $this->belongsTo(Layer::class);
    }
}
