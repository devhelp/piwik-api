<?php

namespace Devhelp\Piwik\Api\Param\Segment\Assertion;

class GreaterThan extends GenericOperator
{
    public function __construct($field, $value)
    {
        parent::__construct($field, $value, '>');
    }
}
