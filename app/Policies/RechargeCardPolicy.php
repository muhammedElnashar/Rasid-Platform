<?php

namespace App\Policies;

use App\Models\RechargeCard;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RechargeCardPolicy
{
    protected function hasAccess(User $user, RechargeCard $rechargeCard): bool
    {

        return ($user->isSchoolAdmin() || $user->isModerator())
            && $user->school_id === $rechargeCard->school_id;
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
    public function view(User $user, RechargeCard $rechargeCard): bool
    {
        return $this->hasAccess($user,$rechargeCard);
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
    public function update(User $user, RechargeCard $rechargeCard): bool
    {
        return $this->hasAccess($user,$rechargeCard);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RechargeCard $rechargeCard): bool
    {
        return $this->hasAccess($user,$rechargeCard);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RechargeCard $rechargeCard): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RechargeCard $rechargeCard): bool
    {
        return false;
    }
}
