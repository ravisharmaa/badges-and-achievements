<?php

namespace App\Badges;

use App\Models\User;

abstract class Badge
{
    protected $model;

    abstract public function qualify(User $user);

    /**
     * Returns the primary key for respected model.
     *
     * @return mixed
     */
    public function primaryKey()
    {
        return $this->model->getKey();
    }
}
