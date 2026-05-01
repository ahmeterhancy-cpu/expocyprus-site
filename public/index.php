<?php
declare(strict_types=1);

/**
 * Front controller — Locale dev (public/ inside project) ve cPanel split
 * (public_html ayrı dizinde) deployment'larını destekler.
 *
 * Ortam algılama:
 *  - vendor/autoload.php parent dizinde varsa → local dev
 *  - Yoksa parent'ın parent'ında veya APP_SRC env değişkeninde aranır
 */
define('PUBLIC_PATH', __DIR__);
define('START_TIME', microtime(true));

// 1. Try local dev: project/public → project/
$basePath = dirname(__DIR__);
if (!file_exists($basePath . '/vendor/autoload.php')) {
    // 2. Try cPanel split: public_html → ~/expocyprus.com (sibling)
    $candidates = [
        dirname($basePath) . '/expocyprus.com',
        dirname($basePath) . '/expocyprus-site',
        getenv('APP_SRC') ?: '',
    ];
    foreach ($candidates as $cand) {
        if ($cand && file_exists($cand . '/vendor/autoload.php')) {
            $basePath = $cand;
            break;
        }
    }
}

if (!file_exists($basePath . '/vendor/autoload.php')) {
    http_response_code(500);
    die('<h1>500 — Setup Error</h1><p>vendor/autoload.php not found. Run <code>composer install</code> on the source directory.</p>');
}

define('BASE_PATH', $basePath);
define('VIEWS_PATH', BASE_PATH . '/views');
define('STORAGE_PATH', BASE_PATH . '/storage');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');

// Autoloader
require_once BASE_PATH . '/vendor/autoload.php';

// Load .env
$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
    }
}

// Boot
$app = new App\Core\Application();
$app->run();
