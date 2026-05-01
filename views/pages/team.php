<?php
$pageTitle       = lang() === 'en'
    ? 'Our Team | Expo Cyprus'
    : 'Ekibimiz | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? 'Meet the experienced team behind Expo Cyprus — fair organisation experts based in Nicosia, Cyprus.'
    : 'Expo Cyprus\'un arkasındaki deneyimli ekiple tanışın — Lefkoşa merkezli fuar organizasyon uzmanları.';
$bodyClass = 'page-team';
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'Our Team' : 'Ekibimiz' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'Our Team' : 'Ekibimiz' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? 'Experience, passion and an obsession with detail.'
            : 'Deneyim, tutku ve detaya verilen önem.' ?>
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?= lang() === 'en' ? 'Meet the Team' : 'Ekibimizle Tanışın' ?></h2>
      <p class="section-subtitle">
        <?= lang() === 'en'
            ? 'The professionals making every event a success.'
            : 'Her etkinliği başarıya taşıyan profesyoneller.' ?>
      </p>
    </div>

    <?php
    $team = (lang() === 'en') ? [
      ['Mehmet Yılmaz', 'MY', 'General Manager', '22 years of fair industry experience. One of the pioneers of the exhibition sector in Northern Cyprus.'],
      ['Ayşe Demir', 'AD', 'Operations Director', '15 years of expertise in congress and event management.'],
      ['Hasan Korkmaz', 'HK', 'Stand Design Lead', 'Lead of the in-house technical team that has designed 100+ custom stand projects.'],
      ['Selin Aydın', 'SA', 'Marketing & PR Manager', 'Specialist in brand communication and digital marketing.'],
      ['Mehmet Erdoğan', 'ME', 'Logistics Coordinator', 'A meticulous tracker of installation and operations workflows.'],
      ['Zehra Yıldız', 'ZY', 'Customer Relations', 'Detail-focused management constantly improving the participant experience.'],
    ] : [
      ['Mehmet Yılmaz', 'MY', 'Genel Müdür', '22 yıllık fuarcılık deneyimi. KKTC\'de fuar sektörünün öncülerinden.'],
      ['Ayşe Demir', 'AD', 'Operasyon Direktörü', 'Kongre ve etkinlik yönetiminde 15 yıllık uzmanlık.'],
      ['Hasan Korkmaz', 'HK', 'Stand Tasarım Şefi', '100+ özel stand projesi tasarlayan iç teknik ekip lideri.'],
      ['Selin Aydın', 'SA', 'Pazarlama & PR Müdürü', 'Marka iletişimi ve dijital pazarlama uzmanı.'],
      ['Mehmet Erdoğan', 'ME', 'Lojistik Koordinatörü', 'Kurulum ve operasyon süreçlerinin titiz takipçisi.'],
      ['Zehra Yıldız', 'ZY', 'Müşteri İlişkileri', 'Katılımcı deneyimini sürekli iyileştiren detay odaklı yönetim.'],
    ];
    ?>
    <div class="team-grid">
      <?php foreach ($team as $m): ?>
        <div class="team-card">
          <div class="team-card-photo"><?= htmlspecialchars($m[1]) ?></div>
          <div class="team-card-body">
            <h3 class="team-card-name"><?= htmlspecialchars($m[0]) ?></h3>
            <p class="team-card-title"><?= htmlspecialchars($m[2]) ?></p>
            <p class="team-card-bio"><?= htmlspecialchars($m[3]) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-cta-banner">
  <div class="container">
    <h2 class="cta-banner-title">
      <?= lang() === 'en' ? 'Join Us' : 'Bize Katılın' ?>
    </h2>
    <p class="cta-banner-text">
      <?= lang() === 'en'
          ? 'Talented, ambitious, team player? Send your CV to hr@expocyprus.com'
          : 'Yetenekli, hırslı, takım oyuncusu mu? CV\'nizi gönderin: hr@expocyprus.com' ?>
    </p>
    <div class="cta-banner-actions">
      <a href="mailto:hr@expocyprus.com" class="btn btn-white btn-lg">hr@expocyprus.com</a>
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

.team-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-xl); }
@media (max-width: 900px) { .team-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) { .team-grid { grid-template-columns: 1fr; } }
.team-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-xl); overflow: hidden; transition: all .3s; }
.team-card:hover { box-shadow: var(--shadow-xl); transform: translateY(-4px); }
.team-card-photo { aspect-ratio: 4/5; background: linear-gradient(135deg, var(--red-light), var(--gray-100)); display: flex; align-items: center; justify-content: center; font-size: 4rem; color: var(--red); font-weight: 800; }
.team-card-body { padding: 1.5rem; }
.team-card-name { margin: 0 0 .25rem; font-size: 1.125rem; font-weight: 700; }
.team-card-title { margin: 0 0 1rem; font-size: .875rem; color: var(--red); font-weight: 600; }
.team-card-bio { margin: 0; font-size: .875rem; color: var(--text-muted); line-height: 1.6; }
@media (max-width: 768px) { .page-hero-title { font-size: var(--font-size-4xl); } }
</style>
