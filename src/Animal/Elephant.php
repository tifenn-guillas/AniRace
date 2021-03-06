<?php

namespace AniRace\Animal;

class Elephant extends Animal
{
    /**
     * Elephant constructor.
     */
    public function __construct()
    {
        $this->setStamina(50);
        $this->setSpeed(30);
        $this->setDiet('herbivorous');
        parent::__construct();
    }
}