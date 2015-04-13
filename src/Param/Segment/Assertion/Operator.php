<?php

namespace Devhelp\Piwik\Api\Param\Segment\Assertion;

interface Operator
{
    /**
     * string representing an assertion in the context of a Segment
     *
     * @return string
     * @see Segment
     */
    public function expression();
}