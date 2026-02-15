<?php

namespace ConstantExposureBundle\Twig;

use ConstantExposureBundle\Extractor\Extractor;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ConstantExposureTwigExtension extends AbstractExtension
{
    public function __construct(
        private Extractor $extractor,
        private string $defaultObjectName,
        private Environment $twig,
    ) {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
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
