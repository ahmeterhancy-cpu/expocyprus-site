<?php
$pageTitle       = lang() === 'en'
    ? 'FAQ | Expo Cyprus'
    : 'Sıkça Sorulan Sorular | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? 'Answers to the most common questions about fair participation, stand costs, technical infrastructure and Expo Cyprus services.'
    : 'Fuar katılımı, stand maliyetleri, teknik altyapı ve Expo Cyprus hizmetleri hakkında en sık sorulan soruların yanıtları.';
$bodyClass = 'page-faq';
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'FAQ' : 'SSS' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'Frequently Asked Questions' : 'Sıkça Sorulan Sorular' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? 'Everything you wanted to ask before getting in touch.'
            : 'İletişime geçmeden önce sormak istediğiniz her şey.' ?>
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php
    $faqs = (lang() === 'en') ? [
      ['How early should I plan for fair participation?', 'At least 3-6 months in advance. Healthy time is needed for stand design, installation and marketing.'],
      ['How is stand cost calculated?', 'm² × design type × additional services. Modular: 350-500 €/m²; custom build: 600-1200 €/m².'],
      ['What support do you offer to international participants?', 'Full support for accommodation, transfers, local communication and Northern Cyprus entry procedures.'],
      ['How long does stand design take?', 'After the brief: 5-10 working days for 3D visualisation; after approval, 15-25 days for production.'],
      ['Do you provide hostess / stage staff?', 'Yes — trained staff including stand attendants, multilingual hostesses, MCs and stage management.'],
      ['Do you supply technical infrastructure (LED, sound, lighting)?', 'All AV equipment, stage construction and technical operations are included with our team.'],
      ['What kind of post-event report do you provide?', 'Detailed attendance report, lead list, ROI analysis, photo/video archive.'],
      ['What is your cancellation and refund policy?', 'Contract-based. General rule: 60+ days prior — full refund; 30-60 days — 50%; under 30 days — no refund.'],
    ] : [
      ['Fuar katılımı için ne kadar erken planlama yapmalıyım?', 'En az 3-6 ay önce. Stand tasarımı, kurulum ve pazarlama için sağlıklı süre.'],
      ['Stand maliyeti nasıl hesaplanır?', 'm² × tasarım tipi × ek hizmetler. Modüler 350-500 €/m², özel yapım 600-1200 €/m² aralığında.'],
      ['Yurt dışından katılım yapanlara hangi destekler veriyorsunuz?', 'Konaklama, transfer, yerel iletişim ve KKTC giriş prosedürleri için tam destek.'],
      ['Stand tasarımı süresi ne kadar?', 'Brief alındıktan sonra 5-10 iş günü içinde 3D görselleştirme + onay sonrası 15-25 gün üretim.'],
      ['Hostes / sahne ekibi sağlıyor musunuz?', 'Evet, eğitimli kadromuz var: stand görevlisi, dil bilen hostes, MC, sahne yönetimi.'],
      ['Teknik altyapı (LED, ses, ışık) sağlıyor musunuz?', 'Tüm AV ekipman, sahne kurulumu ve teknik operasyon ekibimizle dahil.'],
      ['Etkinlik sonrası nasıl bir rapor sunuyorsunuz?', 'Detaylı katılım raporu, lead listesi, ROI analizi, fotoğraf/video arşivi.'],
      ['İptal ve geri ödeme politikanız nedir?', 'Sözleşmeye bağlı. Genel kural: 60+ gün öncesi tam iade, 30-60 gün %50, 30 gün altı iade yok.'],
    ];
    ?>
    <div class="faq-list">
      <?php foreach ($faqs as $f): ?>
        <details class="faq-item">
          <summary><?= htmlspecialchars($f[0]) ?></summary>
          <div class="faq-content"><?= htmlspecialchars($f[1]) ?></div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-cta-banner">
  <div class="container">
    <h2 class="cta-banner-title">
      <?= lang() === 'en' ? 'Question Not Answered?' : 'Cevap Bulamadınız mı?' ?>
    </h2>
    <p class="cta-banner-text">
      <?= lang() === 'en'
          ? 'Reach out — we love a good question.'
          : 'Bize ulaşın — iyi sorular bizi heyecanlandırır.' ?>
    </p>
    <div class="cta-banner-actions">
      <a href="<?= url('iletisim') ?>" class="btn btn-white btn-lg"><?= lang() === 'en' ? 'Contact Us' : 'İletişim' ?></a>
    </div>
  </div>
</section>

<style>
.page-hero { position: relative; min-height: 360px; display: flex; align-items: center; color: var(--white); padding: var(--space-4xl) 0 var(--space-3xl); }
.page-hero-content { max-width: 640px; }
.page-hero-title { font-size: var(--font-size-5xl); font-weight: 800; color: var(--white); margin: .5rem 0; }
.page-hero-subtitle { font-size: var(--font-size-lg); color: rgba(255,255,255,.9); margin-top: .75rem; }
.breadcrumb { display: flex; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.75); margin-bottom: .5rem; }
.breadcrumb a { color: rgba(255,255,255,.75); }
.breadcrumb a:hover { color: var(--white); }

.faq-list { max-width: 800px; margin: 0 auto; }
.faq-item { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-md); margin-bottom: .5rem; overflow: hidden; }
.faq-item[open] { border-color: var(--red); }
.faq-item summary { padding: 1.25rem 1.5rem; font-weight: 600; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
.faq-item summary::after { content: '+'; font-size: 1.5rem; font-weight: 300; color: var(--red); transition: transform .3s; }
.faq-item[open] summary::after { content: '−'; transform: rotate(180deg); }
.faq-item summary::-webkit-details-marker { display: none; }
.faq-content { padding: 0 1.5rem 1.25rem; color: var(--text-muted); line-height: 1.7; border-top: 1px solid var(--border); padding-top: 1rem; }
@media (max-width: 768px) { .page-hero-title { font-size: var(--font-size-4xl); } }
</style>
