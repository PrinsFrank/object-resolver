<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Parameter\TypeResolver;

use PrinsFrank\Validatory\ObjectResolver;

/** @template T */
interface TypeResolver {
    /** @param string|class-string $type */
    public function acceptsType(string $type): bool;

    /** @return T|null */
    public function resolveValue(string $type, mixed $value, ObjectResolver $objectResolver): mixed;
}
