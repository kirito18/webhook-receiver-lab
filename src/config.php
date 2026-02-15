<?php
declare(strict_types=1);

namespace App;

final class Config
{
    private static array $env = [];

    public static function loadEnv(string $path): void
    {
        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (trim($line) === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            self::$env[trim($key)] = trim($value);
        }
    }

    public static function get(string $key, ?string $default = null): string
    {
        return self::$env[$key] ?? $default ?? '';
    }
}