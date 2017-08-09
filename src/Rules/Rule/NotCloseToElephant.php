<?php

namespace AniRace\Rules\Rule;

use AniRace\Animal\Animal;
use AniRace\Rules\Rule;
use Doctrine\Common\Collections\ArrayCollection;

class NotCloseToElephant extends Rule
{
    /**
     * NotCloseToElephant constructor.
     * @param Animal[] $animals
     * @param ArrayCollection $appliedRules
     */
    public function __construct($animals, $appliedRules)
    {
        parent::__construct($animals, $appliedRules);
    }


    public function applyRule() {
        if ($this->appliedRules->containsKey('CloseToElephant')) {
            foreach ($this->appliedRules->get('CloseToElephant') as $animal) {
                $this->applyConstraint($animal);
            }
            $this->appliedRules->remove('CloseToElephant');
        }
    }

    /**
     * @param Animal $animal
     */
    private function applyConstraint($animal) {
        $animal->setSpeed($animal->getSpeedInit() / (1 - 0.03));
    }
}