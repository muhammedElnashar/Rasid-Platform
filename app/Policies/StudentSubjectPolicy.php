<?php

namespace App\Policies;

use App\Models\StudentSubject;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentSubjectPolicy
{
    protected function hasAccess(User $user, StudentSubject $studentSubject): bool
    {
        return ($user->isSchoolAdmin() || $user->isModerator())
            && $user->school_id === $studentSubject->student->school_id
            && $user->school_id === $studentSubject->subject->school_id;
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
    public function view(User $user, StudentSubject $studentSubject): bool
    {
        return $this->hasAccess($user, $studentSubject);
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
    public function update(User $user, StudentSubject $studentSubject): bool
    {
        return $this->hasAccess($user, $studentSubject);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StudentSubject $studentSubject): bool
    {
        return $this->hasAccess($user, $studentSubject);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StudentSubject $studentSubject): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StudentSubject $studentSubject): bool
    {
        return false;
    }
}
