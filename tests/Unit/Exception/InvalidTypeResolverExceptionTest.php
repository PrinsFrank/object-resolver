<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Unit\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Exception\InvalidTypeResolverException;

#[CoversClass(InvalidTypeResolverException::class)]
class InvalidTypeResolverExceptionTest extends TestCase {
    /** @throws InvalidTypeResolverException */
    public function testConstruct(): void {
        static::expectExceptionMessage('foo is not a TypeResolver');
        static::expectException(InvalidTypeResolverException::class);
        throw new InvalidTypeResolverException('foo');
    }
}
