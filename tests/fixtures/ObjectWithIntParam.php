<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\fixtures;

readonly class ObjectWithIntParam {
    public function __construct(
        public int $value
    ) {
    }
}
