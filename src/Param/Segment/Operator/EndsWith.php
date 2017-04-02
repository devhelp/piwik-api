<?php

namespace Devhelp\Piwik\Api\Param\Segment\Operator;

class EndsWith extends GenericOperator
{
    public function __construct($field, $value)
    {
        parent::__construct($field, $value, '=$');
    }
}
