<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Exception;

class ClassDoesNotExistException extends ObjectResolverException {
    public function __construct(string $FQN) {
        parent::__construct(sprintf('Class with FQN %s doesn\'t exist or cannot be found by the autoloader', $FQN));
    }
}
