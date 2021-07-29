# Badges And Achievements

The task from iPhone Photography School.

## Assumptions
These have been the assumptions while working on the test application.
1. User can have many achievements and vice versa.
2. User can have many badges and vice versa.
3. The events `Lesson Watched` and `Comment Written` are fired whenever a user watches a video or comments down, and the application acts according to that.
4. The application has following achievements:
    1. First CommentWritten
    2. Three Comments Written
    3. FiveCommentsWritten
    4. TenCommentsWritten
    5. TwentyCommentsWritten
    6. FirstLessonWatched
    7. 5 Lessons Watched
    8. 25 Lessons Watched
    9. 50 Lessons Watched

5. The application has following badges:
    1. Beginner: 0 Achievements
    2. Intermediate: 4 Achievements
    3. Advanced: 8 Achievements
    4. Master: 10 Achievements

    

## Solution formulation

Steps I thought of and executed for solving the given problem:

1. Prepare database tables which can persist the assignment of badges and achievements for retrieval.

2. Hook the event-listeners of `CommentWritten`, `LessonWatched` and handle the logic of assigning achievements of either 
   comment written or lesson watched.
   1. Add those achievements classes by their respective types either `lesson_watched` or `comment_written` within the 
    app and a service provider `AchievementServiceProvider`.The `boot` method for this provider loops over the classes
      and instantiates and keeps them inside a singleton class within the container.
   2. Afterwards when a user comments or watches video the respective events fire and the listeners `AwardAchievementsForCommentsWritten`,`AwardAchievementsForLessonWatched`   handle method access the achievements from the container and determine the event with the help of a property `achievementType` within the achievement classes and sends them to proper achievements to check whether the subject in question qualifies for the event or not.
   3. If they qualify for the achievement add the record to the `user_achievements` table and fire event `AchievementUnlocked`
      as the task has asked.

3. Add badge classes in the `Badges` directory and allow them to determine badges.
    1. Assign badge to the user in question when they receive an achievement with the help of the event `AchievementUnlocked` and listener `AssignBadges`. It also uses the exact approach of handling achievements, the only difference is the logic to ask the subject in question to award a badge. Please refer to `BadgeServiceProvider` and the classes inside the `Badge` directory to find more.
       
4. Add a console command to sync the achievements of existing users.
    1. The achievements have a type of `comment_written` and `lesson_watched` and for the case of existing users 
     the commands `php artisan sync-achievements comment_written` and `php artisan sync-achievements lesson_watched`
       help them sync their achievements.
    
       

## Libraries/Tools used
* No any third party library other than the framework itself provides.
* Uses php 8.0, but php >= 7.4 can also be used.
* Uses phpunit for testing and xDebug 3.0 for code coverage analysis.

## Installation

Run the following commands to set up the application, given that `php` and `composer` are available:

1. `git clone` https://github.com/ravisharmaa/badges-and-achievements.git
1. `cd badges-and-achievements`
1. `composer install`
1. `cp .env.example .env`

## Running Tests
1. `vendor/bin/phpunit`
1. For code coverage:  `vendor/bin/phpunit --coverage-text`
1. Additionally a report can also be generated using the command `vendor/bin/phpunit --coverage-html=reports`

The current code coverage is 91%. Given the laravel frameworks code which show uncovered while using xDebug.

![Code Coverage Report](https://user-images.githubusercontent.com/22126232/127415266-d6bb3f87-035a-48ec-83dc-e0e2a8d11dda.png)

## Usage of the project
The tests provide a basic overview of the application. Some steps can be done to see the application in action, which are.

1. The data for comments and lessons can be seeded via Tinker and achievements and badges can be seen.
    1. `php artisan tinker`
    2. ```php
       $user = User::factory()->create();

        Comment::factory()->count(10)->create([
           'user_id' => $user->id,
       ]);

        $user->lessons()->attach(Lesson::factory()->count(10)->create(),['watched' => true]);
        
        php artisan sync-achievements comment_written
        php artisan sync-achievements lesson_watched 
       
       ```
    3. Which results in the  output for url `/users/1/achievements`
        ```json
        {
            "unlocked_achievements": [
                "First Comment Written",
                "3 Comments Written",
                "5 Comments Written",
                "10 Comments Written",
                "First Lesson Watched",
                "5 Lessons Watched",
                "10 Lessons Watched"
            ],
            "next_available_achievements": [
                "20 Comments Written",
                "20 Lessons Watched",
                "25 Lessons Watched",
                "50 Lessons Watched"
            ],
            "current_badge": "Intermediate",
            "next_badge": "Advanced",
            "remaining_to_unlock_next_badge": 4
        } 
        ```


## Decisions, tradeoffs and constraints

1. I have used an implicit way of storing achievement, and badge names into the database while a user's achievements are calculated via the event. The constructor for each achievement add the necessary name for the achievement. An admin might want to edit their properties which currently,
   is a bit difficult. If there were a proper backend application which could help manage updates and addition of badges and achievements but it was out of the scope regarding the task and given time frame.
1. I have also added a property `achievement_type` in the database which seems redundant as it is used in the achievement class and in the table. Nevertheless, it might help in grouping the users via their achievement types.
1. I have also assumed that the next badge is in an incrementing order, which might not be the case always. I thought of adding a `next_badge` in the badges table but somehow opted from that.
1. There are places to improve. Still, I would not opt to do them all for a small problem domain like this one. As software engineers we need to find a balance.

## Future Improvements.

It was a challenge. However, if I had to improve upon this:

1. I would work out to find out a proper way to store next badges.
1. Achievements could be editable, or a command to create the achievements and the related class would be great!
   The developer then only had to add the related class and qualifier logic and be done.
1. For a team project, it will be good to have the project dockerized.
