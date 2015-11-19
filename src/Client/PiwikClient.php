<?php

namespace Devhelp\Piwik\Api\Client;

use Psr\Http\Message\ResponseInterface;

/**
 * Make your Piwik client implement this interface
 * in order to be able to use the client on Method call
 */
interface PiwikClient
{
    /**
     * @param string $url base piwik api url
     * @param array $params api parameters
     * @return ResponseInterface
     */
    public function call($url, array $params);
}
