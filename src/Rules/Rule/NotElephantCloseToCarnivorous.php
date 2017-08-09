<?php

namespace AniRace\Rules\Rule;

use AniRace\Animal\Animal;
use AniRace\Animal\Breed\Elephant;
use AniRace\Rules\Rule;
use Doctrine\Common\Collections\ArrayCollection;

class NotElephantCloseToCarnivorous extends Rule
{
    /**
     * NotElephantCloseToCarnivorous constructor.
     * @param Animal[] $animals
     * @param ArrayCollection $appliedRules
     */
    public function __construct($animals, $appliedRules)
    {
        parent::__construct($animals, $appliedRules);
    }

    public function applyRule() {
        if ($this->appliedRules->containsKey('ElephantCloseToCarnivorous')) {
            $this->applyConstraint($this->appliedRules->get('ElephantCloseToCarnivorous'));
            $this->appliedRules->remove('ElephantCloseToCarnivorous');
        }
    }

    /**
     * @param Elephant $elephant
     */
    private function applyConstraint($elephant) {
        $elephant->setSpeed($elephant->getSpeedInit() / (1 + 0.03));
    }
}