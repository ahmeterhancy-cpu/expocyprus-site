<?php
/**
 * Geçici debug: services sorgusunu kontrol et.
 * Kullandıktan sonra SİL.
 *
 * URL: https://expocyprus.com/debug-services.php?key=expo2026
 */
declare(strict_types=1);

if (($_GET['key'] ?? '') !== 'expo2026') {
    http_response_code(403);
    exit('forbidden');
}

header('Content-Type: text/plain; charset=utf-8');

// Find base path (same logic as index.php)
$basePath = dirname(__DIR__);
if (!file_exists($basePath . '/vendor/autoload.php')) {
    foreach ([dirname($basePath) . '/expocyprus.com', dirname($basePath) . '/expocyprus-site'] as $cand) {
        if (file_exists($cand . '/vendor/autoload.php')) { $basePath = $cand; break; }
    }
}

echo "BASE_PATH: $basePath\n";

require_once $basePath . '/vendor/autoload.php';

// Load .env
$envFile = $basePath . '/.env';
echo ".env exists: " . (file_exists($envFile) ? 'YES' : 'NO') . "\n";
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
    }
}

echo "DB_HOST: " . getenv('DB_HOST') . "\n";
echo "DB_NAME: " . getenv('DB_NAME') . "\n";
echo "DB_USER: " . getenv('DB_USER') . "\n";
echo "DB_PASS: " . (getenv('DB_PASS') ? '***SET***' : 'EMPTY') . "\n\n";

if (!defined('BASE_PATH')) define('BASE_PATH', $basePath);

try {
    \App\Core\DB::connect();
    echo "✓ DB::connect() OK\n\n";
} catch (\Throwable $e) {
    echo "✗ DB::connect() FAILED: " . $e->getMessage() . "\n";
    exit;
}

// Show current DB
try {
    $cur = \App\Core\DB::query("SELECT DATABASE() AS db");
    echo "Current DB: " . ($cur[0]['db'] ?? '?') . "\n\n";
} catch (\Throwable $e) {
    echo "Current DB query failed: " . $e->getMessage() . "\n";
}

// Tables
try {
    $tables = \App\Core\DB::query("SHOW TABLES LIKE 'services'");
    echo "services table exists: " . (count($tables) > 0 ? 'YES' : 'NO') . "\n\n";
} catch (\Throwable $e) {
    echo "SHOW TABLES failed: " . $e->getMessage() . "\n";
}

// Raw count
try {
    $cnt = \App\Core\DB::query("SELECT COUNT(*) AS c FROM services");
    echo "Total services rows: " . ($cnt[0]['c'] ?? '?') . "\n";
    $active = \App\Core\DB::query("SELECT COUNT(*) AS c FROM services WHERE status = 'active'");
    echo "Active services rows: " . ($active[0]['c'] ?? '?') . "\n\n";
} catch (\Throwable $e) {
    echo "COUNT failed: " . $e->getMessage() . "\n";
}

// Full query
try {
    $rows = \App\Core\DB::query("SELECT id, slug, title_tr, image, status FROM services ORDER BY sort_order");
    echo "Rows fetched: " . count($rows) . "\n";
    foreach ($rows as $r) {
        echo "  - [{$r['id']}] {$r['slug']} | status={$r['status']} | image={$r['image']}\n";
    }
    echo "\n";
} catch (\Throwable $e) {
    echo "SELECT failed: " . $e->getMessage() . "\n";
}

// Service::allActive() — exact path used by HomeController
try {
    $list = \App\Models\Service::allActive();
    echo "Service::allActive() returned: " . count($list) . " rows\n";
} catch (\Throwable $e) {
    echo "Service::allActive() FAILED: " . $e->getMessage() . "\n";
}
