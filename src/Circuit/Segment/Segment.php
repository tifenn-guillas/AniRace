<?php

namespace AniRace\Circuit\Segment;

use AniRace\Circuit\Segment\Shape\Shape;
use AniRace\Circuit\Segment\Type\Type;

class Segment
{
    /**
     * @var int
     */
    private $size;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var Shape
     */
    private $shape;

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return Segment
     */
    public function setSize(int $size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return Segment
     */
    public function setType(Type $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Shape
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @param Shape $shape
     * @return Segment
     */
    public function setShape(Shape $shape)
    {
        $this->shape = $shape;
        return $this;
    }
}