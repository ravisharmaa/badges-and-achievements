<?php

namespace App\Achievements\CommentsWritten;

use App\Achievements\Achievement as AchievementType;
use App\Models\Achievement;
use App\Models\User;

class TwentyCommentsWritten extends AchievementType
{
    public string $achievementType = 'comment_written';

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
            'name' => '20 Comments Written',
            'description' => 'Some Description',
            'achievement_type' => 'comment_written',
        ]);
    }

    /**
     * @return bool
     */
    public function qualify(User $user): bool
    {
        return $user->comments()->count() >= 20;
    }
}
