<?php

namespace App\Policies;

use App\Models\PointTransfer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PointTransferPolicy
{
    protected function hasAccess(User $user, PointTransfer $pointTransfer): bool
    {
        return ($user->isSchoolAdmin() || $user->isModerator())
            && (
                $user->school_id === $pointTransfer->sender->school_id
                || $user->school_id === $pointTransfer->receiver->school_id
            );
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isModerator()||$user->isSchoolAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PointTransfer $pointTransfer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isTeacher()||$user->isStudent()||$user->isGuardian();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PointTransfer $pointTransfer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PointTransfer $pointTransfer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PointTransfer $pointTransfer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PointTransfer $pointTransfer): bool
    {
        return false;
    }

    public function approve(User $user, PointTransfer $pointTransfer)
    {
        return $this->hasAccess($user,$pointTransfer) && $pointTransfer->isPending();
    }
    public function reject(User $user, PointTransfer $pointTransfer)
    {
        return $this->hasAccess($user,$pointTransfer) && $pointTransfer->isPending();
    }
}
