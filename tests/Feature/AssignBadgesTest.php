<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Listeners\AssignBadge;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AssignBadgesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function userCanReceiveBeginnerBadgeForLessThanFourAchievements()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $achievement = $user->achievements->first();

        (new AssignBadge())->handle(new AchievementUnlocked($user, $achievement));


        $this->assertSame('Beginner', $user->badges->first()->name);
    }

    /**
     * @test
     */
    public function userCanReceiveIntermediateBadgeForLessThanEightAchievements()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(7)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $lastAchievement = $user->achievements->fresh()->last();

        (new AssignBadge())->handle(new AchievementUnlocked($user, $lastAchievement));


        $this->assertSame('Intermediate', $user->badges->fresh()->last()->name);
    }

    /**
     * @test
     */

    public function userCanReceiveAdvancedBadgeForLessThanEightAchievements()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(9)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $lastAchievement = $user->achievements->fresh()->last();

        (new AssignBadge())->handle(new AchievementUnlocked($user, $lastAchievement));

        $this->assertSame('Advanced', $user->badges->fresh()->last()->name);
    }

    /**
     * @test
     */

    public function userCanReceiveMasterBadgeForGreaterThanTenAchievements()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(12)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        (new AssignBadge())->handle(new AchievementUnlocked($user, Achievement::first()));

        $this->assertSame('Master', $user->badges->fresh()->last()->name);
    }

    /**
     * @test
     */

    public function itFiresEventWhenABadgeIsAssigned()
    {
        Event::fake();

        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(12)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        (new AssignBadge())->handle(new AchievementUnlocked($user, Achievement::first()));

        $badge = $user->badges->last();

        Event::assertDispatched(function(BadgeUnlocked $event) use ($user, $badge){
            return $event->badgeName == $badge->name && $event->user->name == $user->name;
        });

    }
}
