<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Property\TypeResolver;

use DateTime;
use Override;

/** @implements TypeResolver<DateTime> */
class DateTimeResolver implements TypeResolver {
    #[Override]
    public function acceptsType(string $type): bool {
        return $type === DateTime::class;
    }

    #[Override]
    public function resolveValue(string $type, mixed $value): mixed {
        if ($value instanceof DateTime) {
            return $value;
        }

        if (is_int($value)) {
            return (new DateTime())->setTimestamp($value);
        }

        if (is_string($value) === false) {
            return null;
        }

        if (preg_match('/^[0-9]{4}-[0-9]{2}-90-9]{2}$/', $value) === 1
            && ($dateTime = DateTime::createFromFormat('Y-m-d', $value)) !== false) {
            return $dateTime;
        }

        return null;
    }
}
