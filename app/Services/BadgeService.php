<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\UserBadge;
use App\Models\User;

class BadgeService
{
    public function checkAndAssignBadges(User $user)
    {
        $badges = Badge::where('school_id', $user->school_id)->get();

        foreach ($badges as $badge) {
            if ($user->fixed_points >= $badge->required_points) {

                $alreadyHasBadge = UserBadge::where('user_id', $user->id)
                    ->where('badge_id', $badge->id)
                    ->exists();

                if (!$alreadyHasBadge) {
                    UserBadge::create([
                        'user_id'   => $user->id,
                        'badge_id'  => $badge->id,
                        'award_date'=> now(),
                    ]);

                    $user->increment('flexible_points', $badge->points_awarded);
                    $user->save();
                }
            }
        }
    }
}
