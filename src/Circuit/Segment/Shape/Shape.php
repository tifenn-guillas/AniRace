<?php

namespace AniRace\Circuit\Segment\Shape;

abstract class Shape
{
    /**
     * @var string
     */
    protected $shape;


    /**
     * @return string
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @param string $shape
     * @return Shape
     */
    public function setShape(string $shape)
    {
        $this->shape = $shape;
        return $this;
    }
}