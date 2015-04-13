<?php

namespace Devhelp\Piwik\Api\Param\Segment;

use Devhelp\Piwik\Api\Param\Segment\Assertion\Operator;

/**
 * Represents piwik segment value. Can be used to build
 * valid segment query by adding segment assertions
 */
class Segment
{
    const OR_EXPRESSION = ',';
    const AND_EXPRESSION = ';';

    private $queryParts = array();

    /**
     * builds the query and returns it as a string
     *
     * @return string
     */
    public function getQuery()
    {
        $queryParts = array_map(function ($value) {
            return ($value instanceof Operator) ? $value->expression() : $value;
        }, $this->queryParts);

        return implode('', $queryParts);
    }

    /**
     * starts segment query with assertion
     *
     * @param Operator $assertion
     * @return self
     */
    public function where(Operator $assertion)
    {
        $this->queryParts = array();
        $this->queryParts[] = $assertion;

        return $this;
    }

    /**
     * adds new assertion using with AND. Starts new segment query if was not started yet
     *
     * @param Operator $assertion
     * @return self
     */
    public function andWhere(Operator $assertion)
    {
        if ($this->queryParts) {
            $this->queryParts[] = self::AND_EXPRESSION;
        }

        $this->queryParts[] = $assertion;

        return $this;
    }

    /**
     * adds new assertion using with OR. Starts new segment query if was not started yet
     *
     * @param Operator $assertion
     * @return self
     */
    public function orWhere(Operator $assertion)
    {
        if ($this->queryParts) {
            $this->queryParts[] = self::OR_EXPRESSION;
        }

        $this->queryParts[] = $assertion;

        return $this;
    }
}
