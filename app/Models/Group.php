<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'school_id', 'leader_id',    'fixed_points',
        'flexible_points',
        'current_negative_points',
        'status',
        'settlement_code'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }



}

