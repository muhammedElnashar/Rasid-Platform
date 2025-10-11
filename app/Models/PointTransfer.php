<?php

namespace App\Models;

use App\Enum\PurposeEnum;
use App\Enum\StatusEnum;
use App\Enum\TransferTypeEnum;
use Illuminate\Database\Eloquent\Model;

class PointTransfer extends Model
{
    protected $fillable = [
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'amount',
        'reason',
        'purpose',
        'status',
    ];
    protected $casts = [
        'status'=>StatusEnum::class,
        'purpose'=>PurposeEnum::class,
    ];

    /**
     */

    public function sender()
    {
        return $this->morphTo();
    }

    public function receiver()
    {
        return $this->morphTo();
    }
    public function scopeForSchool($query, $schoolId)
    {
        return $query->whereIn('sender_id', function ($q) use ($schoolId) {
            $q->select('id')->from('users')->where('school_id', $schoolId);
        })
            ->orWhereIn('receiver_id', function ($q) use ($schoolId) {
                $q->select('id')->from('users')->where('school_id', $schoolId);
            });
    }
    public function isPending(): bool
    {
        return $this->status === \App\Enum\StatusEnum::Pending;
    }

}
