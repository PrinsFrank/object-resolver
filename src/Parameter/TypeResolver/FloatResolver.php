<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Parameter\TypeResolver;

use Override;
use PrinsFrank\ObjectResolver\ObjectResolver;

/** @implements TypeResolver<float> */
class FloatResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return $type === 'float';
    }

    #[Override]
    public function resolveValue(string $type, mixed $value, ObjectResolver $objectResolver): ?float {
        if (is_float($value)) {
            return $value;
        }

        if ((is_string($value) && (string) (float) $value === $value)
            || (is_string($value) && (float) $value . '.0' === $value)
            || (is_int($value) && (int) (float) $value === $value)) {
            return (float) $value;
        }

        return null;
    }
}
