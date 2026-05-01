<?php
$pageTitle       = lang() === 'en'
    ? 'Terms of Use | Expo Cyprus'
    : 'Kullanım Koşulları | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? 'Terms of use governing access to and use of the Expo Cyprus website.'
    : 'Expo Cyprus web sitesine erişimi ve kullanımını düzenleyen kullanım koşulları.';
$bodyClass = 'page-legal';
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'Terms of Use' : 'Kullanım Koşulları' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'Terms of Use' : 'Kullanım Koşulları' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? 'The rules that govern your use of this site.'
            : 'Bu siteyi kullanımınızı düzenleyen kurallar.' ?>
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
        <h2>Use of the Site</h2>
        <p>By accessing this website, you agree to comply with these terms and all applicable laws. The site is provided for informational purposes regarding Expo Cyprus services.</p>

        <h2>Intellectual Property</h2>
        <p>All content on this site — text, images, logos, design — is the property of Unifex Fuarcılık Organizasyon Ltd. and may not be copied, reproduced or distributed without prior written permission.</p>

        <h2>Disclaimer of Liability</h2>
        <p>Information is provided "as is" without warranty. We are not liable for any direct or indirect damages arising from use of the site.</p>

        <h2>Third-Party Links</h2>
        <p>The site may include links to third-party websites. We are not responsible for the content, privacy practices or accuracy of those sites.</p>

        <h2>Service Agreement</h2>
        <p>Information shown on the site does not constitute a binding offer. Specific commercial terms are determined under a separate written service contract.</p>

        <h2>Governing Law</h2>
        <p>These terms are governed by the laws of the Turkish Republic of Northern Cyprus (KKTC).</p>

        <h2>Jurisdiction</h2>
        <p>The Courts of Nicosia (Lefkoşa Mahkemeleri) shall have exclusive jurisdiction in any dispute arising from these terms.</p>

        <h2>Changes</h2>
        <p>We reserve the right to update these terms at any time. The effective date above shows the most recent revision.</p>

        <h2>Contact</h2>
        <p>Questions regarding these terms: <a href="mailto:info@expocyprus.com">info@expocyprus.com</a></p>
      <?php else: ?>
        <h2>Site Kullanımı</h2>
        <p>Bu siteye erişerek işbu koşullara ve yürürlükteki tüm mevzuata uymayı kabul edersiniz. Site, Expo Cyprus hizmetleri hakkında bilgilendirme amaçlıdır.</p>

        <h2>Fikri Mülkiyet</h2>
        <p>Bu sitedeki tüm içerik — metin, görsel, logo, tasarım — Unifex Fuarcılık Organizasyon Ltd.'nin mülkiyetindedir; yazılı izin olmaksızın kopyalanamaz, çoğaltılamaz veya dağıtılamaz.</p>

        <h2>Sorumluluk Reddi</h2>
        <p>Bilgiler "olduğu gibi" sağlanır; herhangi bir garanti verilmez. Sitenin kullanımından doğacak doğrudan veya dolaylı zararlardan sorumlu değiliz.</p>

        <h2>Üçüncü Taraf Bağlantılar</h2>
        <p>Site, üçüncü taraf web sitelerine bağlantılar içerebilir. Bu sitelerin içeriğinden, gizlilik uygulamalarından veya doğruluğundan sorumlu değiliz.</p>

        <h2>Hizmet Sözleşmesi</h2>
        <p>Sitede yer alan bilgiler bağlayıcı bir teklif niteliği taşımaz. Ticari koşullar ayrı bir yazılı hizmet sözleşmesi ile belirlenir.</p>

        <h2>Uygulanacak Hukuk</h2>
        <p>İşbu koşullar Kuzey Kıbrıs Türk Cumhuriyeti (KKTC) hukukuna tabidir.</p>

        <h2>Yetkili Mahkeme</h2>
        <p>Bu koşullardan doğacak uyuşmazlıklarda Lefkoşa Mahkemeleri münhasıran yetkilidir.</p>

        <h2>Değişiklikler</h2>
        <p>Bu koşulları herhangi bir zamanda güncelleme hakkımız saklıdır. Yukarıdaki yürürlük tarihi en güncel revizyonu gösterir.</p>

        <h2>İletişim</h2>
        <p>Bu koşullara ilişkin sorular için: <a href="mailto:info@expocyprus.com">info@expocyprus.com</a></p>
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
