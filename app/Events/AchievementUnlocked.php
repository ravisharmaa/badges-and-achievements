<?php

namespace App\Events;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AchievementUnlocked
{
    use Dispatchable;
    use SerializesModels;

    public User $user;

    public string $achievement;

    /**
     * Create a new event instance.
     * @param User $user
     * @param string $achievement
     */
    public function __construct(User $user, string $achievement)
    {
        $this->user = $user;
        $this->achievement = $achievement;
    }
}
