<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Property\TypeResolver;

/** @implements TypeResolver<float> */
class FloatResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return $type === 'float';
    }

    #[Override]
    public function resolveValue(string $type, mixed $value): ?float {
        if (is_float($value)) {
            return $value;
        }

        if ((is_string($value) && (string) (float) $value === $value)
            || (is_int($value) && (int) (float) $value === $value)) {
            return (float) $value;
        }

        return null;
    }
}
