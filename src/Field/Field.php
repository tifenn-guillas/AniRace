<?php

namespace AniRace\Field;

class Field
{
    /**
     * @var int
     */
    private $distance;

    /**
     * @var string
     */
    private $shape;


    public function __construct()
    {
        $this->distance = 5000;
        $this->shape = 'circular';
    }

    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @return string
     */
    public function getShape()
    {
        return $this->shape;
    }


}