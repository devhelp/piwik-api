<?php

namespace Devhelp\Piwik\Api\Param\Segment\Operator;

interface Operator
{
    /**
     * string representing an operator in the context of a Segment
     *
     * @return string
     * @see Segment
     */
    public function expression();
}
