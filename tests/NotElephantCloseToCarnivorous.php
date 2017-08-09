<?php

use PHPUnit\Framework\TestCase;
use \AniRace\Animal\Breed\Leopard;
use \AniRace\Animal\Breed\Elephant;
use \Doctrine\Common\Collections\ArrayCollection;
use \AniRace\Rules\Rule\NotElephantCloseToCarnivorous;

/**
 * @covers NotElephantCloseToCarnivorous
 */
final class NotElephantCloseToCarnivorousTest extends TestCase
{
    public function testApplyRule()
    {
        $leopard = new Leopard();
        $elephant = new Elephant();
        $animals = array(
            $leopard,
            $elephant
        );
        $appliedRules = new ArrayCollection([]);
        $appliedRules->set('ElephantCloseToCarnivorous', $animals[1]);
        $finalSpeedElephant = $elephant->getSpeedInit() / (1 + 0.03);

        $notElephantCloseToCarnivorous = new NotElephantCloseToCarnivorous($animals, $appliedRules);
        $notElephantCloseToCarnivorous->applyRule();

        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($finalSpeedElephant, $animals[1]->getSpeed());
        $this->assertFalse($appliedRules->containsKey('ElephantCloseToCarnivorous'));
    }

    public function testNoRuleCloseToElephant()
    {
        $appliedRules = new ArrayCollection([]);
        $animals = [];

        $notElephantCloseToCarnivorous = new NotElephantCloseToCarnivorous($animals, $appliedRules);
        $notElephantCloseToCarnivorous->applyRule();

        $this->assertFalse($appliedRules->containsKey('ElephantCloseToCarnivorous'));
    }
}