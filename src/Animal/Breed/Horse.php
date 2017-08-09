<?php

namespace AniRace\Animal\Breed;

use AniRace\Animal\Animal;

class Horse extends Animal
{
    /**
     * Horse constructor.
     */
    public function __construct()
    {
        $this->setStamina(100);
        $this->setSpeed(20);
        $this->setDiet('herbivorous');
        parent::__construct();
    }
}