<?php
/**
 * Tek seferlik katalog içerik tertipleme betiği.
 *   URL: https://expocyprus.com/fix-catalog.php?key=expo2026          (ÖNİZLEME — hiçbir şey yazmaz)
 *        https://expocyprus.com/fix-catalog.php?key=expo2026&apply=1  (UYGULA)
 *
 * Neyi düzeltir:
 *  1. Özellik satırlarının başındaki "• / - / *" işaretlerini temizler
 *     (kart zaten ✓ ekliyordu, "✓ • Masa" gibi çift işaret oluşuyordu).
 *  2. Açıklama alanına yapıştırılmış özellik listelerini ayıklar; TR listesini
 *     features_json'a, EN listesini features_en_json'a yazar.
 *  3. Sadece listenin tekrarı olan açıklamaları boşaltır (kartta aynı bilgi iki kez görünmesin).
 *  4. Ölçüleri tek biçime getirir: "3m x 3m" → "3m × 3m", "10 x 3m" → "10m × 3m".
 *  5. Tek modelli "back-2 … back-8" kategorilerini tek "Backdrop" kategorisinde birleştirir.
 *  6. Kategori sırasını sabitler: Bir Birim → İki Birim → Üç Birim → Ada Stand → Backdrop.
 *
 * İŞİ BİTİNCE BU DOSYAYI SİL.
 */
declare(strict_types=1);

if (($_GET['key'] ?? '') !== 'expo2026') { http_response_code(403); exit('forbidden'); }

$apply = ($_GET['apply'] ?? '') === '1';
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(180);

$basePath = dirname(__DIR__);
if (!file_exists($basePath . '/vendor/autoload.php')) {
    foreach ([dirname($basePath) . '/expocyprus.com', dirname($basePath) . '/expocyprus-site'] as $cand) {
        if (file_exists($cand . '/vendor/autoload.php')) { $basePath = $cand; break; }
    }
}
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
if (!defined('BASE_PATH')) define('BASE_PATH', $basePath);

use App\Core\DB;
use App\Models\CatalogItem;

DB::connect();
CatalogItem::ensureExtended();

// ─── Geri alma ────────────────────────────────────────────────
// Uygulamadan önce catalog_items + catalog_categories'in tam kopyası
// storage/backups altına yazılır. Bir şey ters giderse:
//   fix-catalog.php?key=expo2026&restore=1   → en son yedeği geri yükler
$backupDir = $basePath . '/storage/backups';

function snapshot(string $dir): string
{
    if (!is_dir($dir)) @mkdir($dir, 0775, true);
    $data = [
        'taken_at'            => date('c'),
        'catalog_items'       => DB::query("SELECT * FROM catalog_items"),
        'catalog_categories'  => DB::query("SELECT * FROM catalog_categories"),
    ];
    $file = $dir . '/catalog-' . date('Ymd-His') . '.json';
    file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    return $file;
}

function restoreLatest(string $dir): string
{
    $files = glob($dir . '/catalog-*.json') ?: [];
    if ($files === []) return 'Yedek bulunamadı — geri yüklenecek bir şey yok.';
    sort($files);
    $file = end($files);
    $data = json_decode((string) file_get_contents($file), true);
    if (!is_array($data) || !isset($data['catalog_items'])) return "Yedek okunamadı: $file";

    $n = 0;
    foreach ($data['catalog_items'] as $row) {
        $id = $row['id'] ?? null;
        if (!$id) continue;
        unset($row['id'], $row['created_at'], $row['updated_at']);
        $set    = implode(', ', array_map(static fn($k) => "`$k` = ?", array_keys($row)));
        $params = array_values($row);
        $params[] = $id;
        try { DB::execute("UPDATE catalog_items SET $set WHERE id = ?", $params); $n++; } catch (\Throwable $e) {}
    }

    // Silinen kategorileri geri koy + sort_order'ları eski haline getir
    $c = 0;
    foreach ($data['catalog_categories'] as $row) {
        unset($row['id'], $row['created_at'], $row['updated_at']);
        $cols  = implode(', ', array_map(static fn($k) => "`$k`", array_keys($row)));
        $marks = implode(', ', array_fill(0, count($row), '?'));
        $upd   = implode(', ', array_map(static fn($k) => "`$k` = VALUES(`$k`)", array_keys($row)));
        try {
            DB::execute("INSERT INTO catalog_categories ($cols) VALUES ($marks)
                         ON DUPLICATE KEY UPDATE $upd", array_values($row));
            $c++;
        } catch (\Throwable $e) {}
    }
    return "Geri yüklendi: $n ürün, $c kategori\nKaynak: $file";
}

if (($_GET['restore'] ?? '') === '1') {
    header('Content-Type: text/plain; charset=utf-8');
    echo "═══ Katalog Geri Yükleme ═══\n\n" . restoreLatest($backupDir) . "\n";
    exit;
}

echo "═══ Katalog Tertipleme ═══\n";
echo $apply
    ? "MOD: UYGULA (veritabanına yazılacak)\n\n"
    : "MOD: ÖNİZLEME (hiçbir şey yazılmaz — uygulamak için &apply=1 ekleyin)\n\n";

if ($apply) {
    $file = snapshot($backupDir);
    echo "Yedek alındı: $file\n";
    echo "Geri almak için: fix-catalog.php?key=expo2026&restore=1\n\n";
}

/** Satırın Türkçe mi İngilizce mi olduğunu tahmin eder. */
function guessLang(string $text): string
{
    $t = mb_strtolower($text, 'UTF-8');
    $tr = preg_match_all('/[ıŞşĞğÇçÖöÜüİ]/u', $text);
    $tr += preg_match_all('/(adet|zemin|döşeme|duvar|masa|sandalye|dolap|kapaklı|ışıklı|tabel|görsel|genişli|yüksekli|istenilen|tasarımda|baskılı|alın|kısmına|girilecek|germe|vinil|birim)/u', $t);
    $en = preg_match_all('/\b(floor|covering|tiling|desk|table|tables|chair|chairs|cabinet|door|wall|illuminated|sign|signs|height|thick|wide|images|graphics|desired|design|printed|front|panel|reception|information|unit|units|stretch|vinyl)\b/u', $t);
    if ($tr === $en) return 'unknown';
    return $tr > $en ? 'tr' : 'en';
}

/** Bir listenin bütününü oylamayla dile atar. */
function guessListLang(array $list): string
{
    $tr = 0; $en = 0;
    foreach ($list as $l) {
        $g = guessLang($l);
        if ($g === 'tr') { $tr++; } elseif ($g === 'en') { $en++; }
    }
    if ($tr === $en) return 'unknown';
    return $tr > $en ? 'tr' : 'en';
}

function decodeList(?string $json): array
{
    if ($json === null || trim($json) === '') return [];
    $a = json_decode($json, true);
    if (!is_array($a)) return [];
    $out = [];
    foreach ($a as $x) {
        if (is_array($x)) $x = implode(' ', $x);
        $x = catalog_clean_feature((string) $x);
        if ($x !== '') $out[] = $x;
    }
    return array_values(array_unique($out));
}

/** Bilinen, kesin yazım hataları. */
function fixTypos(array $list): array
{
    $typos = ['Vinil Gerne' => 'Vinil Germe'];
    return array_map(static fn($row) => strtr($row, $typos), $list);
}

// ─────────────────────────────────────────────────────────────
// 1) ÜRÜNLER
// ─────────────────────────────────────────────────────────────
$items    = DB::query("SELECT * FROM catalog_items ORDER BY model_no");
$changed  = 0;
$warnings = [];

foreach ($items as $it) {
    $no = $it['model_no'] ?: ('#' . $it['id']);

    $lists      = [];                                              // dil => liste
    $descIsList = ['description' => false, 'description_en' => false];

    // Mevcut özellik sütunları
    foreach (['features_json' => null, 'features_en_json' => 'en'] as $col => $forceLang) {
        $list = decodeList($it[$col] ?? null);
        if ($list === []) continue;
        $l = $forceLang ?? guessListLang($list);
        if ($l === 'unknown') $l = ($col === 'features_en_json') ? 'en' : 'tr';
        if (!isset($lists[$l])) $lists[$l] = $list;
    }

    // Açıklama alanlarına yapıştırılmış listeler
    foreach (['description', 'description_en'] as $col) {
        $raw = trim((string) ($it[$col] ?? ''));
        if ($raw === '') continue;
        $parts = catalog_split_features($raw);
        if (count($parts) < 2) continue;                           // gerçek tanıtım metni — dokunma
        $descIsList[$col] = true;
        $l = guessListLang($parts);
        if ($l === 'unknown') $l = ($col === 'description_en') ? 'en' : 'tr';
        if (!isset($lists[$l])) $lists[$l] = $parts;
    }

    $featTr = fixTypos($lists['tr'] ?? []);
    $featEn = fixTypos($lists['en'] ?? []);

    // Açıklamalar: liste tekrarıysa boşalt
    $newDesc   = $descIsList['description']    ? '' : trim((string) ($it['description'] ?? ''));
    $newDescEn = $descIsList['description_en'] ? '' : trim((string) ($it['description_en'] ?? ''));

    // Tek satırlık açıklama, özelliklerden birinin aynısıysa yine tekrar sayılır
    foreach ($featTr as $f) {
        if ($newDesc !== '' && catalog_fingerprint($f) === catalog_fingerprint($newDesc)) { $newDesc = ''; break; }
    }
    foreach ($featEn as $f) {
        if ($newDescEn !== '' && catalog_fingerprint($f) === catalog_fingerprint($newDescEn)) { $newDescEn = ''; break; }
    }

    $newDim = catalog_dimensions($it['dimensions'] ?? '');

    $updates = [];
    $curTr = json_encode(decodeList($it['features_json'] ?? null), JSON_UNESCAPED_UNICODE);
    $curEn = json_encode(decodeList($it['features_en_json'] ?? null), JSON_UNESCAPED_UNICODE);
    $ftr   = json_encode($featTr, JSON_UNESCAPED_UNICODE);
    $fen   = json_encode($featEn, JSON_UNESCAPED_UNICODE);

    if ($ftr !== $curTr)                                             $updates['features_json']    = $ftr;
    if ($fen !== $curEn)                                             $updates['features_en_json'] = $fen;
    if ($newDesc   !== trim((string) ($it['description'] ?? '')))    $updates['description']      = $newDesc;
    if ($newDescEn !== trim((string) ($it['description_en'] ?? ''))) $updates['description_en']   = $newDescEn;
    if ($newDim    !== trim((string) ($it['dimensions'] ?? '')))     $updates['dimensions']       = $newDim;

    if ($featTr === [] && $featEn === []) {
        $warnings[] = "$no — hiç özelliği yok, kart neredeyse boş görünecek";
    }
    if (preg_match('/(\d{2,})m/u', $newDim, $mm) && (int) $mm[1] > 20) {
        $warnings[] = "$no — ölçü şüpheli: \"$newDim\" (elle kontrol edin)";
    }

    if ($updates === []) { echo "· $no — değişiklik yok\n"; continue; }

    $changed++;
    echo "✎ $no\n";
    foreach ($updates as $k => $v) {
        $before = trim((string) ($it[$k] ?? ''));
        echo "    $k\n";
        echo "      önce : " . (mb_substr($before, 0, 140) ?: '(boş)') . "\n";
        echo "      sonra: " . (mb_substr((string) $v, 0, 140) ?: '(boş)') . "\n";
    }

    if ($apply) {
        $set    = implode(', ', array_map(static fn($k) => "`$k` = ?", array_keys($updates)));
        $params = array_values($updates);
        $params[] = $it['id'];
        DB::execute("UPDATE catalog_items SET $set WHERE id = ?", $params);
    }
}

// ─────────────────────────────────────────────────────────────
// 2) KATEGORİLER — tek modelli "back-N" kategorilerini birleştir
// ─────────────────────────────────────────────────────────────
echo "\n─── Kategoriler ───\n";
$cats     = DB::query("SELECT * FROM catalog_categories ORDER BY sort_order");
$backKeys = [];
foreach ($cats as $c) {
    if (preg_match('/^back(drop)?(-?\d+)?$/i', (string) $c['cat_key'])) $backKeys[] = $c['cat_key'];
}

$target = null;
if ($backKeys !== []) {
    $target = in_array('backdrop', $backKeys, true) ? 'backdrop' : $backKeys[0];
    $others = array_values(array_diff($backKeys, [$target]));

    if ($others !== []) {
        echo "Birleştirilecek: " . implode(', ', $others) . "  →  $target\n";
    } else {
        echo "Tek backdrop kategorisi var ($target) — birleştirmeye gerek yok.\n";
    }

    if ($apply) {
        $in = implode(',', array_fill(0, count($backKeys), '?'));
        DB::execute(
            "UPDATE catalog_items SET size_category = ?, category = ? WHERE size_category IN ($in)",
            array_merge([$target, $target], $backKeys)
        );
        // Backdrop en sona: asıl ürün stand kategorileri (10–40) önce gelsin.
        DB::execute(
            "UPDATE catalog_categories SET label_tr = 'Backdrop', label_en = 'Backdrop',
                    dimensions_tr = '', dimensions_en = '',
                    description_tr = 'Baskılı vinil germe backdrop modelleri — 3 metre yüksekliğinde, farklı genişliklerde',
                    description_en = 'Printed vinyl stretch backdrops — 3 m high, available in various widths',
                    sort_order = 90
             WHERE cat_key = ?",
            [$target]
        );
        if ($others !== []) {
            $inOthers = implode(',', array_fill(0, count($others), '?'));
            DB::execute("DELETE FROM catalog_categories WHERE cat_key IN ($inOthers)", $others);
        }
    }
} else {
    echo "Backdrop kategorisi yok.\n";
}

// Stand kategorilerinin sırası sabitlensin — Backdrop her zaman en sonda kalsın.
$standOrder = ['bir-birim' => 10, 'iki-birim' => 20, 'uc-birim' => 30, 'ada' => 40];
foreach ($standOrder as $key => $order) {
    $row = DB::first("SELECT cat_key, sort_order FROM catalog_categories WHERE cat_key = ?", [$key]);
    if (!$row || (int) $row['sort_order'] === $order) continue;
    echo "Sıra: $key  {$row['sort_order']} → $order\n";
    if ($apply) DB::execute("UPDATE catalog_categories SET sort_order = ? WHERE cat_key = ?", [$order, $key]);
}

// Modeli kalmayan kategoriler
$empty = DB::query(
    "SELECT c.cat_key, c.label_tr, COUNT(i.id) AS n
       FROM catalog_categories c
       LEFT JOIN catalog_items i ON i.size_category = c.cat_key AND i.status = 'active'
      GROUP BY c.cat_key, c.label_tr
     HAVING n = 0"
);
foreach ($empty as $e) {
    $warnings[] = "Kategori \"{$e['label_tr']}\" ({$e['cat_key']}) — içinde model yok, sayfada gizleniyor";
}

echo "\n═══ Özet ═══\n";
echo "Güncellenen ürün: $changed / " . count($items) . "\n";
if ($warnings !== []) {
    echo "\nDikkat edilecekler:\n";
    foreach (array_unique($warnings) as $w) echo "  ⚠ $w\n";
}
echo $apply
    ? "\n✓ Uygulandı. Bu dosyayı artık silebilirsiniz.\n"
    : "\nÖnizlemeydi — uygulamak için URL'ye &apply=1 ekleyin.\n";
