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
     * @var array
     */
    private $rules;


    /**
     * RulesManager constructor.
     * @param Animal[] $animals
     */
    public function __construct(array $animals)
    {
        $this->animals = $animals;
        $this->appliedRules = new ArrayCollection([]);
        $this->rules = array(
            new NotElephantCloseToCarnivorous($this->animals, $this->appliedRules),
            new NotCloseToElephant($this->animals, $this->appliedRules),
            new CloseToElephant($this->animals, $this->appliedRules),
            new ElephantCloseToCarnivorous($this->animals, $this->appliedRules),
        );
    }

    public function applyRules()
    {
        foreach ($this->rules as $rule) {
            $rule->applyRule();
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getAppliedRules()
    {
        return $this->appliedRules->toArray();
    }
}