<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Parameter\TypeResolver;

use BackedEnum;
use DateTime;
use DateTimeImmutable;
use Override;
use PrinsFrank\ObjectResolver\Exception\ObjectResolverException;
use PrinsFrank\ObjectResolver\ObjectResolver;
use UnitEnum;

/** @implements TypeResolver<object> */
class ClassResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return class_exists($type)
            && $type !== DateTime::class
            && $type !== DateTimeImmutable::class
            && is_a($type, BackedEnum::class, true) === false
            && is_a($type, UnitEnum::class, true) === false;
    }

    /**
     * @param class-string<object>|string $type
     * @throws ObjectResolverException
     */
    #[Override]
    public function resolveValue(string $type, mixed $value, ObjectResolver $objectResolver): ?object {
        if (is_array($value) === false || array_is_list($value)) {
            return null;
        }

        return $objectResolver->resolveFromParams($type, $value);
    }
}
