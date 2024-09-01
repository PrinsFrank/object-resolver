<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Exception;

class ClassDoesNotHaveConstructorException extends ObjectResolverException {
    public function __construct(string $FQN) {
        parent::__construct(sprintf('Class %s doesn\'t have a constructor to resolve', $FQN));
    }
}
