<?php

namespace AniRace\Rules;

use AniRace\Animal\Animal;
use AniRace\Animal\Elephant;
use SebastianBergmann\CodeCoverage\Report\PHP;

class RulesManager
{
    /**
     * @var Animal[]
     */
    private $animals;

    /**
     * @var array
     */
    private $appliedRules = [];

    /**
     * @var CloseToElephant
     */
    private $closeToElephant;

    /**
     * @var ElephantCloseToCarnivorous
     */
    private $elephantCloseToCarnivorous;

    /**
     * RulesManager constructor.
     * @param Animal[] $animals
     */
    public function __construct($animals)
    {
        $this->animals = $animals;
        $this->closeToElephant = new CloseToElephant($this->animals);
        $this->elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($this->animals);
    }

    public function applyRules() {
        $this->removeRules();
        $this->closeToElephant->applyRule($this->appliedRules);
        $this->elephantCloseToCarnivorous->applyRule($this->appliedRules);
    }

    private function removeRules() {
        foreach ($this->appliedRules as $rule => $value) {
            switch ($rule) {
                case 'CloseToElephant':
                    foreach ($value as $animal) {
                        $this->closeToElephant->removeRule($animal);
                    }
                    break;
                case 'ElephantCloseToCarnivorous':
                    $this->elephantCloseToCarnivorous->removeRule($value);
                    break;
            }
        }
        $this->appliedRules = [];
    }
}