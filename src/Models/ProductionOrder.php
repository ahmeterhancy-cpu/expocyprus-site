<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class ProductionOrder extends BaseModel
{
    protected static string $table = 'production_orders';
    private static bool $ensured = false;

    /** Üretim aşamaları — sırasıyla ilerler */
    public const STAGES = [
        'order_received'   => ['label' => 'Sipariş Alındı',        'icon' => 'ti-check',           'color' => 'blue'],
        'design'           => ['label' => 'Tasarım Aşaması',       'icon' => 'ti-pencil',          'color' => 'cyan'],
        'design_review'    => ['label' => 'Müşteri Onayı',         'icon' => 'ti-eye-check',       'color' => 'orange'],
        'design_approved'  => ['label' => 'Tasarım Onaylandı',     'icon' => 'ti-thumb-up',        'color' => 'teal'],
        'production'       => ['label' => 'Üretimde',              'icon' => 'ti-tools',           'color' => 'yellow'],
        'qc'               => ['label' => 'Kalite Kontrol',        'icon' => 'ti-shield-check',    'color' => 'lime'],
        'shipping_ready'   => ['label' => 'Sevkiyata Hazır',       'icon' => 'ti-package',         'color' => 'indigo'],
        'on_site'          => ['label' => 'Sahada Kurulum',        'icon' => 'ti-truck-delivery',  'color' => 'purple'],
        'completed'        => ['label' => 'Tamamlandı',            'icon' => 'ti-trophy',          'color' => 'green'],
        'cancelled'        => ['label' => 'İptal Edildi',          'icon' => 'ti-x',               'color' => 'red'],
    ];

    public static function ensureTables(): void
    {
        if (self::$ensured) return;
        self::$ensured = true;

        DB::execute("CREATE TABLE IF NOT EXISTS `production_orders` (
            `id`               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `order_no`         VARCHAR(40) NOT NULL UNIQUE,
            `member_id`        INT UNSIGNED NOT NULL,
            `lead_id`          INT UNSIGNED NULL,
            `submission_id`    INT UNSIGNED NULL,
            `title`            VARCHAR(250) NOT NULL,
            `event_name`       VARCHAR(250) NULL,
            `event_date`       DATE NULL,
            `event_location`   VARCHAR(200) NULL,
            `stand_type`       VARCHAR(50) NULL,
            `stand_system`     VARCHAR(50) NULL,
            `dimensions`       VARCHAR(100) NULL,
            `total_sqm`        DECIMAL(8,2) NULL,
            `current_stage`    VARCHAR(40) NOT NULL DEFAULT 'order_received',
            `progress`         TINYINT UNSIGNED NOT NULL DEFAULT 10,
            `total_amount`     DECIMAL(12,2) NULL,
            `currency`         VARCHAR(5) NOT NULL DEFAULT 'EUR',
            `paid_amount`      DECIMAL(12,2) NOT NULL DEFAULT 0,
            `expected_delivery` DATE NULL,
            `description`      TEXT NULL,
            `internal_notes`   TEXT NULL,
            `created_by`       INT UNSIGNED NULL,
            `created_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_member`  (`member_id`),
            INDEX `idx_stage`   (`current_stage`),
            INDEX `idx_event`   (`event_date`),
            INDEX `idx_orderno` (`order_no`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // Aşama timeline'ı
        DB::execute("CREATE TABLE IF NOT EXISTS `production_stages_log` (
            `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `order_id`     INT UNSIGNED NOT NULL,
            `stage`        VARCHAR(40) NOT NULL,
            `status`       VARCHAR(20) NOT NULL DEFAULT 'completed',
            `note`         TEXT NULL,
            `actor_name`   VARCHAR(120) NULL,
            `actor_id`     INT UNSIGNED NULL,
            `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_order` (`order_id`),
            CONSTRAINT `fk_stage_order` FOREIGN KEY (`order_id`) REFERENCES `production_orders`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // Sipariş dosyaları (tasarımlar, sözleşmeler, fotoğraflar, faturalar)
        DB::execute("CREATE TABLE IF NOT EXISTS `production_order_files` (
            `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `order_id`     INT UNSIGNED NOT NULL,
            `kind`         VARCHAR(40) NOT NULL DEFAULT 'other',
            `original`     VARCHAR(255) NOT NULL,
            `path`         VARCHAR(400) NOT NULL,
            `size`         INT UNSIGNED NOT NULL DEFAULT 0,
            `mime`         VARCHAR(100) NULL,
            `note`         VARCHAR(400) NULL,
            `visible_to_member` TINYINT(1) NOT NULL DEFAULT 1,
            `uploaded_by`  INT UNSIGNED NULL,
            `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_pof_order` (`order_id`),
            CONSTRAINT `fk_pof_order` FOREIGN KEY (`order_id`) REFERENCES `production_orders`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // Sipariş checklists (malzeme / baskı / üretim listesi)
        DB::execute("CREATE TABLE IF NOT EXISTS `production_order_items` (
            `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `order_id`     INT UNSIGNED NOT NULL,
            `list_type`    ENUM('material','print','production_material','custom') NOT NULL DEFAULT 'material',
            `name`         VARCHAR(255) NOT NULL,
            `quantity`     DECIMAL(10,2) NOT NULL DEFAULT 1,
            `unit`         VARCHAR(20) NULL,
            `note`         VARCHAR(400) NULL,
            `is_ready`     TINYINT(1) NOT NULL DEFAULT 0,
            `ready_at`     DATETIME NULL,
            `ready_by`     VARCHAR(120) NULL,
            `sort_order`   INT NOT NULL DEFAULT 0,
            `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_poi_order` (`order_id`, `list_type`),
            CONSTRAINT `fk_poi_order` FOREIGN KEY (`order_id`) REFERENCES `production_orders`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // Sipariş üzerine mesajlar (admin ↔ üye)
        DB::execute("CREATE TABLE IF NOT EXISTS `production_order_messages` (
            `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `order_id`     INT UNSIGNED NOT NULL,
            `from_role`    ENUM('admin','member') NOT NULL,
            `from_id`      INT UNSIGNED NULL,
            `from_name`    VARCHAR(120) NULL,
            `body`         TEXT NOT NULL,
            `is_read`      TINYINT(1) NOT NULL DEFAULT 0,
            `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_pom_order` (`order_id`),
            CONSTRAINT `fk_pom_order` FOREIGN KEY (`order_id`) REFERENCES `production_orders`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public static function generateOrderNo(): string
    {
        do {
            $no = 'PO-' . date('Y') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
            $exists = DB::first("SELECT id FROM production_orders WHERE order_no = ?", [$no]);
        } while ($exists);
        return $no;
    }

    public static function progressForStage(string $stage): int
    {
        $progressMap = [
            'order_received'  => 10,
            'design'          => 25,
            'design_review'   => 40,
            'design_approved' => 55,
            'production'      => 70,
            'qc'              => 80,
            'shipping_ready'  => 88,
            'on_site'         => 95,
            'completed'       => 100,
            'cancelled'       => 0,
        ];
        return $progressMap[$stage] ?? 0;
    }

    public static function logStage(int $orderId, string $stage, ?string $note = null, ?string $actorName = null, ?int $actorId = null): void
    {
        self::ensureTables();
        DB::insert('production_stages_log', [
            'order_id'   => $orderId,
            'stage'      => $stage,
            'status'     => 'completed',
            'note'       => $note,
            'actor_name' => $actorName ?? ($_SESSION['admin_name'] ?? 'Sistem'),
            'actor_id'   => $actorId ?? ($_SESSION['admin_id'] ?? null),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function getStagesLog(int $orderId): array
    {
        self::ensureTables();
        return DB::query("SELECT * FROM production_stages_log WHERE order_id = ? ORDER BY created_at ASC", [$orderId]);
    }

    public static function getFiles(int $orderId, ?bool $visibleToMember = null): array
    {
        self::ensureTables();
        if ($visibleToMember === true) {
            return DB::query("SELECT * FROM production_order_files WHERE order_id = ? AND visible_to_member = 1 ORDER BY created_at DESC", [$orderId]);
        }
        return DB::query("SELECT * FROM production_order_files WHERE order_id = ? ORDER BY created_at DESC", [$orderId]);
    }

    public static function addFile(int $orderId, array $data): int|string
    {
        self::ensureTables();
        $data['order_id']   = $orderId;
        $data['created_at'] = date('Y-m-d H:i:s');
        return DB::insert('production_order_files', $data);
    }

    public static function deleteFile(int $fileId): bool
    {
        self::ensureTables();
        $f = DB::first("SELECT * FROM production_order_files WHERE id = ?", [$fileId]);
        if (!$f) return false;
        $abs = BASE_PATH . '/public' . $f['path'];
        if (file_exists($abs)) @unlink($abs);
        DB::delete('production_order_files', ['id' => $fileId]);
        return true;
    }

    public static function getMessages(int $orderId): array
    {
        self::ensureTables();
        return DB::query("SELECT * FROM production_order_messages WHERE order_id = ? ORDER BY created_at ASC", [$orderId]);
    }

    public static function addMessage(int $orderId, string $fromRole, ?int $fromId, ?string $fromName, string $body): int|string
    {
        self::ensureTables();
        return DB::insert('production_order_messages', [
            'order_id'   => $orderId,
            'from_role'  => $fromRole,
            'from_id'    => $fromId,
            'from_name'  => $fromName,
            'body'       => $body,
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function paginateFiltered(int $page = 1, int $perPage = 25, array $filters = []): array
    {
        self::ensureTables();
        $where = [];
        $params = [];
        if (!empty($filters['stage']))     { $where[] = 'po.current_stage = ?'; $params[] = $filters['stage']; }
        if (!empty($filters['member_id'])) { $where[] = 'po.member_id = ?';     $params[] = (int)$filters['member_id']; }
        if (!empty($filters['q'])) {
            $where[] = '(po.order_no LIKE ? OR po.title LIKE ? OR po.event_name LIKE ? OR m.company_name LIKE ?)';
            $q = '%' . $filters['q'] . '%';
            array_push($params, $q, $q, $q, $q);
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $total = (int)(DB::first("SELECT COUNT(*) AS c FROM production_orders po LEFT JOIN members m ON m.id = po.member_id $whereSql", $params)['c'] ?? 0);
        $offset = ($page - 1) * $perPage;
        $data = DB::query("SELECT po.*, m.company_name AS member_company, m.contact_name AS member_contact
                           FROM production_orders po
                           LEFT JOIN members m ON m.id = po.member_id
                           $whereSql ORDER BY po.created_at DESC LIMIT $perPage OFFSET $offset", $params);
        return ['data' => $data, 'total' => $total, 'page' => $page, 'last_page' => max(1, (int)ceil($total / $perPage))];
    }

    public static function forMember(int $memberId): array
    {
        self::ensureTables();
        return DB::query("SELECT * FROM production_orders WHERE member_id = ? ORDER BY created_at DESC", [$memberId]);
    }

    public static function findWithMember(int $id): ?array
    {
        self::ensureTables();
        return DB::first("SELECT po.*, m.company_name AS member_company, m.contact_name AS member_contact, m.email AS member_email, m.phone AS member_phone
                          FROM production_orders po
                          LEFT JOIN members m ON m.id = po.member_id
                          WHERE po.id = ? LIMIT 1", [$id]);
    }

    public const ITEM_TYPES = [
        'material'            => 'Malzeme Listesi',
        'print'               => 'Baskı Listesi',
        'production_material' => 'Malzeme Üretim Listesi',
        'custom'              => 'Diğer',
    ];

    public static function getItems(int $orderId, ?string $type = null): array
    {
        self::ensureTables();
        if ($type) {
            return DB::query("SELECT * FROM production_order_items WHERE order_id = ? AND list_type = ? ORDER BY sort_order ASC, id ASC", [$orderId, $type]);
        }
        return DB::query("SELECT * FROM production_order_items WHERE order_id = ? ORDER BY list_type ASC, sort_order ASC, id ASC", [$orderId]);
    }

    public static function addItem(int $orderId, array $data): int|string
    {
        self::ensureTables();
        $data['order_id']   = $orderId;
        $data['created_at'] = date('Y-m-d H:i:s');
        return DB::insert('production_order_items', $data);
    }

    public static function toggleItemReady(int $itemId, bool $ready, ?string $byName = null): void
    {
        self::ensureTables();
        DB::update('production_order_items', [
            'is_ready' => $ready ? 1 : 0,
            'ready_at' => $ready ? date('Y-m-d H:i:s') : null,
            'ready_by' => $ready ? ($byName ?? ($_SESSION['admin_name'] ?? 'Admin')) : null,
        ], ['id' => $itemId]);
    }

    public static function deleteItem(int $itemId): void
    {
        self::ensureTables();
        DB::delete('production_order_items', ['id' => $itemId]);
    }

    public static function itemStats(int $orderId): array
    {
        self::ensureTables();
        $rows = DB::query("SELECT list_type, COUNT(*) AS total, SUM(is_ready) AS ready FROM production_order_items WHERE order_id = ? GROUP BY list_type", [$orderId]);
        $out = [];
        foreach ($rows as $r) {
            $out[$r['list_type']] = ['total' => (int)$r['total'], 'ready' => (int)$r['ready']];
        }
        return $out;
    }

    public static function stageCounts(): array
    {
        self::ensureTables();
        $rows = DB::query("SELECT current_stage, COUNT(*) AS c FROM production_orders GROUP BY current_stage");
        $out = [];
        foreach ($rows as $r) $out[$r['current_stage']] = (int)$r['c'];
        return $out;
    }
}
