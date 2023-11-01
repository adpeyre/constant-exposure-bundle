<?php

namespace ConstantExposureBundle\Denormalizer;

use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Configuration\ParameterConfiguration;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ConfigurationDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @param mixed[] $context
     *
     * @return Configuration
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        $parameter = [];

        if (isset($data['parameter'])) {
            $parameter = $this->denormalizer->denormalize($data['parameter'], ParameterConfiguration::class.'[]', $format, $context);
        }

        $configuration = new Configuration();
        $configuration->setParameter($parameter);

        return $configuration;
    }

    /**
     * @param array<string, mixed> $context
     * @param mixed                $data
     * @param mixed                $type
     * @param null|mixed           $format
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return Configuration::class === $type;
    }

    /**
     * @return array<string, bool>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Configuration::class => true,
        ];
    }
}
