<?php

namespace App\Observers;

use App\Models\User;
use App\Services\BadgeService;

class UserObserver
{
    protected $badgeService;
    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }
    public function updated(User $user)
    {
        if ($user->wasChanged('fixed_points')) {
            $user->saveLevelHistory();
            $this->badgeService->checkAndAssignBadges($user);

        }
    }}
