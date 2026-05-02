<?php
// Mevcut Expo Cyprus altyapısını kullan
$basePath = $basePath ?? dirname(__DIR__, 4);
if (!defined('BASE_PATH')) define('BASE_PATH', $basePath);
$navFile    = $basePath . '/views/partials/nav.php';
$footerFile = $basePath . '/views/partials/footer.php';
?><!DOCTYPE html>
<html lang="<?= htmlspecialchars($language ?? lang(), ENT_QUOTES, 'UTF-8') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (!headers_sent()) {
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
    } ?>

    <title><?= htmlspecialchars($title ?? $metaTitle ?? 'Expo Cyprus', ENT_QUOTES, 'UTF-8') ?></title>
    <?php if (!empty($metaDescription)): ?>
        <meta name="description" content="<?= htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8') ?>">
        <meta property="og:description" content="<?= htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>

    <link rel="icon" type="image/svg+xml" href="/assets/img/logo/unifex-mark-only.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/main.css?v=10">
    <link rel="stylesheet" href="/assets/css/blocks.css?v=1">
    <link rel="stylesheet" href="[theme-url]/css/theme.css">
</head>
<body class="page-pb">

<?php if (file_exists($navFile)) include $navFile; ?>

<main>
    <?= $body ?>
</main>

<?php if (file_exists($footerFile)) include $footerFile; ?>

<script src="/assets/js/main.js?v=2" defer></script>
</body>
</html>
