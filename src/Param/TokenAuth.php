<?php

namespace Devhelp\Piwik\Api\Param;


use Devhelp\Piwik\Api\Param\TokenAuth\TokenAuth as TokenAuthValue;

class TokenAuth implements Param
{

    /**
     * @var TokenAuthValue
     */
    private $tokenAuth;

    public function __construct(TokenAuthValue $tokenAuth)
    {
        $this->tokenAuth = $tokenAuth;
    }

    public function value()
    {
        return array('token_auth' => $this->tokenAuth->getToken());
    }
}
