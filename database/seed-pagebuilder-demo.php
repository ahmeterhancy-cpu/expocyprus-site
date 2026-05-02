<?php
/**
 * PHPagebuilder demo sayfa seed.
 * Çalıştırma: php database/seed-pagebuilder-demo.php
 *
 * Hakkımızda sayfasının PageBuilder versiyonu — kullanıcı /pb-test ile görür.
 * UPSERT: route'a göre var olan sayfayı günceller.
 */
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
    }
}
if (!defined('BASE_PATH')) define('BASE_PATH', dirname(__DIR__));

use App\Core\DB;
DB::connect();

// PHPagebuilder data formatı: html'de [block slug="..."] shortcode'ları
$html = <<<HTML
[block slug="ab-hero"]
[block slug="ab-stats"]
[block slug="ab-features-3"]
[block slug="ab-cta"]
HTML;

$data = json_encode([
    'html' => $html,
    'css'  => '',
    'blocks' => [],
], JSON_UNESCAPED_UNICODE);

// Var mı kontrol — slug yerine name='pb-demo' ile bul
$existing = DB::first("SELECT id FROM pb_pages WHERE name = ?", ['PageBuilder Demo']);

if ($existing) {
    $pageId = (int)$existing['id'];
    DB::update('pb_pages', ['data' => $data, 'layout' => 'master'], ['id' => $pageId]);
    echo "↻ Mevcut demo güncellendi (id=$pageId)\n";
} else {
    $pageId = (int)DB::insert('pb_pages', [
        'name'   => 'PageBuilder Demo',
        'layout' => 'master',
        'data'   => $data,
    ]);
    echo "✓ Yeni demo oluşturuldu (id=$pageId)\n";
}

// TR translation
$trExists = DB::first("SELECT id FROM pb_page_translations WHERE page_id = ? AND locale = ?", [$pageId, 'tr']);
$trData = [
    'title' => 'PageBuilder Demo',
    'meta_title' => 'PageBuilder Demo | Expo Cyprus',
    'meta_description' => 'PHPagebuilder ile oluşturulmuş demo sayfa.',
    'route' => '/pb-demo',
];
if ($trExists) {
    DB::update('pb_page_translations', $trData, ['id' => $trExists['id']]);
} else {
    DB::insert('pb_page_translations', array_merge($trData, ['page_id' => $pageId, 'locale' => 'tr']));
}

// EN translation
$enExists = DB::first("SELECT id FROM pb_page_translations WHERE page_id = ? AND locale = ?", [$pageId, 'en']);
$enData = [
    'title' => 'PageBuilder Demo',
    'meta_title' => 'PageBuilder Demo | Expo Cyprus',
    'meta_description' => 'A demo page built with PHPagebuilder.',
    'route' => '/en/pb-demo',
];
if ($enExists) {
    DB::update('pb_page_translations', $enData, ['id' => $enExists['id']]);
} else {
    DB::insert('pb_page_translations', array_merge($enData, ['page_id' => $pageId, 'locale' => 'en']));
}

echo "✓ Translations: /pb-demo (TR), /en/pb-demo (EN)\n";
echo "\n► Local: http://expocyprus-site.test/pb-demo\n";
echo "► Production: https://expocyprus.com/pb-demo\n";
echo "► Admin builder: /admin/pagebuilder/edit?action=edit&page=$pageId\n";
