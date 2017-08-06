<?php

use PHPUnit\Framework\TestCase;
use \AniRace\Animal\Horse;
use \AniRace\Animal\Elephant;
use \AniRace\Animal\Leopard;
use \AniRace\Rules\ElephantCloseToCarnivorous;

/**
 * @covers CloseToElephant
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
        $history['CloseToElephant'][] = $animals[0];
        $finalSpeedElephant = $elephant->getSpeedInit() * (1 + 0.03);
        $appliedRules = array(
            'CloseToElephant' => [$animals[0]],
            'ElephantCloseToCarnivorous' => $animals[1]
        );

        $elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($animals);
        $elephantCloseToCarnivorous->applyRule($history);

        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($finalSpeedElephant, $animals[1]->getSpeed());
        $this->assertEquals($appliedRules, $history, $canonicalize = true);
    }

    public function testNotCloseToElephant()
    {
        $history = [];
        $horse = new Horse();
        $leopard = new Leopard();
        $animals = array(
            $horse,
            $leopard
        );
        $appliedRules = [];

        $elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($animals);
        $elephantCloseToCarnivorous->applyRule($history);

        $this->assertEquals($appliedRules, $history, $canonicalize = true);
    }

    public function testNoCarnivorous()
    {
        $horse = new Horse();
        $elephant = new Elephant();
        $animals = array(
            $horse,
            $elephant
        );
        $history['CloseToElephant'][] = $animals[0];
        $finalSpeedElephant = $elephant->getSpeedInit();
        $appliedRules = array(
            'CloseToElephant' => [$animals[0]]
        );

        $elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($animals);
        $elephantCloseToCarnivorous->applyRule($history);

        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($finalSpeedElephant, $animals[1]->getSpeed());
        $this->assertEquals($appliedRules, $history, $canonicalize = true);
    }

    public function testRemoveRule()
    {
        $leopard = new Leopard();
        $elephant = new Elephant();
        $animals = array(
            $leopard,
            $elephant
        );
        $finalSpeedElephant = $elephant->getSpeedInit() / (1 + 0.03);

        $elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($animals);
        $elephantCloseToCarnivorous->removeRule($elephant);

        $this->assertInstanceOf(Elephant::class, $animals[1]);
        $this->assertEquals($finalSpeedElephant, $animals[1]->getSpeed());
    }

    public function testNoAnimals()
    {
        $history = [];
        $animals = [];
        $appliedRules = [];

        $elephantCloseToCarnivorous = new ElephantCloseToCarnivorous($animals);
        $elephantCloseToCarnivorous->applyRule($history);

        $this->assertEquals($appliedRules, $history);
    }
}