<?php

namespace ConstantExposureBundle\Extractor;

use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Exposition\Exposition;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class ParameterExtractor implements ExtractorInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function run(Configuration $configuration, Exposition $exposition): Exposition
    {
        if (null !== $configuration->getParameter()) {
            $exposition->setParameter($this->extractor($configuration->getParameter()));
        }

        return $exposition;
    }

    /**
     * @param array<string> $parameters
     *
     * @return array<mixed>
     */
    protected function extractor(array $parameters): array
    {
        $parametersToExpose = [];

        foreach ($parameters as $parameterName) {
            try {
                $parametersToExpose[$parameterName] = $this->container->getParameter($parameterName);
            } catch (InvalidArgumentException $e) {
            }
        }

        return $parametersToExpose;
    }
}
