<?php

namespace App\Models;

use App\Enum\DeductionTypeEnum;
use App\Enum\StatusCardEnum;
use Illuminate\Database\Eloquent\Model;

class CardIssues extends Model
{
    protected $fillable = [
        'issue_number','issued_to_type','issued_to_id', 'card_item_id', 'issued_by',
        'points', 'remaining_points','deduction_type', 'issue_date', 'deduction_deadline', 'status',
        'deduction_duration_days', 'applied_at'
        ,'is_restricted',
    ];
    protected $casts = [
        'deduction_type' => DeductionTypeEnum::class,
        'status' => StatusCardEnum::class,
        'issue_date' => 'datetime',
        'deduction_deadline' => 'date',
        'applied_at'=> 'date',
    ];
    public function isPending(): bool
    {
        return $this->status === \App\Enum\StatusCardEnum::Pending;
    }
    public function isApproved(): bool
    {
        return $this->status === \App\Enum\StatusCardEnum::Approved;
    }

    public function issuedTo()
    {
        return $this->morphTo();
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
    public function cardItem()
    {
        return $this->belongsTo(CardItem::class);
    }
    public function transaction()
    {
        return $this->hasOne(PointTransaction::class);
    }
    protected static function booted()
    {
        static::creating(function ($cardIssue) {
            if ($cardIssue->points < 0 && $cardIssue->deduction_type === DeductionTypeEnum::Deferred) {
                $cardIssue->remaining_points = abs($cardIssue->points);
            } else {
                $cardIssue->remaining_points = null;
            }
        });
    }


}
