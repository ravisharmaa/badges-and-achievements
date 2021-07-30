<?php

namespace App\Badges;

use App\Badges\Badge as BadgeType;
use App\Models\Badge;
use App\Models\User;

class Intermediate extends BadgeType
{
    public function __construct()
    {
        parent::__construct('Intermediate', 4);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function qualify(User $user): bool
    {
        return $user->achievements()->count() >= 4;
    }
}
