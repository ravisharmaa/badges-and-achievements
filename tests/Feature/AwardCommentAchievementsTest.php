<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Listeners\AwardAchievementForCommentsWritten;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::factory()->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
    }
}
