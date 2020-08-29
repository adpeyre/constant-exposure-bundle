<?php

namespace ConstantExposureBundle\Denormalizer;

use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Configuration\ParameterConfiguration;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ConfigurationDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    /**
     * @param mixed[] $context
     * @param mixed   $data
     *
     * @return Configuration
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $data['parameter'] = $this->denormalizer->denormalize($data['parameter'], ParameterConfiguration::class.'[]', $format, $context);

        /** @var Configuration $configuration */
        $configuration = $this->objectNormalizer->denormalize($data, $type, $format, $context);

        return $configuration;
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return Configuration::class === $type;
    }
}
