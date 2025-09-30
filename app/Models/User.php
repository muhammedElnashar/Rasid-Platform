<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'fixed_points',
        'flexible_points',
        'current_negative_points',
        'status',
        'settlement_code'
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

    public function scopeUsersExpectModerator($query)
    {
        return $query->whereNotIn('role_id', [1, 2, 6]);
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


/*    public function teacherSubjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject_classes', 'teacher_id', 'subject_id');
    }*/

  /*  public function teacherClasses()
    {
        return $this->belongsToMany(Classes::class, 'teacher_subject_classes', 'teacher_id', 'class_id');
    }*/

    public function studentClasses()
    {
        return $this->hasMany(StudentClass::class, 'student_id');
    }

//    public function studentSubjects()
//    {
//        return $this->belongsToMany(Subject::class, 'student_classes', 'student_id', 'subject_id');
//    }

/*    public function studentClassesRelation()
    {
        return $this->belongsToMany(Classes::class, 'student_classes', 'student_id', 'class_id');
    }*/
    public function teacherSubjectClasses()
    {
        return $this->hasMany(TeacherSubjectClass::class, 'teacher_id');
    }

    public function subjectsForTeacher()
    {

        if ($this->isTeacher()) {
            // المعلم: يرجع المواد + الفصول
            return $this->teacherSubjectClasses()
                ->with(['class.grade.stage', 'subject'])
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'class_id' => $item->class->id ?? null,
                        'class_name' => $item->class->name ?? null,
                        'subject_id' => $item->subject->id ?? null,
                        'subject_name' => $item->subject->name ?? null,
                        'grade_id' => $item->class->grade->id ?? null,
                        'grade_name' => $item->class->grade->name ?? null,
                        'stage_id' => $item->class->grade->stage->id ?? null,
                        'stage_name' => $item->class->grade->stage->name ?? null
                    ];
                });

        }

        return collect(); // لو مش طالب ولا معلم
    }

    public function studentSubjects()
    {
        return $this->hasMany(StudentSubject::class, 'student_id');
    }
    public function studentClass()
    {
        return $this->hasOne(StudentClass::class, 'student_id');
    }

    public function cardIssues()
    {
        return $this->hasMany(CardIssues::class, 'user_id');
    }

    public function allTransfers()
    {
        return PointTransfer::with(['sender', 'receiver'])
            ->where(function ($q) {
                $q->where('sender_id', $this->id)
                    ->orWhere('receiver_id', $this->id);
            });
    }

    public function deductionCards()
    {
        return $this->belongsToMany(\App\Models\DeductionCard::class, 'user_deduction_cards')
            ->withTimestamps()
            ->withPivot('applied_at', 'cycle_number', 'negative_points_at_time');
    }

    public function rechargeCards()
    {
        return $this->belongsToMany(RechargeCard::class, 'recharge_card_users', 'user_id', 'card_id')
            ->withPivot(['max_uses', 'used_count', 'is_active'])
            ->withTimestamps();
    }

    public function getCalculatedLevelAttribute()
    {
        return Level::where('points_required', '<=', $this->fixed_points)
            ->orderBy('points_required', 'desc')
            ->first();
    }

    public function levelHistories()
    {
        return $this->hasMany(UserLevelHistory::class, 'user_id');
    }

    public function getRemainingForNextLayerAttribute()
    {
        $currentLevel = $this->current_level;

        if (!$currentLevel) {
            return null;
        }

        $currentLayer = $currentLevel->layer;

        $totalPointsLayer = $currentLayer->levels()->max('points_required');

        $userPoints = $this->fixed_points;


        $remaining = $totalPointsLayer - $userPoints;

        return $remaining > 0 ? $remaining : 0;
    }


    public function saveLevelHistory()
    {
        $currentLevel = $this->calculatedLevel;
        if (!$currentLevel) return;

        $layer = $currentLevel->layer;
        $category = $layer->category;

        $lastHistory = $this->levelHistories()->latest()->first();

        if (!$lastHistory || $lastHistory->level_id !== $currentLevel->id) {

            $this->levelHistories()->create([
                'category_id' => $category->id,
                'layer_id' => $layer->id,
                'level_id' => $currentLevel->id,
                'change_date' => now(),
                'is_upgrade' => $lastHistory
                    ? $currentLevel->points_required > $lastHistory->level->points_required
                    : true,
                'notification_sent' => false,
            ]);
        }
    }

    public function currentLevelHistory()
    {
        return $this->hasOne(UserLevelHistory::class)->latestOfMany('change_date');
    }

    public function getCurrentLayerAttribute()
    {
        return $this->currentLevelHistory?->layer;
    }

    public function getCurrentLevelAttribute()
    {
        return $this->currentLevelHistory?->level;
    }

    public function insignias()
    {
        return $this->belongsToMany(Insignia::class, 'user_insignias')
            ->withPivot('award_date');
    }
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('award_date')
            ->withTimestamps();
    }

}
