<?php

namespace App\Policies;

use App\Enum\StatusEnum;
use App\Models\RedemptionRequest;
use App\Models\User;

class RedemptionRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSchoolAdmin() || $user->isModerator();
    }

    public function approve(User $user, RedemptionRequest $request): bool
    {
        return $this->sameSchool($user, $request)
            && $user->isSchoolAdmin()
            && $request->status === StatusEnum::Pending;
    }

    public function reject(User $user, RedemptionRequest $request): bool
    {
        return $this->sameSchool($user, $request)
            && $user->isSchoolAdmin()
            && $request->status === StatusEnum::Pending;
    }


    private function sameSchool(User $user, RedemptionRequest $request): bool
    {
        return $user->school_id === $request->issuedTo->school_id;
    }
}
