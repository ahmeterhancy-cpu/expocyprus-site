<?php
/**
 * GitHub Webhook → cPanel auto-deploy
 *
 * GitHub Settings → Webhooks → Add webhook:
 *   URL:          https://expocyprus.com/deploy-webhook.php
 *   Content type: application/json
 *   Secret:       (DEPLOY_WEBHOOK_SECRET in .env)
 *   Events:       Just push event
 *
 * Bu script:
 * 1. GitHub HMAC signature'ı doğrular
 * 2. git pull yapar
 * 3. composer install çalıştırır
 * 4. database/migrate.php ile tabloları günceller
 * 5. Logları storage/logs/deploy.log'a yazar
 */
declare(strict_types=1);

// Sadece POST kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

// Find base path (same logic as index.php)
$basePath = dirname(__DIR__);
if (!file_exists($basePath . '/vendor/autoload.php')) {
    $homeDir = $basePath; // public_html'in parent'ı = /home/USER
    foreach ([$homeDir . '/expocyprus.com', $homeDir . '/expocyprus-site', dirname($basePath) . '/expocyprus.com'] as $cand) {
        if (file_exists($cand . '/vendor/autoload.php')) { $basePath = $cand; break; }
    }
}

// Load .env
$envFile = $basePath . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
    }
}

$secret = getenv('DEPLOY_WEBHOOK_SECRET');
$branch = getenv('DEPLOY_BRANCH') ?: 'main';
$logFile = $basePath . '/storage/logs/deploy.log';
@mkdir(dirname($logFile), 0775, true);

function log_line(string $msg, string $logFile): void {
    @file_put_contents($logFile, '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n", FILE_APPEND);
}

if (!$secret || $secret === '__GENERATE_A_RANDOM_SECRET__') {
    http_response_code(500);
    log_line('ERROR: DEPLOY_WEBHOOK_SECRET not set in .env', $logFile);
    exit('Webhook secret not configured');
}

// Verify HMAC signature (GitHub sends X-Hub-Signature-256)
$payload   = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

if (empty($signature)) {
    http_response_code(401);
    log_line('ERROR: Missing signature header from ' . ($_SERVER['REMOTE_ADDR'] ?? '?'), $logFile);
    exit('Missing signature');
}

$expectedSig = 'sha256=' . hash_hmac('sha256', $payload, $secret);
if (!hash_equals($expectedSig, $signature)) {
    http_response_code(401);
    log_line('ERROR: Invalid signature from ' . ($_SERVER['REMOTE_ADDR'] ?? '?'), $logFile);
    exit('Invalid signature');
}

// Decode payload
$data = json_decode($payload, true);
$ref  = $data['ref'] ?? '';
$expectedRef = 'refs/heads/' . $branch;

if ($ref !== $expectedRef) {
    http_response_code(200);
    log_line("INFO: Skipped — ref={$ref} not {$expectedRef}", $logFile);
    exit('Skipped (different branch)');
}

// Run deployment
log_line("=== Deploy started — commit: " . ($data['after'] ?? '?') . " ===", $logFile);

$commands = [
    "cd " . escapeshellarg($basePath) . " && git fetch --all 2>&1",
    "cd " . escapeshellarg($basePath) . " && git reset --hard origin/" . escapeshellarg($branch) . " 2>&1",
    "cd " . escapeshellarg($basePath) . " && /usr/local/bin/composer install --no-dev --optimize-autoloader 2>&1",
    "/usr/local/bin/php " . escapeshellarg($basePath . '/database/migrate.php') . " 2>&1",
];

$success = true;
foreach ($commands as $cmd) {
    log_line("$ " . preg_replace('/^cd [^&]+ && /', '', $cmd), $logFile);
    $output = [];
    $exitCode = 0;
    @exec($cmd, $output, $exitCode);
    foreach ($output as $line) log_line('  ' . $line, $logFile);
    if ($exitCode !== 0) {
        $success = false;
        log_line("ERROR: exit code $exitCode", $logFile);
        break;
    }
}

log_line("=== Deploy " . ($success ? 'SUCCESS' : 'FAILED') . " ===\n", $logFile);

http_response_code($success ? 200 : 500);
echo $success ? "Deploy OK\n" : "Deploy FAILED — check storage/logs/deploy.log\n";
