<?php

namespace Tests\Feature;

use App\Events\LessonWatched;
use App\Listeners\AwardAchievementForLessonWatched;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AwardLessonAchievementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function userReceivesAnAchievementAfterWatchingALesson()
    {

        $user = User::factory()->create();

        $lesson = Lesson::factory()->create();

        $user->lessons()->attach($lesson, ['watched' => true]);

        (new AwardAchievementForLessonWatched())->handle(new LessonWatched($lesson, $user));

        $this->assertSame(1, $user->achievements->count());
    }

    /**
     * @test
     */
    public function userReceivesFiveAchievementsUponWatchingTwentyFifthLesson()
    {
        $user = User::factory()->create();

        $user->lessons()
            ->attach(Lesson::factory()->count(24)->create(),
                ['watched' => true]);

        $twentyFifthLesson = Lesson::factory()->create();

        $user->lessons()->attach($twentyFifthLesson, ['watched' => true]);

        (new AwardAchievementForLessonWatched())->handle(new LessonWatched($twentyFifthLesson, $user));

        $this->assertSame(5, $user->achievements->count());
    }
}
