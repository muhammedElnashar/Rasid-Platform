<?php

namespace App\Policies;

use App\Models\CardIssues;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CardIssuePolicy
{
    protected function hasAccess(User $user, CardIssues $cardIssues): bool
    {
        return ($user->isSchoolAdmin() || $user->isModerator() || $user->isTeacher())
            && $user->school_id === $cardIssues->cardItem->category->card->school_id;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSchoolAdmin() || $user->isModerator() || $user->isTeacher();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CardIssues $cardIssues): bool
    {
        return $this->hasAccess($user, $cardIssues);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSchoolAdmin() || $user->isModerator() || $user->isTeacher();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CardIssues $cardIssues): bool
    {
        return $this->hasAccess($user, $cardIssues);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CardIssues $cardIssues): bool
    {
        return $this->hasAccess($user, $cardIssues);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CardIssues $cardIssues): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CardIssues $cardIssues): bool
    {
        return false;
    }

    public function approve(User $user, CardIssues $cardIssues): bool
    {
        return $this->hasAccess($user, $cardIssues) && $cardIssues->isPending();
    }

    public function reject(User $user, CardIssues $cardIssues): bool
    {
        return $this->hasAccess($user, $cardIssues) && $cardIssues->isPending();
    }

    public function unrestricted(User $user, CardIssues $cardIssues): bool
    {
        return $this->hasAccess($user, $cardIssues)
            &&
            $cardIssues->isApproved()
            &&
            $cardIssues->is_restricted === 1;
    }
}
