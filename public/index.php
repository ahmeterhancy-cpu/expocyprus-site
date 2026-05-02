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

// Auto-detect BASE_PATH:
// 1. Local dev / single-dir cPanel: project/public/index.php → project/ has vendor/
$basePath = dirname(__DIR__);
if (!file_exists($basePath . '/vendor/autoload.php')) {
    // 2. Split cPanel — sibling source dir
    $homeDir = $basePath;
    $candidates = [
        $homeDir . '/expocyprus.com',
        $homeDir . '/expocyprus-site',
        $homeDir . '/expocyprus',
        dirname($basePath) . '/expocyprus.com',
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

// PHPageBuilder erken hook: edit/preview/asset URL'leri direkt PB'ye delege
$pbUri = explode('?', $_SERVER['REQUEST_URI'] ?? '/', 2)[0];
if (App\Pagebuilder\PageBuilderApp::isPageBuilderUrl($pbUri)) {
    @session_start();
    App\Pagebuilder\PageBuilderApp::handleAuthenticatedRequest();
    return;
}

// Boot
$app = new App\Core\Application();
$app->run();
