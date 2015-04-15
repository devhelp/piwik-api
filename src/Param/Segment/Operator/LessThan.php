<?php

namespace Devhelp\Piwik\Api\Param\Segment\Operator;

class LessThan extends GenericOperator
{
    public function __construct($field, $value)
    {
        parent::__construct($field, $value, '<');
    }
}
