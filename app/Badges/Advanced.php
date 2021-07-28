<?php

namespace App\Badges;

use App\Badges\Badge as BadgeType;
use App\Models\User;
use App\Models\Badge;

class Advanced extends BadgeType
{
    public function __construct()
    {
        $this->model = Badge::create([
            'name' => 'Advanced',
            'required_achievements' => 8,
        ]);
    }

    public function qualify(User $user)
    {
        return $user->achievements()->count() == 8;
    }
}
