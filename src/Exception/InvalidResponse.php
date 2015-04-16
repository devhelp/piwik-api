<?php

namespace Devhelp\Piwik\Api\Exception;

class InvalidResponse extends \Exception
{

    /**
     * @var mixed
     */
    private $response;

    public function __construct($message, $response)
    {
        parent::__construct($message);

        $this->response;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
