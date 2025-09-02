<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    protected $fillable = [
        'user_id', 'card_issue_id', 'type', 'points', 'balance_after'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cardIssue()
    {
        return $this->belongsTo(CardIssues::class);
    }
}
