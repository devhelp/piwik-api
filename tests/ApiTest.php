<?php

namespace Devhelp\Piwik\Api;


use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;

class ApiTest extends ProphecyTestCase
{

    /**
     * @var ObjectProphecy
     */
    private $client;

    protected function setUp()
    {
        parent::setUp();

        $this->client = $this->prophesize('Devhelp\Piwik\Api\Client\PiwikClient');
    }

    /**
     * @test
     */
    public function it_returns_method()
    {
        $api = new Api($this->client->reveal(), 'http://my.piwik.pro');

        $this->assertInstanceOf('Devhelp\Piwik\Api\Method\Method', $api->getMethod('MyPlugin.myAction'));
    }
}
