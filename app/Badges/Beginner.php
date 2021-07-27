<?php


namespace App\Badges;
use App\Badges\Badge as BadgeType;
use App\Models\User;


class Beginner extends BadgeType
{
    public function __construct()
    {
        $this->model = Badge::create([
           'name' => 'Beginner',
           'required_achievements' => 4
        ]);
    }

    public function qualify(User $user)
    {
        return $user->achievements()->count() == 0;
    }
}
