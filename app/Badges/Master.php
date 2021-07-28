<?php

namespace App\Badges;

use App\Badges\Badge as BadgeType;
use App\Models\Badge;
use App\Models\User;

class Master extends BadgeType
{
    public function __construct()
    {
        $this->model = Badge::create([
            'name' => 'Intermediate',
            'required_achievements' => 10,
        ]);
    }

    public function qualify(User $user)
    {
        return $user->achievements()->count() == 10;
    }
}
