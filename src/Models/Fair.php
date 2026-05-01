<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class Fair extends BaseModel
{
    protected static string $table = 'fairs';
    private static bool $extended = false;

    /** Apple-style alan migrasyonu */
    public static function ensureExtended(): void
    {
        if (self::$extended) return;
        self::$extended = true;
        $cols = DB::query("SHOW COLUMNS FROM fairs");
        $names = array_column($cols, 'Field');
        $migrations = [
            'hero_eyebrow_tr' => "ALTER TABLE fairs ADD COLUMN hero_eyebrow_tr VARCHAR(150) NULL AFTER summary_en",
            'hero_eyebrow_en' => "ALTER TABLE fairs ADD COLUMN hero_eyebrow_en VARCHAR(150) NULL AFTER hero_eyebrow_tr",
            'hero_tagline_tr' => "ALTER TABLE fairs ADD COLUMN hero_tagline_tr VARCHAR(250) NULL AFTER hero_eyebrow_en",
            'hero_tagline_en' => "ALTER TABLE fairs ADD COLUMN hero_tagline_en VARCHAR(250) NULL AFTER hero_tagline_tr",
            'hero_subline_tr' => "ALTER TABLE fairs ADD COLUMN hero_subline_tr TEXT NULL AFTER hero_tagline_en",
            'hero_subline_en' => "ALTER TABLE fairs ADD COLUMN hero_subline_en TEXT NULL AFTER hero_subline_tr",
            'accent_color'    => "ALTER TABLE fairs ADD COLUMN accent_color VARCHAR(20) NULL DEFAULT '#E30613' AFTER hero_subline_en",
            'icon'            => "ALTER TABLE fairs ADD COLUMN icon VARCHAR(20) NULL AFTER image_hero",
            'stats_json'      => "ALTER TABLE fairs ADD COLUMN stats_json TEXT NULL AFTER icon",
        ];
        foreach ($migrations as $col => $sql) {
            if (!in_array($col, $names, true)) {
                try { DB::execute($sql); } catch (\Throwable $e) {}
            }
        }
    }

    public static function allActive(): array
    {
        return DB::query("SELECT * FROM fairs WHERE status = 'active' ORDER BY sort_order ASC");
    }

    public static function findBySlug(string $slug): ?array
    {
        return DB::first("SELECT * FROM fairs WHERE slug = ? LIMIT 1", [$slug]);
    }

    public static function upcoming(): array
    {
        return DB::query("SELECT * FROM fairs WHERE status = 'active' AND next_date >= CURDATE() ORDER BY next_date ASC");
    }
}
