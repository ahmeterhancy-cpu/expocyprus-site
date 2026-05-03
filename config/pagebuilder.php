<?php
/**
 * PHPagebuilder konfigürasyonu — Expo Cyprus.
 * .env'den DB bilgilerini okur, mevcut admin auth ile entegredir.
 */

declare(strict_types=1);

$basePath = dirname(__DIR__);

return [
    'general' => [
        'base_url'    => getenv('APP_URL') ?: 'http://expocyprus-site.test',
        'language'    => 'tr',
        // .htaccess vendor/ yolunu engelliyor; PHP üzerinden serve edilen alias kullan
        'assets_url'  => '/pb-assets',
        'uploads_url' => '/uploads/pagebuilder',
    ],

    'storage' => [
        'use_database' => true,
        'database' => [
            'driver'    => 'mysql',
            'host'      => getenv('DB_HOST') ?: 'localhost',
            'database'  => getenv('DB_NAME') ?: 'expocyprus',
            'username'  => getenv('DB_USER') ?: 'root',
            'password'  => getenv('DB_PASS') ?: '',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => 'pb_', // pb_pages, pb_page_translations, pb_uploads, pb_settings
        ],
        'uploads_folder' => $basePath . '/public/uploads/pagebuilder',
    ],

    // Mevcut admin paneliyle entegre — kendi auth class'ımız
    'auth' => [
        'use_login' => true,
        'class' => \App\Pagebuilder\AdminAuthBridge::class,
        'url' => '/admin/login',
    ],

    // Default WebsiteManager kapalı — admin paneli bizim Tabler UI ile
    // /admin/pagebuilder/pages altında özel listemiz olacak
    'website_manager' => [
        'use_website_manager' => false,
        'class' => PHPageBuilder\Modules\WebsiteManager\WebsiteManager::class,
        'url' => '/admin/pagebuilder',
    ],

    'setting' => [
        'class' => PHPageBuilder\Setting::class,
    ],

    'pagebuilder' => [
        'class' => PHPageBuilder\Modules\GrapesJS\PageBuilder::class,
        'url' => '/admin/pagebuilder/edit',
        'actions' => [
            'back' => '/admin/cms',
        ],
    ],

    'page' => [
        'class' => PHPageBuilder\Page::class,
        // table belirtmedik — default 'pages', prefix 'pb_' ile pb_pages
        'translation' => [
            'class' => PHPageBuilder\PageTranslation::class,
            // table belirtmedik — default 'page_translations', prefix ile pb_page_translations
            'foreign_key' => 'page_id',
        ],
    ],

    'cache' => [
        'enabled' => false,
        'folder' => $basePath . '/storage/cache/pagebuilder',
        'class' => PHPageBuilder\Cache::class,
    ],

    'theme' => [
        'class' => PHPageBuilder\Theme::class,
        'folder' => $basePath . '/themes',
        'folder_url' => '/themes',
        'active_theme' => 'expocyprus',
    ],

    'router' => [
        'class' => PHPageBuilder\Modules\Router\DatabasePageRouter::class,
    ],

    'class_replacements' => [],
];
