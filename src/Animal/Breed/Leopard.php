<?php

namespace AniRace\Animal\Breed;

use AniRace\Animal\Animal;

class Leopard extends Animal
{
    /**
     * Leopard constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->breed = 'Leopard';
        $this->stamina = 10;
        $this->staminaMax = 10;
        $this->speed = 90;
        $this->speedInit = 90;
        $this->diet ='carnivorous';
    }
}