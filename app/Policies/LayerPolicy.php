<?php

namespace App\Policies;

use App\Models\Layer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LayerPolicy
{
    protected function hasAccess(User $user, Layer $layer): bool
    {
        return ($user->isSchoolAdmin() || $user->isModerator())
            && $user->school_id === $layer->category->school_id;
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
    public function view(User $user, Layer $layer): bool
    {
        return $this->hasAccess($user, $layer);
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
    public function update(User $user, Layer $layer): bool
    {
        return $this->hasAccess($user, $layer);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Layer $layer): bool
    {
        return $this->hasAccess($user, $layer);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Layer $layer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Layer $layer): bool
    {
        return false;
    }
}
