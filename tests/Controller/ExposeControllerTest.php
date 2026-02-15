<?php

namespace ConstantExposureBundle\Tests\Controller;

use ConstantExposureBundle\Controller\ExposeController;
use ConstantExposureBundle\Exception\FormatNotSupported;
use ConstantExposureBundle\Extractor\Extractor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExposeControllerTest extends TestCase
{
    #[DataProvider('contentTypeProvider')]
    public function testIndexReturnsCorrectContentType(string $format, string $expectedContentType): void
    {
        $extractor = $this->createMock(Extractor::class);
        $extractor->method('extractExposed')->with($format)->willReturn('content');

        $controller = new ExposeController($extractor);
        $response = $controller->index($format);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame($expectedContentType, $response->headers->get('Content-Type'));
        $this->assertSame('content', $response->getContent());
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function contentTypeProvider(): array
    {
        return [
            'json' => ['json', 'application/json'],
            'xml'  => ['xml', 'application/xml'],
            'csv'  => ['csv', 'text/csv'],
        ];
    }

    public function testIndexWithUnsupportedFormatReturns404(): void
    {
        $extractor = $this->createMock(Extractor::class);
        $extractor->method('extractExposed')
            ->willThrowException(new FormatNotSupported('yaml'));

        $controller = new ExposeController($extractor);

        $this->expectException(NotFoundHttpException::class);
        $controller->index('yaml');
    }
}
