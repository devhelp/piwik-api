<?php

namespace Devhelp\Piwik\Api\Param;

class ParamResolver
{

    private $defaultParams = array();

    private $mandatoryParams = array();

    /**
     * sets default parameters that will be returned on resolve unless overwritten by mandatory or runtime params
     *
     * @param array $params
     */
    public function setDefaults(array $params)
    {
        $this->defaultParams = $params;
    }

    /**
     * sets parameters that won't be overwritten by default or runtime parameters
     * and will be returned on resolve
     *
     * @param array $params
     */
    public function setMandatory(array $params)
    {
        $this->mandatoryParams = $params;
    }

    /**
     * resolves $params value by merging and getting end values from each array elements
     *
     * @param array $params
     * @return array
     */
    public function resolve(array $params)
    {
        $merged = $this->merge($params);
        $resolved = $this->read($merged);

        return $resolved;
    }

    private function merge(array $params)
    {
        $merged = array_merge($this->defaultParams, $params, $this->mandatoryParams);

        return $merged;
    }

    private function read(array $params)
    {
        $resolved = array();

        foreach ($params as $key => $value) {
            if ($value instanceof Param) {
                $value = $value->value();
            } elseif ($value instanceof \Closure) {
                $value = $value();
            }

            $param = array($key => $value);

            $resolved = array_merge($resolved, $param);
        }

        return $resolved;
    }
}
