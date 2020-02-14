<?php

namespace ConstantExposureBundle\Extractor;

use ConstantExposureBundle\Model\Configuration\ClassConfiguration;
use ConstantExposureBundle\Model\Configuration\Configuration;
use ConstantExposureBundle\Model\Exposition\Exposition;

class ClassExtractor implements ExtractorInterface
{
    public function run(Configuration $configuration, Exposition $exposition): Exposition
    {
        if (null !== $configuration->getClass()) {
            $exposition->setClass($this->extractor($configuration->getClass()));
        }

        return $exposition;
    }

    /**
     * @param ClassConfiguration[] $classes
     *
     * @return array<mixed>
     */
    protected function extractor(array $classes): array
    {
        $classesToExpose = [];

        foreach ($classes as $class) {
            $constantsToExpose = [];
            foreach ($class->getConstants() as $constantName) {
                $pathToConstant = sprintf('%s::%s', $class->getName(), $constantName);
                if (defined($pathToConstant)) {
                    $constantsToExpose[$constantName] = constant($pathToConstant);
                }
            }

            if (count($constantsToExpose) > 0) {
                $classesToExpose[$class->getAlias()] = $constantsToExpose;
            }
        }

        return $classesToExpose;
    }
}
