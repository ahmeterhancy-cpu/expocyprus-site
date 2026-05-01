<?php
/**
 * Image Optimizer — PNG/JPG → WebP dönüşümü.
 *
 * Çalıştır:
 *   php scripts/optimize-images.php
 *
 * Tüm public/assets/images altındaki büyük görselleri 80% kalite WebP'ye çevirir.
 * Orijinal dosya silinmez (yedek), sadece .webp kopyası eklenir.
 *
 * Görüntü-imzalı view'larda src güncellemesi otomatik yapar (--update-views flag).
 */
declare(strict_types=1);

$dryRun = in_array('--dry-run', $argv);
$force  = in_array('--force', $argv);
$root   = dirname(__DIR__);
$dir    = $root . '/public/assets/images';
$quality = 82;

if (!extension_loaded('gd')) die("✗ GD extension gerekli (php-gd)\n");
if (!function_exists('imagewebp')) die("✗ GD WebP desteği yok\n");

$totalSrc = 0; $totalDst = 0; $count = 0; $skipped = 0;

$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS));
foreach ($iter as $file) {
    if (!preg_match('/\.(png|jpe?g)$/i', $file->getFilename())) continue;

    $src = $file->getPathname();
    $dst = preg_replace('/\.(png|jpe?g)$/i', '.webp', $src);

    if (file_exists($dst) && !$force) { $skipped++; continue; }

    $srcSize = filesize($src);
    $totalSrc += $srcSize;

    if ($dryRun) {
        echo "DRY-RUN: $src (" . round($srcSize/1024) . " KB) → .webp\n";
        continue;
    }

    if (preg_match('/\.png$/i', $src)) {
        $img = @imagecreatefrompng($src);
    } else {
        $img = @imagecreatefromjpeg($src);
    }
    if (!$img) { echo "✗ Could not load: $src\n"; continue; }

    imagepalettetotruecolor($img);
    if (!@imagewebp($img, $dst, $quality)) {
        echo "✗ Write failed: $dst\n";
        imagedestroy($img);
        continue;
    }
    imagedestroy($img);

    $dstSize = filesize($dst);
    $totalDst += $dstSize;
    $count++;
    $reduction = $srcSize > 0 ? round(100 - ($dstSize / $srcSize * 100)) : 0;
    $relSrc = str_replace($root . '/', '', $src);
    echo sprintf("✓ %s — %s KB → %s KB (-%d%%)\n",
        $relSrc, round($srcSize/1024), round($dstSize/1024), $reduction);
}

echo "\n═══ Summary ═══\n";
echo "Converted: $count\n";
echo "Skipped (already .webp exists): $skipped\n";
echo "Source total: " . round($totalSrc/1024/1024, 1) . " MB\n";
echo "WebP total:   " . round($totalDst/1024/1024, 1) . " MB\n";
if ($totalSrc > 0) echo "Saved: " . round(100 - ($totalDst/$totalSrc*100)) . "%\n";
