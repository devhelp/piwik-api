<?php

namespace Devhelp\Piwik\Api\Param\Segment\Assertion;


class GenericAssertion implements Assertion
{
    protected $field;
    protected $value;
    protected $operator;

    public function __construct($field, $value, $operator)
    {
        $this->field = $field;
        $this->value = $value;
        $this->operator = $operator;
    }

    public function expression()
    {
        return $this->field . $this->operator . $this->value;
    }
}
