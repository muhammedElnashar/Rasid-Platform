<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'location',
        'email',
        'phone',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
