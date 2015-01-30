<?php

namespace Devhelp\Piwik\Api\Param\Segment;


use Devhelp\Piwik\Api\Param\Segment\Assertion\Assertion;

/**
 * Represents piwik segment value. Can be used to build
 * valid segment query by adding segment assertions
 */
class Segment
{
    const OR_OPERATOR = ',';
    const AND_OPERATOR = ';';

    private $queryParts = array();

    /**
     * builds the query and returns it as a string
     *
     * @return string
     */
    public function getQuery()
    {
        $queryParts = array_map(function ($value) {
            return ($value instanceof Assertion) ? $value->expression() : $value;
        }, $this->queryParts);

        return implode('', $queryParts);
    }

    /**
     * starts segment query with assertion
     *
     * @param Assertion $assertion
     * @return self
     */
    public function where(Assertion $assertion)
    {
        $this->queryParts = array();
        $this->queryParts[] = $assertion;

        return $this;
    }

    /**
     * adds new assertion using with AND. Starts new segment query if was not started yet
     *
     * @param Assertion $assertion
     * @return self
     */
    public function andWhere(Assertion $assertion)
    {
        if ($this->queryParts) {
            $this->queryParts[] = self::AND_OPERATOR;
        }

        $this->queryParts[] = $assertion;

        return $this;
    }

    /**
     * adds new assertion using with OR. Starts new segment query if was not started yet
     *
     * @param Assertion $assertion
     * @return self
     */
    public function orWhere(Assertion $assertion)
    {
        if ($this->queryParts) {
            $this->queryParts[] = self::OR_OPERATOR;
        }

        $this->queryParts[] = $assertion;

        return $this;
    }
}
