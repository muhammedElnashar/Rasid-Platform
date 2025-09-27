<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInsignia extends Model
{
    protected $fillable = ['user_id', 'insignia_id', 'issuer_id', 'award_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function insignia()
    {
        return $this->belongsTo(Insignia::class);
    }
    public function issuer()
    {
        return $this->belongsTo(User::class, 'issuer_id');
    }
}
