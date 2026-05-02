<?php
/**
 * Geçici PHPagebuilder setup runner — production için.
 * URL: https://expocyprus.com/setup-pagebuilder.php?key=expo2026
 *
 * 1. pb_pages, pb_page_translations, pb_uploads, pb_settings tablolarını oluşturur
 * 2. Demo sayfa seed'ini çalıştırır
 * 3. uploads/pagebuilder ve storage/cache/pagebuilder klasörlerini oluşturur
 *
 * BİTTİĞİNDE BU DOSYAYI SİL.
 */
declare(strict_types=1);

if (($_GET['key'] ?? '') !== 'expo2026') {
    http_response_code(403);
    exit('forbidden');
}

header('Content-Type: text/plain; charset=utf-8');
set_time_limit(120);

$basePath = dirname(__DIR__);
if (!file_exists($basePath . '/vendor/autoload.php')) {
    foreach ([dirname($basePath) . '/expocyprus.com', dirname($basePath) . '/expocyprus-site'] as $cand) {
        if (file_exists($cand . '/vendor/autoload.php')) { $basePath = $cand; break; }
    }
}
require_once $basePath . '/vendor/autoload.php';

// .env yükle
$envFile = $basePath . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
    }
}
if (!defined('BASE_PATH')) define('BASE_PATH', $basePath);

echo "═══ PHPagebuilder Production Setup ═══\n\n";

try {
    \App\Core\DB::connect();
    echo "✓ DB connected: " . getenv('DB_NAME') . "\n\n";
} catch (\Throwable $e) {
    exit("✗ DB connect failed: " . $e->getMessage() . "\n");
}

echo "─── 1) Schema (pb_* tabloları) ──────────────\n";
$schemaFile = $basePath . '/database/schema-pagebuilder.sql';
if (!file_exists($schemaFile)) {
    exit("✗ schema-pagebuilder.sql bulunamadı: $schemaFile\n");
}
$sql = file_get_contents($schemaFile);
$statements = array_filter(array_map('trim', preg_split('/;\s*$/m', $sql)));
$ok = 0; $skip = 0; $err = 0;
foreach ($statements as $stmt) {
    if (trim($stmt) === '') continue;
    try {
        \App\Core\DB::execute($stmt);
        $ok++;
    } catch (\Throwable $e) {
        $msg = $e->getMessage();
        if (str_contains($msg, 'already exists') || str_contains($msg, 'Duplicate')) {
            $skip++;
        } else {
            $err++;
            echo "    ! HATA: " . substr($msg, 0, 200) . "\n";
        }
    }
}
echo "  ok:$ok, skip:$skip, err:$err\n\n";

echo "─── 2) Klasörler ──────────────\n";
$dirs = [
    $basePath . '/public/uploads/pagebuilder',
    $basePath . '/storage/cache/pagebuilder',
    $basePath . '/themes/expocyprus',
];
foreach ($dirs as $d) {
    if (!is_dir($d)) {
        if (@mkdir($d, 0755, true)) {
            echo "  ✓ created: " . str_replace($basePath, '', $d) . "\n";
        } else {
            echo "  ! kurulamadı: " . str_replace($basePath, '', $d) . "\n";
        }
    } else {
        echo "  - var: " . str_replace($basePath, '', $d) . "\n";
    }
}
echo "\n";

echo "─── 3) Demo sayfa seed ──────────────\n";
try {
    ob_start();
    require $basePath . '/database/seed-pagebuilder-demo.php';
    $out = ob_get_clean();
    echo $out;
} catch (\Throwable $e) {
    echo "  ! seed hatası: " . $e->getMessage() . "\n";
}
echo "\n";

echo "─── ÖZET ──────────────\n";
foreach (['pb_pages', 'pb_page_translations', 'pb_uploads', 'pb_settings'] as $t) {
    try {
        $c = \App\Core\DB::query("SELECT COUNT(*) AS c FROM `$t`");
        echo "  $t: " . ($c[0]['c'] ?? '?') . " kayıt\n";
    } catch (\Throwable $e) {
        echo "  $t: tablo yok / hata\n";
    }
}

echo "\n✓ TAMAMLANDI\n";
echo "  Test URL'leri:\n";
echo "  - https://expocyprus.com/pb-demo (TR)\n";
echo "  - https://expocyprus.com/en/pb-demo (EN)\n";
echo "  - https://expocyprus.com/admin/pagebuilder (admin liste)\n";
echo "\nBittiğinde bu dosyayı silin: public/setup-pagebuilder.php\n";
