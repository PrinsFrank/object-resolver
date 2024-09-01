<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver;

use PrinsFrank\ObjectResolver\Exception\ClassDoesNotExistException;
use PrinsFrank\ObjectResolver\Exception\ClassDoesNotHaveConstructorException;
use PrinsFrank\ObjectResolver\Exception\ObjectResolverException;
use PrinsFrank\ObjectResolver\Parameter\ParameterResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\TypeResolverProvider;
use ReflectionMethod;
use Throwable;

readonly class ObjectResolver {
    private ParameterResolver $parameterResolver;

    public function __construct(
        ?ParameterResolver $parameterResolver = null,
    ) {
        $this->parameterResolver = $parameterResolver ?? new ParameterResolver(new TypeResolverProvider());
    }

    /**
     * @template T of object
     * @param class-string<T> $FQN
     * @param array<string, mixed> $params
     * @throws ObjectResolverException
     * @return T
     */
    public function resolveFromParams(string $FQN, array $params): object {
        if (class_exists($FQN) === false) {
            throw new ClassDoesNotExistException($FQN);
        }

        if (method_exists($FQN, '__construct') === false) {
            return new $FQN();
        }

        try {
            $reflectionMethod = new ReflectionMethod($FQN, '__construct');
        } catch (Throwable) {
            throw new ClassDoesNotHaveConstructorException($FQN);
        }

        $resolvedParams = [];
        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $resolvedParams[] = $this->parameterResolver->resolve($reflectionParameter, $params, $this);
        }

        return new $FQN(...$resolvedParams);
    }
}
