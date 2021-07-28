<?php

namespace App\Badges;

use App\Badges\Badge as BadgeType;
use App\Models\Badge;
use App\Models\User;

class Intermediate extends BadgeType
{
    public function __construct()
    {
        $this->model = Badge::firstOrCreate([
            'name' => 'Intermediate',
            'required_achievements' => 4,
        ]);
    }

    public function qualify(User $user)
    {
        return $user->achievements()->count() >= 4;
    }
}
