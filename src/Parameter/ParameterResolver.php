<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Parameter;

use PrinsFrank\ObjectResolver\Exception\IntersectionTypeNotSupportedException;
use PrinsFrank\ObjectResolver\Exception\MissingParameterValueException;
use PrinsFrank\ObjectResolver\Exception\ParameterDoesntHaveTypeException;
use PrinsFrank\ObjectResolver\Exception\ParameterResolvesToMultipleTypesException;
use PrinsFrank\ObjectResolver\ObjectResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\TypeResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\TypeResolverProvider;
use ReflectionIntersectionType;
use ReflectionParameter;

readonly class ParameterResolver {
    public function __construct(
        private TypeResolverProvider $typeResolverProvider,
    ) {
    }

    /**
     * @param array<string, mixed> $params
     * @throws IntersectionTypeNotSupportedException
     * @throws MissingParameterValueException
     * @throws ParameterDoesntHaveTypeException
     * @throws ParameterResolvesToMultipleTypesException
     */
    public function resolve(ReflectionParameter $reflectionParameter, array $params, ObjectResolver $objectResolver): mixed {
        if (($parameterType = $reflectionParameter->getType()) === null) {
            throw new ParameterDoesntHaveTypeException($reflectionParameter->getName());
        }

        if ($parameterType instanceof ReflectionIntersectionType) {
            throw new IntersectionTypeNotSupportedException($reflectionParameter->getName());
        }

        $value = $params[$reflectionParameter->getName()] ?? null;
        if ($value === null && $reflectionParameter->isDefaultValueAvailable()) {
            /** @phpstan-ignore missingType.checkedException */
            return $reflectionParameter->getDefaultValue();
        }

        $valueOptions = [];
        foreach (explode('|', $parameterType->__toString()) as $allowedType) {
            foreach ($this->typeResolverProvider->all() as $typeResolverFQN) {
                /** @var TypeResolver<mixed> $typeResolver */
                $typeResolver = new $typeResolverFQN();
                if ($typeResolver->acceptsType($allowedType) === false) {
                    continue;
                }

                $valueOptions[] = $typeResolver->resolveValue($allowedType, $value, $objectResolver);
            }
        }

        if (count($valueOptions) > 1) {
            $valueOptions = array_values(array_filter($valueOptions, fn (mixed $value) => $value !== null));
            if ($valueOptions === []) {
                $valueOptions = [null];
            }
        }

        if (count($valueOptions) !== 1) {
            throw new ParameterResolvesToMultipleTypesException($reflectionParameter->getName(), $value, $valueOptions);
        }

        if ($valueOptions[0] === null && $reflectionParameter->allowsNull() === false) {
            throw new MissingParameterValueException($reflectionParameter->getName());
        }

        return $valueOptions[0];
    }
}
