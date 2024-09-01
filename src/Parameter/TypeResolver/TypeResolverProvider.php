<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Parameter\TypeResolver;

use PrinsFrank\ObjectResolver\Exception\InvalidTypeResolverException;

class TypeResolverProvider {
    /** @param array<class-string<TypeResolver<mixed>>> $typeResolvers */
    public function __construct(
        private array $typeResolvers = [
            BackedEnumResolver::class,
            BoolResolver::class,
            DateTimeImmutableResolver::class,
            DateTimeResolver::class,
            FloatResolver::class,
            IntResolver::class,
            ClassResolver::class,
            StringResolver::class,
            UnitEnumResolver::class,
        ]
    ) {
    }

    /** @return array<class-string<TypeResolver<mixed>>> */
    public function all(): array {
        return $this->typeResolvers;
    }

    /**
     * @param class-string<TypeResolver<mixed>> $typeResolver
     * @throws InvalidTypeResolverException
     */
    public function add(string $typeResolver): void {
        if (is_a($typeResolver, TypeResolver::class, true) === false) {
            throw new InvalidTypeResolverException($typeResolver);
        }

        $this->typeResolvers[] = $typeResolver;
    }
}
