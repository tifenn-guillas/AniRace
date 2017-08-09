<?php

namespace AniRace\Circuit\Segment\Type;

abstract class Type
{
    /**
     * @var string
     */
    private $type ;


    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}