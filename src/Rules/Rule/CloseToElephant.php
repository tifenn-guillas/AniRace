<?php

namespace AniRace\Rules\Rule;

use AniRace\Animal\Animal;
use AniRace\Animal\Breed\Elephant;
use AniRace\Rules\Rule;
use Doctrine\Common\Collections\ArrayCollection;

class CloseToElephant extends Rule
{
    /**
     * @var int
     */
    private $distance;


    /**
     * CloseToElephant constructor.
     * @param Animal[] $animals
     * @param ArrayCollection $appliedRules
     */
    public function __construct(array $animals, ArrayCollection $appliedRules)
    {
        parent::__construct($animals, $appliedRules);
        $this->distance = 50;
    }


    public function applyRule() {
        $appliedOn = [];
        if ($this->elephantExists()) {
            $indexElephant = $this->indexElephant();
            /** @var Elephant $elephant */
            $elephant = $this->animals[$indexElephant];
            foreach ($this->animals as $key => $animal) {
                if ($key == $indexElephant) {
                    continue;
                }
                if ($this->isCloseToElephant($elephant, $animal)) {
                    $this->applyConstraint($animal);
                    $appliedOn[] = $this->animals[$key];
                }
            }
            if (!empty($appliedOn)) {
                $this->appliedRules->set('CloseToElephant', $appliedOn);
            }
        }
    }

    /**
     * @param Animal $animal
     */
    public function removeRule(Animal $animal) {
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
    private function isCloseToElephant(Elephant $elephant, Animal $animal) {
        $d = abs($elephant->getProgress() - $animal->getProgress());
        if ($d < $this->distance) {
            return true;
        }
        return false;
    }

    /**
     * @param Animal $animal
     */
    private function applyConstraint(Animal $animal) {
        $animal->setSpeed($animal->getSpeedInit() * (1 - 0.03));
    }
}