<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Parameter\TypeResolver;

use Override;
use PrinsFrank\Validatory\ObjectResolver;

/** @implements TypeResolver<int> */
class IntResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return $type === 'int';
    }

    #[Override]
    public function resolveValue(string $type, mixed $value, ObjectResolver $objectResolver): ?int {
        if (is_int($value)) {
            return $value;
        }

        if ((is_string($value) && (string) (int) $value === $value)
            || (is_float($value) && (float) (int) $value === $value)) {
            return (int) $value;
        }

        return null;
    }
}
