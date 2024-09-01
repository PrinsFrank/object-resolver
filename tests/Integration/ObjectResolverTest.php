<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Tests\Integration;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\Validatory\ObjectResolver;

#[CoversClass(ObjectResolver::class)]
class ObjectResolverTest extends TestCase {
    /** @throws InvalidArgumentException */
    public function testResolvesObject(): void {
        $resolvedObject = (new ObjectResolver())
            ->resolveFromParams(TestA::class, ['nrOfPeople' => 3]);

        static::assertSame(3, $resolvedObject->nrOfPeople);
    }

    public function testResolvesNestedObject(): void {
        $resolvedObject = (new ObjectResolver())
            ->resolveFromParams(TestB::class, ['foo' => ['nrOfPeople' => 3]]);

        static::assertSame(3, $resolvedObject->foo->nrOfPeople);
    }

    public function testResolvesUnionObjectWithOneValidOption(): void {
        $resolvedObject = (new ObjectResolver())
            ->resolveFromParams(TestC::class, ['bar' => 42]);

        static::assertSame(42, $resolvedObject->bar);

        $resolvedObject = (new ObjectResolver())
            ->resolveFromParams(TestC::class, ['bar' => ['nrOfPeople' => 42]]);

        static::assertSame(42, $resolvedObject->bar->nrOfPeople);
    }
}

class TestA {
    public function __construct(
        public int $nrOfPeople,
    ) {
    }
}

class TestB {
    public function __construct(
        public TestA $foo,
    ) {
    }
}

class TestC {
    public function __construct(
        public int|TestA $bar,
    ) {
    }
}
