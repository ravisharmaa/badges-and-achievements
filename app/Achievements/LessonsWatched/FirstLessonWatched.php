<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement as AchievementType;
use App\Models\Achievement;
use App\Models\User;

class FirstLessonWatched extends AchievementType
{
    public string $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('First Lesson Watched', 'Some Description');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function qualify(User $user): bool
    {
        return (bool) $user->watched->count();
    }
}
