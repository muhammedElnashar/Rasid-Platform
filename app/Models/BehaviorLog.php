<?php

namespace App\Models;

use App\Enum\BehaviorCategoryEnum;
use App\Enum\LogsTypeEnum;
use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Model;

class BehaviorLog extends Model
{
    protected $fillable = [
        'school_id',
        'user_id',
        'issuer_by',
        'card_item_id',
        'issue_number',
        'points_value',
        'active',
        'log_date',
        'status',
    ];
    protected $casts = [
        'log_date' => 'datetime',
        'active' => 'boolean',
        'points_value' => 'integer',
        'status'=>StatusEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cardItem()
    {
        return $this->belongsTo(CardItem::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issuer_by');
    }
}
