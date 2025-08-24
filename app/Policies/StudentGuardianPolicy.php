<?php

namespace App\Policies;

use App\Models\StudentGuardian;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentGuardianPolicy
{
    protected function hasAccess(User $user, StudentGuardian $studentGuardian): bool
    {
        return ($user->isSchoolAdmin() || $user->isModerator())
            && $user->school_id === $studentGuardian->student->school_id
            && $user->school_id === $studentGuardian->guardian->school_id;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSchoolAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StudentGuardian $studentGuardian): bool
    {
        return $this->hasAccess($user, $studentGuardian);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSchoolAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StudentGuardian $studentGuardian): bool
    {
        return $this->hasAccess($user, $studentGuardian);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StudentGuardian $studentGuardian): bool
    {
        return $this->hasAccess($user, $studentGuardian);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StudentGuardian $studentGuardian): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StudentGuardian $studentGuardian): bool
    {
        return false;
    }
}
