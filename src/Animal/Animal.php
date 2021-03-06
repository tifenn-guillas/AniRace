<?php

namespace AniRace\Animal;

abstract class Animal
{
    /**
     * @var float
     */
    private $stamina;

    /**
     * @var int
     */
    private $staminaMax;

    /**
     * @var float
     */
    private $speed;

    /**
     * @var int
     */
    private $speedInit;

    /**
     * @var float
     */
    private $progress;

    /**
     * @var string
     */
    private $diet;

    /**
     * Animal constructor.
     */
    public function __construct()
    {
        $this->staminaMax = $this->stamina;
        $this->speedInit = $this->speed;
        $this->progress = 0;
    }

    /**
     * @return float
     */
    public function getStamina()
    {
        return $this->stamina;
    }

    /**
     * @param float $stamina
     * @return Animal
     */
    public function setStamina($stamina)
    {
        $this->stamina = $stamina;
        return $this;
    }

    public function checkStamina()
    {
        // TODO: check avec les regles de l'elephant
        if ($this->speed == $this->speedInit) {
            $this->decreaseStamina();
        } else {
            $this->increaseStamina();
        }
    }

    /**
     * @return float
     */
    private function decreaseStamina()
    {
        if ($this->stamina > 0) {
            $this->stamina -= 1;
            if ($this->stamina == 0) {
                $this->speed = $this->speed/2;
            }
        }
        return $this->stamina;
    }

    /**
     * @return float
     */
    private function increaseStamina()
    {
        if ($this->stamina < $this->staminaMax) {
            $this->stamina += 0.5;
            if ($this->stamina == $this->staminaMax) {
                $this->speed = $this->speedInit;
            }
        }
        return $this->stamina;
    }

    /**
     * @return int
     */
    public function getStaminaMax()
    {
        return $this->staminaMax;
    }

    /**
     * @return float
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param float $speed
     * @return Animal
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * @return int
     */
    public function getSpeedInit()
    {
        return $this->speedInit;
    }

    /**
     * @return float
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param $progress
     * @return Animal
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;
        return $this;
    }

    public function progress() {
        $this->progress += $this->getSpeed();
        $this->checkStamina();
    }

    /**
     * @return string
     */
    public function getDiet()
    {
        return $this->diet;
    }

    /**
     * @param string $diet
     * @return Animal
     */
    public function setDiet($diet)
    {
        $this->diet = $diet;
        return $this;
    }
}