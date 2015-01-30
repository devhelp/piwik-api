<?php

namespace Devhelp\Piwik\Api\Param;

/**
 * Can be used as one of a parameters for piwik method call in Method class
 */
interface Param
{
    /**
     * returns array with param names and values (it may return many of them at once)
     *
     * @return array
     */
    public function value();
}
