<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class SiteSetting extends BaseModel
{
    protected static string $table = 'site_settings';
    private static array $cache = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        if (isset(self::$cache[$key])) return self::$cache[$key];

        $row = DB::first("SELECT value FROM site_settings WHERE `key` = ? LIMIT 1", [$key]);
        $val = $row ? $row['value'] : $default;
        self::$cache[$key] = $val;
        return $val;
    }

    public static function set(string $key, mixed $value): void
    {
        $exists = DB::first("SELECT id FROM site_settings WHERE `key` = ? LIMIT 1", [$key]);
        if ($exists) {
            DB::execute("UPDATE site_settings SET value = ?, updated_at = NOW() WHERE `key` = ?", [$value, $key]);
        } else {
            DB::execute("INSERT INTO site_settings (`key`, value, created_at, updated_at) VALUES (?, ?, NOW(), NOW())", [$key, $value]);
        }
        self::$cache[$key] = $value;
    }

    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            self::set($key, $value);
        }
    }

    public static function allKeyed(): array
    {
        $rows   = DB::query("SELECT `key`, value FROM site_settings");
        $result = [];
        foreach ($rows as $row) $result[$row['key']] = $row['value'];
        return $result;
    }
}
