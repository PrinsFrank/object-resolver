<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Exception;

class MissingParameterValueException extends ObjectResolverException {
    public function __construct(string $parameterName) {
        parent::__construct(sprintf('Value for parameter %s is missing', $parameterName));
    }
}
