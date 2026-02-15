<?php

namespace ConstantExposureBundle\Tests\DependencyInjection;

use ConstantExposureBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testNormalizesParameterKeyValue(): void
    {
        $config = [
            'parameter' => [
                'debug' => true,
                'app_name' => 'MyApp',
            ],
        ];

        $result = (new Processor())->processConfiguration(new Configuration(), [$config]);

        $this->assertSame([
            ['name' => 'debug', 'value' => true],
            ['name' => 'app_name', 'value' => 'MyApp'],
        ], $result['parameter']);
    }

    public function testEmptyConfiguration(): void
    {
        $result = (new Processor())->processConfiguration(new Configuration(), [[]]);

        $this->assertEmpty($result['parameter']);
    }
}
