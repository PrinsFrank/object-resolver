<?php declare(strict_types=1);

namespace PrinsFrank\Validatory\Parameter;

use InvalidArgumentException;
use PrinsFrank\Validatory\ObjectResolver;
use PrinsFrank\Validatory\Parameter\TypeResolver\TypeResolver;
use PrinsFrank\Validatory\Parameter\TypeResolver\TypeResolverProvider;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionParameter;

readonly class ParameterResolver {
    private TypeResolverProvider $typeResolverProvider;

    public function __construct(
        ?TypeResolverProvider $typeResolverProvider = null,
    ) {
        $this->typeResolverProvider = $typeResolverProvider ?? new TypeResolverProvider();
    }

    public function resolve(ReflectionParameter $reflectionParameter, array $params, ObjectResolver $objectResolver): mixed {
        if (($parameterType = $reflectionParameter->getType()) === null) {
            throw new InvalidArgumentException('Unable to resolve parameters without a type');
        }

        if ($parameterType instanceof ReflectionIntersectionType) {
            throw new InvalidArgumentException('Resolving intersection types is currently not supported');
        }

        $value = $params[$reflectionParameter->getName()] ?? null;
        if ($value === null && $reflectionParameter->isDefaultValueAvailable()) {
            return $reflectionParameter->getDefaultValue();
        }

        if ($value === null && $reflectionParameter->allowsNull() === false) {
            throw new InvalidArgumentException();
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
            $valueOptions = array_values(array_filter($valueOptions, fn (mixed $value) => $value !== null) ?? [null]);
        }

        if (count($valueOptions) !== 1 || array_key_exists(0, $valueOptions) === false) {
            throw new InvalidArgumentException(sprintf('Value for parameter $%s could not be resolved, as it resulted in %d possible values', $reflectionParameter->getName(), count($valueOptions)));
        }

        return $valueOptions[0];
    }
}
