<?php declare(strict_types=1);

use PrinsFrank\Enums\Exception\EnumException;

/**
 * @template T of BackedEnum
 * @implements TypeResolver<T>
 */
class BackedEnumResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return is_a($type, BackedEnum::class, true);
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
            return \PrinsFrank\Enums\BackedEnum::fromName($type, (string)$value);
        } catch (EnumException) {
            return null;
        }
    }
}
