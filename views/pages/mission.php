<?php
$pageTitle       = lang() === 'en'
    ? 'Mission & Vision | Expo Cyprus'
    : 'Misyon & Vizyon | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? 'Our mission, vision and values — what drives Expo Cyprus to deliver world-class fair and event organisation in Cyprus.'
    : 'Misyonumuz, vizyonumuz ve değerlerimiz — Expo Cyprus\'u Kıbrıs\'ta dünya standartlarında fuar ve etkinlik organizasyonuna iten temel ilkeler.';
$bodyClass = 'page-mission';
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'Mission & Vision' : 'Misyon & Vizyon' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'Mission & Vision' : 'Misyon & Vizyon' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? 'The compass that guides every decision we make.'
            : 'Aldığımız her kararı yönlendiren pusula.' ?>
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="mission-cards">
      <article class="mission-card">
        <svg class="mission-card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
          <circle cx="12" cy="12" r="10"/>
          <circle cx="12" cy="12" r="6"/>
          <circle cx="12" cy="12" r="2" fill="currentColor"/>
        </svg>
        <h2><?= lang() === 'en' ? 'Our Mission' : 'Misyonumuz' ?></h2>
        <p>
          <?= lang() === 'en'
              ? 'To deliver fair and event organisation services in Cyprus that raise the standard, generate measurable value for participants, and move the industry forward.'
              : 'Kıbrıs\'ta fuar ve etkinlik organizasyonunda standartları yükselten, katılımcılarına ölçülebilir değer üreten, sektörünü ileriye taşıyan çözümler sunmak.' ?>
        </p>
      </article>
      <article class="mission-card">
        <svg class="mission-card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
          <circle cx="12" cy="12" r="3"/>
        </svg>
        <h2><?= lang() === 'en' ? 'Our Vision' : 'Vizyonumuz' ?></h2>
        <p>
          <?= lang() === 'en'
              ? 'To be the leading fair organisation company of the Eastern Mediterranean — internationally recognised, innovative, and creator of sustainable event experiences.'
              : 'Doğu Akdeniz\'in lider fuar organizasyon şirketi olmak; uluslararası ölçekte tanınan, yenilikçi ve sürdürülebilir etkinlik deneyimleri yaratmak.' ?>
        </p>
      </article>
    </div>
  </div>
</section>

<section class="section bg-light">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?= lang() === 'en' ? 'Our Values' : 'Değerlerimiz' ?></h2>
      <p class="section-subtitle">
        <?= lang() === 'en'
            ? 'Six principles we never compromise on.'
            : 'Asla taviz vermediğimiz altı temel ilke.' ?>
      </p>
    </div>

    <?php
    $values = (lang() === 'en') ? [
      ['M9 12l2 2 4-4', 'Customer Focus', 'Every project starts and ends with customer success.'],
      ['M13 2L3 14h9l-1 8 10-12h-9l1-8z', 'Innovation', 'We push the boundaries of what an event can be.'],
      ['M12 2v20M2 12h20', 'Transparency', 'Clear pricing, clear timelines, no hidden surprises.'],
      ['M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M9 7a3 3 0 116 0 3 3 0 01-6 0z', 'Team Spirit', 'We win as a team, we learn as a team.'],
      ['M3 12c2-2 4-2 6 0s4 2 6 0 4-2 6 0', 'Continuous Improvement', 'Every event teaches us something new.'],
      ['M12 2L4 7v10l8 5 8-5V7l-8-5z', 'Sustainability', 'We design events that respect people and planet.'],
    ] : [
      ['M9 12l2 2 4-4', 'Müşteri Odaklılık', 'Her proje müşteri başarısıyla başlar ve biter.'],
      ['M13 2L3 14h9l-1 8 10-12h-9l1-8z', 'Yenilikçilik', 'Bir etkinliğin sınırlarını sürekli zorlarız.'],
      ['M12 2v20M2 12h20', 'Şeffaflık', 'Net fiyat, net takvim, sürpriz yok.'],
      ['M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M9 7a3 3 0 116 0 3 3 0 01-6 0z', 'Takım Ruhu', 'Birlikte kazanır, birlikte öğreniriz.'],
      ['M3 12c2-2 4-2 6 0s4 2 6 0 4-2 6 0', 'Sürekli Gelişim', 'Her etkinlik bize yeni bir şey öğretir.'],
      ['M12 2L4 7v10l8 5 8-5V7l-8-5z', 'Sürdürülebilirlik', 'İnsanı ve gezegeni gözeten etkinlikler tasarlarız.'],
    ];
    ?>
    <div class="values-grid">
      <?php foreach ($values as $v): ?>
        <div class="value-card">
          <div class="value-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="<?= $v[0] ?>"/>
            </svg>
          </div>
          <h3 class="value-title"><?= htmlspecialchars($v[1]) ?></h3>
          <p class="value-text"><?= htmlspecialchars($v[2]) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-cta-banner">
  <div class="container">
    <h2 class="cta-banner-title">
      <?= lang() === 'en' ? 'Share Our Values?' : 'Aynı Değerleri mi Paylaşıyorsunuz?' ?>
    </h2>
    <p class="cta-banner-text">
      <?= lang() === 'en'
          ? 'Let\'s build something exceptional together.'
          : 'Birlikte istisnai bir şey inşa edelim.' ?>
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

.mission-cards { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-2xl); }
@media (max-width: 768px) { .mission-cards { grid-template-columns: 1fr; } }
.mission-card { padding: var(--space-2xl); border-radius: var(--radius-xl); background: var(--bg-alt); border-left: 6px solid var(--red); }
.mission-card-icon { width: 48px; height: 48px; color: var(--red); margin-bottom: 1rem; }
.mission-card h2 { font-size: 1.5rem; margin: 0 0 1rem; }
.mission-card p { font-size: 1.0625rem; line-height: 1.7; color: var(--text); margin: 0; }

.values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-xl); margin-top: var(--space-2xl); }
@media (max-width: 900px) { .values-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) { .values-grid { grid-template-columns: 1fr; } }
.value-card { text-align: center; padding: var(--space-xl); }
.value-icon { width: 64px; height: 64px; margin: 0 auto 1rem; background: var(--red-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--red); }
.value-title { font-size: 1.125rem; font-weight: 700; margin: 0 0 .5rem; }
.value-text { color: var(--text-muted); font-size: .875rem; line-height: 1.6; margin: 0; }
@media (max-width: 768px) { .page-hero-title { font-size: var(--font-size-4xl); } }
</style>
