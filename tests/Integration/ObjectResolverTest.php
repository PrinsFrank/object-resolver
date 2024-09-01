<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Exception\ObjectResolverException;
use PrinsFrank\ObjectResolver\ObjectResolver;
use PrinsFrank\ObjectResolver\Tests\fixtures\ObjectWithBackedEnumParam;
use PrinsFrank\ObjectResolver\Tests\fixtures\ObjectWithBoolParam;
use PrinsFrank\ObjectResolver\Tests\fixtures\ObjectWithComplexUnionParam;
use PrinsFrank\ObjectResolver\Tests\fixtures\ObjectWithFloatParam;
use PrinsFrank\ObjectResolver\Tests\fixtures\ObjectWithIntParam;
use PrinsFrank\ObjectResolver\Tests\fixtures\ObjectWithStringParam;
use PrinsFrank\ObjectResolver\Tests\fixtures\ObjectWithUnitEnumParam;
use PrinsFrank\ObjectResolver\Tests\fixtures\util\BackedEnum;
use PrinsFrank\ObjectResolver\Tests\fixtures\util\UnitEnum;

#[CoversClass(ObjectResolver::class)]
class ObjectResolverTest extends TestCase {
    /** @throws ObjectResolverException */
    public function testResolvesBackedEnumByValue(): void {
        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithBackedEnumParam::class, ['backedEnum' => 'foo']);

        static::assertSame(BackedEnum::HELLO, $resolvedValue->backedEnum);
    }

    /** @throws ObjectResolverException */
    public function testResolvesBackedEnumByName(): void {
        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithBackedEnumParam::class, ['backedEnum' => 'HELLO']);

        static::assertSame(BackedEnum::HELLO, $resolvedValue->backedEnum);
    }

    /** @throws ObjectResolverException */
    public function testResolvesBoolValue(): void {
        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithBoolParam::class, ['isTrue' => true]);

        static::assertTrue($resolvedValue->isTrue);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithBoolParam::class, ['isTrue' => 'true']);

        static::assertTrue($resolvedValue->isTrue);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithBoolParam::class, ['isTrue' => '1']);

        static::assertTrue($resolvedValue->isTrue);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithBoolParam::class, ['isTrue' => false]);

        static::assertFalse($resolvedValue->isTrue);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithBoolParam::class, ['isTrue' => 'false']);

        static::assertFalse($resolvedValue->isTrue);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithBoolParam::class, ['isTrue' => '0']);

        static::assertFalse($resolvedValue->isTrue);
    }

    /** @throws ObjectResolverException */
    public function testFloatValue(): void {
        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithFloatParam::class, ['value' => 42]);

        static::assertSame(42.0, $resolvedValue->value);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithFloatParam::class, ['value' => 42.0]);

        static::assertSame(42.0, $resolvedValue->value);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithFloatParam::class, ['value' => '42']);

        static::assertSame(42.0, $resolvedValue->value);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithFloatParam::class, ['value' => '42.0']);

        static::assertSame(42.0, $resolvedValue->value);
    }

    /** @throws ObjectResolverException */
    public function testIntValue(): void {
        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithIntParam::class, ['value' => 42]);

        static::assertSame(42, $resolvedValue->value);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithIntParam::class, ['value' => '42']);

        static::assertSame(42, $resolvedValue->value);
    }

    /** @throws ObjectResolverException */
    public function testStringValue(): void {
        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithStringParam::class, ['value' => 'foo']);

        static::assertSame('foo', $resolvedValue->value);
    }

    /** @throws ObjectResolverException */
    public function testResolvesUnitEnumByName(): void {
        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithUnitEnumParam::class, ['unitEnum' => 'HELLO']);

        static::assertSame(UnitEnum::HELLO, $resolvedValue->unitEnum);
    }

    /** @throws ObjectResolverException */
    public function testResolvesComplexUnionType(): void {
        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithComplexUnionParam::class, ['value' => 'HELLO']);

        static::assertSame(UnitEnum::HELLO, $resolvedValue->value);

        $resolvedValue = (new ObjectResolver())
            ->resolveFromParams(ObjectWithComplexUnionParam::class, ['value' => 42.0]);

        static::assertSame(42.0, $resolvedValue->value);
    }
}
