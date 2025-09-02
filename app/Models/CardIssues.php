<?php

namespace App\Models;

use App\Enum\DeductionTypeEnum;
use App\Enum\StatusCardEnum;
use Illuminate\Database\Eloquent\Model;

class CardIssues extends Model
{
    protected $fillable = [
        'issue_number', 'user_id', 'card_item_id', 'issued_by',
        'points', 'remaining_points','deduction_type', 'issue_date', 'deduction_deadline', 'status',
        'deduction_duration_days', 'applied_at'
    ];
    protected $casts = [
        'deduction_type' => DeductionTypeEnum::class,
        'status' => StatusCardEnum::class,
        'issue_date' => 'date',
        'deduction_deadline' => 'date',
        'applied_at'=> 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
