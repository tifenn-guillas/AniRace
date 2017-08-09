<?php

namespace AniRace\Rules;

use AniRace\Animal\Animal;
use Doctrine\Common\Collections\ArrayCollection;

abstract class Rule
{
    /**
     * @var Animal[]
     */
    protected $animals;

    /**
     * @var ArrayCollection
     */
    protected $appliedRules;

    /**
     * Rule constructor.
     * @param Animal[] $animals
     * @param ArrayCollection $appliedRules
     */
    public function __construct($animals, $appliedRules)
    {
        $this->animals = $animals;
        $this->appliedRules = $appliedRules;
    }


    abstract public function applyRule();
}