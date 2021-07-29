<?php

namespace App\Badges;

use App\Badges\Badge as BadgeType;
use App\Models\User;
use App\Models\Badge;

class Advanced extends BadgeType
{
    public function __construct()
    {
        $this->model = Badge::firstOrCreate([
            'name' => 'Advanced',
            'required_achievements' => 8,
        ]);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function qualify(User $user): bool
    {
        return $user->achievements()->count() >= 8;
    }
}
