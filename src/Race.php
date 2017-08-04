<?php

namespace AniRace;

use AniRace\Animal\Animal;
use AniRace\Animal\Horse;
use AniRace\Animal\Elephant;
use AniRace\Animal\Leopard;
use AniRace\Field\Field;
use AniRace\Rules\RulesManager;

class Race
{
    /**
     * @var Field
     */
    private $field;

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
        $this->field = new Field();
        $this->rulesManager = new RulesManager($this->animals);
    }

    public function run() {
        while (count($this->ranking) < $this->nbAnimals) {
            $this->rulesManager->applyRules();
            $this->progress();
            $this->checkProgress();
//            echo '---------------------------------------------------' . PHP_EOL;
        }
        $this->prettyPrint();
    }

    private function progress() {
        foreach ($this->animals as $animal) {
            $animal->progress();
//            echo get_class($animal) . ' : ' . $animal->getProgress() . PHP_EOL;
        }
    }

    private function checkProgress() {
        // TODO: if more than 1 animal finish the race at the same time ?
        foreach ($this->animals as $key => $animal) {
            if (($animal->getProgress() >= $this->field->getDistance())) {
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