<?php

namespace ConstantExposureBundle\Extractor;

use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Exposition\Exposition;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class Extractor
{
    private $normalizer;
    private $arrayConfiguration;
    private $cachePath;
    private $serializer;
    private $debug;
    private $extractors;

    /**
     * @param array<mixed>                 $arrayConfiguration
     * @param iterable<ExtractorInterface> $extractors
     */
    public function __construct(
        ObjectNormalizer $normalizer,
        SerializerInterface $serializer,
        iterable $extractors,
        array $arrayConfiguration,
        string $cachePath,
        bool $debug = false
    ) {
        $this->cachePath = $cachePath;
        $this->normalizer = $normalizer;
        $this->arrayConfiguration = $arrayConfiguration;
        $this->serializer = $serializer;
        $this->debug = $debug;
        $this->extractors = $extractors;
    }

    public function extractExposed(): string
    {
        $cache = new ConfigCache($this->cachePath, $this->debug);

        if ($cache->isFresh()) {
            $content = file_get_contents($this->cachePath);
            if (false !== $content) {
                return $content;
            }
        }

        /** @var Configuration $configuration */
        $configuration = $this->normalizer->denormalize(
            $this->arrayConfiguration,
            Configuration::class
        );

        $exposition = new Exposition();
        foreach ($this->extractors as $extractor) {
            $exposition = $extractor->run($configuration, $exposition);
        }

        $expositionSerialized = $this->serializer->serialize($exposition, 'json');
        $cache->write($expositionSerialized);

        return $expositionSerialized;
    }
}
