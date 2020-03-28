<?php

namespace ConstantExposureBundle\Model\Configuration;

class Configuration
{
    /**
     * @var null|ParameterConfiguration[]
     */
    protected $parameter;

    /**
     * @return null|ParameterConfiguration[]
     */
    public function getParameter(): ?array
    {
        return $this->parameter;
    }

    /**
     * @param null|ParameterConfiguration[] $parameter
     */
    public function setParameter(?array $parameter): Configuration
    {
        $this->parameter = $parameter;

        return $this;
    }
}
