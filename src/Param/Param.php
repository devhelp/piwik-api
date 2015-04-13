<?php

namespace Devhelp\Piwik\Api\Param;

/**
 * Can be used as one of a parameters for piwik method call in Method class
 */
interface Param
{
    /**
     * returns param value
     *
     * @return mixed
     */
    public function value();
}
