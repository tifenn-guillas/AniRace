<?php

use PHPUnit\Framework\TestCase;
use \AniRace\Animal\Breed\Leopard;
use \AniRace\Animal\Breed\Elephant;
use \AniRace\Animal\Breed\Horse;
use \Doctrine\Common\Collections\ArrayCollection;
use \AniRace\Rules\Rule\ElephantCloseToCarnivorous;

/**
 * @covers ElephantCloseToCarnivorous
 */
final class ElephantCloseToCarnivorousTest extends TestCase
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
        $appliedRules->set('CloseToElephant', array($animals[0]));
        $finalSpeedElephant = $elephant->getSpeedInit() * (1 + 0.03);

        $elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($animals, $appliedRules);
        $elephantCloseToCarnivorous->applyRule();

        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($finalSpeedElephant, $animals[1]->getSpeed());
        $this->assertTrue($appliedRules->containsKey('CloseToElephant'));
        $this->assertEquals(array($leopard), $appliedRules->get('CloseToElephant'));
        $this->assertTrue($appliedRules->containsKey('ElephantCloseToCarnivorous'));
        $this->assertEquals($elephant, $appliedRules->get('ElephantCloseToCarnivorous'));
    }

    public function testNoRuleCloseToElephant()
    {
        $appliedRules = new ArrayCollection([]);
        $animals = [];

        $elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($animals, $appliedRules);
        $elephantCloseToCarnivorous->applyRule();

        $this->assertFalse($appliedRules->containsKey('ElephantCloseToCarnivorous'));
    }

    public function testNoCarnivorous()
    {
        $horse = new Horse();
        $elephant = new Elephant();
        $animals = array(
            $horse,
            $elephant
        );
        $appliedRules = new ArrayCollection([]);
        $appliedRules->set('CloseToElephant', array($animals[0]));
        $finalSpeedElephant = $elephant->getSpeedInit();

        $elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($animals, $appliedRules);
        $elephantCloseToCarnivorous->applyRule();

        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($finalSpeedElephant, $animals[1]->getSpeed());
        $this->assertFalse($appliedRules->containsKey('ElephantCloseToCarnivorous'));
    }

    public function testNoAnimals()
    {
        $appliedRules = new ArrayCollection([]);
        $animals = [];

        $elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($animals, $appliedRules);
        $elephantCloseToCarnivorous->applyRule();

        $this->assertFalse($appliedRules->containsKey('ElephantCloseToCarnivorous'));
    }
}