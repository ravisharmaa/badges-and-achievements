<?php

namespace App\Achievements\CommentsWritten;

use App\Models\Achievement;
use App\Models\User;
use App\Achievements\Achievement as AchievementType;

class TenCommentsWritten extends AchievementType
{

    public $achievementType = 'comment_written';

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
            'name' => '10 Comments Written',
            'description' => 'Some Description',
            'achievement_type' => 'comment_written'
        ]);
    }

    /**
     * @param User $user
     * @return bool
     */

    public function qualify(User $user)
    {
        return $user->comments()->count() >= 10;
    }

    /**
     *
     */
    public function primaryKey()
    {
        return $this->model->getKey();
    }
}
