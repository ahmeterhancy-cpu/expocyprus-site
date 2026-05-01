<?php
/**
 * Migration runner — Tüm tabloları oluşturur ve seedler.
 * cPanel cron veya manuel olarak çalıştırılabilir:
 *
 *   /usr/local/bin/php /home/user/expocyprus.com/database/migrate.php
 *
 * Tüm Model::ensureTable() metodlarını çağırarak şemayı güncel tutar.
 */
declare(strict_types=1);

$basePath = dirname(__DIR__);
require_once $basePath . '/vendor/autoload.php';

$envFile = $basePath . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
    }
}
define('BASE_PATH', $basePath);

echo "═══ Expo Cyprus — Database Migration ═══\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

try {
    \App\Core\DB::connect();
    echo "✓ DB connected\n";
} catch (\Throwable $e) {
    die("✗ DB connection failed: " . $e->getMessage() . "\n");
}

// 1. Run base schema if needed
$schemaFile = __DIR__ . '/schema.sql';
if (file_exists($schemaFile)) {
    $sql = file_get_contents($schemaFile);
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($statements as $stmt) {
        if ($stmt === '') continue;
        try {
            \App\Core\DB::execute($stmt);
        } catch (\Throwable $e) {
            // Ignore "already exists" errors
            if (!str_contains($e->getMessage(), 'already exists')) {
                echo "  ! Schema warning: " . substr($e->getMessage(), 0, 100) . "\n";
            }
        }
    }
    echo "✓ Base schema applied\n";
}

// 2. Auto-create tables for models that have ensureTable methods
$models = [
    'CmsPage'           => 'CMS pages + settings',
    'CatalogCategory'   => 'Catalog categories',
    'Lead'              => 'Leads + activities + files',
    'CrewApplication'   => 'Crew applications',
    'Member'            => 'Member accounts',
    'ProductionOrder'   => 'Production orders + stages + files + items + messages',
];

foreach ($models as $class => $desc) {
    $fqcn = "App\\Models\\$class";
    if (!class_exists($fqcn)) continue;
    try {
        if (method_exists($fqcn, 'ensureTable'))    $fqcn::ensureTable();
        if (method_exists($fqcn, 'ensureTables'))   $fqcn::ensureTables();
        if (method_exists($fqcn, 'ensureExtended')) $fqcn::ensureExtended();
        echo "✓ $class — $desc\n";
    } catch (\Throwable $e) {
        echo "✗ $class failed: " . $e->getMessage() . "\n";
    }
}

// 3. Service ensureExtended (Apple-style columns)
foreach (['Service', 'Fair'] as $extra) {
    $fqcn = "App\\Models\\$extra";
    if (class_exists($fqcn) && method_exists($fqcn, 'ensureExtended')) {
        try { $fqcn::ensureExtended(); echo "✓ $extra extended\n"; } catch (\Throwable $e) {}
    }
}

echo "\n✓ Migration complete\n";
