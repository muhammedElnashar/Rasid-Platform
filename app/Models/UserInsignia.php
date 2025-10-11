<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserInsignia extends Model
{
    protected $fillable = [
        'issued_to_id',
        'issued_to_type',
        'insignia_id',
        'issuer_id',
        'award_date',
    ];

    public function issuedTo(): MorphTo
    {
        return $this->morphTo();
    }

    public function insignia()
    {
        return $this->belongsTo(Insignia::class);
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issuer_id');
    }
}

