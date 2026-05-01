<?php
declare(strict_types=1);
if (($_GET['key'] ?? '') !== 'expo2026') { http_response_code(403); exit('forbidden'); }
header('Content-Type: text/plain; charset=utf-8');

echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? '?') . "\n";
echo "__DIR__:       " . __DIR__ . "\n";
echo "__FILE__:      " . __FILE__ . "\n\n";

$dirs = [
    __DIR__ . '/uploads',
    __DIR__ . '/uploads/images',
    __DIR__ . '/uploads/cms',
    dirname(__DIR__) . '/uploads',
    dirname(__DIR__) . '/uploads/images',
    dirname(__DIR__) . '/public/uploads/images',
    ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/uploads/images',
    ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/public/uploads/images',
];

foreach ($dirs as $d) {
    $exists = is_dir($d);
    echo str_pad($d, 70) . " " . ($exists ? "EXISTS" : "NO") . "\n";
    if ($exists) {
        $files = @scandir($d) ?: [];
        $files = array_diff($files, ['.', '..']);
        foreach (array_slice($files, 0, 10) as $f) {
            $full = $d . '/' . $f;
            $sz = is_file($full) ? filesize($full) : 'dir';
            echo "  - $f ($sz)\n";
        }
        if (count($files) > 10) echo "  ... +" . (count($files) - 10) . " more\n";
    }
}

echo "\n--- target file search ---\n";
$target = '69f4c9cce060f_1777650124.png';
foreach ($dirs as $d) {
    if (is_dir($d) && file_exists($d . '/' . $target)) {
        echo "FOUND: $d/$target (size: " . filesize($d . '/' . $target) . ")\n";
    }
}
