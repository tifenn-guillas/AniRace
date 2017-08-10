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
        $this->stamina = 100;
        $this->speed = 20;
        $this->diet ='herbivorous';
        parent::__construct();
    }
}