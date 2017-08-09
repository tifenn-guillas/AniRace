<?php

use PHPUnit\Framework\TestCase;
use \Doctrine\Common\Collections\ArrayCollection;
use \AniRace\Animal\Breed\Horse;
use \AniRace\Animal\Breed\Elephant;
use \AniRace\Rules\Rule\NotCloseToElephant;

/**
 * @covers NotElephantCloseToCarnivorous
 */
final class NotCloseToElephantTest extends TestCase
{
    public function testApplyRule()
    {
        $horse = new Horse();
        $elephant = new Elephant();
        $animals = array(
            $horse,
            $elephant
        );
        $appliedRules = new ArrayCollection([]);
        $appliedRules->set('CloseToElephant', array($animals[0]));
        $finalSpeedHorse = $horse->getSpeedInit() / (1 - 0.03);
        $speedElephant = $elephant->getSpeed();

        $notCloseToElephant = new NotCloseToElephant($animals, $appliedRules);
        $notCloseToElephant->applyRule();

        $this->assertInstanceOf(Horse::class, $animals[0]);
        $this->assertEquals($finalSpeedHorse, $animals[0]->getSpeed());
        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($speedElephant, $animals[1]->getSpeed());
        $this->assertFalse($appliedRules->containsKey('CloseToElephant'));
    }

    public function testNoRuleCloseToElephant()
    {
        $horse = new Horse();
        $elephant = new Elephant();
        $animals = array(
            $horse,
            $elephant
        );
        $appliedRules = new ArrayCollection([]);
        $speedHorse = $horse->getSpeed();
        $speedElephant = $elephant->getSpeed();

        $notCloseToElephant = new NotCloseToElephant($animals, $appliedRules);
        $notCloseToElephant->applyRule();

        $this->assertInstanceOf(Horse::class, $animals[0]);
        $this->assertEquals($speedHorse, $animals[0]->getSpeed());
        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($speedElephant, $animals[1]->getSpeed());
    }
}