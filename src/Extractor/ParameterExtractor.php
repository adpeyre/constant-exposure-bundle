<?php

namespace ConstantExposureBundle\Extractor;

use ConstantExposureBundle\Model\Exposition\Exposition;

class ParameterExtractor implements ExtractorInterface
{
    public function run(array $configuration, Exposition $exposition): Exposition
    {
        foreach ($configuration['parameter'] ?? [] as $parameter) {
            $exposition->parameter[$parameter['name']] = $parameter['value'];
        }

        return $exposition;
    }
}
