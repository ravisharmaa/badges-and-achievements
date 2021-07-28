<?php

namespace Tests\Unit;

use App\Models\Achievement;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
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

        Achievement::factory()->count(10)->afterMaking(function($achievement) use ($user){
           $achievement->user()->attach($user);
        });

        $this->assertInstanceOf(BelongsToMany::class, $user->achievements());
    }

    /**
     * @test
     */

    public function it_can_award_achievement()
    {
        Event::fake();

    }
}
