<?php

namespace App\Achievements\CommentsWritten;

use App\Models\Achievement;
use App\Models\User;
use App\Achievements\Achievement as AchievementType;

class TenCommentsWritten extends AchievementType
{

    public string $achievementType = 'comment_written';

    public function __construct()
    {
        parent::__construct('10 Comments Written', 'Some Description');
    }

    /**
     * @param User $user
     * @return bool
     */

    public function qualify(User $user): bool
    {
        return $user->comments()->count() >= 10;
    }
}
