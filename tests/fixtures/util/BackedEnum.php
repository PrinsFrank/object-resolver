<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\fixtures\util;

enum BackedEnum: string {
    case HELLO = 'foo';
    case WORLD = 'bar';
}
