<?php
/**
 * View ve PHP dosyalarındaki .png/.jpg uzantılarını .webp ile değiştirir.
 * Sadece /assets/images/ altındaki referansları günceller (genel olmayan).
 */
declare(strict_types=1);

$root = dirname(__DIR__);
$dirs = ['views', 'src', 'public/assets/css', 'database', 'config'];

$updated = 0; $files = 0;

foreach ($dirs as $sub) {
    $iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root . '/' . $sub, RecursiveDirectoryIterator::SKIP_DOTS));
    foreach ($iter as $file) {
        if (!preg_match('/\.(php|css|sql|js)$/i', $file->getFilename())) continue;

        $content = file_get_contents($file->getPathname());
        $original = $content;

        // /assets/images/foo.png → /assets/images/foo.webp
        // Çalışan referansları sadece (png/jpg/jpeg uzantıları)
        $content = preg_replace_callback(
            '#(/assets/images/[a-zA-Z0-9_./-]+)\.(png|jpe?g)\b#i',
            fn($m) => $m[1] . '.webp',
            $content
        );

        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            $updated++;
            echo "✓ " . str_replace($root . '/', '', $file->getPathname()) . "\n";
        }
        $files++;
    }
}

echo "\n═══ Summary ═══\n";
echo "Files scanned:  $files\n";
echo "Files updated:  $updated\n";
