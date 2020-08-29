<?php

namespace ConstantExposureBundle\Exception;

class FormatNotSupported extends \Exception
{
    public function __construct(string $format)
    {
        parent::__construct(sprintf('ConstantExposureBundle does not support "%s" format.', $format));
    }
}
