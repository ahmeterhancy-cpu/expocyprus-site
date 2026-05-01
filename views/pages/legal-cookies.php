<?php
$pageTitle       = lang() === 'en'
    ? 'Cookie Policy | Expo Cyprus'
    : 'Çerez Politikası | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? 'Explanation of the cookies used by the Expo Cyprus website and how to manage them.'
    : 'Expo Cyprus web sitesinin kullandığı çerezler ve nasıl yönetebileceğinize dair açıklama.';
$bodyClass = 'page-legal';
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'Cookie Policy' : 'Çerez Politikası' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'Cookie Policy' : 'Çerez Politikası' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? 'What cookies we use and how to control them.'
            : 'Hangi çerezleri kullandığımız ve nasıl kontrol edeceğiniz.' ?>
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="legal-content">
      <div class="legal-meta">
        <?= lang() === 'en' ? 'Last updated: 1 April 2026' : 'Son güncelleme: 1 Nisan 2026' ?>
      </div>

      <?php if (lang() === 'en'): ?>
        <h2>What is a Cookie?</h2>
        <p>A cookie is a small text file stored on your device when you visit a website. Cookies allow the site to recognise your device and remember preferences such as language.</p>

        <h2>Cookies We Use</h2>
        <table class="cookie-table">
          <thead>
            <tr><th>Type</th><th>Purpose</th><th>Examples</th></tr>
          </thead>
          <tbody>
            <tr><td>Essential</td><td>Session, language preference</td><td><code>PHPSESSID</code>, <code>lang</code></td></tr>
            <tr><td>Functional</td><td>User preferences</td><td><code>theme</code>, <code>cookie_consent</code></td></tr>
            <tr><td>Performance</td><td>Anonymous analytics</td><td><code>_ga</code>, <code>_gid</code></td></tr>
            <tr><td>Marketing</td><td>Audience measurement</td><td><code>_fbp</code></td></tr>
          </tbody>
        </table>

        <h2>Managing Cookies</h2>
        <p>You can accept, reject or delete cookies through your browser settings. Disabling essential cookies may degrade core functionality.</p>

        <h2>Updating Your Preferences</h2>
        <p>You can change your cookie consent at any time using the cookie banner displayed on the site.</p>

        <h2>More Information</h2>
        <p>See also our <a href="<?= url('gizlilik-politikasi') ?>">Privacy Policy</a>.</p>
      <?php else: ?>
        <h2>Çerez Nedir?</h2>
        <p>Çerez, bir web sitesini ziyaret ettiğinizde cihazınızda saklanan küçük bir metin dosyasıdır. Çerezler sitenin cihazınızı tanımasını ve dil gibi tercihlerinizi hatırlamasını sağlar.</p>

        <h2>Kullandığımız Çerezler</h2>
        <table class="cookie-table">
          <thead>
            <tr><th>Tür</th><th>Amaç</th><th>Örnek</th></tr>
          </thead>
          <tbody>
            <tr><td>Zorunlu</td><td>Oturum, dil tercihi</td><td><code>PHPSESSID</code>, <code>lang</code></td></tr>
            <tr><td>İşlevsel</td><td>Kullanıcı tercihleri</td><td><code>theme</code>, <code>cookie_consent</code></td></tr>
            <tr><td>Performans</td><td>Anonim analiz (Google Analytics)</td><td><code>_ga</code>, <code>_gid</code></td></tr>
            <tr><td>Pazarlama</td><td>Hedef kitle ölçümü (Facebook Pixel)</td><td><code>_fbp</code></td></tr>
          </tbody>
        </table>

        <h2>Çerezleri Yönetme</h2>
        <p>Çerezleri tarayıcı ayarlarınız üzerinden kabul edebilir, reddedebilir veya silebilirsiniz. Zorunlu çerezleri devre dışı bırakmak temel işlevleri olumsuz etkileyebilir.</p>

        <h2>Tercihlerinizi Güncelleme</h2>
        <p>Site üzerinde gösterilen çerez banner'ı aracılığıyla çerez onayınızı dilediğiniz zaman değiştirebilirsiniz.</p>

        <h2>Daha Fazla Bilgi</h2>
        <p>Bkz: <a href="<?= url('gizlilik-politikasi') ?>">Gizlilik Politikası</a>.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<style>
.page-hero { position: relative; min-height: 320px; display: flex; align-items: center; color: var(--white); padding: var(--space-4xl) 0 var(--space-3xl); }
.page-hero-content { max-width: 640px; }
.page-hero-title { font-size: var(--font-size-5xl); font-weight: 800; color: var(--white); margin: .5rem 0; }
.page-hero-subtitle { font-size: var(--font-size-lg); color: rgba(255,255,255,.9); margin-top: .75rem; }
.breadcrumb { display: flex; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.75); margin-bottom: .5rem; }
.breadcrumb a { color: rgba(255,255,255,.75); }
.breadcrumb a:hover { color: var(--white); }

.legal-content { max-width: 760px; margin: 0 auto; line-height: 1.8; color: var(--text); }
.legal-content h2 { font-size: 1.25rem; font-weight: 700; margin: 2rem 0 .75rem; color: var(--text); }
.legal-content p { margin: 0 0 1rem; }
.legal-content ul { margin: 0 0 1rem; padding-left: 1.5rem; }
.legal-content li { margin-bottom: .5rem; }
.legal-content a { color: var(--red); }
.legal-meta { font-size: .875rem; color: var(--text-muted); padding: 1rem 1.25rem; background: var(--bg-alt); border-left: 3px solid var(--red); border-radius: var(--radius-sm); margin-bottom: 2rem; }

.cookie-table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
.cookie-table th, .cookie-table td { padding: .75rem; border: 1px solid var(--border); text-align: left; font-size: .875rem; }
.cookie-table th { background: var(--bg-alt); font-weight: 600; }
.cookie-table code { font-size: .8rem; background: var(--gray-100); padding: .125rem .375rem; border-radius: 4px; }
@media (max-width: 768px) { .page-hero-title { font-size: var(--font-size-4xl); } }
</style>
