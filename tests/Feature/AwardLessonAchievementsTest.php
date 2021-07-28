<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Listeners\AwardAchievementForLessonWatched;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
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

    /**
     * @test
     */
    public function itFiresAnEventWhenAnAchievementIsAwarded()
    {
        Event::fake();

        $user = User::factory()->create();

        $user->lessons()
            ->attach(Lesson::factory()->count(24)->create(),
                ['watched' => true]);

        $twentyFifthLesson = Lesson::factory()->create();

        $user->lessons()->attach($twentyFifthLesson, ['watched' => true]);

        (new AwardAchievementForLessonWatched())->handle(new LessonWatched($twentyFifthLesson, $user));

        $achievement = $user->achievements->last();

        Event::assertDispatched(function (AchievementUnlocked $event) use ($user, $achievement) {
            return $event->user->id === $user->id && $event->achievement == $achievement->name;
        });
    }


    /**
     * @test
     */
    public function itPreventsDuplicateAchievements()
    {
        $user = User::factory()->create();

        $lesson = Lesson::factory()->create();

        $user->lessons()->attach($lesson, ['watched' => true]);

        (new AwardAchievementForLessonWatched())->handle(new LessonWatched($lesson, $user));

        $this->assertSame(1, $user->achievements->count());

        (new AwardAchievementForLessonWatched())->handle(new LessonWatched($lesson, $user));

        $this->assertSame(1, $user->achievements->count());
    }

}
