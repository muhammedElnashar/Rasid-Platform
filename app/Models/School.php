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
        'ministerial_number',
        'logo',
        'documents',
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

    public function studentClasses()
    {
        return $this->hasManyThrough(
            StudentClass::class,
            User::class, // الطلاب
            'school_id', // مفتاح المدرسة في جدول users
            'student_id', // مفتاح الطالب في جدول student_classes
            'id',        // مفتاح المدرسة في schools
            'id'         // مفتاح الطالب في users
        );
    }
    public function studentGuardians()
    {
     return   $this->hasManyThrough(
          StudentGuardian::class,
            User::class,
            'school_id',
            'student_id',
            'id',
            'id'
        );
    }


}
