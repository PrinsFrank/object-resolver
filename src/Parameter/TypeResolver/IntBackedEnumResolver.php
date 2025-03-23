<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Parameter\TypeResolver;

use BackedEnum;
use Override;
use PrinsFrank\Enums\Exception\EnumException;
use PrinsFrank\ObjectResolver\Exception\ShouldNotHappenException;
use PrinsFrank\ObjectResolver\ObjectResolver;
use ReflectionEnum;
use ReflectionException;

/** @implements TypeResolver<BackedEnum> */
class IntBackedEnumResolver implements TypeResolver {
    /** @throws ReflectionException */
    #[Override]
    public function acceptsType(string $type): bool {
        return is_a($type, BackedEnum::class, true)
            && (string) (new ReflectionEnum($type))->getBackingType() === 'int';
    }

    /**
     * @param class-string<BackedEnum>|string $type
     * @throws ReflectionException
     */
    #[Override]
    public function resolveValue(string $type, mixed $value, ObjectResolver $objectResolver): ?BackedEnum {
        if (is_a($type, BackedEnum::class, true) === false
            || (string) (new ReflectionEnum($type))->getBackingType() !== 'int') {
            throw new ShouldNotHappenException();
        }

        if (is_object($value) && is_a($value, $type, true)) {
            return $value;
        }

        if (is_int($value) === false && is_string($value) === false) {
            return null;
        }

        if ((string)(int) $value === $value && ($enumValue = $type::tryFrom((int) $value)) !== null) {
            return $enumValue;
        }

        try {
            return \PrinsFrank\Enums\BackedEnum::fromName($type, (string) $value);
        } catch (EnumException) {
            return null;
        }
    }
}
