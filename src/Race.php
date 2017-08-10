<?php

namespace AniRace;

use AniRace\Animal\Animal;
use AniRace\Animal\Breed\Horse;
use AniRace\Animal\Breed\Elephant;
use AniRace\Animal\Breed\Leopard;
use AniRace\Circuit\Circuit;
use AniRace\Rules\RulesManager;

class Race
{
    /**
     * @var Animal[]
     */
    private $animals;

    /**
     * @var int
     */
    private $nbAnimals;

    /**
     * @var array
     */
    private $ranking = [];

    /**
     * @var RulesManager
     */
    private $rulesManager;

    /**
     * @var Circuit
     */
    private $circuit;


    /**
     * RaceManager constructor.
     */
    public function __construct()
    {
        $this->animals = array(
            new Horse(),
            new Elephant(),
            new Leopard()
        );
        $this->nbAnimals = count($this->animals);
        $this->rulesManager = new RulesManager($this->animals);
        $this->circuit = new Circuit();
    }


    public function run() {
        while (count($this->ranking) < $this->nbAnimals) {
            $this->rulesManager->applyRules();
            $this->progress();
            $this->checkProgress();
        }
        $this->prettyPrint();
    }

    private function progress() {
        foreach ($this->animals as $animal) {
            $animal->progress();
        }
    }

    private function checkProgress() {
        // TODO: if more than 1 animal finish the race at the same time ?
        foreach ($this->animals as $key => $animal) {
            if (($animal->getProgress() >= $this->circuit->getSize())) {
                array_push($this->ranking, $animal);
                unset($this->animals[$key]);
            }
        }
    }

    private function prettyPrint() {
        foreach ($this->ranking as $rank => $animal)
        {
            echo $rank+1 . ' -> '. get_class($animal) . PHP_EOL;
        }
    }
}