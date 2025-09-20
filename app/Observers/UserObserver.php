<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function updated(User $user)
    {
        if ($user->wasChanged('fixed_points')) {
            $user->saveLevelHistory();
        }
    }}
