<?php

namespace Devhelp\Piwik\Api;


use Devhelp\Piwik\Api\Client\PiwikClient;
use Devhelp\Piwik\Api\Method\Method;

/**
 * Creates Method objects using predefined set of arguments, so that
 * all methods will share the same basic set of them
 */
class Api
{

    private $piwikClient;

    private $url;

    private $defaultParams = array();

    public function __construct(PiwikClient $piwikClient, $url)
    {
        $this->piwikClient = $piwikClient;
        $this->url = $url;
    }

    private function getDefaultParams()
    {
        return $this->defaultParams;
    }

    public function setDefaultParams(array $params)
    {
        $this->defaultParams = $params;
    }

    /**
     * @param string $methodName
     * @return Method
     */
    public function getMethod($methodName)
    {
        $method = new Method($this->piwikClient, $this->url, $methodName);

        $method->setDefaultParams($this->getDefaultParams());

        return $method;
    }
}
