<?php declare(strict_types=1);

namespace PrinsFrank\ObjectResolver\Casing;

use PrinsFrank\ObjectResolver\Exception\ShouldNotHappenException;

enum Casing {
    case camel;
    case pascal;
    case snake;
    case kebab;
    case upper;

    public static function convertTo(string $string, self $to): string {
        $parts = preg_split(
            match (self::forString($string)) {
                self::kebab => '/[-]+/',
                self::snake, self::upper => '/([_]+)/',
                self::camel, self::pascal => '/(?=[A-Z])/',
                null => '/([-_ ]+)|(?=[A-Z])/'
            },
            $string,
            flags: PREG_SPLIT_NO_EMPTY
        );
        if ($parts === false) {
            /** @codeCoverageIgnoreStart */
            throw new ShouldNotHappenException();
            /** @codeCoverageIgnoreEnd */
        }

        $parts = array_map(fn (string $part) => strtolower($part), $parts);
        $parts = match($to) {
            self::camel => self::partsToCamel($parts),
            self::pascal => array_map(fn (string $part) => ucfirst($part), $parts),
            self::snake, self::kebab => array_map(fn (string $part) => strtolower($part), $parts),
            self::upper => array_map(fn (string $part) => strtoupper($part), $parts),
        };

        $separator = match ($to) {
            self::camel, self::pascal => '',
            self::upper, self::snake => '_',
            self::kebab => '-',
        };

        return implode($separator, $parts);
    }

    public static function forString(string $string): ?self {
        $possibleCasings = self::allForString($string);
        if (count($possibleCasings) === 1) {
            return $possibleCasings[0];
        }

        return null;
    }

    /** @return list<self> */
    public static function allForString(string $string): array {
        if (preg_match('/^[A-Z_]+$/', $string) === 1) {
            return [self::upper];
        }

        if (preg_match('/^[a-z]+_[a-z_]+$/', $string) === 1) {
            return [self::snake];
        }

        if (preg_match('/^[a-z]+-[a-z-]+$/', $string) === 1) {
            return [self::kebab];
        }

        if (preg_match('/^[A-Z][a-zA-Z]+$/', $string) === 1) {
            return [self::pascal];
        }

        if (preg_match('/^[a-z]+[A-Z]+[a-zA-Z]+$/', $string) === 1) {
            return [self::camel];
        }

        return [self::upper, self::snake, self::kebab, self::pascal, self::camel];
    }

    /**
     * @param array<string> $parts
     * @return array<string>
     */
    private static function partsToCamel(array $parts): array {
        array_walk($parts, fn (string &$part, int $key) => $key !== 0 ? $part = ucfirst($part) : $part = lcfirst($part));

        return $parts;
    }
}
