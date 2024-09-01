<?php declare(strict_types=1);

namespace PrinsFrank\Validatory;

use InvalidArgumentException;
use PrinsFrank\Validatory\Parameter\ParameterResolver;
use PrinsFrank\Validatory\Parameter\TypeResolver\TypeResolverProvider;
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
     * @throws InvalidArgumentException
     * @return T
     */
    public function resolveFromParams(string $FQN, array $params): object {
        if (class_exists($FQN) === false) {
            throw new InvalidArgumentException(sprintf('Class with FQN %s doesn\'t exist or cannot be found by the autoloader', $FQN));
        }

        if (method_exists($FQN, '__construct') === false) {
            return new $FQN();
        }

        try {
            $reflectionMethod = new ReflectionMethod($FQN, '__construct');
        } catch (Throwable) {
            throw new InvalidArgumentException(sprintf('Class %s doesn\'t have a constructor to resolve', $FQN));
        }

        $resolvedParams = [];
        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $resolvedParams[] = $this->parameterResolver->resolve($reflectionParameter, $params, $this);
        }

        return new $FQN(...$resolvedParams);
    }
}
