<?php
$pageTitle       = lang() === 'en'
    ? 'Hotels | Expo Cyprus — Partner Hotels Across Northern Cyprus'
    : 'Oteller | Expo Cyprus — Kıbrıs Partner Otel Ağı';
$metaDescription = lang() === 'en'
    ? 'Our partner network of premium hotels across Northern Cyprus — perfect accommodation for fair and congress guests.'
    : 'Kıbrıs\'ın seçkin otel ağı — fuar ve kongre konuklarınız için ideal konaklama.';
$bodyClass = 'page-hotels';

$regions = [
    ['key' => '',        'tr' => 'Tümü',    'en' => 'All'],
    ['key' => 'Girne',   'tr' => 'Girne',   'en' => 'Kyrenia'],
    ['key' => 'Mağusa',  'tr' => 'Mağusa',  'en' => 'Famagusta'],
    ['key' => 'Lefkoşa', 'tr' => 'Lefkoşa', 'en' => 'Nicosia'],
    ['key' => 'Bafra',   'tr' => 'Bafra',   'en' => 'Bafra'],
    ['key' => 'İskele',  'tr' => 'İskele',  'en' => 'Iskele'],
];

$currentRegion = $region ?? '';
?>

<!-- ═══════════════════════════════════════════════════════════════
     HOTELS HERO
═══════════════════════════════════════════════════════════════ -->
<section class="hotels-hero" style="background-image:url('/assets/images/hotels-hero.png');">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span aria-hidden="true">›</span>
            <span><?= lang() === 'en' ? 'Hotels' : 'Oteller' ?></span>
        </nav>
        <h1><?= lang() === 'en' ? 'Hotels' : 'Oteller' ?></h1>
        <p>
            <?php if (lang() === 'en'): ?>
                Our Trusted Partner Network of Premium Cyprus Hotels.<br>
                Handpicked for Fair, Congress, Launch Meetings and Dealer Meeting Guests.
            <?php else: ?>
                Kıbrıs'ın Seçkin Otelleriyle Çözüm Ortağıyız.<br>
                Fuar, Kongre, Lansman Toplantıları ve Bayi Toplantıları Konuklarınız İçin Titizlikle Seçilmiş Oteller.
            <?php endif; ?>
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     INTRO + FILTRELER + GRID
═══════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">

        <div class="hotels-intro">
            <p>
                <?= lang() === 'en'
                    ? 'We arrange accommodation for fair and congress guests at our trusted partner hotels across Northern Cyprus. From Kyrenia\'s seafront resorts to Bafra\'s luxury integrated complexes, we match every event with the right hotel.'
                    : 'Fuar ve kongre konuklarınız için Kuzey Kıbrıs\'taki güvenilir partner otellerimizde özenle konaklama düzenler. Girne sahil tesislerinden Bafra\'nın lüks entegre kompleksine her etkinliğe uygun oteli eşleştiriyoruz.' ?>
            </p>
        </div>

        <!-- Bölge Filtre Tabları -->
        <div class="region-tabs" role="tablist">
            <?php foreach ($regions as $r):
                $isActive = ($currentRegion === $r['key']);
                $label    = lang() === 'en' ? $r['en'] : $r['tr'];
                $count    = $r['key'] === '' ? array_sum($regionCounts ?? []) : ($regionCounts[$r['key']] ?? 0);
                $href     = $r['key'] === '' ? url('oteller') : url('oteller') . '?region=' . urlencode($r['key']);
            ?>
            <a href="<?= e($href) ?>" class="region-tab <?= $isActive ? 'active' : '' ?>">
                <?= e($label) ?>
                <?php if ($count > 0): ?>
                    <span class="count">(<?= $count ?>)</span>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Otel Listesi -->
        <?php if (empty($hotels)): ?>
            <div class="empty-state">
                <p><?= lang() === 'en'
                    ? 'No hotels listed in this region yet.'
                    : 'Bu bölgede henüz otel kaydı bulunmuyor.' ?></p>
            </div>
        <?php else: ?>
        <div class="hotels-grid">
            <?php foreach ($hotels as $h):
                $summary = lang() === 'en' ? ($h['summary_en'] ?? $h['summary_tr']) : ($h['summary_tr'] ?? $h['summary_en']);
                $summaryShort = mb_substr(strip_tags((string)$summary), 0, 120, 'UTF-8');
                if (mb_strlen((string)$summary, 'UTF-8') > 120) $summaryShort .= '…';
                $features = [];
                if (!empty($h['features_json'])) {
                    $decoded = json_decode((string)$h['features_json'], true);
                    if (is_array($decoded)) $features = array_slice($decoded, 0, 3);
                }
                $stars = (int)($h['stars'] ?? 5);
                $meetingRooms = (int)($h['meeting_rooms'] ?? 0);
                $eventTypes = [];
                if (!empty($h['event_types_json'])) {
                    $decoded = json_decode((string)$h['event_types_json'], true);
                    if (is_array($decoded)) $eventTypes = $decoded;
                }
                $eventTypesShow = array_slice($eventTypes, 0, 3);
                $eventTypesExtra = max(0, count($eventTypes) - 3);
            ?>
            <a href="<?= url('oteller/' . $h['slug']) ?>" class="hotel-card-wrap" style="text-decoration:none; color:inherit;">
                <article class="hotel-card">
                    <div class="hotel-card-img">
                        <span class="hotel-card-stars"><?= str_repeat('★', $stars) ?></span>
                        <?php if (!empty($h['region'])): ?>
                        <span class="hotel-card-region"><?= e($h['region']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($h['image_main'])): ?>
                            <img src="<?= e($h['image_main']) ?>" alt="<?= e($h['name']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="hotel-card-img-placeholder"><?= e($h['name']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="hotel-card-body">
                        <h3 class="hotel-card-name"><?= e($h['name']) ?></h3>
                        <?php if (!empty($h['location'])): ?>
                        <p class="hotel-card-location">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <?= e($h['location']) ?>
                        </p>
                        <?php endif; ?>
                        <?php if (!empty($summaryShort)): ?>
                        <p class="hotel-card-summary"><?= e($summaryShort) ?></p>
                        <?php endif; ?>
                        <?php if ($meetingRooms > 0 || !empty($eventTypesShow)): ?>
                        <div class="hotel-card-mice">
                            <?php if ($meetingRooms > 0): ?>
                            <span class="hotel-card-rooms" title="<?= lang() === 'en' ? 'Meeting Rooms' : 'Toplantı Salonları' ?>">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M3 21h18"></path>
                                    <path d="M5 21V7l8-4v18"></path>
                                    <path d="M19 21V11l-6-4"></path>
                                    <path d="M9 9v.01"></path>
                                    <path d="M9 12v.01"></path>
                                    <path d="M9 15v.01"></path>
                                    <path d="M9 18v.01"></path>
                                </svg>
                                <strong><?= $meetingRooms ?></strong> <?= lang() === 'en' ? ($meetingRooms === 1 ? 'Hall' : 'Halls') : 'Salon' ?>
                            </span>
                            <?php endif; ?>
                            <?php foreach ($eventTypesShow as $type): ?>
                                <span class="hotel-card-event-type"><?= e($type) ?></span>
                            <?php endforeach; ?>
                            <?php if ($eventTypesExtra > 0): ?>
                                <span class="hotel-card-event-extra">+<?= $eventTypesExtra ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($features)): ?>
                        <div class="hotel-card-features">
                            <?php foreach ($features as $feat): ?>
                                <span class="hotel-card-feature"><?= e($feat) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <span class="hotel-card-link">
                            <?= lang() === 'en' ? 'View Details' : 'Detaylar' ?>
                        </span>
                    </div>
                </article>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     CTA BANNER
═══════════════════════════════════════════════════════════════ -->
<section class="section-cta-banner">
    <div class="container">
        <h2 class="cta-banner-title">
            <?= lang() === 'en'
                ? 'Need Hotel Reservations for Your Fair or Congress?'
                : 'Fuar veya Kongre İçin Otel Rezervasyonu mu Lazım?' ?>
        </h2>
        <p class="cta-banner-text">
            <?= lang() === 'en'
                ? 'We\'ll match your event with the right hotel — single-room blocks to full venue takeovers.'
                : 'Etkinliğinize en uygun oteli birlikte seçelim — tek odadan tüm tesis kapatmaya kadar her ölçekte.' ?>
        </p>
        <div class="cta-banner-actions">
            <a href="<?= url('iletisim') ?>" class="btn btn-white btn-lg">
                <?= lang() === 'en' ? 'Contact Us' : 'Bize Ulaşın' ?> <span aria-hidden="true">→</span>
            </a>
            <a href="<?= url('teklif-al') ?>" class="btn btn-outline-white btn-lg">
                <?= lang() === 'en' ? 'Request a Quote' : 'Teklif İste' ?>
            </a>
        </div>
    </div>
</section>

<style>
.hotels-hero {
    position: relative;
    min-height: 50vh;
    display: flex;
    align-items: center;
    padding: var(--space-4xl) 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-color: var(--gray-900);
    color: var(--white);
}
.hotels-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,10,10,.85) 0%, rgba(10,10,10,.55) 100%);
}
.hotels-hero > .container { position: relative; z-index: 1; max-width: 1200px; }
.hotels-hero h1 {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    margin: .5rem 0 1rem;
    color: var(--white);
}
.hotels-hero p {
    font-size: 1.125rem;
    max-width: 600px;
    opacity: .92;
    margin: 0;
    line-height: 1.6;
}
.hotels-hero .breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.7); margin-bottom: .25rem; }
.hotels-hero .breadcrumb a { color: rgba(255,255,255,.7); }
.hotels-hero .breadcrumb a:hover { color: var(--white); }

.hotels-intro {
    max-width: 780px;
    margin: 0 auto var(--space-2xl);
    text-align: center;
    color: var(--text);
    font-size: 1.0625rem;
    line-height: 1.7;
}

.region-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    margin: 0 auto var(--space-2xl);
    padding: .5rem;
    background: var(--bg-alt, var(--gray-50));
    border-radius: 100px;
    max-width: max-content;
}
.region-tab {
    padding: .625rem 1.25rem;
    border-radius: 100px;
    font-size: .875rem;
    font-weight: 600;
    color: var(--text);
    background: transparent;
    border: 0;
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
}
.region-tab:hover { background: var(--white); }
.region-tab.active { background: var(--red); color: var(--white); box-shadow: var(--shadow-md); }
.region-tab.active:hover { background: var(--red); }
.region-tab .count { opacity: .7; font-weight: 500; }

.hotels-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-xl);
}
@media (max-width: 1000px) { .hotels-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .hotels-grid { grid-template-columns: 1fr; } }

.hotel-card-wrap { display: block; }
.hotel-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: all .3s;
    height: 100%;
}
.hotel-card-wrap:hover .hotel-card {
    border-color: transparent;
    box-shadow: var(--shadow-xl);
    transform: translateY(-4px);
}
.hotel-card-img {
    position: relative;
    aspect-ratio: 16/10;
    overflow: hidden;
    background: linear-gradient(135deg, #2c3e50 0%, #4a6d7c 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}
.hotel-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s;
}
.hotel-card-wrap:hover .hotel-card-img img { transform: scale(1.05); }
.hotel-card-img-placeholder {
    color: var(--white);
    text-align: center;
    padding: 1rem;
    font-weight: 700;
    font-size: 1rem;
    letter-spacing: .03em;
    opacity: .9;
}
.hotel-card-stars {
    position: absolute;
    top: .75rem;
    left: .75rem;
    background: rgba(0,0,0,.65);
    color: #FFD700;
    padding: .25rem .625rem;
    border-radius: 100px;
    font-size: .75rem;
    font-weight: 700;
    backdrop-filter: blur(4px);
    z-index: 2;
}
.hotel-card-region {
    position: absolute;
    top: .75rem;
    right: .75rem;
    background: var(--red);
    color: var(--white);
    padding: .25rem .625rem;
    border-radius: 100px;
    font-size: .75rem;
    font-weight: 600;
    z-index: 2;
}
.hotel-card-body {
    padding: 1.125rem 1.25rem 1.25rem;
    display: flex;
    flex-direction: column;
    gap: .375rem;
    flex: 1;
}
.hotel-card-name {
    font-size: 1.0625rem;
    font-weight: 700;
    margin: 0 0 .125rem;
    color: var(--text);
    line-height: 1.3;
}
.hotel-card-location {
    font-size: .75rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: .35rem;
    margin: 0;
}
.hotel-card-location svg { flex-shrink: 0; opacity: .8; }
.hotel-card-summary {
    font-size: .8125rem;
    color: var(--text-muted);
    line-height: 1.55;
    margin: .25rem 0 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* MICE info — clean inline row, no heavy box */
.hotel-card-mice {
    display: flex;
    flex-wrap: wrap;
    gap: .375rem;
    align-items: center;
    margin-top: auto;
    padding-top: .875rem;
    border-top: 1px dashed var(--border);
}
.hotel-card-rooms {
    display: inline-flex;
    align-items: center;
    gap: .375rem;
    font-size: .8125rem;
    color: var(--text);
    font-weight: 600;
    padding-right: .5rem;
    margin-right: .125rem;
    border-right: 1px solid var(--border);
    white-space: nowrap;
}
.hotel-card-rooms svg { color: var(--red); flex-shrink: 0; }
.hotel-card-rooms strong { font-weight: 700; color: var(--text); }
.hotel-card-event-type {
    font-size: .6875rem;
    padding: .25rem .5rem;
    background: var(--gray-50, #F8FAFC);
    color: var(--gray-700, #334155);
    border: 1px solid var(--border);
    border-radius: 100px;
    font-weight: 600;
    line-height: 1.2;
    white-space: nowrap;
    letter-spacing: .01em;
}
.hotel-card-event-extra {
    font-size: .6875rem;
    padding: .25rem .5rem;
    background: var(--gray-100);
    color: var(--text-muted);
    border-radius: 100px;
    font-weight: 700;
    line-height: 1.2;
}

/* Features hidden in card view — too cluttered, shown on detail page */
.hotel-card-features { display: none; }

.hotel-card-link {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    color: var(--red);
    font-weight: 700;
    font-size: .8125rem;
    margin-top: .875rem;
    padding-top: .875rem;
    border-top: 1px solid var(--border);
    transition: gap .2s;
}
.hotel-card-link::after {
    content: '→';
    transition: transform .25s;
}
.hotel-card-wrap:hover .hotel-card-link::after {
    transform: translateX(4px);
}
.hotel-card-wrap:hover .hotel-card-link { gap: .5rem; }

.empty-state {
    text-align: center;
    padding: var(--space-3xl) var(--space-xl);
    color: var(--text-muted);
    background: var(--gray-50);
    border-radius: var(--radius-lg);
    font-size: 1.0625rem;
}
</style>
