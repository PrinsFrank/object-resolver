<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Parameter\TypeResolver;

use BackedEnum;
use InvalidArgumentException;
use Override;
use PrinsFrank\Enums\Exception\EnumException;
use PrinsFrank\Validatory\ObjectResolver;

/** @implements TypeResolver<BackedEnum> */
class BackedEnumResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return is_a($type, BackedEnum::class, true);
    }

    /**
     * @param class-string<BackedEnum>|string $type
     * @throws InvalidArgumentException
     */
    #[Override]
    public function resolveValue(string $type, mixed $value, ObjectResolver $objectResolver): ?BackedEnum {
        if (is_a($type, BackedEnum::class, true) === false) {
            throw new InvalidArgumentException();
        }

        if (is_object($value) && is_a($value, $type, true)) {
            return $value;
        }

        if (is_int($value) === false && is_string($value) === false) {
            return null;
        }

        if (($enumValue = $type::tryFrom($value)) !== null) {
            return $enumValue;
        }

        try {
            return \PrinsFrank\Enums\BackedEnum::fromName($type, (string) $value);
        } catch (EnumException) {
            return null;
        }
    }
}
