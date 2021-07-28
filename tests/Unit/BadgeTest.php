<?php

namespace Tests\Unit;

use App\Events\AchievementUnlocked;
use App\Listeners\AssignBadge;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function itBelongsToManyUsers()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(12)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        (new AssignBadge())->handle(new AchievementUnlocked($user, Achievement::first()->name));

        $badges = \App\Models\Badge::first();

        $this->assertInstanceOf(BelongsToMany::class, $badges->user());
    }
}
