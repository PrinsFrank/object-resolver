<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Exception;

class ParameterResolvesToMultipleTypesException extends ObjectResolverException {
    /** @param array<mixed> $values */
    public function __construct(string $parameterName, mixed $value, array $values) {
        parent::__construct(
            sprintf(
                'Value "%s" for parameter $%s could not be resolved, as it resulted in %d possible types: %s',
                is_string($value) || is_bool($value) || is_int($value) || is_float($value) ? $value : '{value}',
                $parameterName,
                count($values),
                implode('|', array_map(fn (mixed $value) => gettype($value), $values)),
            )
        );
    }
}
