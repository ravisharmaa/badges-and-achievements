<?php


namespace App\Achievements;


use App\Models\User;

abstract class Achievement
{
    public $model;

    public $achievementType;

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
