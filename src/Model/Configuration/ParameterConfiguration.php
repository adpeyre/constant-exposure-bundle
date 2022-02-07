<?php

namespace ConstantExposureBundle\Model\Configuration;

class ParameterConfiguration
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var null|int|string
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
     * @return null|int|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param null|int|string $value
     *
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }
}
