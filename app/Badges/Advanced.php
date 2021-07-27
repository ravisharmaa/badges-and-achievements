<?php

namespace App\Badges;

use App\Badges\Badge as BadgeType;
use App\Models\User;

class Advanced extends BadgeType
{
    public function __construct()
    {
        $this->model = Badge::create([
            'name' => 'Advanced',
            'required_achievements' => 4,
        ]);
    }

    public function qualify(User $user)
    {
        return 0 == $user->achievements()->count();
    }
}
