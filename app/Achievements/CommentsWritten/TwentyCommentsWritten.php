<?php

namespace App\Achievements\CommentsWritten;

use App\Achievements\Achievement as AchievementType;
use App\Models\User;

class TwentyCommentsWritten extends AchievementType
{
    public string $achievementType = 'comment_written';

    public function __construct()
    {
        parent::__construct('20 Comments Written', 'Some Description');
    }

    /**
     * @return bool
     */
    public function qualify(User $user): bool
    {
        return $user->comments()->count() >= 20;
    }
}
