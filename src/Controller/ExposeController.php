<?php

namespace ConstantExposureBundle\Controller;

use ConstantExposureBundle\Exception\FormatNotSupported;
use ConstantExposureBundle\Extractor\Extractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ExposeController extends AbstractController
{
    public function __construct(private Extractor $extractor)
    {
    }

    public function index(string $_format): Response
    {
        try {
            $exposition = $this->extractor->extractExposed($_format);
        } catch (FormatNotSupported $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $mimeTypes = [
            'json' => 'application/json',
            'xml' => 'application/xml',
            'csv' => 'text/csv',
        ];

        return new Response($exposition, Response::HTTP_OK, [
            'Content-Type' => $mimeTypes[$_format] ?? 'text/plain',
        ]);
    }
}
