<?php

namespace Devhelp\Piwik\Api\Param;


use Devhelp\Piwik\Api\Param\Segment\Segment as SegmentValue;

class Segment implements Param
{

    /**
     * @var SegmentValue
     */
    private $segment;

    public function __construct(SegmentValue $segment)
    {
        $this->segment = $segment;
    }

    public function value()
    {
        return array('segment' => $this->segment->getQuery());
    }
}
