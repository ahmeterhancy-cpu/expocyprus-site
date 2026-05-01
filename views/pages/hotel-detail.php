<?php
$name        = $hotel['name'] ?? '';
$summary     = lang() === 'en' ? ($hotel['summary_en'] ?? $hotel['summary_tr'] ?? '') : ($hotel['summary_tr'] ?? $hotel['summary_en'] ?? '');
$description = lang() === 'en' ? ($hotel['description_en'] ?? $hotel['description_tr'] ?? '') : ($hotel['description_tr'] ?? $hotel['description_en'] ?? '');

$pageTitle       = !empty($hotel['meta_title_tr']) && lang() === 'tr' ? e($hotel['meta_title_tr']) : (!empty($hotel['meta_title_en']) && lang() === 'en' ? e($hotel['meta_title_en']) : e($name) . ' | Expo Cyprus');
$metaDescription = lang() === 'en' ? (!empty($hotel['meta_desc_en']) ? e($hotel['meta_desc_en']) : e(mb_substr(strip_tags((string)$summary), 0, 160))) : (!empty($hotel['meta_desc_tr']) ? e($hotel['meta_desc_tr']) : e(mb_substr(strip_tags((string)$summary), 0, 160)));
$bodyClass       = 'page-hotel-detail';
$heroBg          = !empty($hotel['image_main']) ? 'background-image:url(' . e($hotel['image_main']) . ');' : '';

$features = [];
if (!empty($hotel['features_json'])) {
    $decoded = json_decode((string)$hotel['features_json'], true);
    if (is_array($decoded)) $features = $decoded;
}

$gallery = [];
if (!empty($hotel['gallery_json'])) {
    $decoded = json_decode((string)$hotel['gallery_json'], true);
    if (is_array($decoded)) $gallery = $decoded;
}

$stars = (int)($hotel['stars'] ?? 5);
?>

<!-- ═══════════════════════════════════════════════════════════════
     HOTEL HERO
═══════════════════════════════════════════════════════════════ -->
<section class="hotel-detail-hero <?= empty($hotel['image_main']) ? 'hotel-detail-hero-placeholder' : '' ?>" style="<?= $heroBg ?>">
    <div class="hotel-detail-hero-overlay"></div>
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span aria-hidden="true">›</span>
            <a href="<?= url('oteller') ?>"><?= lang() === 'en' ? 'Hotels' : 'Oteller' ?></a>
            <span aria-hidden="true">›</span>
            <span><?= e($name) ?></span>
        </nav>
        <?php if (empty($hotel['image_main'])): ?>
            <div class="hero-placeholder-name"><?= e($name) ?></div>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     DETAY İÇERİK
═══════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">

        <a href="<?= url('oteller') ?>" class="btn btn-outline btn-sm" style="margin-bottom:var(--space-xl);">
            <span aria-hidden="true">←</span> <?= lang() === 'en' ? 'All Hotels' : 'Tüm Oteller' ?>
        </a>

        <div class="detail-layout">

            <!-- Main -->
            <article class="detail-main">

                <header class="hotel-header">
                    <div class="hotel-header-meta">
                        <span class="hotel-stars" aria-label="<?= $stars ?> stars">
                            <?php for ($i = 0; $i < $stars; $i++): ?>★<?php endfor; ?>
                        </span>
                        <?php if (!empty($hotel['region'])): ?>
                            <span class="hotel-region-badge"><?= e($hotel['region']) ?></span>
                        <?php endif; ?>
                    </div>
                    <h1 class="hotel-title"><?= e($name) ?></h1>
                    <?php if (!empty($hotel['location'])): ?>
                    <p class="hotel-location">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <?= e($hotel['location']) ?>
                    </p>
                    <?php endif; ?>
                    <?php if (!empty($summary)): ?>
                    <p class="hotel-summary"><?= e($summary) ?></p>
                    <?php endif; ?>
                </header>

                <?php if (!empty($description)): ?>
                <div class="prose hotel-description">
                    <?= $description ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($gallery)): ?>
                <h2 class="section-subtitle"><?= lang() === 'en' ? 'Gallery' : 'Galeri' ?></h2>
                <div class="hotel-gallery">
                    <?php foreach ($gallery as $img): ?>
                        <a href="<?= e($img) ?>" target="_blank" rel="noopener" class="hotel-gallery-item">
                            <img src="<?= e($img) ?>" alt="<?= e($name) ?>" loading="lazy">
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </article>

            <!-- Sidebar -->
            <aside class="detail-sidebar">

                <?php if (!empty($features)): ?>
                <div class="sidebar-card">
                    <h3 class="sidebar-card-title"><?= lang() === 'en' ? 'Hotel Features' : 'Otel Özellikleri' ?></h3>
                    <ul class="hotel-features-list">
                        <?php foreach ($features as $feat): ?>
                            <li>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <?= e($feat) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="sidebar-card" style="margin-top:var(--space-lg);">
                    <h3 class="sidebar-card-title"><?= lang() === 'en' ? 'Contact & Info' : 'İletişim & Bilgi' ?></h3>
                    <ul class="hotel-info-list">
                        <?php if (!empty($hotel['rooms'])): ?>
                        <li>
                            <span class="info-label"><?= lang() === 'en' ? 'Rooms' : 'Oda Sayısı' ?>:</span>
                            <span class="info-value"><?= (int)$hotel['rooms'] ?></span>
                        </li>
                        <?php endif; ?>
                        <li>
                            <span class="info-label"><?= lang() === 'en' ? 'Stars' : 'Yıldız' ?>:</span>
                            <span class="info-value"><?= str_repeat('★', $stars) ?></span>
                        </li>
                        <?php if (!empty($hotel['phone'])): ?>
                        <li>
                            <span class="info-label"><?= lang() === 'en' ? 'Phone' : 'Telefon' ?>:</span>
                            <a href="tel:<?= e(preg_replace('/\s+/', '', $hotel['phone'])) ?>" class="info-value"><?= e($hotel['phone']) ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <?php if (!empty($hotel['website_url'])): ?>
                    <a href="<?= e($hotel['website_url']) ?>" target="_blank" rel="noopener" class="btn btn-outline btn-block" style="margin-top:.75rem;">
                        <?= lang() === 'en' ? 'Visit Website' : 'Web Sitesini Ziyaret Et' ?> <span aria-hidden="true">↗</span>
                    </a>
                    <?php endif; ?>
                </div>

                <!-- Rezervasyon Talebi Formu -->
                <div class="sidebar-card" style="margin-top:var(--space-lg);">
                    <h3 class="sidebar-card-title"><?= lang() === 'en' ? 'Request Reservation' : 'Rezervasyon Talebi' ?></h3>
                    <p class="sidebar-card-text">
                        <?= lang() === 'en'
                            ? 'Send us your dates — we\'ll confirm availability and pricing.'
                            : 'Tarihlerinizi gönderin — uygunluk ve fiyat bilgisini iletelim.' ?>
                    </p>
                    <form action="<?= url('iletisim') ?>" method="POST" class="hotel-reserve-form">
                        <input type="hidden" name="subject" value="<?= e(lang() === 'en' ? 'Reservation request: ' : 'Rezervasyon talebi: ') . e($name) ?>">
                        <input type="hidden" name="hotel" value="<?= e($name) ?>">
                        <div class="form-group">
                            <label class="form-label"><?= lang() === 'en' ? 'Name' : 'Ad Soyad' ?> *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">E-posta *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?= lang() === 'en' ? 'Phone' : 'Telefon' ?></label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                        <div class="form-group form-row">
                            <div>
                                <label class="form-label"><?= lang() === 'en' ? 'Check-in' : 'Giriş' ?></label>
                                <input type="date" name="checkin" class="form-control">
                            </div>
                            <div>
                                <label class="form-label"><?= lang() === 'en' ? 'Check-out' : 'Çıkış' ?></label>
                                <input type="date" name="checkout" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="message" value="<?= e(lang() === 'en' ? 'I would like to request a reservation at ' : 'Otel rezervasyonu talep ediyorum: ') . e($name) ?>">
                        <button type="submit" class="btn btn-primary btn-block">
                            <?= lang() === 'en' ? 'Send Request' : 'Talebi Gönder' ?> <span aria-hidden="true">→</span>
                        </button>
                    </form>
                </div>

            </aside>

        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     CTA — DİĞER OTELLER
═══════════════════════════════════════════════════════════════ -->
<section class="section-cta-banner">
    <div class="container">
        <h2 class="cta-banner-title">
            <?= lang() === 'en' ? 'Explore Other Hotels' : 'Diğer Otelleri Keşfedin' ?>
        </h2>
        <p class="cta-banner-text">
            <?= lang() === 'en'
                ? 'Browse our full partner network across Cyprus regions.'
                : 'Tüm bölgelerdeki partner otel ağımıza göz atın.' ?>
        </p>
        <div class="cta-banner-actions">
            <a href="<?= url('oteller') ?>" class="btn btn-white btn-lg">
                <?= lang() === 'en' ? 'All Hotels' : 'Tüm Oteller' ?> <span aria-hidden="true">→</span>
            </a>
            <a href="<?= url('iletisim') ?>" class="btn btn-outline-white btn-lg">
                <?= lang() === 'en' ? 'Contact Us' : 'İletişime Geç' ?>
            </a>
        </div>
    </div>
</section>

<style>
.hotel-detail-hero {
    position: relative;
    min-height: 420px;
    display: flex;
    align-items: flex-end;
    padding: var(--space-4xl) 0 var(--space-2xl);
    background-size: cover;
    background-position: center;
    background-color: var(--gray-900);
    color: var(--white);
}
.hotel-detail-hero-placeholder { background: linear-gradient(135deg, #2c3e50 0%, #4a6d7c 100%); }
.hotel-detail-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(10,10,10,.45) 0%, rgba(10,10,10,.85) 100%);
}
.hotel-detail-hero .container { position: relative; z-index: 1; }
.hotel-detail-hero .breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.7); margin: 0; }
.hotel-detail-hero .breadcrumb a { color: rgba(255,255,255,.7); }
.hotel-detail-hero .breadcrumb a:hover { color: var(--white); }
.hero-placeholder-name { color: rgba(255,255,255,.85); font-weight: 700; font-size: 1.75rem; margin-top: 1rem; }

.hotel-header { margin-bottom: var(--space-2xl); }
.hotel-header-meta { display: flex; align-items: center; gap: .75rem; margin-bottom: .75rem; }
.hotel-stars { color: #f59e0b; font-size: 1.25rem; letter-spacing: .1em; }
.hotel-region-badge {
    background: var(--red-light);
    color: var(--red);
    padding: .25rem .75rem;
    border-radius: 100px;
    font-size: .75rem;
    font-weight: 700;
}
.hotel-title { font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 800; margin: 0 0 .75rem; color: var(--text); line-height: 1.2; }
.hotel-location {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .9375rem;
    color: var(--text-muted);
    margin: 0 0 1rem;
}
.hotel-summary { font-size: 1.125rem; line-height: 1.6; color: var(--text); margin: 0; max-width: 720px; }

.section-subtitle { font-size: 1.5rem; font-weight: 700; margin: var(--space-2xl) 0 var(--space-lg); color: var(--text); }

.hotel-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: var(--space-sm);
}
.hotel-gallery-item {
    aspect-ratio: 4/3;
    overflow: hidden;
    border-radius: var(--radius-md);
    display: block;
}
.hotel-gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.hotel-gallery-item:hover img { transform: scale(1.05); }

.detail-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: var(--space-3xl);
    align-items: start;
}
.detail-main { min-width: 0; }
.prose { line-height: 1.8; color: var(--gray-700); }
.prose h2, .prose h3 { color: var(--text); margin: 1.5em 0 .5em; }
.prose p { margin-bottom: 1em; }
.sidebar-card {
    background: var(--gray-50);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
}
.sidebar-card-title { font-size: 1rem; font-weight: 700; margin-bottom: .75rem; color: var(--text); }
.sidebar-card-text { font-size: .8125rem; color: var(--text-muted); margin-bottom: var(--space-md); line-height: 1.55; }

.hotel-features-list, .hotel-info-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .5rem; }
.hotel-features-list li {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .875rem;
    color: var(--text);
}
.hotel-features-list li svg { color: var(--red); flex-shrink: 0; }
.hotel-info-list li {
    display: flex;
    justify-content: space-between;
    padding: .375rem 0;
    border-bottom: 1px solid var(--border);
    font-size: .875rem;
}
.hotel-info-list li:last-child { border-bottom: 0; }
.hotel-info-list .info-label { color: var(--text-muted); }
.hotel-info-list .info-value { font-weight: 600; color: var(--text); }
.hotel-info-list a.info-value { color: var(--red); }

.hotel-reserve-form .form-group { margin-bottom: .75rem; }
.hotel-reserve-form .form-label { display:block; font-size:.8125rem; font-weight:600; margin-bottom:.25rem; color: var(--text); }
.hotel-reserve-form .form-control {
    width:100%; padding:.5rem .75rem; border:1px solid var(--border); border-radius: var(--radius-md);
    font-size:.875rem; font-family: inherit; background: var(--white); color: var(--text);
}
.hotel-reserve-form .form-control:focus { outline: 2px solid var(--red); outline-offset: -1px; border-color: var(--red); }
.hotel-reserve-form .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; }
.hotel-reserve-form .btn-block { width: 100%; margin-top: .5rem; }

@media (max-width: 960px) {
    .detail-layout { grid-template-columns: 1fr; }
}
</style>
