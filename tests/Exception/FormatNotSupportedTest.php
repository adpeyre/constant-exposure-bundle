<?php

namespace ConstantExposureBundle\Tests\Exception;

use ConstantExposureBundle\Exception\FormatNotSupported;
use PHPUnit\Framework\TestCase;

class FormatNotSupportedTest extends TestCase
{
    public function testExceptionMessage(): void
    {
        $exception = new FormatNotSupported('yaml');

        $this->assertSame(
            'ConstantExposureBundle does not support "yaml" format.',
            $exception->getMessage()
        );
    }
}
