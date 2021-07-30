<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement as AchievementType;
use App\Models\User;
use App\Models\Achievement;

class TenLessonsWatched extends AchievementType
{
    public string $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('10 Lessons Watched', 'Some Description');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function qualify(User $user): bool
    {
        return $user->watched()->count() >= 10;
    }
}
