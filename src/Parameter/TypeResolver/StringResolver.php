<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Parameter\TypeResolver;

use Override;
use PrinsFrank\Validatory\ObjectResolver;

/** @implements TypeResolver<string> */
class StringResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return $type === 'string';
    }

    #[Override]
    public function resolveValue(string $type, mixed $value, ObjectResolver $objectResolver): ?string {
        if (is_string($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (string) $value;
        }

        return null;
    }
}
