<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Parameter\TypeResolver;

use BackedEnum;
use Override;
use PrinsFrank\Enums\Exception\EnumException;
use PrinsFrank\ObjectResolver\Exception\ShouldNotHappenException;
use PrinsFrank\ObjectResolver\ObjectResolver;
use UnitEnum;

/** @implements TypeResolver<UnitEnum> */
class UnitEnumResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return is_a($type, UnitEnum::class, true)
            && is_a($type, BackedEnum::class, true) === false; // Make sure ordering won't matter in what typeResolver gets called first
    }

    /** @param class-string<UnitEnum>|string $type */
    #[Override]
    public function resolveValue(string $type, mixed $value, ObjectResolver $objectResolver): ?UnitEnum {
        if (is_a($type, UnitEnum::class, true) === false) {
            throw new ShouldNotHappenException();
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
