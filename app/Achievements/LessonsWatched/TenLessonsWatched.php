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
        $this->model = Achievement::firstOrCreate([
            'name' => '10 Lessons Watched',
            'description' => 'Some Description',
            'achievement_type' => 'lesson_watched',
        ]);
    }

    public function qualify(User $user): bool
    {
        return $user->watched()->count() >= 10;
    }
}
