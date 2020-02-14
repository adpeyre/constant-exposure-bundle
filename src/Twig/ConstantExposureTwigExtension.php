<?php

namespace ConstantExposureBundle\Twig;

use ConstantExposureBundle\Extractor\Extractor;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ConstantExposureTwigExtension extends AbstractExtension
{
    private $extractor;
    private $serializer;
    private $defaultObjectName;

    public function __construct(Extractor $extractor, SerializerInterface $serializer, string $defaultObjectName)
    {
        $this->extractor = $extractor;
        $this->serializer = $serializer;
        $this->defaultObjectName = $defaultObjectName;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('constant_exposure_object', [$this, 'getConstantExposureObject'], ['is_safe' =>  ['html']]),
        ];
    }

    public function getConstantExposureObject(?string $varName = null): string
    {
        if (null === $varName) {
            $varName = $this->defaultObjectName;
        }

        return sprintf('<script>var %s = %s;</script>', $varName, $this->extractor->extractExposed());
    }
}
