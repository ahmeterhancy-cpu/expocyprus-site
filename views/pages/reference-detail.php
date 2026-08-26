<?php
$p = $project ?? [];
$related = $related ?? [];

$serviceTypes = \App\Models\ReferenceProject::serviceTypes();
$standTypes   = \App\Models\ReferenceProject::standTypes();
$gallery      = \App\Models\ReferenceProject::gallery($p);

$title   = lang() === 'en' ? ($p['title_en'] ?: $p['title_tr']) : ($p['title_tr'] ?: $p['title_en']);
$summary = trim((string) (lang() === 'en' ? ($p['summary_en'] ?: $p['summary_tr']) : ($p['summary_tr'] ?: $p['summary_en'])));
$body    = trim((string) (lang() === 'en' ? ($p['description_en'] ?: $p['description_tr']) : ($p['description_tr'] ?: $p['description_en'])));

$svc    = $p['service_type'] ?? '';
$svcLbl = ($svc !== '' && isset($serviceTypes[$svc])) ? (lang() === 'en' ? $serviceTypes[$svc]['en'] : $serviceTypes[$svc]['tr']) : '';
$std    = $p['stand_type'] ?? '';
$stdLbl = ($std !== '' && isset($standTypes[$std])) ? (lang() === 'en' ? $standTypes[$std]['en'] : $standTypes[$std]['tr']) : '';

$pageTitle       = $title . ' | Expo Cyprus';
$metaDescription = $summary !== '' ? mb_substr($summary, 0, 160) : ($title . ' — Expo Cyprus');
$bodyClass       = 'page-reference-detail';

// Künye satırları — yalnızca dolu olanlar
$facts = array_filter([
    (lang() === 'en' ? 'Client'   : 'Müşteri')        => trim((string) ($p['client'] ?? '')),
    (lang() === 'en' ? 'Event'    : 'Fuar / Etkinlik')=> trim((string) ($p['fair_name'] ?? '')),
    (lang() === 'en' ? 'Location' : 'Konum')          => trim((string) ($p['location'] ?? '')),
    (lang() === 'en' ? 'Year'     : 'Yıl')            => $p['year'] ? (string) (int) $p['year'] : '',
    (lang() === 'en' ? 'Area'     : 'Alan')           => $p['sqm'] ? (int) $p['sqm'] . ' m²' : '',
    (lang() === 'en' ? 'Service'  : 'Hizmet')         => $svcLbl,
    (lang() === 'en' ? 'Build'    : 'Stand Tipi')     => $stdLbl,
], fn($v) => $v !== '');

$heroImage = $p['image_main'] ?? ($gallery[0] ?? '');
?>

<section class="rd-hero<?= $heroImage ? ' rd-hero--photo' : '' ?>"
         <?= $heroImage ? 'style="background-image:linear-gradient(180deg,rgba(10,10,10,.35),rgba(10,10,10,.85)),url(\'' . e($heroImage) . '\')"' : '' ?>>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
      <span aria-hidden="true">›</span>
      <a href="<?= url('referanslar') ?>"><?= lang() === 'en' ? 'Reference Projects' : 'Referans Projelerimiz' ?></a>
      <span aria-hidden="true">›</span>
      <span><?= e($title) ?></span>
    </nav>
    <?php if (!empty($p['client'])): ?>
      <p class="rd-client"><?= e($p['client']) ?></p>
    <?php endif; ?>
    <h1 class="rd-title"><?= e($title) ?></h1>
    <?php if ($summary !== ''): ?>
      <p class="rd-summary"><?= e($summary) ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="rd-layout">

      <div class="rd-main">
        <?php if ($body !== ''): ?>
          <div class="rd-body">
            <?php foreach (preg_split('/\R{2,}/u', $body) as $para): ?>
              <?php $para = trim($para); if ($para === '') continue; ?>
              <p><?= nl2br(e($para)) ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if (count($gallery) > 1 || ($gallery && $gallery[0] !== $heroImage)): ?>
          <h2 class="rd-section-title"><?= lang() === 'en' ? 'Photos' : 'Fotoğraflar' ?></h2>
          <div class="rd-gallery">
            <?php foreach ($gallery as $g): ?>
              <a href="<?= e($g) ?>" target="_blank" rel="noopener" class="rd-gallery-item">
                <img src="<?= e($g) ?>" alt="<?= e($title) ?>" loading="lazy">
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if ($body === '' && !$gallery): ?>
          <p class="text-muted"><?= lang() === 'en'
              ? 'Details for this project will be published soon.'
              : 'Bu projenin detayları yakında yayınlanacak.' ?></p>
        <?php endif; ?>
      </div>

      <aside class="rd-aside">
        <?php if ($facts): ?>
        <div class="rd-facts">
          <h2 class="rd-facts-title"><?= lang() === 'en' ? 'Project Details' : 'Proje Künyesi' ?></h2>
          <dl>
            <?php foreach ($facts as $label => $value): ?>
              <dt><?= e($label) ?></dt>
              <dd><?= e($value) ?></dd>
            <?php endforeach; ?>
          </dl>
        </div>
        <?php endif; ?>

        <div class="rd-cta">
          <p><?= lang() === 'en'
                ? 'Want something similar for your brand?'
                : 'Markanız için benzerini ister misiniz?' ?></p>
          <a href="<?= url('teklif-al') ?>" class="btn btn-primary btn-block"><?= lang() === 'en' ? 'Get a Quote' : 'Teklif Al' ?></a>
          <a href="<?= url('iletisim') ?>" class="btn btn-outline btn-block"><?= lang() === 'en' ? 'Contact' : 'İletişim' ?></a>
        </div>
      </aside>

    </div>

    <?php if ($related): ?>
    <div class="rd-related">
      <h2 class="rd-section-title"><?= lang() === 'en' ? 'Other Projects' : 'Diğer Projeler' ?></h2>
      <div class="rd-related-grid">
        <?php foreach ($related as $r):
          $rTitle = lang() === 'en' ? ($r['title_en'] ?: $r['title_tr']) : ($r['title_tr'] ?: $r['title_en']);
          $rHref  = url('referanslar/' . $r['slug']);
        ?>
        <a class="rd-related-card" href="<?= e($rHref) ?>">
          <?php if (!empty($r['image_main'])): ?>
            <img src="<?= e($r['image_main']) ?>" alt="<?= e($rTitle) ?>" loading="lazy">
          <?php endif; ?>
          <div>
            <?php if (!empty($r['client'])): ?><span><?= e($r['client']) ?></span><?php endif; ?>
            <strong><?= e($rTitle) ?></strong>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <p class="rd-back">
      <a href="<?= url('referanslar') ?>">← <?= lang() === 'en' ? 'All reference projects' : 'Tüm referans projeleri' ?></a>
    </p>
  </div>
</section>

<style>
.rd-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);
    background-size: cover; background-position: center;
    color: var(--white);
    padding: var(--space-4xl) 0 var(--space-3xl);
    min-height: 340px; display: flex; align-items: flex-end;
}
.rd-hero--photo { min-height: 420px; }
.rd-hero .breadcrumb { display: flex; flex-wrap: wrap; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.75); margin-bottom: .75rem; }
.rd-hero .breadcrumb a { color: rgba(255,255,255,.75); }
.rd-hero .breadcrumb a:hover { color: var(--white); }
.rd-client { margin: 0; font-size: .75rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: rgba(255,255,255,.85); }
.rd-title { font-size: clamp(1.75rem, 4vw, 2.75rem); font-weight: 800; color: var(--white); margin: .375rem 0 .5rem; }
.rd-summary { font-size: 1.0625rem; line-height: 1.6; color: rgba(255,255,255,.92); margin: 0; max-width: 680px; }

.rd-layout { display: grid; grid-template-columns: 1fr 320px; gap: var(--space-2xl); align-items: start; }
@media (max-width: 900px) { .rd-layout { grid-template-columns: 1fr; } }

.rd-body p { font-size: 1rem; line-height: 1.75; color: var(--text); margin: 0 0 1rem; }
.rd-section-title { font-size: 1.25rem; font-weight: 800; margin: var(--space-xl) 0 1rem; color: var(--text); }

.rd-gallery { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; }
@media (max-width: 640px) { .rd-gallery { grid-template-columns: repeat(2, 1fr); } }
.rd-gallery-item { display: block; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-lg); border: 1px solid var(--border); }
.rd-gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s; }
.rd-gallery-item:hover img { transform: scale(1.05); }

.rd-facts { background: var(--bg-alt); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 1.25rem; margin-bottom: 1rem; }
.rd-facts-title { font-size: .8125rem; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; color: var(--text-muted); margin: 0 0 .875rem; }
.rd-facts dl { margin: 0; display: grid; grid-template-columns: auto 1fr; gap: .5rem .875rem; }
.rd-facts dt { font-size: .75rem; color: var(--text-muted); font-weight: 600; white-space: nowrap; }
.rd-facts dd { margin: 0; font-size: .8125rem; color: var(--text); font-weight: 700; }

.rd-cta { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 1.25rem; text-align: center; }
.rd-cta p { margin: 0 0 .875rem; font-size: .9375rem; color: var(--text); font-weight: 600; }
.rd-cta .btn-block { display: block; width: 100%; margin-bottom: .5rem; }

.rd-related { margin-top: var(--space-3xl); }
.rd-related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
@media (max-width: 900px) { .rd-related-grid { grid-template-columns: 1fr; } }
.rd-related-card {
    display: flex; gap: .875rem; align-items: center;
    padding: .75rem; text-decoration: none;
    background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg);
    transition: all .2s;
}
.rd-related-card:hover { border-color: var(--red); transform: translateY(-2px); }
.rd-related-card img { width: 72px; height: 54px; object-fit: cover; border-radius: var(--radius-md); flex: 0 0 auto; }
.rd-related-card span { display: block; font-size: .6875rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--red); }
.rd-related-card strong { display: block; font-size: .875rem; font-weight: 700; color: var(--text); line-height: 1.35; }

.rd-back { margin-top: var(--space-2xl); }
.rd-back a { font-weight: 700; color: var(--red); text-decoration: none; }
.rd-back a:hover { text-decoration: underline; }
</style>
