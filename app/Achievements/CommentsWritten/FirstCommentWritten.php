<?php


namespace App\Achievements\CommentsWritten;
use App\Models\User;
use App\Models\Achievement;
use App\Achievements\Achievement as AchievementType;

class FirstCommentWritten extends AchievementType
{

    public $achievementType = 'comment_written';

    public function __construct()
    {
        $this->model = Achievement::firstOrCreate([
            'name' => 'First Comment Written',
            'description' => 'Some Description',
            'achievement_type' => 'comment_written'
        ]);
    }

    /**
     *
     * @param User $user
     * @return bool|mixed
     */

    public function qualify(User $user)
    {
        return !!$user->comments()->count();
    }
}
