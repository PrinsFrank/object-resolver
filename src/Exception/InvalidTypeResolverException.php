<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Exception;

class InvalidTypeResolverException extends ObjectResolverException {
    public function __construct(string $FQN) {
        parent::__construct(sprintf('%s is not a TypeResolver', $FQN));
    }
}
