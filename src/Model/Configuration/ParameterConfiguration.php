<?php

namespace ConstantExposureBundle\Model\Configuration;

class ParameterConfiguration
{
    public string $name = '';

    /** @var null|array<int|string, mixed>|bool|int|string */
    public null|array|bool|int|string $value = null;
}
