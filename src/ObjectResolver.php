<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver;

use PrinsFrank\ObjectResolver\Casing\Casing;
use PrinsFrank\ObjectResolver\Exception\ClassDoesNotExistException;
use PrinsFrank\ObjectResolver\Exception\ClassDoesNotHaveConstructorException;
use PrinsFrank\ObjectResolver\Exception\InvalidPropertyCasing;
use PrinsFrank\ObjectResolver\Exception\ObjectResolverException;
use PrinsFrank\ObjectResolver\Parameter\ParameterResolver;
use PrinsFrank\ObjectResolver\Parameter\TypeResolver\TypeResolverProvider;
use ReflectionMethod;
use Throwable;

readonly class ObjectResolver {
    private ParameterResolver $parameterResolver;

    /**
     * When $enforcePropertyNameCasing is set to a specific value, and the casing of the properties
     * for an object doesn't match that casing, an InvalidPropertyCaseException will be thrown when resolving
     *
     * When $convertFromParamKeyCasing is set to a specific value, all values in $params that don't
     * match this casing will be dropped.
     *
     * When both $enforcePropertyNameCasing and $convertFromParamKeyCasing are set, all $params will be converted to
     * casing style in $enforcePropertyNameCasing so property $fooBar will resolve when a param foo_bar is supplied
     * and $convertFromParamCasing is set to Casing::snake and $enforcePropertyNameCasing is set to Casing::camel.
     */
    public function __construct(
        private ?Casing $enforcePropertyNameCasing = null,
        private ?Casing $convertFromParamKeyCasing = null,
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
        $params = $this->convertParamCasing($params);
        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            if ($this->enforcePropertyNameCasing !== null
                && in_array($this->enforcePropertyNameCasing, Casing::allForString($reflectionParameter->getName()), true) === false) {
                throw new InvalidPropertyCasing($reflectionParameter->getName(), $this->enforcePropertyNameCasing);
            }

            $resolvedParams[] = $this->parameterResolver->resolve($reflectionParameter, $params, $this);
        }

        return new $FQN(...$resolvedParams);
    }

    /**
     * @param array<mixed> $params
     * @return array<mixed>
     */
    private function convertParamCasing(array $params): array {
        if ($this->convertFromParamKeyCasing === null) {
            return $params;
        }

        foreach ($params as $key => $param) {
            if (is_int($key) || in_array($this->convertFromParamKeyCasing, Casing::allForString($key), true) === false) {
                unset($params[$key]);

                continue;
            }

            if ($this->enforcePropertyNameCasing === null) {
                continue;
            }

            $params[Casing::convertTo($key, $this->enforcePropertyNameCasing)] = is_array($param) ? $this->convertParamCasing($param) : $param;
        }

        return $params;
    }
}
