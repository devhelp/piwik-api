<?php

namespace Devhelp\Piwik\Api\Client;

use Devhelp\Piwik\Api\Exception\InvalidResponse;

/**
 * Make your http client or client wrapper class to implement this
 * interface in order to be able to use the client on Method call
 */
interface PiwikClient
{
    /**
     * @param string $url base piwik api url
     * @param array $params api parameters
     * @return mixed depends on the implementation
     * @throws InvalidResponse if response is not valid
     */
    public function call($url, array $params);
}
