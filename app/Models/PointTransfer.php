<?php

namespace App\Models;

use App\Enum\PurposeEnum;
use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Model;

class PointTransfer extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
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
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
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
