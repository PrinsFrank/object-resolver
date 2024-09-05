<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Exception;

use PrinsFrank\ObjectResolver\Casing\Casing;

class InvalidPropertyCasing extends ObjectResolverException {
    public function __construct(string $propertyName, Casing $expectedCasing) {
        parent::__construct(sprintf('Property %s does not match expected casing %s', $propertyName, $expectedCasing->name));
    }
}
