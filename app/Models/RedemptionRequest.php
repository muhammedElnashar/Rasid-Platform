<?php

namespace App\Models;

use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedemptionRequest extends Model
{
    protected $fillable = [
        'school_id',
        'issued_to_id',
        'issued_to_type',
        'item_id',
        'request_date',
        'status',
        'delivery_code',
    ];
    protected $casts = [
        'status' => StatusEnum::class,
    ];

    public function issuedTo(): BelongsTo
    {
        return $this->morphTo();
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(StoreItem::class, 'item_id');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
