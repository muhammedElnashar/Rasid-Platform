<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = ['grade_id', 'name'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function teacherSubjects()
    {
        return $this->hasMany(TeacherSubjectClass::class, 'class_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_classes', 'class_id', 'student_id');
    }

}
