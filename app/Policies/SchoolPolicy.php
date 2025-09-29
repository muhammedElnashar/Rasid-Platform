<?php

namespace App\Policies;

use App\Models\School;
use App\Models\User;

class SchoolPolicy
{

    public function update(User $user, School $model): bool
    {
        return ($user->isSchoolAdmin() || $user->isModerator())
            && $user->school_id === $model->id;
    }
}
