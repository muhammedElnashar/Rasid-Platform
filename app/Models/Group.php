<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    protected $fillable = [
        'name', 'description',
        'school_id', 'leader_id', 'fixed_points',
        'category_id',
        'image', 'file',
        'flexible_points',
        'current_negative_points',
        'status',
        'settlement_code', 'active'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(GroupCategory::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id');
    }

    public function cardIssues()
    {
        return $this->morphMany(CardIssues::class, 'issued_to');
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

    // ✅ العلاقة مع السجل التاريخي للمستويات
    public function levelHistories()
    {
        return $this->morphMany(UserLevelHistory::class, 'issued_to');
    }

    // ✅ المستوى المحسوب حسب النقاط
    public function getCalculatedLevelAttribute()
    {
        return Level::where('points_required', '<=', $this->fixed_points)
            ->orderBy('points_required', 'desc')
            ->first();
    }

    // ✅ المتبقي للوصول للطبقة التالية
    public function getRemainingForNextLayerAttribute()
    {
        $currentLevel = $this->current_level;

        if (!$currentLevel) {
            return null;
        }

        $currentLayer = $currentLevel->layer;
        $totalPointsLayer = $currentLayer->levels()->max('points_required');
        $groupPoints = $this->fixed_points;

        $remaining = $totalPointsLayer - $groupPoints;

        return $remaining > 0 ? $remaining : 0;
    }

    // ✅ حفظ السجل عند تغيير المستوى
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

    // ✅ الوصول للطبقة والمستوى الحاليين
    public function getCurrentLayerAttribute()
    {
        return $this->currentLevelHistory?->layer;
    }

    public function getCurrentLevelAttribute()
    {
        return $this->currentLevelHistory?->level;
    }

    public function badges()
    {
        return $this->morphToMany(Badge::class, 'issued_to', 'user_badges')
            ->withPivot('award_date')
            ->withTimestamps();
    }

    public function insignias()
    {
        return $this->morphToMany(Insignia::class, 'issued_to', 'user_insignias')
            ->withPivot('award_date')
            ->withTimestamps();
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

    public function rechargeCards()
    {
        return $this->morphToMany(RechargeCard::class, 'issued_to', 'recharge_card_users', 'issued_to_id', 'card_id')
            ->withPivot(['max_uses', 'used_count', 'is_active', 'code'])
            ->withTimestamps();
    }
}

