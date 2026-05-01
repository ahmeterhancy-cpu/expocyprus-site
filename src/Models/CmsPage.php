<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

/**
 * CMS-yönetilebilir sayfalar — anasayfa, hakkımızda, hizmetler, fuarlar, vb.
 * Her sayfa için: hero, sections (JSON), SEO meta, görsel asset.
 */
class CmsPage extends BaseModel
{
    protected static string $table = 'cms_pages';
    private static bool $ensured = false;

    /** Düzenlenebilir sayfalar — slug → varsayılan başlık eşlemesi */
    public const PAGE_DEFINITIONS = [
        // Kurumsal
        'home'                => ['title_tr' => 'Anasayfa',                'title_en' => 'Home',              'route' => '/',                  'group' => 'corporate'],
        'about'               => ['title_tr' => 'Hakkımızda',              'title_en' => 'About',             'route' => '/hakkimizda',        'group' => 'corporate'],
        'history'             => ['title_tr' => 'Tarihçe',                 'title_en' => 'History',           'route' => '/tarihce',           'group' => 'corporate'],
        'team'                => ['title_tr' => 'Ekibimiz',                'title_en' => 'Team',              'route' => '/ekip',              'group' => 'corporate'],
        'mission'             => ['title_tr' => 'Misyon & Vizyon',         'title_en' => 'Mission',           'route' => '/misyon-vizyon',     'group' => 'corporate'],
        // Hizmet & Ürün
        'services'            => ['title_tr' => 'Hizmetler',               'title_en' => 'Services',          'route' => '/hizmetler',         'group' => 'services'],
        'fairs'               => ['title_tr' => 'Fuarlar',                 'title_en' => 'Fairs',             'route' => '/fuarlarimiz',       'group' => 'services'],
        'catalog'             => ['title_tr' => 'Stand Kataloğu',          'title_en' => 'Catalog',           'route' => '/stand-katalogu',    'group' => 'services'],
        'hotels'              => ['title_tr' => 'Oteller',                 'title_en' => 'Hotels',            'route' => '/oteller',           'group' => 'services'],
        'references'          => ['title_tr' => 'Projeler',                'title_en' => 'Projects',          'route' => '/referanslar',       'group' => 'services'],
        'blog'                => ['title_tr' => 'Blog',                    'title_en' => 'Blog',              'route' => '/blog',              'group' => 'services'],
        // Form sayfaları
        'contact'             => ['title_tr' => 'İletişim',                'title_en' => 'Contact',           'route' => '/iletisim',          'group' => 'forms'],
        'quote'               => ['title_tr' => 'Stand Teklif Formu',      'title_en' => 'Stand Quote',       'route' => '/teklif-al',         'group' => 'forms'],
        'inquiry'             => ['title_tr' => 'Stand Talep Formu',       'title_en' => 'Stand Inquiry',     'route' => '/talep-formu',       'group' => 'forms'],
        'material_request'    => ['title_tr' => 'Malzeme Talebi',          'title_en' => 'Material Request',  'route' => '/malzeme-talebi',    'group' => 'forms'],
        'crew'                => ['title_tr' => 'Unifex Crew Başvurusu',   'title_en' => 'Unifex Crew Application','route' => '/unifex-crew',  'group' => 'forms'],
        // Yardımcı sayfalar
        'faq'                 => ['title_tr' => 'SSS',                     'title_en' => 'FAQ',               'route' => '/sss',               'group' => 'help'],
        'cart'                => ['title_tr' => 'Sepet',                   'title_en' => 'Cart',              'route' => '/sepet',             'group' => 'help'],
        'checkout'            => ['title_tr' => 'Ödeme',                   'title_en' => 'Checkout',          'route' => '/odeme',             'group' => 'help'],
        'not_found'           => ['title_tr' => '404 — Sayfa Bulunamadı',  'title_en' => '404 — Not Found',   'route' => '/404',               'group' => 'help'],
        // Yasal
        'kvkk'                => ['title_tr' => 'KVKK',                    'title_en' => 'KVKK',              'route' => '/kvkk',              'group' => 'legal'],
        'privacy'             => ['title_tr' => 'Gizlilik Politikası',     'title_en' => 'Privacy',           'route' => '/gizlilik-politikasi','group' => 'legal'],
        'cookies'             => ['title_tr' => 'Çerez Politikası',        'title_en' => 'Cookies',           'route' => '/cerez-politikasi',  'group' => 'legal'],
        'terms'               => ['title_tr' => 'Kullanım Koşulları',      'title_en' => 'Terms',             'route' => '/kullanim-kosullari','group' => 'legal'],
    ];

    public const PAGE_GROUPS = [
        'corporate' => ['label' => 'Kurumsal',     'icon' => '🏢', 'color' => 'blue'],
        'services'  => ['label' => 'Hizmet & Ürün','icon' => '🛍️', 'color' => 'green'],
        'forms'     => ['label' => 'Formlar',      'icon' => '📝', 'color' => 'orange'],
        'help'      => ['label' => 'Yardım',       'icon' => '❓', 'color' => 'cyan'],
        'legal'     => ['label' => 'Yasal',        'icon' => '📜', 'color' => 'gray'],
    ];

    public static function ensureTable(): void
    {
        if (self::$ensured) return;
        self::$ensured = true;

        DB::execute("CREATE TABLE IF NOT EXISTS `cms_pages` (
            `id`                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `page_key`          VARCHAR(60) NOT NULL UNIQUE,
            `title_tr`          VARCHAR(250) NOT NULL,
            `title_en`          VARCHAR(250) NULL,
            `hero_eyebrow_tr`   VARCHAR(150) NULL,
            `hero_eyebrow_en`   VARCHAR(150) NULL,
            `hero_title_tr`     VARCHAR(250) NULL,
            `hero_title_en`     VARCHAR(250) NULL,
            `hero_subtitle_tr`  TEXT NULL,
            `hero_subtitle_en`  TEXT NULL,
            `hero_image`        VARCHAR(400) NULL,
            `body_tr`           LONGTEXT NULL,
            `body_en`           LONGTEXT NULL,
            `sections_json`     LONGTEXT NULL,
            `meta_title_tr`     VARCHAR(250) NULL,
            `meta_title_en`     VARCHAR(250) NULL,
            `meta_description_tr` VARCHAR(400) NULL,
            `meta_description_en` VARCHAR(400) NULL,
            `meta_keywords_tr`  VARCHAR(400) NULL,
            `meta_keywords_en`  VARCHAR(400) NULL,
            `og_image`          VARCHAR(400) NULL,
            `noindex`           TINYINT(1) NOT NULL DEFAULT 0,
            `status`            ENUM('draft','published') NOT NULL DEFAULT 'published',
            `updated_by`        INT UNSIGNED NULL,
            `created_at`        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at`        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_status` (`status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // Site geneli ayarlar — header, footer, social, contact info
        DB::execute("CREATE TABLE IF NOT EXISTS `cms_settings` (
            `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `setting_key`   VARCHAR(100) NOT NULL UNIQUE,
            `setting_value` LONGTEXT NULL,
            `setting_group` VARCHAR(50) NOT NULL DEFAULT 'general',
            `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_group` (`setting_group`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // Sync — eksik PAGE_DEFINITIONS satırlarını ekle (var olanlara dokunma)
        $existingKeys = array_column(DB::query("SELECT page_key FROM cms_pages"), 'page_key');
        foreach (self::PAGE_DEFINITIONS as $key => $def) {
            if (!in_array($key, $existingKeys, true)) {
                DB::insert('cms_pages', [
                    'page_key'  => $key,
                    'title_tr'  => $def['title_tr'],
                    'title_en'  => $def['title_en'],
                    'status'    => 'published',
                    'created_at'=> date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public static function findByKey(string $key): ?array
    {
        self::ensureTable();
        return DB::first("SELECT * FROM cms_pages WHERE page_key = ? LIMIT 1", [$key]);
    }

    public static function allOrdered(): array
    {
        self::ensureTable();
        return DB::query("SELECT * FROM cms_pages ORDER BY page_key ASC");
    }

    public static function getSetting(string $key, string $default = ''): string
    {
        self::ensureTable();
        $row = DB::first("SELECT setting_value FROM cms_settings WHERE setting_key = ?", [$key]);
        return $row ? (string)$row['setting_value'] : $default;
    }

    public static function setSetting(string $key, string $value, string $group = 'general'): void
    {
        self::ensureTable();
        $row = DB::first("SELECT id FROM cms_settings WHERE setting_key = ?", [$key]);
        if ($row) {
            DB::update('cms_settings', ['setting_value' => $value, 'setting_group' => $group], ['id' => $row['id']]);
        } else {
            DB::insert('cms_settings', ['setting_key' => $key, 'setting_value' => $value, 'setting_group' => $group]);
        }
    }

    public static function allSettings(): array
    {
        self::ensureTable();
        $rows = DB::query("SELECT setting_key, setting_value, setting_group FROM cms_settings ORDER BY setting_group, setting_key");
        $out = [];
        foreach ($rows as $r) $out[$r['setting_key']] = $r['setting_value'];
        return $out;
    }

    /**
     * Helper: sayfa içeriğini al, fallback ile.
     * View'da: $cms = CmsPage::content('about');
     */
    public static function content(string $key): array
    {
        $page = self::findByKey($key);
        if (!$page) {
            $def = self::PAGE_DEFINITIONS[$key] ?? null;
            return [
                'title_tr' => $def['title_tr'] ?? $key,
                'title_en' => $def['title_en'] ?? $key,
            ];
        }
        return $page;
    }
}
