<?php

namespace ConstantExposureBundle\Controller;

use ConstantExposureBundle\Extractor\Extractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ExposeController extends AbstractController
{
    private $extractor;

    public function __construct(Extractor $extractor)
    {
        $this->extractor = $extractor;
    }

    public function index(string $_format): Response
    {
        if ('json' !== $_format) {
            throw new BadRequestHttpException('This format is not supported');
        }

        $exposition = $this->extractor->extractExposed();

        return new Response($exposition);
    }
}
