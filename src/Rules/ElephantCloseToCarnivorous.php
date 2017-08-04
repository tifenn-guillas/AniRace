<?php

namespace AniRace\Rules;

use AniRace\Animal\Animal;
use AniRace\Animal\Elephant;

class ElephantCloseToCarnivorous
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
     * ElephantCloseToCarnivorous constructor.
     * @param array $history
     * @param Animal[] $animals
     */
    public function __construct($history, $animals)
    {
        $this->history = $history;
        $this->animals = $animals;
    }

    public function applyRule(&$appliedOn) {
        $appliedOn = null;
        if ($this->isAnimalsClose()) {
            foreach ($this->history['CloseToElephant'] as $animal) {
                if ($this->isCarnivorous($animal)) {
                    $elephant = $this->searchElephant();
                    $this->applyBonus($elephant);
                    $appliedOn = $elephant;
                    break;
                }
            }
        }
    }

    /**
     * @param Elephant $elephant
     */
    public function removeRule($elephant) {
        $elephant->setSpeed($elephant->getSpeedInit() / (1 + 0.03));
    }

    private function isAnimalsClose() {
        if (array_key_exists('CloseToElephant', $this->history)) {
            return true;
        }
        return false;
    }

    /**
     * @param Animal $animal
     * @return bool
     */
    private function isCarnivorous($animal) {
        if ($animal->getDiet() == 'carnivorous') {
            return true;
        }
        return false;
    }

    /**
     * @return Elephant
     */
    private function searchElephant() {
        foreach ($this->animals as $animal) {
            if ($animal instanceof Elephant) {
                return $animal;
            }
        }
    }

    /**
     * @param Elephant $elephant
     */
    private function applyBonus($elephant) {
        $elephant->setSpeed($elephant->getSpeedInit() * (1 - 0.03));
    }
}