<?php

namespace ConstantExposureBundle\Extractor;

use ConstantExposureBundle\Exception\FormatNotSupported;
use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Exposition\Exposition;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Serializer\SerializerInterface;

class Extractor
{
    public const FORMAT_JSON = 'json';
    public const FORMAT_XML = 'xml';
    public const FORMAT_CSV = 'csv';

    /**
     * @param iterable<ExtractorInterface> $extractors
     * @param array<mixed>                 $arrayConfiguration
     */
    public function __construct(
        private SerializerInterface $serializer,
        private iterable $extractors,
        private array $arrayConfiguration,
        private string $cachePath,
        private bool $debug = false,
    ) {
    }

    public function extractExposed(string $format): string
    {
        if (!in_array($format, $this->supportedFormats())) {
            throw new FormatNotSupported($format);
        }

        $cachePath = $this->getCachePathByFormat($format);
        $cache = new ConfigCache($cachePath, $this->debug);

        if ($cache->isFresh()) {
            $content = file_get_contents($cachePath);
            if (false !== $content) {
                return $content;
            }
        }

        /** @var Configuration $configuration */
        $configuration = $this->serializer->denormalize(
            $this->arrayConfiguration,
            Configuration::class
        );

        $exposition = new Exposition();
        foreach ($this->extractors as $extractor) {
            $exposition = $extractor->run($configuration, $exposition);
        }

        $expositionSerialized = $this->serializer->serialize($exposition, $format);
        $cache->write($expositionSerialized);

        return $expositionSerialized;
    }

    protected function getCachePathByFormat(string $format): string
    {
        return sprintf('%s_%s', $this->cachePath, $format);
    }

    /**
     * @return string[]
     */
    protected function supportedFormats(): array
    {
        return [self::FORMAT_JSON, self::FORMAT_XML, self::FORMAT_CSV];
    }
}
