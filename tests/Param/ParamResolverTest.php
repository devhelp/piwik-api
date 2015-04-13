<?php

namespace Devhelp\Piwik\Api\Param;


class ParamResolverTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ParamResolver
     */
    private $resolver;

    protected function setUp()
    {
        $this->resolver = new ParamResolver();
    }

    /**
     * @test
     */
    public function it_returns_merged_array_according_array_priorities()
    {
        $defaults = array(
            'k_1' => 'd1',
            'k_2' => 'd2',
            'k_3' => function() { return 'd3'; },
        );

        $mandatory = array(
            'k_2' => new RawParam('m2'),
        );

        $params = array(
            'k_1' => 'p1',
            'k_2' => 'p2',
        );

        $expected = array(
            'k_1' => 'p1',
            'k_2' => 'm2',
            'k_3' => 'd3'
        );

        $this->resolver->setDefaults($defaults);
        $this->resolver->setMandatory($mandatory);
        $this->assertSame($expected, $this->resolver->resolve($params));
    }
}
