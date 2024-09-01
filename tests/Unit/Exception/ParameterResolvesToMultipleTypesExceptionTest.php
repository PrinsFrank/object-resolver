<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Unit\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Exception\ParameterResolvesToMultipleTypesException;

#[CoversClass(ParameterResolvesToMultipleTypesException::class)]
class ParameterResolvesToMultipleTypesExceptionTest extends TestCase {
    public function testConstruct(): void {
        $exception = new ParameterResolvesToMultipleTypesException(
            'foo',
            '123',
            [123, 123.0, '123']
        );

        static::assertSame(
            'Value "123" for parameter $foo could not be resolved, as it resulted in 3 possible types: integer|double|string',
            $exception->getMessage()
        );
    }
}
