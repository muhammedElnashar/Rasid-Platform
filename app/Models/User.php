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
        'image',
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
        return $this->morphMany(CardIssues::class, 'issued_to');
    }


    public function allTransfers()
    {
        return PointTransfer::with(['sender', 'receiver'])
            ->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->where('sender_id', $this->id)
                        ->where('sender_type', get_class($this));
                })
                    ->orWhere(function ($sub) {
                        $sub->where('receiver_id', $this->id)
                            ->where('receiver_type', get_class($this));
                    });
            });
    }


    public function deductionCards()
    {
        return $this->morphToMany(DeductionCard::class, 'issued_to', 'user_deduction_cards')
            ->withPivot(['applied_at', 'cycle_number', 'negative_points_at_time'])
            ->withTimestamps();
    }

    public function userDeductionCards()
    {
        return $this->morphMany(UserDeductionCard::class, 'issued_to');
    }

    public function rechargeCards()
    {
        return $this->morphToMany(RechargeCard::class, 'issued_to', 'recharge_card_users','issued_to_id','card_id')
            ->withPivot(['max_uses', 'used_count', 'is_active','created_by','code'])
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
        return $this->morphMany(UserLevelHistory::class, 'issued_to');
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
        return $this->morphOne(UserLevelHistory::class, 'issued_to')->latestOfMany('change_date');
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
        return $this->morphToMany(Insignia::class, 'issued_to','user_insignias')
            ->withPivot('award_date')
            ->withTimestamps();

    }
    public function badges()
    {
        return $this->morphToMany(Badge::class, 'issued_to', 'user_badges')
            ->withPivot('award_date')
            ->withTimestamps();
    }


}
