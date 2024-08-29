<?php declare(strict_types=1);

/** @template T */
interface TypeResolver {
    /** @param string|class-string $type */
    public function acceptsType(string $type): bool;

    /** @return T|null */
    public function resolveValue(string $type, mixed $value): mixed;
}
