<?php

namespace ConstantExposureBundle\Tests\Extractor;

use ConstantExposureBundle\Extractor\ClassExtractor;
use ConstantExposureBundle\Extractor\Extractor;
use ConstantExposureBundle\Extractor\ParameterExtractor;
use ConstantExposureBundle\Model\Configuration\ClassConfiguration;
use ConstantExposureBundle\Model\Configuration\Configuration;
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
        Phake::when($container)->getParameter('kernel.name')->thenReturn('my_app');

        $configuration = (new Configuration())->setParameter([
           'kernel.name'
        ]);

        $expectedExposition = (new Exposition())->setParameter([
           'kernel.name' => 'my_app'
        ]);

        $actualExposition = (new ParameterExtractor($container))->run($configuration, new Exposition());
        $this->assertEquals($expectedExposition, $actualExposition);
    }
}
