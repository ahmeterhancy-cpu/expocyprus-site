<?php
// HTML her zaman taze gelsin (CMS değişiklikleri anında yansısın).
// Asset'ler (CSS/JS/img) ayrı cache header'larıyla yönetiliyor — etkilenmez.
if (!headers_sent()) {
    header('Cache-Control: no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
}
?><!DOCTYPE html>
<html lang="<?= lang() ?>" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#1d1d1f" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <?php
    // Build SEO via central helper (overridable from views)
    $seo = \App\Core\Seo::for(
        $pageTitle ?? 'Expo Cyprus | Kıbrıs Fuar & Kongre Organizasyonu',
        $metaDescription ?? 'Kıbrıs\'ta 22 yıllık deneyim. Fuar organizasyonu, kongre, stand tasarımı ve PR hizmetleri tek noktadan. Lefkoşa merkezli, 100\'ü aşkın stand kurulumu.',
        [
            'canonical'  => $canonical  ?? null,
            'image'      => $ogImage    ?? null,
            'type'       => $ogType     ?? 'website',
            'breadcrumb' => $breadcrumb ?? [],
            'structured' => $structured ?? [],
            'keywords'   => $keywords   ?? [],
            'noindex'    => $noindex    ?? false,
        ]
    );
    echo $seo->meta();
    ?>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= asset('img/logo/unifex-mark-only.svg') ?>">
    <link rel="apple-touch-icon" href="<?= asset('img/logo/unifex-mark-only.svg') ?>">

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>?v=10">
    <link rel="stylesheet" href="<?= asset('css/blocks.css') ?>?v=1">

    <!-- JSON-LD Structured Data -->
    <?= $seo->jsonLd() ?>

    <!-- Custom Favicon (CMS) -->
    <?php $cmsFavicon = setting('site_favicon'); if ($cmsFavicon): ?>
    <link rel="icon" type="image/png" href="<?= e($cmsFavicon) ?>">
    <?php endif; ?>

    <!-- Search Console Verifications -->
    <?php $gscVerify = setting('seo_google_verification'); if ($gscVerify): ?>
    <meta name="google-site-verification" content="<?= e($gscVerify) ?>">
    <?php endif; ?>
    <?php $bingVerify = setting('seo_bing_verification'); if ($bingVerify): ?>
    <meta name="msvalidate.01" content="<?= e($bingVerify) ?>">
    <?php endif; ?>

    <!-- Google Tag Manager -->
    <?php $gtmId = setting('seo_gtm_id'); if ($gtmId): ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?= e($gtmId) ?>');</script>
    <?php endif; ?>

    <!-- Google Analytics 4 -->
    <?php $gaId = setting('seo_ga_id'); if ($gaId && !$gtmId): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($gaId) ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?= e($gaId) ?>');
    </script>
    <?php endif; ?>

    <!-- Facebook Pixel -->
    <?php $fbPixel = setting('seo_facebook_pixel'); if ($fbPixel): ?>
    <script>
      !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '<?= e($fbPixel) ?>');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?= e($fbPixel) ?>&ev=PageView&noscript=1"></noscript>
    <?php endif; ?>
</head>
<body class="<?= e($bodyClass ?? '') ?>">

    <!-- GTM noscript -->
    <?php $gtmId = setting('seo_gtm_id'); if ($gtmId): ?>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= e($gtmId) ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php endif; ?>

    <!-- Cookie Banner -->
    <?php \App\Core\View::partial('cookie-banner'); ?>

    <!-- Header / Navigation -->
    <?php \App\Core\View::partial('nav'); ?>

    <!-- Page Content -->
    <main id="main-content">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <?php \App\Core\View::partial('footer'); ?>

    <!-- Main JS -->
    <script src="<?= asset('js/main.js') ?>?v=1" defer></script>

    <?php if ($extraScripts ?? false): ?>
        <?= $extraScripts ?>
    <?php endif; ?>
</body>
</html>
