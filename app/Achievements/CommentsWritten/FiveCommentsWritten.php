<?php

namespace App\Achievements\CommentsWritten;

use App\Achievements\Achievement as AchievementType;
use App\Models\Achievement;
use App\Models\User;

class FiveCommentsWritten extends AchievementType
{
    public string $achievementType = 'comment_written';

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
            'name' => '5 Comments Written',
            'description' => 'Some Description',
            'achievement_type' => 'comment_written',
        ]);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function qualify(User $user): bool
    {
        return $user->comments()->count() >= 5;
    }
}
