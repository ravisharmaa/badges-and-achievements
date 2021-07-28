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
        $this->model = Achievement::firstOrCreate([
            'name' => '50 Lessons Watched',
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
        return $user->watched()->count() >= 50;
    }
}
