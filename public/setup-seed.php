<?php
/**
 * Geçici seed runner — tüm DB seed dosyalarını sırayla çalıştırır.
 * Kullanım:
 *   https://expocyprus.com/setup-seed.php?key=expo2026
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

// Find base path
$basePath = dirname(__DIR__);
if (!file_exists($basePath . '/vendor/autoload.php')) {
    foreach ([dirname($basePath) . '/expocyprus.com', dirname($basePath) . '/expocyprus-site'] as $cand) {
        if (file_exists($cand . '/vendor/autoload.php')) { $basePath = $cand; break; }
    }
}
require_once $basePath . '/vendor/autoload.php';

// Load .env
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

echo "═══ Expo Cyprus — Seed Runner ═══\n\n";

try {
    \App\Core\DB::connect();
    echo "✓ DB connected: " . getenv('DB_NAME') . "\n\n";
} catch (\Throwable $e) {
    exit("✗ DB connect failed: " . $e->getMessage() . "\n");
}

/**
 * SQL dosyasını parse et ve çalıştır.
 * Çoklu satır INSERT'leri ve string içindeki noktalı virgülleri korur.
 */
function runSqlFile(string $path): void {
    $name = basename($path);
    if (!file_exists($path)) {
        echo "  ⊘ $name — bulunamadı, atlandı\n";
        return;
    }
    $sql = file_get_contents($path);
    // Yorum satırlarını temizle
    $sql = preg_replace('/^--.*$/m', '', $sql);

    // String literal'leri korumak için basit parse
    $statements = [];
    $current = '';
    $inString = false;
    $stringChar = '';
    $escaped = false;
    $len = strlen($sql);
    for ($i = 0; $i < $len; $i++) {
        $ch = $sql[$i];
        if ($escaped) { $current .= $ch; $escaped = false; continue; }
        if ($ch === '\\' && $inString) { $current .= $ch; $escaped = true; continue; }
        if ($inString) {
            $current .= $ch;
            if ($ch === $stringChar) $inString = false;
        } else {
            if ($ch === "'" || $ch === '"') { $inString = true; $stringChar = $ch; $current .= $ch; }
            elseif ($ch === ';') {
                $stmt = trim($current);
                if ($stmt !== '') $statements[] = $stmt;
                $current = '';
            } else {
                $current .= $ch;
            }
        }
    }
    if (trim($current) !== '') $statements[] = trim($current);

    $ok = 0; $skip = 0; $err = 0;
    foreach ($statements as $stmt) {
        try {
            \App\Core\DB::execute($stmt);
            $ok++;
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'Duplicate entry') || str_contains($msg, 'already exists')) {
                $skip++;
            } else {
                $err++;
                echo "    ! HATA: " . substr($msg, 0, 200) . "\n";
            }
        }
    }
    echo "  ✓ $name — ok:$ok skip:$skip err:$err\n";
}

/**
 * PHP seed dosyasını include et.
 */
function runPhpSeed(string $path): void {
    $name = basename($path);
    if (!file_exists($path)) {
        echo "  ⊘ $name — bulunamadı, atlandı\n";
        return;
    }
    try {
        ob_start();
        require $path;
        ob_end_clean();
        echo "  ✓ $name — çalıştı\n";
    } catch (\Throwable $e) {
        ob_end_clean();
        echo "  ! $name — hata: " . substr($e->getMessage(), 0, 200) . "\n";
    }
}

$db = $basePath . '/database';

echo "─── 1) Schema migration ──────────────\n";
try {
    ob_start();
    require $db . '/migrate.php';
    $output = ob_get_clean();
    echo "  ✓ migrate.php tamamlandı\n";
} catch (\Throwable $e) {
    echo "  ! migrate.php hata: " . $e->getMessage() . "\n";
}
echo "\n";

echo "─── 2) Ana seed (admin/settings/services/fairs) ──────────────\n";
runSqlFile($db . '/seed.sql');
echo "\n";

echo "─── 3) Services prod (image path'leri) ──────────────\n";
runSqlFile($db . '/seed-services-prod.sql');
echo "\n";

echo "─── 4) Hotels ──────────────\n";
runSqlFile($db . '/seed-hotels.sql');
runSqlFile($db . '/seed-hotels-extra.sql');
runSqlFile($db . '/seed-hotels-maestro.sql');
echo "\n";

echo "─── 5) Stand kataloğu ──────────────\n";
runSqlFile($db . '/seed-stand-catalog.sql');
echo "\n";

echo "─── 6) CMS / SEO içerik ──────────────\n";
runPhpSeed($db . '/seed-cms-seo.php');
echo "\n";

echo "─── 7) Service detail içerik ──────────────\n";
runPhpSeed($db . '/seed-services-content.php');
echo "\n";

echo "─── ÖZET ──────────────\n";
foreach (['services', 'fairs', 'hotels', 'catalog_items', 'cms_pages'] as $t) {
    try {
        $c = \App\Core\DB::query("SELECT COUNT(*) AS c FROM `$t`");
        echo "  $t: " . ($c[0]['c'] ?? '?') . " kayıt\n";
    } catch (\Throwable $e) {
        echo "  $t: tablo yok / hata\n";
    }
}

echo "\n✓ TAMAMLANDI. Bu dosyayı ($_SERVER[SCRIPT_NAME]) silin.\n";
