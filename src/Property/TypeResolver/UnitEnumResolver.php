<?php declare(strict_types=1);

use PrinsFrank\Enums\Exception\EnumException;

/**
 * @template T of UnitEnum
 * @implements TypeResolver<T>
 */
class UnitEnumResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return is_a($type, UnitEnum::class, true)
            && is_a($type, BackedEnum::class, true) === false; // Make sure ordering won't matter in what typeResolver gets called first
    }

    /** @param class-string<T> $type */
    #[Override]
    public function resolveValue(string $type, mixed $value): mixed {
        if ($value instanceof $type) {
            return $value;
        }

        if (is_int($value) === false && is_string($value) === false) {
            return null;
        }

        try {
            return \PrinsFrank\Enums\UnitEnum::fromName($type, (string)$value);
        } catch (EnumException) {
            return null;
        }
    }
}
