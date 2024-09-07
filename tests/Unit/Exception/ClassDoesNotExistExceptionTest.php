<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Unit\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Exception\ClassDoesNotExistException;

#[CoversClass(ClassDoesNotExistException::class)]
class ClassDoesNotExistExceptionTest extends TestCase {
    /** @throws ClassDoesNotExistException */
    public function testConstruct(): void {
        static::expectExceptionMessage('Class with FQN foo doesn\'t exist or cannot be found by the autoloader');
        static::expectException(ClassDoesNotExistException::class);
        throw new ClassDoesNotExistException('foo');
    }
}
