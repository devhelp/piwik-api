<?php

namespace Devhelp\Piwik\Api\Param;

class RawParam implements Param
{

    /**
     * @var mixed
     */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * returns param value
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
