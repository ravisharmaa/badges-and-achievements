<?php

namespace Tests\Unit;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function itHasManyComments()
    {
        $user = User::factory()->create();

        Comment::factory()->make([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(HasMany::class, $user->comments());
    }

    /**
     * @test
     */
    public function itHasManyAchievements()
    {
        $user = User::factory()->create();

        Achievement::factory()->count(10)->afterMaking(function ($achievement) use ($user) {
            $achievement->user()->attach($user);
        });

        $this->assertInstanceOf(BelongsToMany::class, $user->achievements());
    }

    /**
     * @test
     */
    public function itCanAwardAchievement()
    {
        $this->withoutEvents();

        $user = User::factory()->create();

        Comment::factory()->count(2)->create([
            'user_id' => $user->id
        ]);

        $achievements = Achievement::factory()->count(2)->create([
            'achievement_type' => 'comment_written',
        ])->pluck('id');

        $user->awardAchievement($achievements);

        $this->assertSame(2, $user->achievements->count());
    }

    /**
     * @test
     */
    public function itBelongsToManyBadges()
    {
        $user = User::factory()->make();

        Badge::factory()->count(10)->afterMaking(function ($badge) use ($user) {
            $badge->user()->attach($user);
        });

        $this->assertInstanceOf(BelongsToMany::class, $user->badges());
    }

    /**
     * @test
     */

    public function itCanAssignBadges()
    {
        $this->withoutEvents();

        $user = User::factory()->create();

        $badges = Badge::factory()->count(10)->create()->pluck('id');

        $user->assignBadges($badges);

        $this->assertSame(10, $user->badges->count());

    }
}
