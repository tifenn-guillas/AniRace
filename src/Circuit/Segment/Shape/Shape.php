<?php

namespace AniRace\Circuit\Segment\Shape;

abstract class Shape
{
    /**
     * @var string
     */
    private $shape;


    /**
     * @return string
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @param $shape
     * @return Shape
     */
    public function setShape($shape)
    {
        $this->shape = $shape;
        return $this;
    }
}