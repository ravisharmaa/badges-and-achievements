<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Listeners\AwardAchievementForCommentsWritten;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AwardCommentAchievementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function userReceivesAnAchievementAfterPostingAComment()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AwardAchievementForCommentsWritten())->handle(new CommentWritten($comment));

        $this->assertSame(1, $user->achievements->count());
    }

    /**
     * @test
     */
    public function userReceivesFiveAchievementsUponPostingTwentiethComment()
    {
        $user = User::factory()->create();

        Comment::factory()->count(19)->create([
            'user_id' => $user->id,
        ]);

        $twentiethComment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AwardAchievementForCommentsWritten())->handle(new CommentWritten($twentiethComment));

        $this->assertSame(5, $user->achievements->count());
    }

    /**
     * @test
     */
    public function itFiresAnEventWhenAnAchievementIsAwarded()
    {
        Event::fake();

        $user = User::factory()->create();

        Comment::factory()->count(19)->create([
            'user_id' => $user->id,
        ]);

        $twentiethComment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AwardAchievementForCommentsWritten())->handle(new CommentWritten($twentiethComment));

        $achievement = $user->achievements->last();

        Event::assertDispatched(function (AchievementUnlocked $event) use ($user, $achievement) {
            return $event->user->id === $user->id && $event->achievement == $achievement->name;
        });
    }
}
