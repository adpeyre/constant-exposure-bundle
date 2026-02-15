<?php

namespace ConstantExposureBundle\Tests\Twig;

use ConstantExposureBundle\Extractor\Extractor;
use ConstantExposureBundle\Twig\ConstantExposureTwigExtension;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\TwigFunction;

class ConstantExposureTwigExtensionTest extends TestCase
{
    public function testGetFunctionsRegistersConstantExposureObject(): void
    {
        $extractor = $this->createMock(Extractor::class);
        $twig = $this->createMock(Environment::class);

        $extension = new ConstantExposureTwigExtension($extractor, 'MyApp', $twig);
        $functions = $extension->getFunctions();

        $this->assertCount(1, $functions);
        $this->assertInstanceOf(TwigFunction::class, $functions[0]);
        $this->assertSame('constant_exposure_object', $functions[0]->getName());
    }

    public function testGetConstantExposureObjectUsesDefaultVarName(): void
    {
        $extractor = $this->createMock(Extractor::class);
        $extractor->method('extractExposed')->willReturn('{"debug":true}');

        $twig = $this->createMock(Environment::class);
        $twig->expects($this->once())
            ->method('render')
            ->with('@ConstantExposure/expose.html.twig', [
                'var_name' => 'MyApp',
                'exposed'  => '{"debug":true}',
            ])
            ->willReturn('<script>var MyApp = {"debug":true};</script>');

        $extension = new ConstantExposureTwigExtension($extractor, 'MyApp', $twig);
        $result = $extension->getConstantExposureObject();

        $this->assertStringContainsString('MyApp', $result);
    }

    public function testGetConstantExposureObjectUsesCustomVarName(): void
    {
        $extractor = $this->createMock(Extractor::class);
        $extractor->method('extractExposed')->willReturn('{}');

        $twig = $this->createMock(Environment::class);
        $twig->expects($this->once())
            ->method('render')
            ->with('@ConstantExposure/expose.html.twig', [
                'var_name' => 'CustomName',
                'exposed'  => '{}',
            ])
            ->willReturn('<script>var CustomName = {};</script>');

        $extension = new ConstantExposureTwigExtension($extractor, 'MyApp', $twig);
        $result = $extension->getConstantExposureObject('CustomName');

        $this->assertStringContainsString('CustomName', $result);
    }
}
