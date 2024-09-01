<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\fixtures;

readonly class ObjectWithFloatParam {
    public function __construct(
        public float $value
    ) {
    }
}
