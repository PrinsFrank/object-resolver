<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Unit\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Exception\MissingParameterValueException;

#[CoversClass(MissingParameterValueException::class)]
class MissingParameterValueExceptionTest extends TestCase {
    /** @throws MissingParameterValueException */
    public function testConstruct(): void {
        static::expectExceptionMessage('Value for parameter foo is missing');
        static::expectException(MissingParameterValueException::class);
        throw new MissingParameterValueException('foo');
    }
}
