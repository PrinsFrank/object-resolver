<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Parameter\TypeResolver;

use Override;
use PrinsFrank\ObjectResolver\ObjectResolver;

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

        return null;
    }
}
