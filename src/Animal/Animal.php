<?php

namespace AniRace\Animal;

use \JsonSerializable;

abstract class Animal implements JsonSerializable
{
    /**
     * @var string
     */
    protected $breed;

    /**
     * @var float
     */
    protected $stamina;

    /**
     * @var float
     */
    protected $staminaMax;

    /**
     * @var float
     */
    protected $staminaUp;

    /**
     * @var float
     */
    protected $staminaDown;

    /**
     * @var float
     */
    protected $speed;

    /**
     * @var float
     */
    protected $speedInit;

    /**
     * @var bool
     */
    private $isUp;

    /**
     * @var float
     */
    private $progress;

    /**
     * @var string
     */
    protected $diet;

    /**
     * Animal constructor.
     */
    public function __construct()
    {
        $this->progress = 0;
        $this->isUp = true;
        $this->staminaUp = 0.5;
        $this->staminaDown = 1;
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
    public function setStamina(float $stamina)
    {
        $this->stamina = $stamina;
        return $this;
    }

    public function checkStamina()
    {
        if ($this->isUp) {
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
            $this->stamina -= $this->staminaDown;
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
            $this->stamina += $this->staminaUp;
            if ($this->stamina == $this->staminaMax) {
                $this->speed = $this->speedInit;
            }
        }
        return $this->stamina;
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
    public function setSpeed(float $speed)
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * @return float
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param float $progress
     * @return Animal
     */
    public function setProgress(float $progress)
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
    public function setDiet(string $diet)
    {
        $this->diet = $diet;
        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return float
     */
    public function getStaminaMax()
    {
        return $this->staminaMax;
    }

    /**
     * @param float $staminaMax
     * @return Animal
     */
    public function setStaminaMax(float $staminaMax)
    {
        $this->staminaMax = $staminaMax;
        return $this;
    }

    /**
     * @return float
     */
    public function getSpeedInit()
    {
        return $this->speedInit;
    }

    /**
     * @param float $speedInit
     * @return Animal
     */
    public function setSpeedInit(float $speedInit)
    {
        $this->speedInit = $speedInit;
        return $this;
    }
}