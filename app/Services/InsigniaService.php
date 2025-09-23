<?php

namespace App\Services;

use App\Models\User;
use App\Models\Insignia;
use App\Models\UserInsignia;
use Illuminate\Support\Facades\DB;

class InsigniaService
{

    public function assignInsignia(array $data): void
    {
        DB::transaction(function () use ($data) {
            UserInsignia::create([
                'user_id'     => $data['user_id'],
                'insignia_id' => $data['insignia_id'],
                'issuer_id' => $data['issuer_id'],
                'award_date'  => $data['award_date'],
            ]);

            $user     = User::findOrFail($data['user_id']);
            $insignia = Insignia::findOrFail($data['insignia_id']);

            $user->increment('fixed_points', $insignia->points_value);
            $user->increment('flexible_points', $insignia->points_value);
        });
    }
}
