<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SyncAchievementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */

    public function itExpectsAnArgumentForSyncingForSyncingAchievements()
    {
        $this->artisan('sync-achievements', ['achievement' => null])
        ->expectsOutput('Argument is required');

    }

    /**
     * @test
     */
    public function itSyncsAchievementsForExistingUsers()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Comment::factory()->count(10)->create([
           'user_id' => $user->id,
       ]);

        $user->lessons()
            ->attach(Lesson::factory()->count(10)->create(),
                ['watched' => true]);

        $this->artisan('sync-achievements', ['achievement' => 'comment_written']);


        $this->artisan('sync-achievements', ['achievement' => 'lesson_watched']);

        $this->assertSame(7, $user->achievements->fresh()->count());

    }
}
