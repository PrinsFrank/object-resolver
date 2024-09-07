<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Unit\Parameter\TypeResolver;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Exception\InvalidTypeResolverException;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\BackedEnumResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\BoolResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\ClassResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\DateTimeImmutableResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\DateTimeResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\FloatResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\IntResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\StringResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\TypeResolverProvider;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\UnitEnumResolver;

#[CoversClass(TypeResolverProvider::class)]
class TypeResolverProviderTest extends TestCase {
    public function testAll(): void {
        $typeResolverProvider = new TypeResolverProvider();
        static::assertSame(
            [
                BackedEnumResolver::class,
                BoolResolver::class,
                DateTimeImmutableResolver::class,
                DateTimeResolver::class,
                FloatResolver::class,
                IntResolver::class,
                ClassResolver::class,
                StringResolver::class,
                UnitEnumResolver::class,
            ],
            $typeResolverProvider->all(),
        );

        $typeResolverProvider = new TypeResolverProvider([]);
        static::assertSame(
            [],
            $typeResolverProvider->all(),
        );
    }

    /** @throws InvalidTypeResolverException */
    public function testAddThrowsExceptionOnInvalidTypeResolver(): void {
        $typeResolver = new TypeResolverProvider([]);
        static::expectException(InvalidTypeResolverException::class);
        static::expectExceptionMessage('Foo is not a TypeResolver');
        /** @phpstan-ignore argument.type */
        $typeResolver->add('Foo');
    }
}
