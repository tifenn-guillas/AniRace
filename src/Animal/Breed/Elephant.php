<?php

namespace AniRace\Animal\Breed;

use AniRace\Animal\Animal;

class Elephant extends Animal
{
    /**
     * Elephant constructor.
     */
    public function __construct()
    {
        $this->breed = 'Elephant';
        $this->stamina = 50;
        $this->speed = 30;
        $this->diet ='herbivorous';
        parent::__construct();
    }
}