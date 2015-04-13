<?php

namespace Devhelp\Piwik\Api\Param\Segment;


use Devhelp\Piwik\Api\Param\Segment\Assertion\Contains;
use Devhelp\Piwik\Api\Param\Segment\Assertion\DoesNotContain;
use Devhelp\Piwik\Api\Param\Segment\Assertion\Equals;
use Devhelp\Piwik\Api\Param\Segment\Assertion\GreaterThan;
use Devhelp\Piwik\Api\Param\Segment\Assertion\GreaterThanOrEqual;
use Devhelp\Piwik\Api\Param\Segment\Assertion\LessThan;
use Devhelp\Piwik\Api\Param\Segment\Assertion\LessThanOrEqual;
use Devhelp\Piwik\Api\Param\Segment\Assertion\NotEquals;

class SegmentTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_builds_segment_query()
    {
        $segment = new Segment();

        $segment->where(new Equals('country', 'PL'));
        $segment->andWhere(new NotEquals('actions', 1));
        $segment->andWhere(new Contains('referrerName', 'piwik'));
        $segment->orWhere(new DoesNotContain('referrerKeyword', 'myBrand'));
        $segment->andWhere(new LessThan('myCustomVariable', 10));
        $segment->andWhere(new LessThanOrEqual('visitServerHour', 12));
        $segment->andWhere(new GreaterThan('daysSinceLastVisit', 1));
        $segment->orWhere(new GreaterThanOrEqual('visitDuration', 600));

        $expected = 'country==PL;actions!=1;referrerName=@piwik,referrerKeyword!@myBrand;myCustomVariable<10'.
                    ';visitServerHour<=12;daysSinceLastVisit>1,visitDuration>=600';

        $this->assertSame($expected, $segment->getQuery());
    }
}
