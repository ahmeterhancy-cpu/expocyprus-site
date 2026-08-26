<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class CatalogItem extends BaseModel
{
    protected static string $table = 'catalog_items';

    private static bool $extended = false;

    /** Eksik sütunları güvenli şekilde ekler (migrate.php ve ilk sorguda çağrılır). */
    public static function ensureExtended(): void
    {
        if (self::$extended) return;
        self::$extended = true;

        try {
            $names = array_column(DB::query("SHOW COLUMNS FROM catalog_items"), 'Field');
        } catch (\Throwable $e) { return; }

        // Not: eski kurulumlarda bu kolonların bir kısmı hiç oluşmamış olabilir
        // (bir dönem yalnızca geçici bir setup betiğiyle ekleniyorlardı).
        $migrations = [
            'model_no'         => "ALTER TABLE catalog_items ADD COLUMN model_no VARCHAR(20) NULL",
            'name_tr'          => "ALTER TABLE catalog_items ADD COLUMN name_tr VARCHAR(200) NULL",
            'name_en'          => "ALTER TABLE catalog_items ADD COLUMN name_en VARCHAR(200) NULL",
            'size_category'    => "ALTER TABLE catalog_items ADD COLUMN size_category VARCHAR(30) NULL",
            'dimensions'       => "ALTER TABLE catalog_items ADD COLUMN dimensions VARCHAR(30) NULL",
            'price'            => "ALTER TABLE catalog_items ADD COLUMN price DECIMAL(10,2) NULL",
            'currency'         => "ALTER TABLE catalog_items ADD COLUMN currency VARCHAR(5) NULL DEFAULT 'EUR'",
            'features_json'    => "ALTER TABLE catalog_items ADD COLUMN features_json JSON NULL",
            // İngilizce özellik listesi — yoksa TR listesine düşülür
            'features_en_json' => "ALTER TABLE catalog_items ADD COLUMN features_en_json JSON NULL",
            'description_en'   => "ALTER TABLE catalog_items ADD COLUMN description_en TEXT NULL",
        ];
        foreach ($migrations as $col => $sql) {
            if (!in_array($col, $names, true)) {
                try { DB::execute($sql); } catch (\Throwable $e) {}
            }
        }
    }

    public static function filtered(array $filters = [], int $page = 1, int $perPage = 100): array
    {
        // Stand catalog: tek sayfada tüm modeller (kategori bazında gruplanır), pagination kullanılmaz
        self::ensureExtended();
        $rows  = DB::query("SELECT * FROM catalog_items WHERE status = 'active' ORDER BY
                            FIELD(size_category, 'bir-birim', 'iki-birim', 'uc-birim', 'ada'),
                            model_no ASC");
        return ['data' => $rows, 'total' => count($rows), 'page' => 1, 'last_page' => 1];
    }

    public static function findByModelNo(string $modelNo): ?array
    {
        return DB::first("SELECT * FROM catalog_items WHERE model_no = ? AND status = 'active' LIMIT 1", [$modelNo]);
    }
}
