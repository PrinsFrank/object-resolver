<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\fixtures;

use PrinsFrank\ObjectResolver\Tests\fixtures\util\BackedEnum;

readonly class ObjectWithBackedEnumParam {
    public function __construct(
        public BackedEnum $backedEnum,
    ) {
    }
}
