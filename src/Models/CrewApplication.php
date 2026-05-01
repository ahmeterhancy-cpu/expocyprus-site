<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class CrewApplication extends BaseModel
{
    protected static string $table = 'crew_applications';
    private static bool $ensured = false;

    /** Pozisyonlar (çoklu seçilebilir, CSV olarak saklanır) */
    public const POSITIONS = [
        'tanitim_hostesi'    => 'Tanıtım Hostesi',
        'karsilama_hostesi'  => 'Karşılama Hostesi',
        'kongre_fuar_hostesi'=> 'Kongre & Fuar Hostesi',
        'stand_gorevlisi'    => 'Stand Görevlisi',
        'mc_sunucu'          => 'MC / Sahne Sunucusu',
        'supervisor'         => 'Süpervizör / Ekip Lideri',
        'tercuman'           => 'Tercüman',
        'model'              => 'Model',
        'dansci'             => 'Dansçı',
        'guvenlik'           => 'Güvenlik',
        'fotograf_video'     => 'Fotoğrafçı / Videografer',
        'sofor'              => 'Şoför / Transfer',
        'diger'              => 'Diğer',
    ];

    public const STATUSES = [
        'new'        => ['label' => 'Yeni',           'color' => 'blue'],
        'reviewing'  => ['label' => 'İnceleniyor',    'color' => 'azure'],
        'shortlist'  => ['label' => 'Kısa Liste',     'color' => 'cyan'],
        'interview'  => ['label' => 'Görüşmede',      'color' => 'orange'],
        'approved'   => ['label' => 'Onaylandı',      'color' => 'green'],
        'rejected'   => ['label' => 'Reddedildi',     'color' => 'red'],
        'on_hold'    => ['label' => 'Beklemede',      'color' => 'gray'],
    ];

    /** KKTC + Türkiye + Yurtdışı bölgeler */
    public const REGIONS = [
        'lefkosa'      => 'Lefkoşa',
        'girne'        => 'Girne',
        'gazimagusa'   => 'Gazimağusa',
        'guzelyurt'    => 'Güzelyurt',
        'iskele'       => 'İskele',
        'karpaz'       => 'Karpaz',
        'lefke'        => 'Lefke',
        'kktc_geneli'  => 'KKTC Geneli',
        'turkiye'      => 'Türkiye',
        'yurtdisi'     => 'Yurtdışı',
    ];

    public const MARITAL_STATUSES = [
        'bekar' => 'Bekar',
        'evli'  => 'Evli',
    ];

    public const EDUCATION_LEVELS = [
        'lise'       => 'Lise',
        'universite' => 'Üniversite',
        'ogrenci'    => 'Öğrenci',
        'onlisans'   => 'Önlisans',
        'lisansustu' => 'Lisansüstü',
    ];

    public const TRANSPORTATION_OPTIONS = [
        'evet'           => 'Evet, ulaşım sorunum var',
        'hayir'          => 'Hayır, ulaşım sorunum yok',
        'kendi_aracim'   => 'Kendi aracım var',
    ];

    public const WORK_TYPES = [
        'part_time' => 'Part Time',
        'full_time' => 'Full Time',
        'her_ikisi' => 'Her İkisi',
    ];

    public static function ensureTable(): void
    {
        if (self::$ensured) return;
        self::$ensured = true;

        DB::execute("CREATE TABLE IF NOT EXISTS `crew_applications` (
            `id`                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            -- Kişisel
            `first_name`          VARCHAR(100) NOT NULL,
            `last_name`           VARCHAR(100) NOT NULL,
            `birth_date`          DATE NULL,
            `age`                 TINYINT UNSIGNED NULL,
            `gender`              VARCHAR(20) NULL,
            `marital_status`      VARCHAR(20) NULL,
            `nationality`         VARCHAR(100) NULL,
            `id_number`           VARCHAR(30) NULL,
            -- İletişim
            `phone`               VARCHAR(50) NOT NULL,
            `email`               VARCHAR(200) NOT NULL,
            `instagram`           VARCHAR(150) NULL,
            `city`                VARCHAR(100) NULL,
            `address`             TEXT NULL,
            -- Fiziksel
            `height_cm`           SMALLINT UNSIGNED NULL,
            `weight_kg`           SMALLINT UNSIGNED NULL,
            `shirt_size`          VARCHAR(10) NULL,
            `shoe_size`           VARCHAR(10) NULL,
            `body_size`           VARCHAR(10) NULL,
            `hair_color`          VARCHAR(40) NULL,
            `eye_color`           VARCHAR(40) NULL,
            -- Eğitim & Diller
            `education`           VARCHAR(30) NULL,
            `languages`           VARCHAR(250) NULL,
            -- Çalışma tercihleri (multi)
            `positions`           TEXT NULL,
            `position_other`      VARCHAR(150) NULL,
            `work_type`           VARCHAR(30) NULL,
            `regions`             VARCHAR(60) NULL,
            `availability`        VARCHAR(150) NULL,
            -- Deneyim
            `experience_years`    TINYINT UNSIGNED NOT NULL DEFAULT 0,
            `prior_experience`    TINYINT(1) NOT NULL DEFAULT 0,
            `experience_text`     TEXT NULL,
            -- Kısıtlar
            `travel_constraint`   TINYINT(1) NOT NULL DEFAULT 0,
            `night_work`          TINYINT(1) NOT NULL DEFAULT 1,
            `transportation`      VARCHAR(30) NULL,
            -- Ücret
            `daily_rate`          DECIMAL(10,2) NULL,
            `currency`            VARCHAR(5) NOT NULL DEFAULT 'EUR',
            -- Dosyalar
            `photo_portrait`      VARCHAR(300) NULL,
            `photo_full`          VARCHAR(300) NULL,
            `photo_profile`       VARCHAR(300) NULL,
            `photo_extra`         VARCHAR(300) NULL,
            `photo_usage_consent` TINYINT(1) NOT NULL DEFAULT 0,
            `cv_path`             VARCHAR(300) NULL,
            -- Kişisel anlatım & ek mesaj
            `self_description`    TEXT NULL,
            `notes`               TEXT NULL,
            -- Admin
            `status`              VARCHAR(40) NOT NULL DEFAULT 'new',
            `admin_notes`         TEXT NULL,
            -- Meta
            `kvkk_accepted`       TINYINT(1) NOT NULL DEFAULT 0,
            `ip`                  VARCHAR(45) NULL,
            `created_at`          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at`          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_status`    (`status`),
            INDEX `idx_gender`    (`gender`),
            INDEX `idx_regions`   (`regions`),
            INDEX `idx_created`   (`created_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // ─── Migrasyon: yeni kolonlar (eski tabloya) ───────────────────
        $cols = DB::query("SHOW COLUMNS FROM crew_applications");
        $colNames = array_column($cols, 'Field');
        $migrations = [
            'age'                 => "ALTER TABLE crew_applications ADD COLUMN age TINYINT UNSIGNED NULL AFTER birth_date",
            'marital_status'      => "ALTER TABLE crew_applications ADD COLUMN marital_status VARCHAR(20) NULL AFTER gender",
            'education'           => "ALTER TABLE crew_applications ADD COLUMN education VARCHAR(30) NULL AFTER eye_color",
            'positions'           => "ALTER TABLE crew_applications ADD COLUMN positions TEXT NULL AFTER languages",
            'work_type'           => "ALTER TABLE crew_applications ADD COLUMN work_type VARCHAR(30) NULL AFTER position_other",
            'prior_experience'    => "ALTER TABLE crew_applications ADD COLUMN prior_experience TINYINT(1) NOT NULL DEFAULT 0 AFTER experience_years",
            'travel_constraint'   => "ALTER TABLE crew_applications ADD COLUMN travel_constraint TINYINT(1) NOT NULL DEFAULT 0 AFTER experience_text",
            'night_work'          => "ALTER TABLE crew_applications ADD COLUMN night_work TINYINT(1) NOT NULL DEFAULT 1 AFTER travel_constraint",
            'transportation'      => "ALTER TABLE crew_applications ADD COLUMN transportation VARCHAR(30) NULL AFTER night_work",
            'photo_extra'         => "ALTER TABLE crew_applications ADD COLUMN photo_extra VARCHAR(300) NULL AFTER photo_profile",
            'photo_usage_consent' => "ALTER TABLE crew_applications ADD COLUMN photo_usage_consent TINYINT(1) NOT NULL DEFAULT 0 AFTER photo_extra",
            'self_description'    => "ALTER TABLE crew_applications ADD COLUMN self_description TEXT NULL AFTER cv_path",
        ];
        foreach ($migrations as $col => $sql) {
            if (!in_array($col, $colNames, true)) {
                try { DB::execute($sql); } catch (\Throwable $e) { /* ignore */ }
            }
        }

        // Banka alanlarını kullanmıyoruz artık — varsa kalsın, yenilerde eklenmez
    }

    public static function paginateFiltered(int $page = 1, int $perPage = 25, array $filters = []): array
    {
        self::ensureTable();
        $where = [];
        $params = [];
        if (!empty($filters['position']))   { $where[] = 'positions LIKE ?'; $params[] = '%' . $filters['position'] . '%'; }
        if (!empty($filters['gender']))     { $where[] = 'gender = ?';       $params[] = $filters['gender']; }
        if (!empty($filters['status']))     { $where[] = 'status = ?';       $params[] = $filters['status']; }
        if (!empty($filters['regions']))    { $where[] = 'regions = ?';      $params[] = $filters['regions']; }
        if (!empty($filters['work_type']))  { $where[] = 'work_type = ?';    $params[] = $filters['work_type']; }
        if (!empty($filters['education']))  { $where[] = 'education = ?';    $params[] = $filters['education']; }
        if (!empty($filters['min_height'])) { $where[] = 'height_cm >= ?';   $params[] = (int)$filters['min_height']; }
        if (!empty($filters['max_height'])) { $where[] = 'height_cm <= ?';   $params[] = (int)$filters['max_height']; }
        if (!empty($filters['min_age'])) {
            $where[] = '(age >= ? OR TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= ?)';
            $params[] = (int)$filters['min_age'];
            $params[] = (int)$filters['min_age'];
        }
        if (!empty($filters['max_age'])) {
            $where[] = '(age <= ? OR TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) <= ?)';
            $params[] = (int)$filters['max_age'];
            $params[] = (int)$filters['max_age'];
        }
        if (!empty($filters['language']))   { $where[] = 'languages LIKE ?'; $params[] = '%' . $filters['language'] . '%'; }
        if (!empty($filters['q'])) {
            $where[] = '(first_name LIKE ? OR last_name LIKE ? OR phone LIKE ? OR email LIKE ? OR instagram LIKE ?)';
            $q = '%' . $filters['q'] . '%';
            array_push($params, $q, $q, $q, $q, $q);
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $total = (int)(DB::first("SELECT COUNT(*) AS c FROM crew_applications $whereSql", $params)['c'] ?? 0);
        $offset = ($page - 1) * $perPage;
        $data  = DB::query("SELECT * FROM crew_applications $whereSql ORDER BY created_at DESC LIMIT $perPage OFFSET $offset", $params);
        return [
            'data'      => $data,
            'total'     => $total,
            'page'      => $page,
            'last_page' => max(1, (int)ceil($total / $perPage)),
        ];
    }

    public static function statusCounts(): array
    {
        self::ensureTable();
        $rows = DB::query("SELECT status, COUNT(*) AS c FROM crew_applications GROUP BY status");
        $out = [];
        foreach ($rows as $r) $out[$r['status']] = (int)$r['c'];
        return $out;
    }

    /** CSV positions string -> array of labels */
    public static function positionLabels(?string $csv): array
    {
        if (!$csv) return [];
        $keys = array_filter(array_map('trim', explode(',', $csv)));
        $out = [];
        foreach ($keys as $k) $out[] = self::POSITIONS[$k] ?? $k;
        return $out;
    }
}
