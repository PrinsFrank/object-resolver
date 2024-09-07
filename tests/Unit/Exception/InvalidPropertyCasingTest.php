<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Unit\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Casing\Casing;
use PrinsFrank\ObjectResolver\Exception\InvalidPropertyCasing;

#[CoversClass(InvalidPropertyCasing::class)]
class InvalidPropertyCasingTest extends TestCase {
    /** @throws InvalidPropertyCasing */
    public function testConstruct(): void {
        static::expectExceptionMessage('Property foo does not match expected casing upper');
        static::expectException(InvalidPropertyCasing::class);
        throw new InvalidPropertyCasing('foo', Casing::upper);
    }
}
