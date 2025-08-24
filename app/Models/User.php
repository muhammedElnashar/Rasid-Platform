<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'school_id',
        'username',
        'full_name',
        'email',
        'password',
        'role_id',
        'phone',
        'points_balance',
        'status',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** ========== Checks ========== */
    public function isSuperAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isSchoolAdmin(): bool
    {
        return $this->role_id === 2;
    }
    public function isStudent(): bool
    {
        return $this->role_id === 3;
    }
    public function isTeacher(): bool
    {
        return $this->role_id === 4;
    }
    public function isGuardian(): bool
    {
        return $this->role_id === 5;
    }
    public function isModerator(): bool
    {
        return $this->role_id === 6;
    }

    /** ========== Scopes ========== */
    public function scopeSuperAdmins($query)
    {
        return $query->where('role_id', 1);
    }
    public function scopeSchoolAdmins($query)
    {
        return $query->where('role_id', 2);
    }

    public function scopeOnlyStudents($query)
    {
        return $query->where('role_id', 3);
    }

    public function scopeOnlyTeachers($query)
    {
        return $query->where('role_id', 4);
    }
    public function scopeOnlyGuardians($query)
    {
        return $query->where('role_id', 5);
    }
    public function scopeOnlyModerators($query)
    {
        return $query->where('role_id', 6);
    }
    public function scopeUsersExpectAdmins($query)
    {
        return $query->whereNotIn('role_id', [1, 2]);
    }

    /** ========== Relationships ========== */


    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function guardians()
    {
        return $this->belongsToMany(User::class, 'student_guardians', 'student_id', 'guardian_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_guardians', 'guardian_id', 'student_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }
    public function teacherSubjects()
    {
        return $this->hasMany(TeacherSubjectClass::class, 'teacher_id');
    }
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'student_classes', 'student_id', 'class_id');
    }
}
