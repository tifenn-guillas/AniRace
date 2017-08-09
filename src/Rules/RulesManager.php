<?php

namespace AniRace\Rules;

use AniRace\Animal\Animal;
use AniRace\Rules\Rule\CloseToElephant;
use AniRace\Rules\Rule\ElephantCloseToCarnivorous;
use AniRace\Rules\Rule\NotCloseToElephant;
use AniRace\Rules\Rule\NotElephantCloseToCarnivorous;
use Doctrine\Common\Collections\ArrayCollection;

class RulesManager
{
    /**
     * @var Animal[]
     */
    private $animals;

    /**
     * @var ArrayCollection
     */
    private $appliedRules;

    /**
     * @var CloseToElephant
     */
    private $closeToElephant;

    /**
     * @var NotCloseToElephant
     */
    private $notCloseToElephant;

    /**
     * @var ElephantCloseToCarnivorous
     */
    private $elephantCloseToCarnivorous;

    /**
     * @var NotElephantCloseToCarnivorous
     */
    private $notElephantCloseToCarnivorous;

    /**
     * RulesManager constructor.
     * @param Animal[] $animals
     */
    public function __construct($animals)
    {
        $this->animals = $animals;
        $this->appliedRules = new ArrayCollection([]);
        $this->closeToElephant = new CloseToElephant($this->animals, $this->appliedRules);
        $this->notCloseToElephant = new NotCloseToElephant($this->animals, $this->appliedRules);
        $this->elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($this->animals, $this->appliedRules);
        $this->notElephantCloseToCarnivorous = new NotElephantCloseToCarnivorous($this->animals, $this->appliedRules);
    }

    public function applyRules()
    {
        $this->notElephantCloseToCarnivorous->applyRule();
        $this->notCloseToElephant->applyRule();
        $this->closeToElephant->applyRule();
        $this->elephantCloseToCarnivorous->applyRule();
    }
}