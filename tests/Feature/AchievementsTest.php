<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\AwardAchievementForCommentsWritten;
use App\Listeners\AwardAchievementForLessonWatched;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchievementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function userCanReceiveAchievementsByWatchingVideoOrWritingComments()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AwardAchievementForCommentsWritten())->handle(new CommentWritten($comment));

        $lesson = Lesson::factory()->create();

        $user->lessons()->attach($lesson, ['watched' => true]);

        (new AwardAchievementForLessonWatched())->handle(new LessonWatched($lesson, $user));

        $this->assertSame(2, $user->achievements->count());
    }
}
