<?php

namespace Devhelp\Piwik\Api\Param\Segment\Assertion;

class LessThanOrEqual extends GenericOperator
{
    public function __construct($field, $value)
    {
        parent::__construct($field, $value, '<=');
    }
}
