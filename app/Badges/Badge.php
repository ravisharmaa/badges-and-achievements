<?php

namespace App\Badges;

use App\Models\User;

abstract class Badge
{
    protected $model;

    public function __construct(string $name, int $requiredAchievements)
    {
        $this->model = \App\Models\Badge::firstOrCreate([
            'name' => $name,
            'required_achievements' => $requiredAchievements,
        ]);
    }

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
