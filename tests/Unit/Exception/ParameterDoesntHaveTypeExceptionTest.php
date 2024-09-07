<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Unit\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Exception\ParameterDoesntHaveTypeException;

#[CoversClass(ParameterDoesntHaveTypeException::class)]
class ParameterDoesntHaveTypeExceptionTest extends TestCase {
    /** @throws ParameterDoesntHaveTypeException */
    public function testConstruct(): void {
        static::expectExceptionMessage('Unable to resolve parameter foo without a type');
        static::expectException(ParameterDoesntHaveTypeException::class);
        throw new ParameterDoesntHaveTypeException('foo');
    }
}
