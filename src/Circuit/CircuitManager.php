<?php

namespace AniRace\Circuit;

use AniRace\Circuit\Segment\Segment;
use AniRace\Circuit\Segment\Shape\StraightLine;
use AniRace\Circuit\Segment\Type\Mud;
use Doctrine\Common\Collections\ArrayCollection;

class CircuitManager
{
    /**
     * @var int
     */
    private $size = 5000;

    /**
     * @var ArrayCollection
     */
    private $segments;


    public function __construct()
    {
        $this->initCircuit();
    }

    /**
     * @throws \Exception
     */
    private function initCircuit()
    {
        $segment1 = new Segment();
        $segment1->setType(new Mud());
        $segment1->setShape(new StraightLine());
        $segment1->setSize(4000);
        $segment2 = new Segment();
        $segment2->setType(new Mud());
        $segment2->setShape(new StraightLine());
        $segment2->setSize(1000);

        $segments = new ArrayCollection(array($segment1, $segment2));

        if (!$this->isValidSize($segments)) {
            throw new \Exception('Total size of segments is different than the size of the circuit');
        }
        $this->segments = $segments;
    }
    /**
     * @param ArrayCollection $segments
     * @return bool
     */
    private function isValidSize($segments)
    {
        $segmentsSize = 0;
        foreach ($segments as $segment) {
            $segmentsSize += $segment->getSize();
        }
        if ($segmentsSize == $this->size) {
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return CircuitManager
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }
}