<?php

namespace AniRace\Rules\Rule;

use AniRace\Animal\Animal;
use AniRace\Animal\Breed\Elephant;
use AniRace\Rules\Rule;
use Doctrine\Common\Collections\ArrayCollection;

class ElephantCloseToCarnivorous extends Rule
{
    /**
     * ElephantCloseToCarnivorous constructor.
     * @param Animal[] $animals
     * @param ArrayCollection $appliedRules
     */
    public function __construct($animals, $appliedRules)
    {
        parent::__construct($animals, $appliedRules);
    }

    public function applyRule() {
        if ($this->areAnimalsClose()) {
            foreach ($this->appliedRules->get('CloseToElephant') as $key => $animal) {
                if ($this->isCarnivorous($animal)) {
                    $indexElephant = $this->searchElephant();
                    $this->applyBonus($this->animals[$indexElephant]);
                    $this->appliedRules->set('ElephantCloseToCarnivorous', $this->animals[$indexElephant]);
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
     * @return bool
     */
    private function areAnimalsClose() {
        if ($this->appliedRules->containsKey('CloseToElephant')) {
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