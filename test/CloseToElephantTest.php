<?php

use PHPUnit\Framework\TestCase;
use \AniRace\Animal\Horse;
use \AniRace\Animal\Elephant;
use \AniRace\Animal\Leopard;
use \AniRace\Rules\CloseToElephant;

/**
 * @covers CloseToElephant
 */
final class CloseToElephantTest extends TestCase
{
    public function testApplyRule()
    {
        $history = [];
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
        $appliedRules[] = $horse;

        $closeToElephant = new CloseToElephant($history, $animals);
        $closeToElephant->applyRule($history);

        $this->assertInstanceOf(Horse::class, $animals[0]);
        $this->assertEquals($finalSpeedHorse, $animals[0]->getSpeed());
        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($speedElephant, $animals[1]->getSpeed());
        $this->assertTrue($distanceBetweenAnimals <= 50);
        $this->assertEquals($appliedRules, $history, $canonicalize = true);


    }

    public function testNoElephant()
    {
        $history = [];
        $horse = new Horse();
        $leopard = new Leopard();
        $animals = array(
            $horse,
            $leopard
        );
        $speedHorse = $horse->getSpeed();
        $speedLeopard = $leopard->getSpeed();
        $appliedRules = [];

        $closeToElephant = new CloseToElephant($history, $animals);
        $closeToElephant->applyRule($history);

        $this->assertInstanceOf(Horse::class, $animals[0]);
        $this->assertEquals($speedHorse, $animals[0]->getSpeed());
        $this->assertInstanceOf(Leopard::class, $animals[1]);
        $this->assertEquals($speedLeopard, $animals[1]->getSpeed());
        $this->assertEquals($appliedRules, $history, $canonicalize = true);
    }

    public function testNotCloseToElephant()
    {
        $history = [];
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
        $appliedRules = [];

        $closeToElephant = new \AniRace\Rules\CloseToElephant($history, $animals);
        $closeToElephant->applyRule($history);

        $this->assertInstanceOf(Horse::class, $animals[0]);
        $this->assertEquals($speedHorse, $animals[0]->getSpeed());
        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($speedElephant, $animals[1]->getSpeed());
        $this->assertTrue($distanceBetweenAnimals >= 50);
        $this->assertEquals($appliedRules, $history, $canonicalize = true);
    }

    public function testRemoveRule()
    {
        $history = [];
        $horse = new Horse();
        $elephant = new Elephant();
        $animals = array(
            $horse,
            $elephant
        );
        $finalSpeedHorse = $horse->getSpeedInit() / (1 - 0.03);
        $speedElephant = $elephant->getSpeed();

        $closeToElephant = new \AniRace\Rules\CloseToElephant($history, $animals);
        $closeToElephant->removeRule($animals[0]);

        $this->assertInstanceOf(Horse::class, $animals[0]);
        $this->assertEquals($finalSpeedHorse, $animals[0]->getSpeed());
        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($speedElephant, $animals[1]->getSpeed());
    }
}