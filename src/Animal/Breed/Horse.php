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
        parent::__construct();
        $this->breed = 'Horse';
        $this->stamina = 100;
        $this->staminaMax = 100;
        $this->speed = 20;
        $this->speedInit = 20;
        $this->diet ='herbivorous';
    }
}