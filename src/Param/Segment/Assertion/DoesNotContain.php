<?php

namespace Devhelp\Piwik\Api\Param\Segment\Assertion;


class DoesNotContain extends GenericAssertion
{
    public function __construct($field, $value)
    {
        parent::__construct($field, $value, '!@');
    }
}
