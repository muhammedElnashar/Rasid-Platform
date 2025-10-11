<?php

namespace App\Observers;

use App\Services\BadgeService;
use App\Services\DeductionCardService;

class PointsObserver
{
    protected BadgeService $badgeService;
    protected DeductionCardService $deductionCardService;

    public function __construct(BadgeService $badgeService, DeductionCardService $deductionCardService)
    {
        $this->badgeService = $badgeService;
        $this->deductionCardService = $deductionCardService;
    }

    public function updated($model): void
    {
        if ($model->wasChanged('fixed_points')) {
            $model->saveLevelHistory();
            $this->badgeService->checkAndAssignBadges($model);
            $this->deductionCardService->applyBestCard($model);
        }
    }
}

