<?php

namespace ConstantExposureBundle\Tests\Extractor;

use ConstantExposureBundle\Extractor\ClassExtractor;
use ConstantExposureBundle\Extractor\Extractor;
use ConstantExposureBundle\Extractor\ParameterExtractor;
use ConstantExposureBundle\Model\Configuration\ClassConfiguration;
use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Configuration\ParameterConfiguration;
use ConstantExposureBundle\Model\Exposition\Exposition;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Phake;

class ParameterExtractorTest extends KernelTestCase
{

    public function testParameter(): void
    {
        $container = Phake::mock(ContainerInterface::class);

        $debug = new ParameterConfiguration();
        $debug->name = 'debug';
        $debug->value = true;

        $array = new ParameterConfiguration();
        $array->name = 'array';
        $array->value = ['value1', 'value2'];

        $assoc = new ParameterConfiguration();
        $assoc->name = 'assoc';
        $assoc->value = ['key1' => 'value1', 'key2' => 'value2'];

        $configuration = new Configuration();
        $configuration->parameter = [$debug, $array, $assoc];

        $expectedExposition = new Exposition();
        $expectedExposition->parameter = [
           'debug' => true,
            'array' => ['value1', 'value2'],
            'assoc' => ['key1' => 'value1', 'key2' => 'value2'],
        ];

        $actualExposition = (new ParameterExtractor($container))->run($configuration, new Exposition());
        $this->assertEquals($expectedExposition, $actualExposition);
    }
}
