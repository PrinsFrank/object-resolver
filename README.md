<picture>
    <source srcset="https://github.com/PrinsFrank/object-resolver/raw/main/docs/images/banner_dark.png" media="(prefers-color-scheme: dark)">
    <img src="https://github.com/PrinsFrank/object-resolver/raw/main/docs/images/banner_light.png" alt="Banner">
</picture>

# Object Resolver

[![GitHub](https://img.shields.io/github/license/prinsfrank/object-resolver)](https://github.com/PrinsFrank/object-resolver/blob/main/LICENSE)
[![PHP Version Support](https://img.shields.io/packagist/php-v/prinsfrank/object-resolver)](https://github.com/PrinsFrank/object-resolver/blob/main/composer.json)
[![Packagist Downloads](https://img.shields.io/packagist/dt/prinsfrank/object-resolver)](https://packagist.org/packages/prinsfrank/object-resolver/stats)
[![codecov](https://codecov.io/gh/PrinsFrank/object-resolver/branch/main/graph/badge.svg?token=Y03NIFWEZL)](https://codecov.io/gh/PrinsFrank/object-resolver)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-level%209-brightgreen.svg?style=flat)](https://github.com/PrinsFrank/object-resolver/blob/main/phpstan.neon)

**Resolve objects from data from requests, json etc**

## Setup

> **Note**
> Make sure you are running PHP 8.3 or higher to use this package

To start right away, run the following command in your composer project;

```composer require prinsfrank/object-resolver```

Or for development only;

```composer require prinsfrank/object-resolver --dev```

# Use cases

## Handling incoming requests

Given a simple login controller, we have the following request object:

```php
<?php declare(strict_types=1);

readonly class LogInRequest {
    public function __construct(
        #[SensitiveParameter] private string $email,
        #[SensitiveParameter] private string $password,
    ) {
    }
}
```

With a controller that looks like this:

```php
<?php declare(strict_types=1);

readonly class LogInController {
    public function __invoke(LogInRequest $logInRequest){
        // Handle authentication
    }
}
```

We somehow need to automatically wire the incoming request based on the request data. That's where this package comes in!

If there is a container available, we can then add a dynamic abstract concrete binding:

```php
final class RequestDataProvider implements ServiceProviderInterface {
    public function provides(string $identifier): bool {
        return is_a($identifier, RequestData::class, true);
    }

    public function register(string $identifier, DefinitionSet $resolvedSet): void {
        $resolvedSet->add(
            new Concrete(
                $identifier,
                static function (ObjectResolver $objectResolver, ServerRequestInterface $serverRequest) use ($identifier) {
                    $requestData = match ($serverRequest->getMethod()) {
                        'GET' => $serverRequest->getQueryParams(),
                        'POST', 
                        'PATCH', 
                        'PUT' => $serverRequest->getParsedBody(),
                        default => [],
                    };

                    return $objectResolver->resolveFromParams($identifier, $requestData);
                },
            )
        );
    }
}
```

## Casing conversion

Because code conventions between different tech stacks might differ, it's possible to automatically convert between different casings.

Let's say there's a form in HTML that has name `user_name`, but in the backend our model has parameter `$userName`. This can be automatically converted, by supplying the parameters `$enforcePropertyNameCasing` and `$convertFromParamKeyCasing`:

```php
final class ObjectResolverServiceProvider implements ServiceProviderInterface {
    #[Override]
    public function provides(string $identifier): bool {
        return $identifier === ObjectResolver::class;
    }

    /** @throws InvalidArgumentException */
    #[Override]
    public function register(string $identifier, DefinitionSet $resolvedSet): void {
        $resolvedSet->add(
            new Concrete(
                $identifier,
                fn () => new ObjectResolver(Casing::camel, Casing::snake)
            )
        );
    }
}
```

## Json from APIs etc

TODO: write documentation
