<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class Lead extends BaseModel
{
    protected static string $table = 'leads';
    private static bool $ensured = false;

    public const STATUSES = [
        'new'            => ['label' => 'Yeni',         'color' => 'blue',   'icon' => 'sparkles'],
        'contacted'      => ['label' => 'İletişime Geçildi','color' => 'azure','icon' => 'phone'],
        'qualified'      => ['label' => 'Nitelikli',    'color' => 'cyan',   'icon' => 'check'],
        'proposal_sent'  => ['label' => 'Teklif Gönderildi','color' => 'orange','icon' => 'file-text'],
        'negotiation'    => ['label' => 'Müzakere',     'color' => 'yellow', 'icon' => 'messages'],
        'won'            => ['label' => 'Kazanıldı',    'color' => 'green',  'icon' => 'trophy'],
        'lost'           => ['label' => 'Kaybedildi',   'color' => 'red',    'icon' => 'x'],
        'on_hold'        => ['label' => 'Beklemede',    'color' => 'gray',   'icon' => 'pause'],
    ];

    public const TEMPERATURES = [
        'cold' => ['label' => 'Soğuk', 'color' => 'blue',   'icon' => '❄️'],
        'warm' => ['label' => 'Ilık',  'color' => 'orange', 'icon' => '🌤️'],
        'hot'  => ['label' => 'Sıcak', 'color' => 'red',    'icon' => '🔥'],
    ];

    public const SOURCES = [
        'form_quote'      => 'Stand Teklif Formu',
        'form_inquiry'    => 'Stand Talep Formu',
        'form_contact'    => 'İletişim Formu',
        'form_material'   => 'Malzeme Talebi',
        'phone'           => 'Telefon',
        'email'           => 'E-posta',
        'whatsapp'        => 'WhatsApp',
        'instagram'       => 'Instagram',
        'referral'        => 'Referans',
        'fair'            => 'Fuarda Tanışma',
        'website_chat'    => 'Web Sohbet',
        'manual'          => 'Manuel Eklendi',
    ];

    public static function ensureTables(): void
    {
        if (self::$ensured) return;
        self::$ensured = true;

        DB::execute("CREATE TABLE IF NOT EXISTS `leads` (
            `id`               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `submission_id`    INT UNSIGNED NULL,
            `name`             VARCHAR(200) NOT NULL,
            `company`          VARCHAR(200) NULL,
            `email`            VARCHAR(200) NULL,
            `phone`            VARCHAR(50) NULL,
            `status`           VARCHAR(40) NOT NULL DEFAULT 'new',
            `temperature`      VARCHAR(20) NOT NULL DEFAULT 'warm',
            `score`            TINYINT UNSIGNED NOT NULL DEFAULT 50,
            `source`           VARCHAR(40) NOT NULL DEFAULT 'manual',
            `event_name`       VARCHAR(250) NULL,
            `event_date`       DATE NULL,
            `event_location`   VARCHAR(150) NULL,
            `expected_value`   DECIMAL(12,2) NULL,
            `currency`         VARCHAR(5) NOT NULL DEFAULT 'EUR',
            `has_order`        TINYINT(1) NOT NULL DEFAULT 0,
            `order_ref`        VARCHAR(100) NULL,
            `proposal_amount`  DECIMAL(12,2) NULL,
            `proposal_sent_at` DATETIME NULL,
            `next_action`      VARCHAR(250) NULL,
            `next_action_date` DATETIME NULL,
            `assigned_to`      INT UNSIGNED NULL,
            `tags_json`        JSON NULL,
            `notes`            TEXT NULL,
            `last_contacted_at` DATETIME NULL,
            `created_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_status`      (`status`),
            INDEX `idx_temperature` (`temperature`),
            INDEX `idx_assigned`    (`assigned_to`),
            INDEX `idx_next_action` (`next_action_date`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // Activities (timeline)
        DB::execute("CREATE TABLE IF NOT EXISTS `lead_activities` (
            `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `lead_id`      INT UNSIGNED NOT NULL,
            `type`         VARCHAR(40) NOT NULL,
            `title`        VARCHAR(250) NULL,
            `body`         TEXT NULL,
            `meta_json`    JSON NULL,
            `actor_id`     INT UNSIGNED NULL,
            `actor_name`   VARCHAR(120) NULL,
            `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_lead_id` (`lead_id`),
            INDEX `idx_type`    (`type`),
            CONSTRAINT `fk_activity_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // Files (proposals, contracts, briefs)
        DB::execute("CREATE TABLE IF NOT EXISTS `lead_files` (
            `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `lead_id`      INT UNSIGNED NOT NULL,
            `kind`         VARCHAR(40) NOT NULL DEFAULT 'other',
            `original`     VARCHAR(255) NOT NULL,
            `path`         VARCHAR(400) NOT NULL,
            `size`         INT UNSIGNED NOT NULL DEFAULT 0,
            `mime`         VARCHAR(100) NULL,
            `note`         VARCHAR(400) NULL,
            `uploaded_by`  INT UNSIGNED NULL,
            `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_lead_files_lead` (`lead_id`),
            CONSTRAINT `fk_lead_file_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public static function paginateFiltered(int $page = 1, int $perPage = 20, array $filters = []): array
    {
        self::ensureTables();
        $where = [];
        $params = [];
        if (!empty($filters['status']))      { $where[] = 'status = ?';      $params[] = $filters['status']; }
        if (!empty($filters['temperature'])) { $where[] = 'temperature = ?'; $params[] = $filters['temperature']; }
        if (!empty($filters['source']))      { $where[] = 'source = ?';      $params[] = $filters['source']; }
        if (!empty($filters['q'])) {
            $where[] = '(name LIKE ? OR company LIKE ? OR email LIKE ? OR phone LIKE ?)';
            $q = '%' . $filters['q'] . '%';
            array_push($params, $q, $q, $q, $q);
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $total = (int)(DB::first("SELECT COUNT(*) AS c FROM leads $whereSql", $params)['c'] ?? 0);
        $offset = ($page - 1) * $perPage;
        $data  = DB::query(
            "SELECT * FROM leads $whereSql ORDER BY created_at DESC LIMIT $perPage OFFSET $offset",
            $params
        );
        return [
            'data'      => $data,
            'total'     => $total,
            'page'      => $page,
            'last_page' => max(1, (int)ceil($total / $perPage)),
        ];
    }

    public static function statusCounts(): array
    {
        self::ensureTables();
        $rows = DB::query("SELECT status, COUNT(*) AS c FROM leads GROUP BY status");
        $out = [];
        foreach ($rows as $r) $out[$r['status']] = (int)$r['c'];
        return $out;
    }

    public static function getActivities(int $leadId): array
    {
        self::ensureTables();
        return DB::query(
            "SELECT * FROM lead_activities WHERE lead_id = ? ORDER BY created_at DESC",
            [$leadId]
        );
    }

    public static function addActivity(int $leadId, string $type, ?string $title, ?string $body = null, array $meta = [], ?string $actorName = null): int|string
    {
        self::ensureTables();
        return DB::insert('lead_activities', [
            'lead_id'    => $leadId,
            'type'       => $type,
            'title'      => $title,
            'body'       => $body,
            'meta_json'  => $meta ? json_encode($meta, JSON_UNESCAPED_UNICODE) : null,
            'actor_id'   => $_SESSION['admin_id'] ?? null,
            'actor_name' => $actorName ?? ($_SESSION['admin_name'] ?? 'Sistem'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function getFiles(int $leadId): array
    {
        self::ensureTables();
        return DB::query(
            "SELECT * FROM lead_files WHERE lead_id = ? ORDER BY created_at DESC",
            [$leadId]
        );
    }

    public static function addFile(int $leadId, array $data): int|string
    {
        self::ensureTables();
        $data['lead_id']    = $leadId;
        $data['created_at'] = date('Y-m-d H:i:s');
        return DB::insert('lead_files', $data);
    }

    public static function deleteFile(int $fileId): bool
    {
        self::ensureTables();
        $f = DB::first("SELECT * FROM lead_files WHERE id = ?", [$fileId]);
        if (!$f) return false;
        $abs = BASE_PATH . '/public' . $f['path'];
        if (file_exists($abs)) @unlink($abs);
        DB::delete('lead_files', ['id' => $fileId]);
        return true;
    }

    /** Convert a form_submission row into a lead */
    public static function fromSubmission(array $sub): int|string
    {
        self::ensureTables();
        $d = json_decode($sub['data_json'] ?? '{}', true) ?: [];
        $sourceMap = [
            'contact'           => 'form_contact',
            'stand_inquiry'     => 'form_inquiry',
            'stand_request'     => 'form_quote',
            'quote_request'     => 'form_quote',
            'material_request'  => 'form_material',
        ];
        $source = $sourceMap[$sub['form_type']] ?? 'manual';

        $lead = [
            'submission_id'  => $sub['id'],
            'name'           => $d['contact_name'] ?? $d['customer_name'] ?? $d['name'] ?? '—',
            'company'        => $d['company'] ?? null,
            'email'          => $d['email'] ?? null,
            'phone'          => $d['phone'] ?? null,
            'event_name'     => $d['event_name'] ?? $d['fair_name'] ?? null,
            'event_date'     => !empty($d['event_date']) ? $d['event_date'] : (!empty($d['fair_date']) ? $d['fair_date'] : null),
            'event_location' => $d['event_location'] ?? $d['fair_location'] ?? null,
            'source'         => $source,
            'status'         => 'new',
            'temperature'    => 'warm',
            'score'          => 50,
            'notes'          => $d['notes'] ?? $d['message'] ?? null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];
        $id = (int)DB::insert('leads', $lead);

        self::addActivity(
            $id,
            'created',
            'Lead form başvurusundan oluşturuldu',
            'Form tipi: ' . ($sub['form_type'] ?? '—'),
            ['submission_id' => $sub['id']]
        );

        return $id;
    }
}
