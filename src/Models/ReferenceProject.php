<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

/**
 * Referans projeler — yapılmış, tamamlanmış işler.
 * Stand kataloğundan (catalog_items) ayrıdır: orada satılan hazır modeller,
 * burada gerçekten hayata geçirilmiş projeler var.
 */
class ReferenceProject extends BaseModel
{
    protected static string $table = 'reference_projects';
    private static bool $ensured = false;

    public static function ensureTable(): void
    {
        if (self::$ensured) return;
        self::$ensured = true;

        DB::execute("CREATE TABLE IF NOT EXISTS `reference_projects` (
            `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `slug`           VARCHAR(200) NOT NULL UNIQUE,
            `title_tr`       VARCHAR(200) NOT NULL,
            `title_en`       VARCHAR(200),
            `client`         VARCHAR(200),
            `fair_name`      VARCHAR(200),
            `location`       VARCHAR(150),
            `year`           SMALLINT UNSIGNED,
            `sqm`            SMALLINT UNSIGNED,
            `stand_type`     ENUM('modular','custom','hybrid','other') DEFAULT 'custom',
            `service_type`   VARCHAR(50),
            `summary_tr`     VARCHAR(400),
            `summary_en`     VARCHAR(400),
            `description_tr` TEXT,
            `description_en` TEXT,
            `image_main`     VARCHAR(300),
            `gallery_json`   JSON,
            `featured`       TINYINT(1) NOT NULL DEFAULT 0,
            `sort_order`     INT NOT NULL DEFAULT 0,
            `status`         ENUM('active','inactive') NOT NULL DEFAULT 'active',
            `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_status_sort` (`status`, `sort_order`),
            INDEX `idx_year`        (`year`),
            INDEX `idx_service`     (`service_type`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    /** Yayındaki projeler — öne çıkanlar önce, sonra yıl (yeniden eskiye). */
    public static function allActive(string $serviceType = ''): array
    {
        self::ensureTable();
        $sql = "SELECT * FROM reference_projects WHERE status = 'active'";
        $params = [];
        if ($serviceType !== '') {
            $sql .= " AND service_type = ?";
            $params[] = $serviceType;
        }
        $sql .= " ORDER BY featured DESC, sort_order ASC, year DESC, id DESC";
        return DB::query($sql, $params);
    }

    public static function findBySlug(string $slug): ?array
    {
        self::ensureTable();
        return DB::first("SELECT * FROM reference_projects WHERE slug = ? AND status = 'active' LIMIT 1", [$slug]);
    }

    /**
     * Detay sayfasının altındaki "Diğer Projeler".
     * Aynı hizmet türündekiler önce gelir ama liste onlarla sınırlı değil —
     * tek bir stand projesi varken bölümün boş kalmaması için diğerleri de gösterilir.
     */
    public static function related(array $project, int $limit = 3): array
    {
        self::ensureTable();
        $limit = max(1, min(12, $limit));
        return DB::query(
            "SELECT * FROM reference_projects
              WHERE status = 'active' AND id <> ?
           ORDER BY (service_type = ?) DESC, featured DESC, year DESC, id DESC
              LIMIT $limit",
            [$project['id'], $project['service_type'] ?? '']
        );
    }

    /** Filtre çubuğu için hizmet türü sayıları. */
    public static function countByService(): array
    {
        self::ensureTable();
        $rows = DB::query("SELECT service_type, COUNT(*) AS cnt FROM reference_projects
                            WHERE status = 'active' AND service_type IS NOT NULL AND service_type <> ''
                            GROUP BY service_type");
        $out = [];
        foreach ($rows as $r) $out[$r['service_type']] = (int) $r['cnt'];
        return $out;
    }

    /** Kartlarda/detayda kullanılan sabit listeler. */
    public static function serviceTypes(): array
    {
        return [
            'fuar'    => ['tr' => 'Fuar Organizasyonu',  'en' => 'Fair Organisation'],
            'stand'   => ['tr' => 'Stand Tasarım & Kurulum', 'en' => 'Stand Design & Build'],
            'kongre'  => ['tr' => 'Kongre Organizasyonu', 'en' => 'Congress Organisation'],
            'etkinlik'=> ['tr' => 'Etkinlik & Lansman',   'en' => 'Event & Launch'],
            'diger'   => ['tr' => 'Diğer',                'en' => 'Other'],
        ];
    }

    public static function standTypes(): array
    {
        return [
            'modular' => ['tr' => 'Modüler',     'en' => 'Modular'],
            'custom'  => ['tr' => 'Özel Yapım',  'en' => 'Custom Build'],
            'hybrid'  => ['tr' => 'Hibrit',      'en' => 'Hybrid'],
            'other'   => ['tr' => 'Diğer',       'en' => 'Other'],
        ];
    }

    /** Kayıttaki galeri JSON'unu temiz diziye çevirir. */
    public static function gallery(array $project): array
    {
        $raw = $project['gallery_json'] ?? null;
        if (empty($raw)) return [];
        $list = is_array($raw) ? $raw : json_decode((string) $raw, true);
        if (!is_array($list)) return [];
        $out = [];
        foreach ($list as $u) {
            $u = trim((string) $u);
            if ($u !== '') $out[] = $u;
        }
        return array_values(array_unique($out));
    }
}
