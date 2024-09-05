<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Tests\Unit\Casing;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ObjectResolver\Casing\Casing;

#[CoversClass(Casing::class)]
class CasingTest extends TestCase {
    public function testConvert(): void {
        static::assertSame('foo', Casing::convertTo('foo', Casing::camel));
        static::assertSame('Foo', Casing::convertTo('foo', Casing::pascal));
        static::assertSame('foo', Casing::convertTo('foo', Casing::snake));
        static::assertSame('foo', Casing::convertTo('foo', Casing::kebab));
        static::assertSame('FOO', Casing::convertTo('foo', Casing::upper));

        static::assertSame('fooBar', Casing::convertTo('foo-bar', Casing::camel));
        static::assertSame('FooBar', Casing::convertTo('foo-bar', Casing::pascal));
        static::assertSame('foo_bar', Casing::convertTo('foo-bar', Casing::snake));
        static::assertSame('foo-bar', Casing::convertTo('foo-bar', Casing::kebab));
        static::assertSame('FOO_BAR', Casing::convertTo('foo-bar', Casing::upper));

        static::assertSame('fooBar', Casing::convertTo('foo_bar', Casing::camel));
        static::assertSame('FooBar', Casing::convertTo('foo_bar', Casing::pascal));
        static::assertSame('foo_bar', Casing::convertTo('foo_bar', Casing::snake));
        static::assertSame('foo-bar', Casing::convertTo('foo_bar', Casing::kebab));
        static::assertSame('FOO_BAR', Casing::convertTo('foo_bar', Casing::upper));

        static::assertSame('fooBar', Casing::convertTo('fooBar', Casing::camel));
        static::assertSame('FooBar', Casing::convertTo('fooBar', Casing::pascal));
        static::assertSame('foo_bar', Casing::convertTo('fooBar', Casing::snake));
        static::assertSame('foo-bar', Casing::convertTo('fooBar', Casing::kebab));
        static::assertSame('FOO_BAR', Casing::convertTo('fooBar', Casing::upper));

        static::assertSame('fooBar', Casing::convertTo('FooBar', Casing::camel));
        static::assertSame('FooBar', Casing::convertTo('FooBar', Casing::pascal));
        static::assertSame('foo_bar', Casing::convertTo('FooBar', Casing::snake));
        static::assertSame('foo-bar', Casing::convertTo('FooBar', Casing::kebab));
        static::assertSame('FOO_BAR', Casing::convertTo('FooBar', Casing::upper));

        static::assertSame('fooBar', Casing::convertTo('FOO_BAR', Casing::camel));
        static::assertSame('FooBar', Casing::convertTo('FOO_BAR', Casing::pascal));
        static::assertSame('foo_bar', Casing::convertTo('FOO_BAR', Casing::snake));
        static::assertSame('foo-bar', Casing::convertTo('FOO_BAR', Casing::kebab));
        static::assertSame('FOO_BAR', Casing::convertTo('FOO_BAR', Casing::upper));
    }

    public function testForString(): void {
        static::assertNull(Casing::forString(''));
        static::assertNull(Casing::forString('foo'), 'Can be snake, pascal or kebab');
        static::assertSame(Casing::kebab, Casing::forString('foo-bar'));
        static::assertSame(Casing::snake, Casing::forString('foo_bar'));
        static::assertSame(Casing::camel, Casing::forString('fooBar'));
        static::assertSame(Casing::pascal, Casing::forString('FooBar'));
        static::assertSame(Casing::upper, Casing::forString('FOO_BAR'));
    }
}
