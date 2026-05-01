<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Üye Paneli | Expo Cyprus') ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= asset('img/logo/unifex-mark-only.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>?v=9">
</head>
<body class="member-portal">

<header class="mp-header">
    <div class="container">
        <div class="mp-header-inner">
            <a href="/uye/panel" class="mp-logo">
                <img src="<?= asset('img/logo/unifex-logo.png') ?>" alt="Expo Cyprus" width="140" height="36">
            </a>
            <nav class="mp-nav">
                <a href="/uye/panel" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/uye/panel') ? 'active' : '' ?>">Panelim</a>
                <a href="/uye/siparisler" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/uye/siparis') ? 'active' : '' ?>">Siparişlerim</a>
                <a href="/uye/profil" class="<?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/uye/profil') ? 'active' : '' ?>">Profilim</a>
            </nav>
            <div class="mp-actions">
                <span class="mp-user">
                    <strong><?= e($_SESSION['member_company'] ?? '') ?></strong>
                    <small><?= e($_SESSION['member_contact'] ?? '') ?></small>
                </span>
                <a href="/uye/cikis" class="mp-logout" title="Çıkış">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</header>

<?php
$flashSuccess = \App\Core\Session::getFlash('success') ?? \App\Core\Session::getFlash('member_dashboard_success');
$flashError   = \App\Core\Session::getFlash('error');
?>
<?php if ($flashSuccess): ?>
<div class="container"><div class="mp-flash mp-flash-ok">✓ <?= e($flashSuccess) ?></div></div>
<?php endif; ?>
<?php if ($flashError): ?>
<div class="container"><div class="mp-flash mp-flash-err">! <?= e($flashError) ?></div></div>
<?php endif; ?>

<main class="mp-main">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<footer class="mp-footer">
    <div class="container">
        <p>© <?= date('Y') ?> Expo Cyprus — UNIFEX Fuarcılık. Tüm hakları saklıdır.</p>
        <p><a href="/">Anasayfa</a> · <a href="/iletisim">İletişim</a> · <a href="/kvkk">KVKK</a></p>
    </div>
</footer>

<style>
.member-portal { background: #f5f5f7; min-height: 100vh; display: flex; flex-direction: column; }
.member-portal .mp-header {
    background: #1d1d1f; color: #fff;
    border-bottom: 1px solid rgba(255,255,255,.1);
    padding: 1rem 0;
    position: sticky; top: 0; z-index: 100;
}
.mp-header-inner { display: flex; align-items: center; justify-content: space-between; gap: 2rem; }
.mp-logo { display: inline-flex; }
.mp-logo img { filter: brightness(0) invert(1); }
.mp-nav { display: flex; gap: 1.5rem; flex: 1; justify-content: center; }
.mp-nav a {
    color: rgba(255,255,255,.7); text-decoration: none;
    font-size: .9375rem; font-weight: 500;
    padding: .5rem .75rem; border-radius: 8px;
    transition: all .2s;
}
.mp-nav a:hover { color: #fff; background: rgba(255,255,255,.08); }
.mp-nav a.active { color: #fff; background: rgba(227,6,19,.2); }
.mp-actions { display: flex; align-items: center; gap: 1rem; }
.mp-user { display: flex; flex-direction: column; line-height: 1.2; text-align: right; font-size: .8125rem; }
.mp-user strong { color: #fff; font-weight: 600; }
.mp-user small { color: rgba(255,255,255,.6); font-size: .75rem; }
.mp-logout {
    color: rgba(255,255,255,.7); padding: .5rem;
    border-radius: 8px; background: rgba(255,255,255,.08);
    transition: all .2s;
}
.mp-logout:hover { color: #fff; background: rgba(227,6,19,.5); }
.mp-flash {
    margin-top: 1.25rem; padding: 1rem 1.25rem;
    border-radius: 12px; font-size: .9375rem;
}
.mp-flash-ok  { background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }
.mp-flash-err { background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; }
.mp-main { flex: 1; padding: 2rem 0 4rem; }
.mp-footer {
    background: #1d1d1f; color: rgba(255,255,255,.6);
    padding: 1.5rem 0; font-size: .8125rem;
    text-align: center;
}
.mp-footer a { color: rgba(255,255,255,.7); }
.mp-footer p { margin: .25rem 0; }

@media (max-width: 768px) {
    .mp-header-inner { flex-direction: column; gap: 1rem; }
    .mp-nav { width: 100%; justify-content: center; flex-wrap: wrap; }
    .mp-user { display: none; }
}
</style>
</body>
</html>
