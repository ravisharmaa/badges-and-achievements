<?php

namespace App\Achievements\CommentsWritten;

use App\Models\User;
use App\Models\Achievement;
use App\Achievements\Achievement as AchievementType;

class FirstCommentWritten extends AchievementType
{
    public string $achievementType = 'comment_written';

    public $requiredAchievements = 0;

    public function __construct()
    {
        parent::__construct('First Comment Written', 'Some Description');
    }

    /**
     *
     * @param User $user
     * @return bool
     */

    public function qualify(User $user): bool
    {
        return !!$user->comments()->count();
    }
}
