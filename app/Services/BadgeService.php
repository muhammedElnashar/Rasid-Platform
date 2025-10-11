<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\UserBadge;

class BadgeService
{
    public function checkAndAssignBadges($entity)
    {
        if (!isset($entity->school_id) || !isset($entity->fixed_points)) {
            return;
        }

        $badges = Badge::where('school_id', $entity->school_id)->get();

        foreach ($badges as $badge) {
            if ($entity->fixed_points >= $badge->required_points) {

                $alreadyHasBadge = UserBadge::where('issued_to_id', $entity->id)
                    ->where('issued_to_type', get_class($entity))
                    ->where('badge_id', $badge->id)
                    ->exists();

                if (!$alreadyHasBadge) {
                    UserBadge::create([
                        'issued_to_id'   => $entity->id,
                        'issued_to_type' => get_class($entity),
                        'badge_id'       => $badge->id,
                        'award_date'     => now(),
                    ]);


                    if ($entity->isFillable('fixed_points') && $entity->isFillable('flexible_points')) {
                        $entity->increment('fixed_points',$badge->points_awarded );
                        $entity->increment('flexible_points', $badge->points_awarded);
                    }

                }
            }
        }
    }
}
