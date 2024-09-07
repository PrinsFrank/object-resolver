<?php

namespace PrinsFrank\ObjectResolver\Tests\Unit\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Exception\ClassDoesNotHaveConstructorException;

#[CoversClass(ClassDoesNotHaveConstructorException::class)]
class ClassDoesNotHaveConstructorExceptionTest extends TestCase
{
    public function testConstruct(): void {
        static::expectExceptionMessage('Class foo doesn\'t have a constructor to resolve');
        static::expectException(ClassDoesNotHaveConstructorException::class);
        throw new ClassDoesNotHaveConstructorException('foo');
    }

}
