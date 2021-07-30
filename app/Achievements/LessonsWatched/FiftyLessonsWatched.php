<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement as AchievementType;
use App\Models\Achievement;
use App\Models\User;

class FiftyLessonsWatched extends AchievementType
{
    public string $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('50 Lessons Watched', 'Some Description');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function qualify(User $user): bool
    {
        return $user->watched()->count() >= 50;
    }
}
