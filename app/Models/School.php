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
        'ministerial_number'
    ];

    public function manager()
    {
        return $this->hasOne(User::class)->where('role_id', 2);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }





}
