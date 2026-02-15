<?php

namespace ConstantExposureBundle\Extractor;

use ConstantExposureBundle\Model\Exposition\Exposition;

interface ExtractorInterface
{
    public function run(array $configuration, Exposition $exposition): Exposition;
}
