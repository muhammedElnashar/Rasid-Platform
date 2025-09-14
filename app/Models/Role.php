<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function scopeExpectModeratorAndAdmin($query)
    {
        return $query->whereNotIn('name', ['super_admin', 'school_admin', 'moderator']);
    }
}
