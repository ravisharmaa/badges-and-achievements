<?php

namespace App\Models;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
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
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    /**
     * Achievements related to a user.
     */
    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class)->withTimestamps();
    }

    /**
     * @param $achievements
     *
     * @return $this
     */
    public function awardAchievement($achievements): User
    {
        $this->achievements()->syncWithoutDetaching($achievements);
        $lastAchievement = $this->achievements->last();

        AchievementUnlocked::dispatch($this, $lastAchievement->name);

        return $this;
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    /**
     * @param $badges
     *
     * @return $this
     */
    public function assignBadges($badges): User
    {
        $this->badges()->syncWithoutDetaching($badges);

        $lastBadge = $this->badges->last();

        BadgeUnlocked::dispatch($this, $lastBadge->name);

        return $this;
    }
}
