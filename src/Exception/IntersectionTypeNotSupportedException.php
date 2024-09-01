<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Exception;

class IntersectionTypeNotSupportedException extends ObjectResolverException {
    public function __construct(string $parameterName) {
        parent::__construct(sprintf('Resolving intersection types (for parameter %s) is currently not supported', $parameterName));
    }
}
