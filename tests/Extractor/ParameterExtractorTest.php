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
        $configuration = (new Configuration())->setParameter([
            (new ParameterConfiguration())
                ->setName('debug')
                ->setValue(true),
        ]);

        $expectedExposition = (new Exposition())->setParameter([
           'debug' => true
        ]);

        $actualExposition = (new ParameterExtractor($container))->run($configuration, new Exposition());
        $this->assertEquals($expectedExposition, $actualExposition);
    }
}
