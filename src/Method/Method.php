<?php

namespace Devhelp\Piwik\Api\Method;

use Devhelp\Piwik\Api\Client\PiwikClient;
use Devhelp\Piwik\Api\Param\ParamResolver;

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
     * @var string
     */
    private $name;

    /**
     * @var string return format of piwik api response
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
        /*
         * provides default format parameter if not set
         */
        $params['format'] = isset($params['format']) ? $params['format'] : $this->format;

        $this->defaultParams = $params;
    }

    /**
     * calls piwik api
     *
     * @param array $params
     * @return mixed
     */
    public function call(array $params)
    {
        $this->initResolver();

        $this->resolver->setDefaults($this->defaultParams);
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
