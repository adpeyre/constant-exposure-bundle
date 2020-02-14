<?php

namespace ConstantExposureBundle\Extractor;

use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Exposition\Exposition;

interface ExtractorInterface
{
    public function run(Configuration $configuration, Exposition $exposition): Exposition;
}
