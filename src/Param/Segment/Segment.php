<?php

namespace Devhelp\Piwik\Api\Param\Segment;

use Devhelp\Piwik\Api\Param\Segment\Operator\Operator;

/**
 * Represents piwik segment value. Can be used to build
 * valid segment query by adding segment assertions
 */
class Segment
{
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
     * starts segment query with operator
     *
     * @param Operator $operator
     * @return self
     */
    public function where(Operator $operator)
    {
        $this->queryParts = array();
        $this->queryParts[] = $operator;

        return $this;
    }

    /**
     * adds new operator using with AND. Starts new segment query if was not started yet
     *
     * @param Operator $operator
     * @return self
     */
    public function andWhere(Operator $operator)
    {
        return $this->append($operator, ';');
    }

    /**
     * adds new operator using with OR. Starts new segment query if was not started yet
     *
     * @param Operator $operator
     * @return self
     */
    public function orWhere(Operator $operator)
    {
        return $this->append($operator, ',');
    }

    private function append(Operator $operator, $sign)
    {
        if ($this->queryParts) {
            $this->queryParts[] = $sign;
        }

        $this->queryParts[] = $operator;

        return $this;
    }
}
