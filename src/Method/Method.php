<?php

namespace Devhelp\Piwik\Api\Method;

use Devhelp\Piwik\Api\Client\PiwikClient;
use Devhelp\Piwik\Api\Param\ParamResolver;
use Psr\Http\Message\ResponseInterface;

/**
 * Provides encapsulated method call to piwik api
 */
class Method
{

    /**
     * @var PiwikClient
     */
    private $piwikClient;

    /**
     * @var string piwik api endpoint
     */
    private $url;

    /**
     * @var string piwik method name (equals to 'method' parameter in reporting api)
     */
    private $name;

    /**
     * @var string return format of piwik api response (equals to 'format' parameter in reporting api)
     */
    private $format;

    /**
     * @var ParamResolver
     */
    private $resolver;

    /**
     * @var array
     */
    private $defaultParams = array();

    public function __construct(PiwikClient $piwikClient, $url, $name, $format = 'json')
    {
        $this->piwikClient = $piwikClient;
        $this->url = $url;
        $this->name = $name;
        $this->format = $format;
    }

    public function name()
    {
        return $this->name;
    }

    public function url()
    {
        return $this->url;
    }

    public function setDefaultParams(array $params)
    {
        $this->defaultParams = $params;
    }

    public function getDefaultParams()
    {
        return $this->defaultParams;
    }

    /**
     * calls piwik api
     *
     * @param array $params
     * @return ResponseInterface
     */
    public function call(array $params)
    {
        $this->initResolver();

        /**
         * makes sure that 'format' is passed and that 'API' and 'method'
         * parameters are not overwritten by defaults nor by call parameters
         */
        $defaults = array_merge(array('format' => $this->format), $this->defaultParams);
        $this->resolver->setDefaults($defaults);
        $this->resolver->setMandatory(array(
            'module' => 'API',
            'method' => $this->name()
        ));

        return $this->piwikClient->call($this->url(), $this->resolver->resolve($params));
    }

    private function initResolver()
    {
        if (!$this->resolver instanceof ParamResolver) {
            $this->resolver = new ParamResolver();
        }
    }
}
