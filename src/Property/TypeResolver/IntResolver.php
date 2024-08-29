<?php declare(strict_types=1);

/** @implements TypeResolver<int> */
class IntResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return $type === 'int';
    }

    #[Override]
    public function resolveValue(string $type, mixed $value): ?int {
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
