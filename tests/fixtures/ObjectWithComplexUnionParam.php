<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\fixtures;

use DateTimeImmutable;
use PrinsFrank\ObjectResolver\Tests\fixtures\util\UnitEnum;

readonly class ObjectWithComplexUnionParam {
    public function __construct(
        public float|UnitEnum|DateTimeImmutable $value
    ) {
    }
}
