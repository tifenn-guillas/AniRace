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

    private $json;


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
        $this->circuit = new Circuit($this->animals);
        $this->json = fopen('./race.json', 'w');
    }


    public function run() {
        $i = 0;
        fwrite($this->json, '[');
        while (count($this->ranking) < $this->nbAnimals) {
            $this->rulesManager->applyRules();
            $this->progress();
            $this->checkProgress();
            $this->toJson($i);
            $i++;
        }
        $this->prettyPrint();
        fwrite($this->json, ']');
        fclose($this->json);
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

    /**
     * @param int $i
     */
    private function toJson(int $i) {
//        $animalPosition = $this->circuit->getAnimalsPosition();
        $json = '{"iteration ' . $i . '" : [';
        $json .= '{"animals" : ';
        $json .= json_encode($this->animals);
        $json .= '},';
        $json .= '{"applied rules" : ';
        $json .= json_encode($this->rulesManager->getAppliedRules());
        $json .= '},';
        $json .= '{"animals position" : ';
        $json .= json_encode($this->circuit->getAnimalsPosition());
        $json .= '}';
        $json .= ']}';
        fwrite($this->json, $json);
        if (!empty($this->animals)) {
            fwrite($this->json, ',');
        }
    }

    private function prettyPrint() {
        foreach ($this->ranking as $rank => $animal)
        {
            echo $rank+1 . ' -> '. get_class($animal) . PHP_EOL;
        }
    }
}