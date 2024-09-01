<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\fixtures;

use PrinsFrank\ObjectResolver\Tests\fixtures\util\UnitEnum;

readonly class ObjectWithUnitEnumParam {
    public function __construct(
        public UnitEnum $unitEnum,
    ) {
    }
}
