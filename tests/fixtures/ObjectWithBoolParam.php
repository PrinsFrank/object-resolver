<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\fixtures;

readonly class ObjectWithBoolParam {
    public function __construct(
        public bool $isTrue
    ) {
    }
}
