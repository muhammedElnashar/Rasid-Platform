<?php

namespace App\Policies;

use App\Enum\StatusEnum;
use App\Models\BehaviorLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LogPolicy
{
    protected function hasAccess(User $user, BehaviorLog $behaviorLog): bool
    {
        return ($user->isSchoolAdmin() || $user->isModerator() || $user->isTeacher())
            && $user->school_id === $behaviorLog->cardItem->category->card->school_id;
    }
    protected function access(User $user, BehaviorLog $behaviorLog): bool
    {
        return ($user->isSchoolAdmin())
            && $user->school_id === $behaviorLog->cardItem->category->card->school_id;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSchoolAdmin() || $user->isModerator()|| $user->isTeacher();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BehaviorLog $behaviorLog): bool
    {
        return  $this->hasAccess($user,$behaviorLog);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSchoolAdmin() || $user->isModerator()|| $user->isTeacher();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BehaviorLog $behaviorLog): bool
    {
        return  $this->hasAccess($user,$behaviorLog);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BehaviorLog $behaviorLog): bool
    {
        return  $this->hasAccess($user,$behaviorLog);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BehaviorLog $behaviorLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BehaviorLog $behaviorLog): bool
    {
        return false;
    }

    public function approve(User $user ,BehaviorLog $behaviorLog)
    {
        return $this->access($user, $behaviorLog) && $behaviorLog->status === StatusEnum::Pending;
    }
    public function reject(User $user ,BehaviorLog $behaviorLog)
    {
        return $this->access($user, $behaviorLog) && $behaviorLog->status === StatusEnum::Pending;
    }
    public function activation(User $user ,BehaviorLog $behaviorLog)
    {
        return $this->access($user, $behaviorLog) && $behaviorLog->status === StatusEnum::Approved;
    }
}
