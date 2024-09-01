<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Exception;

class ParameterDoesntHaveTypeException extends ObjectResolverException {
    public function __construct(string $parameterName) {
        parent::__construct(sprintf('Unable to resolve parameter %s without a type', $parameterName));
    }
}
