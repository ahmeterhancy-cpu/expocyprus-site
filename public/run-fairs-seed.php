<?php
/**
 * Geçici runner — fuar içeriklerini DB'ye basar.
 * Kullanım: https://expocyprus.com/run-fairs-seed.php?key=expo2026
 * BİTTİĞİNDE BU DOSYAYI SİL.
 */
declare(strict_types=1);
if (($_GET['key'] ?? '') !== 'expo2026') { http_response_code(403); exit('forbidden'); }
header('Content-Type: text/plain; charset=utf-8');
set_time_limit(60);

$basePath = dirname(__DIR__);
if (!file_exists($basePath . '/vendor/autoload.php')) {
    foreach ([dirname($basePath) . '/expocyprus.com', dirname($basePath) . '/expocyprus-site'] as $cand) {
        if (file_exists($cand . '/vendor/autoload.php')) { $basePath = $cand; break; }
    }
}

if (!defined('BASE_PATH')) define('BASE_PATH', $basePath);

ob_start();
require $basePath . '/database/seed-fairs-content.php';
echo ob_get_clean();
echo "\n✓ TAMAMLANDI. Bu dosyayı silin.\n";
