<?php

namespace Devhelp\Piwik\Api\Method;


use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;

class MethodTest extends ProphecyTestCase
{

    /**
     * @var ObjectProphecy
     */
    private $connection;

    /**
     * @var ObjectProphecy
     */
    private $client;

    private $url;

    private $methodName;

    private $defaultParams = array();

    private $params;

    protected function setUp()
    {
        parent::setUp();

        $this->client = $this->prophesize('Devhelp\Piwik\Api\Client\PiwikClient');
    }

    /**
     * @test
     */
    public function it_wraps_piwik_client_call_using_predefined_params()
    {
        $this->given_url_equals('http://my.piwik.pro/index.php');
        $this->given_method_name_equals('MyPlugin.someAction');
        $this->given_default_params_equals(array('my_default_param' => 'value'));
        $this->given_call_params_equals(array('my_param_1' => 'value_1', 'my_param_2' => 'value_2'));
        $this->piwik_client_is_called_with_the_params(
            'http://my.piwik.pro/index.php',
            array(
                'my_default_param' => 'value',
                'my_param_1' => 'value_1',
                'my_param_2' => 'value_2',
                'module' => 'API',
                'method' => 'MyPlugin.someAction',
                'format' => 'json',
            )
        );
        $this->when_method_is_called();
    }

    /**
     * @test
     */
    public function it_is_not_possible_to_overwrite_mandatory_method_params()
    {
        $this->given_url_equals('http://my.piwik.pro/index.php');
        $this->given_method_name_equals('MyPlugin.someAction');
        $this->given_call_params_equals(array(
            'format' => 'xml',
            'module' => 'SomeModule',
            'method' => 'MyOtherPlugin.someAction',
            'token_auth' => 'MY_TOKEN'
        ));
        $this->piwik_client_is_called_with_the_params(
            'http://my.piwik.pro/index.php',
            array(
                'format' => 'xml',
                'module' => 'API',
                'method' => 'MyPlugin.someAction',
                'token_auth' => 'MY_TOKEN'
            )
        );
        $this->when_method_is_called();
    }

    private function given_url_equals($url)
    {
        $this->url = $url;
    }

    private function given_default_params_equals($defaults)
    {
        $this->defaultParams = $defaults;
    }

    private function given_call_params_equals($params)
    {
        $this->params = $params;
    }

    private function given_method_name_equals($name)
    {
        $this->methodName = $name;
    }

    private function piwik_client_is_called_with_the_params($url, $params)
    {
        $this->client->call($url, $params)->shouldBeCalled();
    }

    private function when_method_is_called()
    {
        $method = new Method($this->client->reveal(), $this->url, $this->methodName);

        $method->setDefaultParams($this->defaultParams);

        $method->call($this->params);
    }
}
