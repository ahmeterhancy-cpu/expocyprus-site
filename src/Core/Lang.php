<?php
declare(strict_types=1);

namespace App\Core;

class Lang
{
    private static string $current = 'tr';
    private static array  $strings = [];

    public static function detect(Request $req): void
    {
        $path = $req->path();
        if (str_starts_with($path, '/en') && (strlen($path) === 3 || $path[3] === '/')) {
            self::$current = 'en';
        } else {
            self::$current = 'tr';
        }
        self::load();
    }

    public static function set(string $lang): void
    {
        self::$current = $lang;
        self::load();
    }

    public static function get(): string
    {
        return self::$current;
    }

    private static function load(): void
    {
        self::$strings = [];
        $langDir = BASE_PATH . '/lang/' . self::$current;
        if (!is_dir($langDir)) return;
        foreach (glob($langDir . '/*.php') as $file) {
            $group = basename($file, '.php');
            self::$strings[$group] = require $file;
        }
    }

    public static function trans(string $key, array $replace = []): string
    {
        [$group, $item] = array_pad(explode('.', $key, 2), 2, null);
        $text = $item
            ? (self::$strings[$group][$item] ?? $key)
            : (self::$strings[$group] ?? $key);

        if (is_array($text)) return $key;
        foreach ($replace as $k => $v) {
            $text = str_replace(':' . $k, (string)$v, $text);
        }
        return $text;
    }

    public static function url(string $path = ''): string
    {
        $base = rtrim(env('APP_URL', ''), '/');
        if (self::$current === 'en') {
            return $base . '/en' . ($path ? '/' . ltrim($path, '/') : '');
        }
        return $base . ($path ? '/' . ltrim($path, '/') : '');
    }

    public static function switch(): string
    {
        if (self::$current === 'tr') {
            return rtrim(env('APP_URL', ''), '/') . '/en';
        }
        return rtrim(env('APP_URL', ''), '/');
    }
}
