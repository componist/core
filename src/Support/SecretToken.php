<?php

declare(strict_types=1);

namespace Componist\Core\Support;

final class SecretToken
{
    public static function hash(string $plain): string
    {
        return hash('sha256', $plain);
    }

    public static function equals(string $plain, string $stored): bool
    {
        if (self::isHashed($stored)) {
            return hash_equals($stored, self::hash($plain));
        }

        return hash_equals($stored, $plain);
    }

    public static function isHashed(string $value): bool
    {
        return strlen($value) === 64 && ctype_xdigit($value);
    }

    public static function hashIfPlain(string $value): string
    {
        $value = trim($value);

        if ($value === '' || self::isHashed($value)) {
            return $value;
        }

        return self::hash($value);
    }

    public static function hint(string $plain): string
    {
        return substr($plain, 0, 8);
    }
}
