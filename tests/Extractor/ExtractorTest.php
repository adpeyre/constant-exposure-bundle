<?php

namespace ConstantExposureBundle\Tests\Extractor;

use ConstantExposureBundle\Exception\FormatNotSupported;
use ConstantExposureBundle\Extractor\Extractor;
use ConstantExposureBundle\Extractor\ExtractorInterface;
use ConstantExposureBundle\Model\Exposition\Exposition;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class ExtractorTest extends TestCase
{
    public function testUnsupportedFormatThrowsException(): void
    {
        $serializer = $this->createMock(SerializerInterface::class);

        $extractor = new Extractor($serializer, [], [], sys_get_temp_dir() . '/ce_test');

        $this->expectException(FormatNotSupported::class);
        $extractor->extractExposed('yaml');
    }

    public function testExtractExposedCallsExtractorsAndSerializes(): void
    {
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->method('serialize')->willReturn('{"debug":true}');

        $config = ['parameter' => [['name' => 'debug', 'value' => true]]];

        $subExtractor = $this->createMock(ExtractorInterface::class);
        $subExtractor->expects($this->once())
            ->method('run')
            ->with($config, $this->isInstanceOf(Exposition::class))
            ->willReturnCallback(function (array $config, Exposition $exposition): Exposition {
                $exposition->parameter = ['debug' => true];
                return $exposition;
            });

        $cachePath = sys_get_temp_dir() . '/ce_test_' . uniqid();

        $extractor = new Extractor($serializer, [$subExtractor], $config, $cachePath);
        $result = $extractor->extractExposed('json');

        $this->assertSame('{"debug":true}', $result);

        // Cleanup
        @unlink($cachePath . '_json');
        @unlink($cachePath . '_json.meta');
    }

    public function testExtractExposedReturnsCachedContent(): void
    {
        $cachePath = sys_get_temp_dir() . '/ce_cache_test_' . uniqid();
        $cacheFile = $cachePath . '_json';

        // Write cache file (no .meta file = always fresh in non-debug mode)
        file_put_contents($cacheFile, '{"cached":true}');

        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->never())->method('serialize');

        $extractor = new Extractor($serializer, [], [], $cachePath, false);
        $result = $extractor->extractExposed('json');

        $this->assertSame('{"cached":true}', $result);

        // Cleanup
        @unlink($cacheFile);
    }
}
