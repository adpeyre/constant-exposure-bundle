<?php

namespace ConstantExposureBundle\Model\Configuration;

class ClassConfiguration
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string[]
     */
    protected $constants = [];

    /**
     * @var string
     */
    protected $alias;

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
     * @return string[]
     */
    public function getConstants(): array
    {
        return $this->constants;
    }

    /**
     * @param string[] $constants
     */
    public function setConstants(array $constants): self
    {
        $this->constants = $constants;

        return $this;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }
}
