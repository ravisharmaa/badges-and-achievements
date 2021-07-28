<?php

namespace App\Providers;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Listeners\AssignBadge;
use App\Listeners\AwardAchievementForCommentsWritten;
use App\Listeners\AwardAchievementForLessonWatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            AwardAchievementForCommentsWritten::class
        ],

        LessonWatched::class => [
            AwardAchievementForLessonWatched::class
        ],

        AchievementUnlocked::class => [
            AssignBadge::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
