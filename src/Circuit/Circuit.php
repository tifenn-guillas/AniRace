<?php

namespace AniRace\Circuit;

use AniRace\Animal\Animal;
use AniRace\Circuit\Segment\Segment;
use AniRace\Circuit\Segment\Shape\StraightLine;
use AniRace\Circuit\Segment\Type\Mud;
use Doctrine\Common\Collections\ArrayCollection;

class Circuit
{
    /**
     * @var int
     */
    private $size = 5000;

    /**
     * @var ArrayCollection
     */
    private $segments;

    /**
     * @var Animal[]
     */
    private $animals;

    /**
     * Circuit constructor.
     * @param Animal[] $animals
     * @throws \Exception
     */
    public function __construct(array $animals)
    {
        $segment1 = new Segment();
        $segment1->setType(new Mud())->setShape(new StraightLine())->setSize(4000);
        $segment2 = new Segment();
        $segment2->setType(new Mud())->setShape(new StraightLine())->setSize(1000);

        $segments = new ArrayCollection([]);
        $segments->add($segment1);
        $segments->add($segment2);

        if (!$this->isValidSize($segments)) {
            throw new \Exception('Total size of segments is different than the size of the circuit');
        }
        $this->segments = $segments;
        $this->animals = $animals;
    }


    /**
     * @param ArrayCollection $segments
     * @return bool
     */
    private function isValidSize(ArrayCollection $segments)
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
     * @return Circuit
     */
    public function setSize(int $size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return array
     */
    public function getAnimalsPosition() {
        $positions = [];
        $d = 0;
        foreach ($this->segments as $key => $segment) {
            $seg = ['segment' => array(
                $segment->getSize(),
                $segment->getType()->getType(),
                $segment->getShape()->getShape())];
            $animals['Animals'] = [];
            $segmentStart = $d;
            $segmentEnd = $d + $segment->getSize();
            foreach ($this->animals as $animal) {
                if (($animal->getProgress() >= $segmentStart) and ($animal->getProgress() < $segmentEnd)) {
                    $animals['Animals'][] = array(
                        $animal->getBreed(),
                        $animal->getProgress());
                }
            }
            $positions["Segment $key"] = array(
                $seg,
                $animals
            );
            $d += $segment->getSize();
        }
        return $positions;
    }
}