<?php

namespace Devhelp\Piwik\Api\Param\Segment;


use Devhelp\Piwik\Api\Param\Segment\Operator\Contains;
use Devhelp\Piwik\Api\Param\Segment\Operator\DoesNotContain;
use Devhelp\Piwik\Api\Param\Segment\Operator\EndsWith;
use Devhelp\Piwik\Api\Param\Segment\Operator\Equals;
use Devhelp\Piwik\Api\Param\Segment\Operator\GreaterThan;
use Devhelp\Piwik\Api\Param\Segment\Operator\GreaterThanOrEqual;
use Devhelp\Piwik\Api\Param\Segment\Operator\LessThan;
use Devhelp\Piwik\Api\Param\Segment\Operator\LessThanOrEqual;
use Devhelp\Piwik\Api\Param\Segment\Operator\NotEquals;
use Devhelp\Piwik\Api\Param\Segment\Operator\StartsWith;

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
        $segment->andWhere(new StartsWith('referrerKeyword', 'my'));
        $segment->andWhere(new EndsWith('referrerKeyword', 'Brand'));
        $segment->orWhere(new GreaterThanOrEqual('visitDuration', 600));

        $expected = 'country==PL'.
                    ';actions!=1'.
                    ';referrerName=@piwik'.
                    ',referrerKeyword!@myBrand'.
                    ';myCustomVariable<10'.
                    ';visitServerHour<=12'.
                    ';daysSinceLastVisit>1'.
                    ';referrerKeyword=^my'.
                    ';referrerKeyword=$Brand'.
                    ',visitDuration>=600';

        $this->assertSame($expected, $segment->getQuery());
    }
}
