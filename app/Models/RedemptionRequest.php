<?php

namespace App\Models;

use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedemptionRequest extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'request_date',
        'status',
        'delivery_code',
    ];
    protected $casts = [
        'status' => StatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(StoreItem::class,'item_id');
    }
}
