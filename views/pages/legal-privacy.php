<?php
$pageTitle       = lang() === 'en'
    ? 'Privacy Policy | Expo Cyprus'
    : 'Gizlilik Politikası | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? 'Privacy practices for the Expo Cyprus website — what we collect, how we use it, and your rights.'
    : 'Expo Cyprus web sitesinin gizlilik uygulamaları — neyi topluyoruz, nasıl kullanıyoruz ve haklarınız.';
$bodyClass = 'page-legal';
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'Privacy Policy' : 'Gizlilik Politikası' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'Privacy Policy' : 'Gizlilik Politikası' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? 'Plain-language summary of how we handle your information.'
            : 'Bilgilerinizi nasıl yönettiğimizin sade dilde özeti.' ?>
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
        <h2>Data Controller</h2>
        <p>Unifex Fuarcılık Organizasyon Ltd. (Expo Cyprus), based in Nicosia, Northern Cyprus, is responsible for processing your personal data.</p>

        <h2>Data We Collect</h2>
        <ul>
          <li><strong>Form data:</strong> name, email, phone, message you submit through contact and quote forms.</li>
          <li><strong>Cookies:</strong> session cookies, language preference, analytics identifiers.</li>
          <li><strong>Analytics:</strong> aggregate page-view data via Google Analytics.</li>
        </ul>

        <h2>How We Use Data</h2>
        <ul>
          <li>To respond to your enquiries and deliver requested services.</li>
          <li>To improve site performance and content.</li>
          <li>To meet legal/accounting obligations.</li>
        </ul>

        <h2>Sharing With Third Parties</h2>
        <p>We share limited data with: Google Analytics (anonymised analytics), email service providers (transactional email delivery), and authorities where legally required. We never sell personal data.</p>

        <h2>Cookies</h2>
        <p>For details, see our <a href="<?= url('cerez-politikasi') ?>">Cookie Policy</a>.</p>

        <h2>Your Rights</h2>
        <p>Access, rectify, delete, restrict processing, data portability, and object to processing. Submit requests to <a href="mailto:privacy@expocyprus.com">privacy@expocyprus.com</a>.</p>

        <h2>Contact</h2>
        <p>Questions about this policy? Email <a href="mailto:privacy@expocyprus.com">privacy@expocyprus.com</a>.</p>

        <h2>Effective Date</h2>
        <p>This policy is effective as of 1 April 2026.</p>
      <?php else: ?>
        <h2>Veri Sorumlusu</h2>
        <p>Lefkoşa, KKTC merkezli Unifex Fuarcılık Organizasyon Ltd. (Expo Cyprus), kişisel verilerinizin işlenmesinden sorumludur.</p>

        <h2>Topladığımız Veriler</h2>
        <ul>
          <li><strong>Form verileri:</strong> iletişim ve teklif formları aracılığıyla ilettiğiniz ad, e-posta, telefon, mesaj.</li>
          <li><strong>Çerezler:</strong> oturum çerezleri, dil tercihi, analiz tanımlayıcıları.</li>
          <li><strong>Analytics:</strong> Google Analytics ile toplu sayfa görüntüleme verileri.</li>
        </ul>

        <h2>Verilerin Kullanımı</h2>
        <ul>
          <li>Talep ve sorularınıza yanıt vermek, talep ettiğiniz hizmetleri sunmak.</li>
          <li>Site performansını ve içeriği iyileştirmek.</li>
          <li>Yasal ve muhasebe yükümlülüklerini yerine getirmek.</li>
        </ul>

        <h2>Üçüncü Taraflarla Paylaşım</h2>
        <p>Sınırlı verileri Google Analytics (anonimleştirilmiş istatistik), e-posta servis sağlayıcıları (işlemsel e-posta) ve yasal zorunluluk halinde yetkili makamlarla paylaşırız. Kişisel veriyi asla satmıyoruz.</p>

        <h2>Çerezler</h2>
        <p>Detaylar için bkz: <a href="<?= url('cerez-politikasi') ?>">Çerez Politikası</a>.</p>

        <h2>Haklarınız</h2>
        <p>Erişim, düzeltme, silme, işlemeyi kısıtlama, veri taşınabilirliği ve işlemeye itiraz hakkına sahipsiniz. Başvurularınızı <a href="mailto:privacy@expocyprus.com">privacy@expocyprus.com</a> adresine iletebilirsiniz.</p>

        <h2>İletişim</h2>
        <p>Bu politikaya ilişkin sorular için: <a href="mailto:privacy@expocyprus.com">privacy@expocyprus.com</a>.</p>

        <h2>Yürürlük</h2>
        <p>Bu politika 1 Nisan 2026 tarihinden itibaren yürürlüktedir.</p>
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
@media (max-width: 768px) { .page-hero-title { font-size: var(--font-size-4xl); } }
</style>
