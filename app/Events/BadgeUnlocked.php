<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BadgeUnlocked
{
    use Dispatchable;
    use SerializesModels;

    public User $user;

    public string $badgeName;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $badgeName)
    {
        $this->user = $user;
        $this->badgeName = $badgeName;
    }
}
