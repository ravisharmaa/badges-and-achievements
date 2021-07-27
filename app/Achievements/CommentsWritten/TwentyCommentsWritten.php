<?php

namespace App\Achievements\CommentsWritten;

use App\Achievements\Achievement as AchievementType;
use App\Models\Achievement;
use App\Models\User;

class TwentyCommentsWritten extends AchievementType
{
    public $achievementType = 'comment_written';

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
            'name' => '20 Comments Written',
            'description' => 'Some Description',
            'achievement_type' => 'comment_written',
        ]);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function qualify(User $user)
    {
        return $user->comments()->count() >= 20;
    }
}
