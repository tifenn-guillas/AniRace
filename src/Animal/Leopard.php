<?php

namespace AniRace\Animal;

class Leopard extends Animal
{
    /**
     * Leopard constructor.
     */
    public function __construct()
    {
        $this->setStamina(10);
        $this->setSpeed(90);
        $this->setDiet('carnivorous');
        parent::__construct();
    }
}