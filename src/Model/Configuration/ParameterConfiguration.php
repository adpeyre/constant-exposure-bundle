<?php

namespace ConstantExposureBundle\Model\Configuration;

class ParameterConfiguration
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var null|array<int|string, mixed>|bool|int|string
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
     * @return null|array<int|string, mixed>|bool|int|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param null|array<int|string, mixed>|bool|int|string $value
     *
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }
}
