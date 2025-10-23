<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Parameter\TypeResolver;

use Override;
use PrinsFrank\ObjectResolver\ObjectResolver;

/** @implements TypeResolver<bool> */
class FalseResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return $type === 'false';
    }

    #[Override]
    public function resolveValue(string $type, mixed $value, ObjectResolver $objectResolver): ?bool {
        if (is_bool($value)) {
            return $value;
        }

        if ($value === 'false' || $value === '0' || $value === 0) {
            return false;
        }

        return null;
    }
}
