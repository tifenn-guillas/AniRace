<?php

namespace AniRace\Rules;

use AniRace\Animal\Animal;
use AniRace\Animal\Elephant;

class CloseToElephant
{
    /**
     * @var array
     */
    private $history;

    /**
     * @var Animal[]
     */
    private $animals;

    /**
     * @var int
     */
    private $distance;

    /**
     * CloseToElephant constructor.
     * @param array $history
     * @param Animal[] $animals
     */
    public function __construct($history, $animals)
    {
        $this->history = $history;
        $this->animals = $animals;
        $this->distance = 50;
    }

    /**
     * @return array
     */
    public function applyRule(&$appliedOn) {
        $appliedOn = [];
        if ($this->elephantExists()) {
            $indexElephant = $this->indexElephant();
            $elephant = $this->animals[$indexElephant];
            foreach ($this->animals as $key => $animal) {
                if ($key == $indexElephant) {
                    continue;
                }
                if ($this->isCloseToElephant($elephant, $animal)) {
                    $this->applyConstraint($animal);
                    $appliedOn[] = $animal;
                }
            }
        }
    }

    /**
     * @param Animal $animal
     */
    public function removeRule($animal) {
        $animal->setSpeed($animal->getSpeedInit() / (1 - 0.03));
    }

    /**
     * @return boolean
     */
    private function elephantExists() {
        foreach ($this->animals as $animal) {
            if ($animal instanceof Elephant) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return int
     */
    private function indexElephant() {
        foreach ($this->animals as $key => $animal) {
            if ($animal instanceof Elephant) {
                return $key;
            }
        }
    }

    /**
     * @param Elephant $elephant
     * @param Animal $animal
     * @return bool
     */
    private function isCloseToElephant($elephant, $animal) {
        $d = abs($elephant->getProgress() - $animal->getProgress());
        if ($d < $this->distance) {
            return true;
        }
        return false;
    }

    /**
     * @param Animal $animal
     */
    private function applyConstraint($animal) {
        $animal->setSpeed($animal->getSpeedInit() * (1 - 0.03));
    }
}