<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class Service extends BaseModel
{
    protected static string $table = 'services';
    private static bool $extended = false;

    /** Apple-style kolonları yoksa ekle (services tablosu için tek seferlik migration) */
    public static function ensureExtended(): void
    {
        if (self::$extended) return;
        self::$extended = true;

        $cols = DB::query("SHOW COLUMNS FROM services");
        $names = array_column($cols, 'Field');

        $migrations = [
            'hero_eyebrow_tr' => "ALTER TABLE services ADD COLUMN hero_eyebrow_tr VARCHAR(150) NULL AFTER summary_en",
            'hero_eyebrow_en' => "ALTER TABLE services ADD COLUMN hero_eyebrow_en VARCHAR(150) NULL AFTER hero_eyebrow_tr",
            'hero_tagline_tr' => "ALTER TABLE services ADD COLUMN hero_tagline_tr VARCHAR(250) NULL AFTER hero_eyebrow_en",
            'hero_tagline_en' => "ALTER TABLE services ADD COLUMN hero_tagline_en VARCHAR(250) NULL AFTER hero_tagline_tr",
            'hero_subline_tr' => "ALTER TABLE services ADD COLUMN hero_subline_tr TEXT NULL AFTER hero_tagline_en",
            'hero_subline_en' => "ALTER TABLE services ADD COLUMN hero_subline_en TEXT NULL AFTER hero_subline_tr",
            'accent_color'    => "ALTER TABLE services ADD COLUMN accent_color VARCHAR(20) NULL DEFAULT '#E30613' AFTER hero_subline_en",
            'showcase_image'  => "ALTER TABLE services ADD COLUMN showcase_image VARCHAR(400) NULL AFTER image",
            'stats_json'      => "ALTER TABLE services ADD COLUMN stats_json TEXT NULL AFTER showcase_image",
        ];

        foreach ($migrations as $col => $sql) {
            if (!in_array($col, $names, true)) {
                try { DB::execute($sql); } catch (\Throwable $e) {}
            }
        }
    }

    public static function allActive(): array
    {
        return DB::query("SELECT * FROM services WHERE status = 'active' ORDER BY sort_order ASC");
    }

    public static function findBySlug(string $slug): ?array
    {
        return DB::first("SELECT * FROM services WHERE slug = ? LIMIT 1", [$slug]);
    }
}
