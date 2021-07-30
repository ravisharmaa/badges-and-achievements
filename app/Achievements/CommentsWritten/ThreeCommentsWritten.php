<?php

namespace App\Achievements\CommentsWritten;

use App\Achievements\Achievement as AchievementType;
use App\Models\User;

class ThreeCommentsWritten extends AchievementType
{
    public string $achievementType = 'comment_written';

    public function __construct()
    {
        parent::__construct('3 Comments Written', 'Some Description');
    }

    /**
     * @return bool
     */
    public function qualify(User $user)
    {
        return $user->comments()->count() >= 3;
    }
}
