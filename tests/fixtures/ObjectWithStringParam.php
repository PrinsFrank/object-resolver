<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\fixtures;

class ObjectWithStringParam {
    public function __construct(
        public string $value
    ) {
    }
}
