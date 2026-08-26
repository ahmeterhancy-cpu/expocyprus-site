<?php
$pageTitle       = lang() === 'en'
    ? 'Reference Projects | Expo Cyprus'
    : 'Referans Projelerimiz | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? 'Completed fair, congress and stand projects delivered by Expo Cyprus across Cyprus over 22 years.'
    : 'Expo Cyprus\'ın 22 yılda Kıbrıs\'ta hayata geçirdiği fuar, kongre ve stand projeleri.';
$bodyClass = 'page-references';

$projects = $projects ?? [];
$counts   = $counts   ?? [];
$service  = $service  ?? '';

$serviceTypes = \App\Models\ReferenceProject::serviceTypes();
$total        = array_sum($counts) ?: count($projects);
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'Reference Projects' : 'Referans Projelerimiz' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'Reference Projects' : 'Referans Projelerimiz' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? 'Completed work, not promises. 22 years, 100+ installations across Cyprus.'
            : 'Söz değil, yapılmış işler. 22 yıl, Kıbrıs genelinde 100+ kurulum.' ?>
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">

    <?php if ($projects || $counts): ?>

      <?php if (count($counts) > 1): ?>
      <nav class="ref-filter" aria-label="<?= lang() === 'en' ? 'Filter by service' : 'Hizmete göre filtrele' ?>">
        <a href="<?= url('referanslar') ?>" class="ref-filter-btn <?= $service === '' ? 'is-active' : '' ?>">
          <?= lang() === 'en' ? 'All' : 'Tümü' ?>
          <span><?= $total ?></span>
        </a>
        <?php foreach ($serviceTypes as $key => $label): ?>
          <?php if (empty($counts[$key])) continue; ?>
          <a href="<?= url('referanslar') ?>?hizmet=<?= e($key) ?>" class="ref-filter-btn <?= $service === $key ? 'is-active' : '' ?>">
            <?= e(lang() === 'en' ? $label['en'] : $label['tr']) ?>
            <span><?= (int) $counts[$key] ?></span>
          </a>
        <?php endforeach; ?>
      </nav>
      <?php endif; ?>

      <?php if ($projects): ?>
      <div class="ref-grid">
        <?php foreach ($projects as $p):
          $title   = lang() === 'en' ? ($p['title_en'] ?: $p['title_tr']) : ($p['title_tr'] ?: $p['title_en']);
          $summary = trim((string) (lang() === 'en' ? ($p['summary_en'] ?: $p['summary_tr']) : ($p['summary_tr'] ?: $p['summary_en'])));
          $svc     = $p['service_type'] ?? '';
          $svcLbl  = ($svc !== '' && isset($serviceTypes[$svc]))
                      ? (lang() === 'en' ? $serviceTypes[$svc]['en'] : $serviceTypes[$svc]['tr']) : '';
          $meta    = array_values(array_filter([
                       trim((string) ($p['fair_name'] ?? '')),
                       $p['year'] ? (string) (int) $p['year'] : '',
                       $p['sqm']  ? (int) $p['sqm'] . ' m²' : '',
                     ], fn($v) => $v !== ''));
          $href    = url('referanslar/' . $p['slug']);
        ?>
        <article class="ref-card">
          <a class="ref-card-media" href="<?= e($href) ?>" aria-label="<?= e($title) ?>">
            <?php if (!empty($p['image_main'])): ?>
              <img src="<?= e($p['image_main']) ?>" alt="<?= e($title) ?>" loading="lazy">
            <?php else: ?>
              <div class="ref-card-noimg"><?= e(mb_substr($title, 0, 1)) ?></div>
            <?php endif; ?>
            <?php if ($svcLbl !== ''): ?><span class="ref-card-tag"><?= e($svcLbl) ?></span><?php endif; ?>
          </a>
          <div class="ref-card-body">
            <?php if (!empty($p['client'])): ?>
              <p class="ref-card-client"><?= e($p['client']) ?></p>
            <?php endif; ?>
            <h2 class="ref-card-title"><a href="<?= e($href) ?>"><?= e($title) ?></a></h2>
            <?php if ($meta): ?>
              <p class="ref-card-meta"><?= e(implode(' · ', $meta)) ?></p>
            <?php endif; ?>
            <?php if ($summary !== ''): ?>
              <p class="ref-card-summary"><?= e($summary) ?></p>
            <?php endif; ?>
            <a class="ref-card-link" href="<?= e($href) ?>">
              <?= lang() === 'en' ? 'View project' : 'Projeyi incele' ?> →
            </a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <div class="ref-empty">
        <p><?= lang() === 'en' ? 'No projects in this category yet.' : 'Bu kategoride henüz proje yok.' ?></p>
        <a href="<?= url('referanslar') ?>" class="btn btn-outline"><?= lang() === 'en' ? 'Show all' : 'Tümünü göster' ?></a>
      </div>
      <?php endif; ?>

    <?php else: ?>
      <!-- Hiç proje eklenmemiş — uydurma içerik yerine dürüst bir boş durum -->
      <div class="ref-empty">
        <p><?= lang() === 'en'
              ? 'Our project archive is being prepared. Get in touch and we will share references relevant to your sector.'
              : 'Proje arşivimiz hazırlanıyor. Bize ulaşın, sektörünüze uygun referanslarımızı paylaşalım.' ?></p>
        <a href="<?= url('iletisim') ?>" class="btn btn-primary"><?= lang() === 'en' ? 'Contact us' : 'İletişime geçin' ?></a>
      </div>
    <?php endif; ?>

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

/* ─── Filtre ─────────────────────────────────────────── */
.ref-filter { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: var(--space-2xl); }
.ref-filter-btn {
    display: inline-flex; align-items: center; gap: .4375rem;
    padding: .5rem .875rem;
    border: 1px solid var(--border); border-radius: 100px;
    background: var(--white); color: var(--text);
    font-size: .8125rem; font-weight: 600; text-decoration: none;
    transition: all .2s;
}
.ref-filter-btn span {
    font-size: .6875rem; font-weight: 700;
    background: var(--bg-alt); color: var(--text-muted);
    padding: .0625rem .375rem; border-radius: 100px;
}
.ref-filter-btn:hover { border-color: var(--red); color: var(--red); }
.ref-filter-btn.is-active { background: var(--red); border-color: var(--red); color: #ffffff; }
.ref-filter-btn.is-active span { background: rgba(255,255,255,.22); color: #ffffff; }

/* ─── Proje kartları ─────────────────────────────────── */
.ref-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-xl); align-items: stretch; }
@media (max-width: 1024px) { .ref-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px)  { .ref-grid { grid-template-columns: 1fr; } }

.ref-card {
    display: flex; flex-direction: column;
    background: var(--white);
    border: 1px solid var(--border); border-radius: var(--radius-xl);
    overflow: hidden; transition: all .25s;
}
.ref-card:hover { border-color: transparent; box-shadow: var(--shadow-xl); transform: translateY(-4px); }

.ref-card-media { position: relative; display: block; aspect-ratio: 4/3; overflow: hidden; background: var(--bg-alt); }
.ref-card-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.ref-card:hover .ref-card-media img { transform: scale(1.04); }
.ref-card-noimg {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 3rem; font-weight: 800; color: var(--border);
    background: var(--bg-alt);
}
.ref-card-tag {
    position: absolute; top: .75rem; left: .75rem;
    padding: .25rem .625rem; border-radius: 100px;
    background: rgba(0,0,0,.72); color: #ffffff;
    font-size: .6875rem; font-weight: 700; letter-spacing: .02em;
}

.ref-card-body { display: flex; flex-direction: column; gap: .4375rem; padding: 1.125rem 1.25rem 1.25rem; flex: 1; }
.ref-card-client { margin: 0; font-size: .6875rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--red); }
.ref-card-title { margin: 0; font-size: 1.0625rem; font-weight: 700; line-height: 1.35; }
.ref-card-title a { color: var(--text); text-decoration: none; }
.ref-card-title a:hover { color: var(--red); }
.ref-card-meta { margin: 0; font-size: .75rem; color: var(--text-muted); font-weight: 600; }
.ref-card-summary {
    margin: .1875rem 0 0; font-size: .8125rem; line-height: 1.55; color: var(--text-muted);
    display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
}
.ref-card-link { margin-top: auto; padding-top: .625rem; font-size: .8125rem; font-weight: 700; color: var(--red); text-decoration: none; }
.ref-card-link:hover { text-decoration: underline; }

.ref-empty { text-align: center; padding: var(--space-3xl) 1rem; color: var(--text-muted); }
.ref-empty p { margin: 0 0 1.25rem; font-size: 1rem; }

@media (max-width: 768px) { .page-hero-title { font-size: var(--font-size-4xl); } }
</style>
