<?php

namespace AniRace\Rules;

use AniRace\Animal\Animal;
use AniRace\Animal\Elephant;

class ElephantCloseToCarnivorous
{
    /**
     * @var Animal[]
     */
    private $animals;

    /**
     * ElephantCloseToCarnivorous constructor.
     * @param Animal[] $animals
     */
    public function __construct($animals)
    {
        $this->animals = $animals;
    }

    public function applyRule(&$appliedRules) {
        if ($this->isAnimalsClose($appliedRules)) {
            foreach ($appliedRules['CloseToElephant'] as $key => $animal) {
                if ($this->isCarnivorous($animal)) {
                    $indexElephant = $this->searchElephant();
                    $this->applyBonus($this->animals[$indexElephant]);
                    $appliedRules['ElephantCloseToCarnivorous'] = $this->animals[$indexElephant];
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

    /**
     * @param array $appliedRules
     * @return bool
     */
    private function isAnimalsClose($appliedRules) {
        if (array_key_exists('CloseToElephant', $appliedRules)) {
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
        foreach ($this->animals as $key => $animal) {
            if ($animal instanceof Elephant) {
                return $key;
            }
        }
    }

    /**
     * @param Elephant $elephant
     */
    private function applyBonus($elephant) {
        $elephant->setSpeed($elephant->getSpeedInit() * (1 + 0.03));
    }
}