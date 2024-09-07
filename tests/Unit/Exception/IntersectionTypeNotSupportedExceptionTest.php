<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Unit\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Exception\IntersectionTypeNotSupportedException;

#[CoversClass(IntersectionTypeNotSupportedException::class)]
class IntersectionTypeNotSupportedExceptionTest extends TestCase {
    /** @throws IntersectionTypeNotSupportedException */
    public function testConstruct(): void {
        static::expectExceptionMessage('Resolving intersection types (for parameter foo) is currently not supported');
        static::expectException(IntersectionTypeNotSupportedException::class);
        throw new IntersectionTypeNotSupportedException('foo');
    }
}
