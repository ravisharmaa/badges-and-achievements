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
        $this->model = Achievement::firstOrCreate([
            'name' => 'First Lesson Watched',
            'description' => 'Some Description',
            'achievement_type' => 'lesson_watched',
        ]);
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
