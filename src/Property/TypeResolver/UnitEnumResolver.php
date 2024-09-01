<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Property\TypeResolver;

use BackedEnum;
use InvalidArgumentException;
use Override;
use PrinsFrank\Enums\Exception\EnumException;
use UnitEnum;

/** @implements TypeResolver<UnitEnum> */
class UnitEnumResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return is_a($type, UnitEnum::class, true)
            && is_a($type, BackedEnum::class, true) === false; // Make sure ordering won't matter in what typeResolver gets called first
    }

    /**
     * @param class-string<UnitEnum>|string $type
     * @throws InvalidArgumentException
     */
    #[Override]
    public function resolveValue(string $type, mixed $value): ?UnitEnum {
        if (is_a($type, UnitEnum::class, true) === false) {
            throw new InvalidArgumentException();
        }

        if (is_object($value) && is_a($value, $type, true)) {
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
