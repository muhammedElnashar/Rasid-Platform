<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGuardian extends Model
{
    protected $fillable = [
        'student_id',
        'guardian_id',
        'relationship',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function guardian()
    {
        return $this->belongsTo(User::class, 'guardian_id');
    }
}
