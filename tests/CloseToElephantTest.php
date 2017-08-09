<?php

use PHPUnit\Framework\TestCase;
use \Doctrine\Common\Collections\ArrayCollection;
use \AniRace\Animal\Breed\Horse;
use \AniRace\Animal\Breed\Elephant;
use \AniRace\Animal\Breed\Leopard;
use \AniRace\Rules\Rule\CloseToElephant;

/**
 * @covers CloseToElephant
 */
final class CloseToElephantTest extends TestCase
{
    public function testApplyRule()
    {
        $appliedRules = new ArrayCollection([]);
        $horse = new Horse();
        $elephant = new Elephant();
        $horse->setProgress(10);
        $elephant->setProgress(10);
        $animals = array(
            $horse,
            $elephant
        );
        $finalSpeedHorse = $horse->getSpeedInit() * (1 - 0.03);
        $speedElephant = $elephant->getSpeed();
        $distanceBetweenAnimals = abs($horse->getProgress() - $elephant->getProgress());

        $closeToElephant = new CloseToElephant($animals, $appliedRules);
        $closeToElephant->applyRule();

        $this->assertInstanceOf(Horse::class, $animals[0]);
        $this->assertEquals($finalSpeedHorse, $animals[0]->getSpeed());
        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($speedElephant, $animals[1]->getSpeed());
        $this->assertTrue($distanceBetweenAnimals <= 50);
        $this->assertTrue($appliedRules->containsKey('CloseToElephant'));
        $this->assertEquals(array($horse), $appliedRules->get('CloseToElephant'), $canonicalize = true);

    }

    public function testNoElephant()
    {
        $appliedRules = new ArrayCollection([]);
        $horse = new Horse();
        $leopard = new Leopard();
        $animals = array(
            $horse,
            $leopard
        );
        $speedHorse = $horse->getSpeed();
        $speedLeopard = $leopard->getSpeed();

        $closeToElephant = new CloseToElephant($animals, $appliedRules);
        $closeToElephant->applyRule();

        $this->assertInstanceOf(Horse::class, $animals[0]);
        $this->assertEquals($speedHorse, $animals[0]->getSpeed());
        $this->assertInstanceOf(Leopard::class, $animals[1]);
        $this->assertEquals($speedLeopard, $animals[1]->getSpeed());
        $this->assertFalse($appliedRules->containsKey('CloseToElephant'));
    }

    public function testNotCloseToElephant()
    {
        $appliedRules = new ArrayCollection([]);
        $horse = new Horse();
        $elephant = new Elephant();
        $horse->setProgress(10);
        $elephant->setProgress(3000);
        $animals = array(
            $horse,
            $elephant
        );
        $speedHorse = $horse->getSpeed();
        $speedElephant = $elephant->getSpeed();
        $distanceBetweenAnimals = abs($horse->getProgress() - $elephant->getProgress());

        $closeToElephant = new CloseToElephant($animals, $appliedRules);
        $closeToElephant->applyRule();
        var_dump($appliedRules);

        $this->assertInstanceOf(Horse::class, $animals[0]);
        $this->assertEquals($speedHorse, $animals[0]->getSpeed());
        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($speedElephant, $animals[1]->getSpeed());
        $this->assertTrue($distanceBetweenAnimals >= 50);
        $this->assertFalse($appliedRules->containsKey('CloseToElephant'));
    }

    public function testNoAnimals()
    {
        $appliedRules = new ArrayCollection([]);
        $animals = [];

        $closeToElephant = new CloseToElephant($animals, $appliedRules);
        $closeToElephant->applyRule();

        $this->assertFalse($appliedRules->containsKey('CloseToElephant'));
    }
}