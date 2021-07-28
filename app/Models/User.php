<?php

namespace App\Models;

use App\Events\AchievementUnlocked;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    /**
     * Achievements related to a user.
     *
     * @return BelongsToMany
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class)->withTimestamps();
    }

    /**
     * Add achievement.
     *
     * @param $achievements
     *
     * @return $this
     */
    public function awardAchievement($achievements)
    {
        $this->achievements()->attach($achievements);

        AchievementUnlocked::dispatch($this, $this->achievements->last());

        return $this;
    }

    /**
     * @return BelongsToMany
     */

    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    /**
     * @param $badges
     * @return $this
     */
    public function assignBadges($badges)
    {
        $this->badges()->attach($badges);

        return $this;
    }


}
