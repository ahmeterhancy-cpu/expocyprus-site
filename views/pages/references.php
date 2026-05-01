<?php
$pageTitle       = lang() === 'en'
    ? 'References | Expo Cyprus'
    : 'Referanslarımız | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? 'Public institutions, universities, hotels and corporations that have trusted Expo Cyprus over 22 years.'
    : 'Expo Cyprus\'a 22 yıl boyunca güvenen kamu kurumları, üniversiteler, oteller ve kurumsal markalar.';
$bodyClass = 'page-references';
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'References' : 'Referanslarımız' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'References' : 'Referanslarımız' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? '100+ stand installations, 22 years of trust.'
            : '100+ kurulum, 22 yıl güven.' ?>
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?= lang() === 'en' ? 'Trusted By' : 'Bize Güvenenler' ?></h2>
      <p class="section-subtitle">
        <?= lang() === 'en'
            ? 'A small selection from our long-term clients.'
            : 'Uzun vadeli müşterilerimizden küçük bir seçki.' ?>
      </p>
    </div>

    <?php
    $logos = [
      'TC Lefkoşa Büyükelçiliği',
      'KKTC Ticaret Odası',
      'KKTC Sanayi Odası',
      'Near East University',
      'Eastern Mediterranean University',
      'Cyprus Turkish Chamber of Commerce',
      'Lefkoşa Belediyesi',
      'KKTC Tarım Bakanlığı',
      'KKTC Sağlık Bakanlığı',
      'Saray Hotel',
      'Salamis Bay Conti',
      'Acapulco Resort',
    ];
    ?>
    <div class="logos-grid">
      <?php foreach ($logos as $l): ?>
        <div class="logo-box"><?= htmlspecialchars($l) ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section bg-light">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?= lang() === 'en' ? 'What They Say' : 'Ne Diyorlar?' ?></h2>
      <p class="section-subtitle">
        <?= lang() === 'en'
            ? 'Real stories from real partners.'
            : 'Gerçek ortaklarımızdan gerçek hikayeler.' ?>
      </p>
    </div>

    <?php
    $testimonials = (lang() === 'en') ? [
      ['The Expo Cyprus team is fully professional. From stand design to installation, every detail was on time and complete.', 'Ahmet K., Marketing Director, XYZ A.Ş.'],
      ['Their 22 years of experience shows at every stage. Our congress organisation was flawless.', 'Prof. Dr. Selin G., NEU'],
      ['It was our first time exhibiting in Cyprus, and Expo Cyprus made it an unforgettable experience.', 'Mert B., Istanbul Exporters\' Association'],
    ] : [
      ['Expo Cyprus ekibi tam profesyonel. Stand tasarımından kuruluma her detay zamanında ve eksiksiz.', 'Ahmet K., XYZ A.Ş. Pazarlama Direktörü'],
      ['22 yıllık deneyimleri her aşamada hissediliyor. Kongre organizasyonumuz kusursuzdu.', 'Prof. Dr. Selin G., NEU'],
      ['Kıbrıs\'ta fuara ilk kez katıldık, Expo Cyprus sayesinde unutulmaz bir deneyim oldu.', 'Mert B., İstanbul İhracatçılar Birliği'],
    ];
    ?>
    <div class="testimonials">
      <?php foreach ($testimonials as $t): ?>
        <article class="testimonial">
          <p class="testimonial-quote"><?= htmlspecialchars($t[0]) ?></p>
          <p class="testimonial-author"><?= htmlspecialchars($t[1]) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-cta-banner">
  <div class="container">
    <h2 class="cta-banner-title">
      <?= lang() === 'en' ? 'Ready to Join the List?' : 'Listeye Katılmaya Hazır mısınız?' ?>
    </h2>
    <p class="cta-banner-text">
      <?= lang() === 'en'
          ? 'Tell us about your project. We\'ll respond within 24 hours.'
          : 'Projenizi anlatın. 24 saat içinde dönüş yapıyoruz.' ?>
    </p>
    <div class="cta-banner-actions">
      <a href="<?= url('teklif-al') ?>" class="btn btn-white btn-lg"><?= lang() === 'en' ? 'Get a Quote' : 'Teklif Al' ?></a>
      <a href="<?= url('iletisim') ?>" class="btn btn-outline-white btn-lg"><?= lang() === 'en' ? 'Contact' : 'İletişim' ?></a>
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

.logos-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin: 2rem 0; }
@media (max-width: 900px) { .logos-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 600px) { .logos-grid { grid-template-columns: repeat(2, 1fr); } }
.logo-box { aspect-ratio: 16/9; background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; padding: 1rem; text-align: center; font-size: .75rem; font-weight: 600; color: var(--text-muted); transition: all .3s; }
.logo-box:hover { box-shadow: var(--shadow-md); border-color: var(--red); color: var(--red); }

.testimonials { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-xl); }
@media (max-width: 900px) { .testimonials { grid-template-columns: 1fr; } }
.testimonial { background: var(--white); border-radius: var(--radius-xl); padding: var(--space-xl); border: 1px solid var(--border); position: relative; }
.testimonial::before { content: '"'; position: absolute; top: 1rem; left: 1.5rem; font-size: 4rem; color: var(--red); opacity: .2; line-height: 1; font-family: Georgia, serif; }
.testimonial-quote { font-size: 1rem; line-height: 1.7; color: var(--text); margin: 0 0 1rem; padding-top: 1rem; }
.testimonial-author { font-size: .875rem; color: var(--text-muted); font-style: italic; }
@media (max-width: 768px) { .page-hero-title { font-size: var(--font-size-4xl); } }
</style>
