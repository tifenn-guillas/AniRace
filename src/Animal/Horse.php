<?php

namespace AniRace\Animal;

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