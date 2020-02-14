<?php

namespace ConstantExposureBundle\Model\Configuration;

class Configuration
{
    /**
     * @var null|ClassConfiguration[]
     */
    protected $class;

    /**
     * @var null|string[]
     */
    protected $parameter;

    /**
     * @return null|ClassConfiguration[]
     */
    public function getClass(): ?array
    {
        return $this->class;
    }

    /**
     * @param null|ClassConfiguration[] $class
     */
    public function setClass(?array $class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return null|string[]
     */
    public function getParameter(): ?array
    {
        return $this->parameter;
    }

    /**
     * @param null|string[] $parameter
     */
    public function setParameter(?array $parameter): Configuration
    {
        $this->parameter = $parameter;

        return $this;
    }
}
