<?php

namespace App\Achievements;

use App\Models\User;

abstract class Achievement
{
    public $model;

    public $achievementType;

    /**
     * Checks whether the user qualifies for the achievement.
     * @param User $user
     * @return mixed
     */
    abstract public function qualify(User $user);

    /**
     * Returns the primary key for respected model.
     * @return mixed
     */

    public function primaryKey()
    {
        return $this->model->getKey();
    }
}
