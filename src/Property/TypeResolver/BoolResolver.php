<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Property\TypeResolver;

use Override;

/** @implements TypeResolver<bool> */
class BoolResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return $type === 'bool';
    }

    #[Override]
    public function resolveValue(string $type, mixed $value): ?bool {
        if (is_bool($value)) {
            return $value;
        }

        if ($value === 'true' || $value === '1' || $value === 1) {
            return true;
        }

        if ($value === 'false' || $value === '0' || $value === 0) {
            return false;
        }

        return null;
    }
}
