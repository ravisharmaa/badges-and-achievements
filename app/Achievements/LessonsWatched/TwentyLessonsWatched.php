<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement as AchievementType;
use App\Models\User;
use App\Models\Achievement;

class TwentyLessonsWatched extends AchievementType
{
    public string $achievementType = 'lesson_watched';

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
            'name' => '20 Lessons Watched',
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
        return $user->watched()->count() >= 20;
    }
}
