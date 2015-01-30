<?php

namespace Devhelp\Piwik\Api\Method;


use Devhelp\Piwik\Api\Client\PiwikClient;

/**
 * Creates Method objects using predefined set of arguments, so that
 * all methods will share the same basic set of them
 */
class MethodFactory
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
    public function create($methodName)
    {
        $method = new Method($this->piwikClient, $this->url, $methodName);

        $method->setDefaultParams($this->getDefaultParams());

        return $method;
    }
}
