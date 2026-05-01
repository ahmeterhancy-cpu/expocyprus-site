<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class CatalogCategory extends BaseModel
{
    protected static string $table = 'catalog_categories';
    private static bool $ensured = false;

    /**
     * Auto-create table & seed defaults on first access.
     */
    public static function ensureTable(): void
    {
        if (self::$ensured) return;
        self::$ensured = true;

        DB::execute("CREATE TABLE IF NOT EXISTS `catalog_categories` (
            `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `cat_key`        VARCHAR(50) NOT NULL UNIQUE,
            `label_tr`       VARCHAR(100) NOT NULL,
            `label_en`       VARCHAR(100),
            `dimensions_tr`  VARCHAR(50),
            `dimensions_en`  VARCHAR(50),
            `description_tr` TEXT,
            `description_en` TEXT,
            `sort_order`     INT NOT NULL DEFAULT 0,
            `status`         ENUM('active','inactive') NOT NULL DEFAULT 'active',
            `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_status_sort` (`status`, `sort_order`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $count = DB::first("SELECT COUNT(*) AS c FROM catalog_categories")['c'] ?? 0;
        if ((int)$count === 0) {
            $defaults = [
                ['bir-birim', 'Bir Birim',  'Single Unit', '3m × 2m', '3m × 2m',
                    'Kompakt başlangıç stand modelleri — küçük markalar ve ilk fuar deneyimi için',
                    'Compact starter stands — for small brands and first-time exhibitors', 10],
                ['iki-birim', 'İki Birim',  'Double Unit', '6m × 2m', '6m × 2m',
                    'Orta ölçek standlar — L tipi veya iki cephe açık modeller',
                    'Mid-size stands — L-type or two-sided open models', 20],
                ['uc-birim',  'Üç Birim',   'Triple Unit', '9m × 2m', '9m × 2m',
                    'Büyük cephe standlar — üç cephe açık, çoklu sergileme bölgesi',
                    'Large frontage stands — three sides open, multiple display zones', 30],
                ['ada',       'Ada Stand',  'Island Stand', '6m × 4m', '6m × 4m',
                    'Premium ada standlar — dört cephe açık, amiral marka temsili',
                    'Premium island stands — four sides open, flagship brand presence', 40],
            ];
            foreach ($defaults as $d) {
                DB::insert('catalog_categories', [
                    'cat_key'        => $d[0],
                    'label_tr'       => $d[1],
                    'label_en'       => $d[2],
                    'dimensions_tr'  => $d[3],
                    'dimensions_en'  => $d[4],
                    'description_tr' => $d[5],
                    'description_en' => $d[6],
                    'sort_order'     => $d[7],
                    'status'         => 'active',
                ]);
            }
        }
    }

    /** Active categories ordered by sort_order */
    public static function active(): array
    {
        self::ensureTable();
        return DB::query("SELECT * FROM catalog_categories WHERE status = 'active' ORDER BY sort_order ASC, id ASC");
    }

    /** All categories (admin) */
    public static function allOrdered(): array
    {
        self::ensureTable();
        return DB::query("SELECT * FROM catalog_categories ORDER BY sort_order ASC, id ASC");
    }

    /** key => label_tr map */
    public static function keyLabelMap(): array
    {
        $map = [];
        foreach (self::active() as $c) {
            $map[$c['cat_key']] = $c['label_tr'] . ($c['dimensions_tr'] ? ' — ' . $c['dimensions_tr'] : '');
        }
        return $map;
    }

    /** key => dimensions_tr map */
    public static function keyDimMap(): array
    {
        $map = [];
        foreach (self::active() as $c) {
            $map[$c['cat_key']] = $c['dimensions_tr'] ?? '';
        }
        return $map;
    }

    public static function findByKey(string $key): ?array
    {
        self::ensureTable();
        return DB::first("SELECT * FROM catalog_categories WHERE cat_key = ? LIMIT 1", [$key]);
    }
}
