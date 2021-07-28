<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AchievementsController extends Controller
{
    /**
     * Returns the json response for users achievements.
     *
     */
    public function index(User $user): JsonResponse
    {
        $nextAvailableAchievements = Achievement::all()
            ->whereNotIn('name', $user->achievements()->pluck('name'))->pluck('name');

        $badge = $user->badges->last();

        $nextBadge = null;

        $remainingToUnlockNextBadge = 0;

        if ($badge) {
            $nextBadge = Badge::find(++$badge->id);
            $remainingToUnlockNextBadge = is_null($nextBadge) ? 0 :
                $nextBadge->required_achievements - $badge->required_achievements;
        }

        return response()->json([
            'unlocked_achievements' => $user->achievements()->pluck('name'),
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => is_null($badge) ? '' : $badge->name,
            'next_badge' => is_null($nextBadge) ? '' : $nextBadge->name,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ]);
    }
}
