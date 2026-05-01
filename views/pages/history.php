<?php
$pageTitle       = lang() === 'en'
    ? 'Our Journey | Expo Cyprus — 22 Years of History'
    : 'Tarihçe | Expo Cyprus — 22 Yıllık Serüven';
$metaDescription = lang() === 'en'
    ? 'From a small Nicosia startup in 2004 to Cyprus\'s leading fair organisation company. Discover the milestones of Expo Cyprus.'
    : '2004\'te Lefkoşa\'da kurulan küçük bir ekipten Kıbrıs\'ın lider fuar organizasyon şirketine. Expo Cyprus\'un dönüm noktalarını keşfedin.';
$bodyClass = 'page-history';
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'Our Journey' : 'Tarihçe' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'Our Journey' : 'Tarihçe' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? '22 years of perseverance — from 2004 to today.'
            : '2004\'ten bugüne 22 yıllık serüven.' ?>
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?= lang() === 'en' ? 'Milestones' : 'Dönüm Noktaları' ?></h2>
      <p class="section-subtitle">
        <?= lang() === 'en'
            ? 'Two decades of building Cyprus\'s exhibition industry.'
            : 'Kıbrıs\'ın fuar sektörünü inşa eden yirmi yılı aşkın bir yolculuk.' ?>
      </p>
    </div>

    <div class="timeline">
      <?php
      $events = (lang() === 'en') ? [
        ['2004', 'Founded in Nicosia', 'Unifex Fuarcılık was founded in Nicosia. The first Consumer Fair was organised.'],
        ['2008', 'First Specialty Fair', 'Hunting, Shooting & Outdoor Sports Fair launched — Northern Cyprus\'s first specialty fair.'],
        ['2012', 'Agriculture Fair Added', 'Agriculture & Livestock Fair added. Annual visitors passed 30,000+.'],
        ['2016', '100th Stand', 'Stand build team expanded; 100th custom stand installation completed.'],
        ['2018', 'Wedding Fair', 'Wedding Preparations Fair joined our portfolio.'],
        ['2020', 'Hybrid Events', 'Hybrid event infrastructure launched; full digital solutions deployed.'],
        ['2022', 'Expo Cyprus Brand', 'Rebranded as Expo Cyprus. Annual visitors surpassed 50,000+.'],
        ['2024', 'Industry Leadership', '4 main fairs, 100+ stand builds, 10+ congress organisations annually.'],
        ['2026', 'Today', 'The leading fair organisation company in Cyprus.'],
      ] : [
        ['2004', 'Lefkoşa\'da Kuruluş', 'Unifex Fuarcılık Lefkoşa\'da kuruldu. İlk Tüketici Fuarı düzenlendi.'],
        ['2008', 'İlk İhtisas Fuarı', 'Av, Avcılık & Doğa Sporları Fuarı başladı. KKTC\'nin ilk ihtisas fuarı.'],
        ['2012', 'Tarım Fuarı Eklendi', 'Tarım Hayvancılık Fuarı eklendi. Yıllık ziyaretçi 30.000+.'],
        ['2016', '100. Stand', 'Stand kurulum ekibi büyüdü, 100. stand kurulumu tamamlandı.'],
        ['2018', 'Düğün Fuarı', 'Düğün Hazırlıkları Fuarı portföye katıldı.'],
        ['2020', 'Hibrit Etkinlikler', 'Hibrit etkinlik altyapısı, dijital çözümler.'],
        ['2022', 'Expo Cyprus Markası', 'Expo Cyprus markası ile yenilendik. 50.000+ yıllık ziyaretçi.'],
        ['2024', 'Sektörde Liderlik', '4 ana fuar, 100+ stand kurulumu, 10+ kongre organizasyonu.'],
        ['2026', 'Bugün', 'Kıbrıs\'ın lider fuar organizasyon şirketi.'],
      ];
      foreach ($events as $ev): ?>
        <div class="timeline-item">
          <div class="timeline-year"><?= $ev[0] ?></div>
          <div class="timeline-content">
            <h3><?= htmlspecialchars($ev[1]) ?></h3>
            <p><?= htmlspecialchars($ev[2]) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section bg-dark">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title text-white"><?= lang() === 'en' ? 'In Numbers' : 'Sayılarla' ?></h2>
    </div>
    <div class="stats-grid">
      <div class="stat-item"><span class="stat-num">22+</span><span class="stat-label"><?= lang() === 'en' ? 'Years' : 'Yıl' ?></span></div>
      <div class="stat-item"><span class="stat-num">4</span><span class="stat-label"><?= lang() === 'en' ? 'Annual Fairs' : 'Yıllık Fuar' ?></span></div>
      <div class="stat-item"><span class="stat-num">100+</span><span class="stat-label"><?= lang() === 'en' ? 'Stands' : 'Stand' ?></span></div>
      <div class="stat-item"><span class="stat-num">10+</span><span class="stat-label"><?= lang() === 'en' ? 'Congresses' : 'Kongre' ?></span></div>
    </div>
  </div>
</section>

<section class="section-cta-banner">
  <div class="container">
    <h2 class="cta-banner-title">
      <?= lang() === 'en' ? 'Become Part of the Story' : 'Hikayenin Parçası Olun' ?>
    </h2>
    <p class="cta-banner-text">
      <?= lang() === 'en'
          ? 'Join the next chapter — exhibit, sponsor or partner with us.'
          : 'Bir sonraki bölüme katılın — katılımcı, sponsor ya da ortak olun.' ?>
    </p>
    <div class="cta-banner-actions">
      <a href="<?= url('teklif-al') ?>" class="btn btn-white btn-lg"><?= lang() === 'en' ? 'Get a Quote' : 'Teklif Al' ?></a>
      <a href="<?= url('iletisim') ?>" class="btn btn-outline-white btn-lg"><?= lang() === 'en' ? 'Contact Us' : 'İletişim' ?></a>
    </div>
  </div>
</section>

<style>
.page-hero { position: relative; min-height: 360px; display: flex; align-items: center; color: var(--white); padding: var(--space-4xl) 0 var(--space-3xl); }
.page-hero .container { position: relative; z-index: 1; }
.page-hero-content { max-width: 640px; }
.page-hero-title { font-size: var(--font-size-5xl); font-weight: 800; color: var(--white); margin: .5rem 0; }
.page-hero-subtitle { font-size: var(--font-size-lg); color: rgba(255,255,255,.9); margin-top: .75rem; }
.breadcrumb { display: flex; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.75); margin-bottom: .5rem; }
.breadcrumb a { color: rgba(255,255,255,.75); }
.breadcrumb a:hover { color: var(--white); }

.timeline { position: relative; padding: 2rem 0; max-width: 800px; margin: 0 auto; }
.timeline::before { content: ''; position: absolute; left: 80px; top: 0; bottom: 0; width: 2px; background: var(--red); }
.timeline-item { display: flex; gap: 2rem; margin-bottom: 2.5rem; align-items: start; }
.timeline-year { flex: 0 0 80px; font-size: 1.5rem; font-weight: 800; color: var(--red); }
.timeline-content { flex: 1; padding-left: 2rem; position: relative; }
.timeline-content::before { content: ''; position: absolute; left: -7px; top: 8px; width: 14px; height: 14px; border-radius: 50%; background: var(--red); border: 3px solid var(--white); box-shadow: 0 0 0 2px var(--red); }
.timeline-content h3 { margin: 0 0 .5rem; font-size: 1.125rem; }
.timeline-content p { margin: 0; color: var(--text-muted); }
@media (max-width: 768px) {
  .page-hero-title { font-size: var(--font-size-4xl); }
  .timeline::before { left: 30px; }
  .timeline-year { flex: 0 0 60px; font-size: 1rem; }
}
</style>
