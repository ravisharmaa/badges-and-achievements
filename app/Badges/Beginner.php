<?php


namespace App\Badges;
use App\Badges\Badge as BadgeType;
use App\Models\User;
use App\Models\Badge;


class Beginner extends BadgeType
{
    public function __construct()
    {
        $this->model = Badge::create([
           'name' => 'Beginner',
           'required_achievements' => 0
        ]);
    }

    public function qualify(User $user)
    {
        return !!$user->achievements()->count();
    }
}
