<?php

namespace Devhelp\Piwik\Api\Param;

use Devhelp\Piwik\Api\Param\Segment\Segment as SegmentQuery;

/**
 * Adapter for Segment (to be used as Param)
 */
class Segment implements Param
{

    /**
     * @var SegmentQuery
     */
    private $segment;

    public function __construct(SegmentQuery $segment)
    {
        $this->segment = $segment;
    }

    /**
     * returns param value
     *
     * @return string
     */
    public function value()
    {
        return $this->segment->getQuery();
    }
}
