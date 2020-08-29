<?php

namespace ConstantExposureBundle\Extractor;

use ConstantExposureBundle\Exception\FormatNotSupported;
use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Exposition\Exposition;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class Extractor
{
    public const FORMAT_JSON = 'json';
    public const FORMAT_XML = 'xml';
    public const FORMAT_CSV = 'csv';

    private $arrayConfiguration;
    private $cachePath;
    private $serializer;
    private $debug;
    private $extractors;

    /**
     * @param Serializer                   $serializer
     * @param array<mixed>                 $arrayConfiguration
     * @param iterable<ExtractorInterface> $extractors
     */
    public function __construct(
        SerializerInterface $serializer,
        iterable $extractors,
        array $arrayConfiguration,
        string $cachePath,
        bool $debug = false
    ) {
        $this->cachePath = $cachePath;
        $this->arrayConfiguration = $arrayConfiguration;
        $this->serializer = $serializer;
        $this->debug = $debug;
        $this->extractors = $extractors;
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
