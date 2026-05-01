<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class Member extends BaseModel
{
    protected static string $table = 'members';
    private static bool $ensured = false;

    public const STATUSES = [
        'pending'  => ['label' => 'Onay Bekliyor', 'color' => 'orange'],
        'active'   => ['label' => 'Aktif',         'color' => 'green'],
        'inactive' => ['label' => 'Pasif',         'color' => 'gray'],
        'banned'   => ['label' => 'Yasaklı',       'color' => 'red'],
    ];

    public static function ensureTable(): void
    {
        if (self::$ensured) return;
        self::$ensured = true;

        DB::execute("CREATE TABLE IF NOT EXISTS `members` (
            `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `company_name`   VARCHAR(200) NOT NULL,
            `contact_name`   VARCHAR(150) NOT NULL,
            `email`          VARCHAR(200) NOT NULL UNIQUE,
            `phone`          VARCHAR(50) NULL,
            `password_hash`  VARCHAR(255) NOT NULL,
            `tax_no`         VARCHAR(40) NULL,
            `address`        TEXT NULL,
            `city`           VARCHAR(100) NULL,
            `country`        VARCHAR(100) NOT NULL DEFAULT 'KKTC',
            `website`        VARCHAR(200) NULL,
            `logo_path`      VARCHAR(300) NULL,
            `status`         VARCHAR(40) NOT NULL DEFAULT 'pending',
            `last_login_at`  DATETIME NULL,
            `last_login_ip`  VARCHAR(45) NULL,
            `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_status` (`status`),
            INDEX `idx_email`  (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public static function findByEmail(string $email): ?array
    {
        self::ensureTable();
        return DB::first("SELECT * FROM members WHERE email = ? LIMIT 1", [strtolower($email)]);
    }

    public static function authenticate(string $email, string $password): ?array
    {
        $m = self::findByEmail($email);
        if (!$m) return null;
        if (!password_verify($password, $m['password_hash'])) return null;
        if ($m['status'] !== 'active') return null;
        return $m;
    }

    public static function register(array $data): int|string
    {
        self::ensureTable();
        $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        unset($data['password']);
        $data['email']         = strtolower(trim((string)$data['email']));
        $data['status']        = $data['status'] ?? 'pending';
        $data['created_at']    = date('Y-m-d H:i:s');
        $data['updated_at']    = date('Y-m-d H:i:s');
        return DB::insert('members', $data);
    }

    public static function paginateFiltered(int $page = 1, int $perPage = 25, array $filters = []): array
    {
        self::ensureTable();
        $where = [];
        $params = [];
        if (!empty($filters['status'])) { $where[] = 'status = ?'; $params[] = $filters['status']; }
        if (!empty($filters['q'])) {
            $where[] = '(company_name LIKE ? OR contact_name LIKE ? OR email LIKE ? OR phone LIKE ?)';
            $q = '%' . $filters['q'] . '%';
            array_push($params, $q, $q, $q, $q);
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $total = (int)(DB::first("SELECT COUNT(*) AS c FROM members $whereSql", $params)['c'] ?? 0);
        $offset = ($page - 1) * $perPage;
        $data = DB::query("SELECT * FROM members $whereSql ORDER BY created_at DESC LIMIT $perPage OFFSET $offset", $params);
        return ['data' => $data, 'total' => $total, 'page' => $page, 'last_page' => max(1, (int)ceil($total / $perPage))];
    }

    public static function statusCounts(): array
    {
        self::ensureTable();
        $rows = DB::query("SELECT status, COUNT(*) AS c FROM members GROUP BY status");
        $out = [];
        foreach ($rows as $r) $out[$r['status']] = (int)$r['c'];
        return $out;
    }
}
