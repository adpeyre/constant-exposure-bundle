<?php

namespace ConstantExposureBundle\Twig;

use ConstantExposureBundle\Extractor\Extractor;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ConstantExposureTwigExtension extends AbstractExtension
{
    private $extractor;
    private $serializer;
    private $defaultObjectName;
    private $twig;

    public function __construct(
        Extractor $extractor,
        SerializerInterface $serializer,
        string $defaultObjectName,
        Environment $twig
    ) {
        $this->extractor = $extractor;
        $this->serializer = $serializer;
        $this->defaultObjectName = $defaultObjectName;
        $this->twig = $twig;
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

        $render = $this->twig->render('@ConstantExposure/expose.html.twig', [
            'var_name' => $varName,
            'exposed'  => $this->extractor->extractExposed(Extractor::FORMAT_JSON),
        ]);

        return preg_replace('/\s\s+/', '', $render) ?? '';
    }
}
