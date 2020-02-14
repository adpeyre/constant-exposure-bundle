<?php

namespace ConstantExposureBundle\Tests\Extractor;

use ConstantExposureBundle\Extractor\ClassExtractor;
use ConstantExposureBundle\Extractor\Extractor;
use ConstantExposureBundle\Model\Configuration\ClassConfiguration;
use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Exposition\Exposition;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ClassExtractorTest extends TestCase
{

    public function testClassConst(): void
    {
        $configuration = (new Configuration())->setClass([
            (new ClassConfiguration())
                ->setName('Symfony\Component\Serializer\Normalizer\DateTimeNormalizer')
                ->setConstants(['FORMAT_KEY', 'TIMEZONE_KEY'])
                ->setAlias('DateTimeNormalizer'),
        ]);

        $expectedExposition = (new Exposition())->setClass([
           'DateTimeNormalizer' => [
               'FORMAT_KEY' => 'datetime_format',
               'TIMEZONE_KEY' => 'datetime_timezone',
           ]
        ]);

        $actualExposition = (new ClassExtractor())->run($configuration, new Exposition());
        $this->assertEquals($expectedExposition, $actualExposition);
    }
}
