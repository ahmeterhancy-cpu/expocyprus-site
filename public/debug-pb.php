<?php
/**
 * Geçici PageBuilder debug — /admin/pagebuilder/edit sorununu lokalize et.
 * URL: https://expocyprus.com/debug-pb.php?key=expo2026
 */
declare(strict_types=1);
if (($_GET['key'] ?? '') !== 'expo2026') { http_response_code(403); exit('forbidden'); }
header('Content-Type: text/plain; charset=utf-8');

$basePath = dirname(__DIR__);
require_once $basePath . '/vendor/autoload.php';

// .env yükle
if (file_exists($basePath . '/.env')) {
    foreach (file($basePath . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
    }
}
if (!defined('BASE_PATH')) define('BASE_PATH', $basePath);

// Server'ı simüle et
$_SERVER['REQUEST_URI'] = '/admin/pagebuilder/edit?action=edit&page=1';
$_SERVER['SERVER_NAME'] = $_SERVER['SERVER_NAME'] ?? 'expocyprus.com';
$_SERVER['HTTPS'] = $_SERVER['HTTPS'] ?? 'on';
$_SERVER['SERVER_PORT'] = $_SERVER['SERVER_PORT'] ?? '443';
$_GET['action'] = 'edit';
$_GET['page'] = '1';

echo "═══ PB Debug ═══\n\n";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SERVER_NAME: " . $_SERVER['SERVER_NAME'] . "\n";
echo "HTTPS:       " . ($_SERVER['HTTPS'] ?? 'off') . "\n\n";

echo "─── isPageBuilderUrl ───\n";
$isPb = \App\Pagebuilder\PageBuilderApp::isPageBuilderUrl('/admin/pagebuilder/edit');
echo "  /admin/pagebuilder/edit → " . ($isPb ? 'TRUE' : 'FALSE') . "\n\n";

echo "─── PageBuilderApp::instance() ───\n";
try {
    $pb = \App\Pagebuilder\PageBuilderApp::instance();
    echo "  ✓ PHPageBuilder örneği oluşturuldu\n";
    echo "  base_url config: " . phpb_config('general.base_url') . "\n";
    echo "  pagebuilder.url config: " . phpb_config('pagebuilder.url') . "\n";
    echo "  page.table config: " . phpb_config('page.table') . " (PB prefix uygulayınca: pb_pages)\n";
    echo "  storage.database.prefix: '" . phpb_config('storage.database.prefix') . "'\n";
} catch (\Throwable $e) {
    echo "  ✗ EXCEPTION: " . $e->getMessage() . "\n";
    echo "  Trace: " . $e->getFile() . ':' . $e->getLine() . "\n";
    exit;
}
echo "\n";

echo "─── URL helpers ───\n";
echo "  phpb_current_full_url():     " . (phpb_current_full_url() ?? '(null)') . "\n";
echo "  phpb_current_relative_url(): " . phpb_current_relative_url() . "\n";
echo "  phpb_url('pagebuilder',[],false): " . phpb_url('pagebuilder', [], false) . "\n";
echo "  phpb_in_module('pagebuilder'): " . (phpb_in_module('pagebuilder') ? 'TRUE' : 'FALSE') . "\n";
echo "\n";

echo "─── Page lookup ───\n";
try {
    $repo = new \PHPageBuilder\Repositories\PageRepository();
    $page = $repo->findWithId(1);
    if ($page) {
        echo "  ✓ Page id=1 bulundu: " . $page->getName() . "\n";
        echo "  Layout: " . $page->getLayout() . "\n";
    } else {
        echo "  ✗ Page id=1 bulunamadı (DB query OK ama kayıt yok)\n";
    }
} catch (\Throwable $e) {
    echo "  ✗ EXCEPTION: " . $e->getMessage() . "\n";
}
echo "\n";

echo "─── Auth check ───\n";
@session_start();
$auth = new \App\Pagebuilder\AdminAuthBridge();
echo "  Session admin_id: " . ($_SESSION['admin_id'] ?? '(yok)') . "\n";
echo "  isAuthenticated(): " . ($auth->isAuthenticated() ? 'TRUE' : 'FALSE') . "\n";
