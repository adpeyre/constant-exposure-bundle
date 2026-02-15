<?php

namespace ConstantExposureBundle\Tests\Extractor;

use ConstantExposureBundle\Extractor\ParameterExtractor;
use ConstantExposureBundle\Model\Exposition\Exposition;
use PHPUnit\Framework\TestCase;

class ParameterExtractorTest extends TestCase
{
    public function testParameter(): void
    {
        $configuration = [
            'parameter' => [
                ['name' => 'debug', 'value' => true],
                ['name' => 'array', 'value' => ['value1', 'value2']],
                ['name' => 'assoc', 'value' => ['key1' => 'value1', 'key2' => 'value2']],
            ],
        ];

        $expectedExposition = new Exposition();
        $expectedExposition->parameter = [
            'debug' => true,
            'array' => ['value1', 'value2'],
            'assoc' => ['key1' => 'value1', 'key2' => 'value2'],
        ];

        $actualExposition = (new ParameterExtractor())->run($configuration, new Exposition());
        $this->assertEquals($expectedExposition, $actualExposition);
    }
}
