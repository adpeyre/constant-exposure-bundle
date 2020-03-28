<?php

namespace ConstantExposureBundle\Model\Configuration;

class ParameterConfiguration
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var null|mixed
     */
    protected $value;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param null|mixed $value
     *
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }
}
