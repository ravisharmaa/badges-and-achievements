<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Listeners\AssignBadge;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignBadgesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function userCanReceiveBeginnerBadgeForLessThanFourAchievements()
    {
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
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(7)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $lastAchievement = $user->achievements->fresh()->last();

        (new AssignBadge())->handle(new AchievementUnlocked($user, $lastAchievement));

        print $user->achievements->count();

        $this->assertSame('Intermediate', $user->badges->fresh()->last()->name);
    }

    /**
     * @test
     */

    public function userCanReceiveAdvancedBadgeForLessThanEightAchievements()
    {
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(9)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $lastAchievement = $user->achievements->fresh()->last();

        (new AssignBadge())->handle(new AchievementUnlocked($user, $lastAchievement));

        print $user->achievements->count();

        $this->assertSame('Advanced', $user->badges->fresh()->last()->name);
    }

    /**
     * @test
     */

    public function userCanReceiveMasterBadgeForLessThanEightAchievements()
    {
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(12)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $lastAchievement = $user->achievements->fresh()->last();

        (new AssignBadge())->handle(new AchievementUnlocked($user, $lastAchievement));



        $this->assertSame('Advanced', $user->badges->fresh()->last()->name);
    }
}
