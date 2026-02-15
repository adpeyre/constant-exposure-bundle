<?php

namespace ConstantExposureBundle\Extractor;

use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Configuration\ParameterConfiguration;
use ConstantExposureBundle\Model\Exposition\Exposition;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class ParameterExtractor implements ExtractorInterface
{
    public function run(Configuration $configuration, Exposition $exposition): Exposition
    {
        if (null !== $configuration->parameter) {
            $exposition->parameter = $this->extractor($configuration->parameter);
        }

        return $exposition;
    }

    /**
     * @param ParameterConfiguration[] $parameters
     *
     * @return array<mixed>
     */
    protected function extractor(array $parameters): array
    {
        $parametersToExpose = [];

        foreach ($parameters as $parameter) {
            try {
                $parametersToExpose[$parameter->name] = $parameter->value;
            } catch (InvalidArgumentException $e) {
            }
        }

        return $parametersToExpose;
    }
}
