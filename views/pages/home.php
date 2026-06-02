<?php
$pageTitle       = cms('home', 'meta_title') ?: (lang() === 'en'
    ? 'Expo Cyprus | Fair, Congress & Stand Organisation in Cyprus | UNIFEX'
    : 'Expo Cyprus | Kıbrıs\'ta Fuar, Kongre ve Stand Organizasyonu | UNIFEX');
$metaDescription = cms('home', 'meta_description') ?: (lang() === 'en'
    ? '22 years of experience in Cyprus. Fair organisation, congress, stand design, hostess and PR services all in one. Nicosia-based, 100+ stand installations.'
    : 'Kıbrıs\'ta 22 yıllık deneyim. Fuar organizasyonu, kongre, stand tasarımı, hostes ve PR hizmetleri tek noktadan. Lefkoşa merkezli, 100\'ü aşkın stand kurulumu.');
$cmsKw = cms('home', 'meta_keywords');
$bodyClass = 'page-home';
$keywords = $cmsKw
    ? array_filter(array_map('trim', explode(',', $cmsKw)))
    : (lang() === 'en'
        ? ['fair organisation Cyprus', 'congress Cyprus', 'stand design', 'UNIFEX', 'Expo Cyprus', 'exhibition Cyprus', 'trade show', 'event organisation']
        : ['fuar organizasyonu', 'kongre Kıbrıs', 'stand tasarım', 'UNIFEX Fuarcılık', 'Expo Cyprus', 'KKTC fuar', 'etkinlik organizasyonu']);
$breadcrumb = [['name' => lang() === 'en' ? 'Home' : 'Anasayfa', 'url' => '/']];
$structured = [
    [
        '@type' => 'LocalBusiness',
        '@id'   => rtrim(env('APP_URL',''),'/') . '/#organization',
        'name'  => 'Expo Cyprus',
        'description' => $metaDescription,
        'url'   => env('APP_URL', ''),
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Lefkoşa',
            'addressRegion' => 'Kuzey Kıbrıs',
            'addressCountry' => 'CY',
        ],
        'priceRange' => '€€',
        'image' => rtrim(env('APP_URL',''),'/') . '/assets/images/hero-hall.webp',
        'aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => '4.9',
            'reviewCount' => '120',
        ],
    ],
];
?>

<!-- ═══════════════════════════════════════════════════════════════
     SECTION 1 — HERO
═══════════════════════════════════════════════════════════════ -->
<section class="hero" id="hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="hero-overlay"></div>
        <video autoplay muted loop playsinline poster="<?= asset('images/hero-hall.png') ?>">
            <source src="<?= asset('images/hero-video.mp4') ?>" type="video/mp4">
        </video>
    </div>
    <div class="container">
        <div class="hero-content">
            <span class="hero-kicker"><?= __('home.hero_kicker') ?></span>
            <h1 class="hero-title"><?= __('home.hero_title') ?></h1>
            <p class="hero-subtitle"><?= __('home.hero_subtitle') ?></p>
            <div class="hero-ctas">
                <a href="<?= url('teklif-al') ?>" class="btn btn-primary btn-lg">
                    <?= __('home.hero_cta_primary') ?> <span aria-hidden="true">→</span>
                </a>
                <a href="<?= url('hizmetler') ?>" class="btn btn-outline-white btn-lg">
                    <?= __('home.hero_cta_secondary') ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Trust Bar -->
    <div class="trust-bar">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-item">
                    <span class="trust-num">22+</span>
                    <span class="trust-label"><?= __('home.trust_years') ?></span>
                </div>
                <div class="trust-item">
                    <span class="trust-num">4</span>
                    <span class="trust-label"><?= __('home.trust_fairs') ?></span>
                </div>
                <div class="trust-item">
                    <span class="trust-num">100+</span>
                    <span class="trust-label"><?= __('home.trust_stands') ?></span>
                </div>
                <div class="trust-item">
                    <span class="trust-num">10+</span>
                    <span class="trust-label"><?= __('home.trust_congress') ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     SECTION 2 — HİZMETLER (6 Kart)
═══════════════════════════════════════════════════════════════ -->
<section class="section section-services" id="hizmetler">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?= __('home.services_title') ?></h2>
            <p class="section-subtitle"><?= __('home.services_subtitle') ?></p>
        </div>
        <div class="services-grid">
            <?php foreach ($services as $s):
                $title = lang() === 'en' ? $s['title_en'] : $s['title_tr'];
                $summary = lang() === 'en' ? $s['summary_en'] : $s['summary_tr'];
            ?>
            <article class="service-card">
                <?php if ($s['image']): ?>
                <div class="service-card-img">
                    <img src="<?= e($s['image']) ?>" alt="<?= e($title) ?>" loading="lazy">
                </div>
                <?php endif; ?>
                <div class="service-card-body">
                    <h3 class="service-card-title"><?= e($title) ?></h3>
                    <p class="service-card-text"><?= e($summary) ?></p>
                    <a href="<?= url('hizmetler/' . $s['slug']) ?>" class="service-card-link">
                        <?= __('common.learn_more') ?> <span aria-hidden="true">→</span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>

            <?php if (empty($services)): ?>
            <!-- Placeholder hizmet kartları (DB boşken görüntülenir) -->
            <?php $placeholders = [
                ['icon'=>'🎪','t'=>'Fuar Organizasyonu','s'=>'Kendi sektörel fuarlarımızı düzenleriz. Sizin fuarınızı da konseptten kuruluma A\'dan Z\'ye yönetiriz.','slug'=>'fuar-organizasyonu'],
                ['icon'=>'🎙️','t'=>'Kongre Organizasyonu','s'=>'Akademik, tıbbi, kurumsal kongreler. Konuşmacı yönetiminden sosyal programa, tüm operasyon bizden.','slug'=>'kongre-organizasyonu'],
                ['icon'=>'🏗️','t'=>'Stand Tasarım & Kurulum','s'=>'İç teknik ekibimizle 100+ stand kurulumu deneyimi. Modüler, özel yapım veya hibrit — markanıza özel tasarım.','slug'=>'stand-tasarim-kurulum'],
                ['icon'=>'🧭','t'=>'Fuar Katılım Danışmanlığı','s'=>'Fuara hazırlıksız gitmeyin. Stratejiden ROI hesabına, hazırlıktan sonrası takibe — yanınızdayız.','slug'=>'fuar-katilim-danismanligi'],
                ['icon'=>'👤','t'=>'Hostes & Stand Görevlisi','s'=>'Eğitimli, profesyonel saha kadrosu. Karşılamadan demoya, ürün tanıtımından lead toplamaya.','slug'=>'hostes-stand-gorevlisi'],
                ['icon'=>'📢','t'=>'PR & Tanıtım','s'=>'Etkinlik öncesi-sırası-sonrası iletişim yönetimi. Basın bülteninden sosyal medyaya, tek elden.','slug'=>'pr-tanitim'],
            ]; foreach ($placeholders as $p): ?>
            <article class="service-card">
                <div class="service-card-body">
                    <div class="service-card-icon"><span style="font-size:2rem"><?= $p['icon'] ?></span></div>
                    <h3 class="service-card-title"><?= $p['t'] ?></h3>
                    <p class="service-card-text"><?= $p['s'] ?></p>
                    <a href="<?= url('hizmetler/' . $p['slug']) ?>" class="service-card-link">Detaylı Bilgi <span aria-hidden="true">→</span></a>
                </div>
            </article>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     SECTION 3 — FUARLARIMIZ (4 Kart)
═══════════════════════════════════════════════════════════════ -->
<?php
// Sadece Av/Atıcılık fuarını öne çıkar (homepage feature)
$featured = null;
foreach ($fairs as $f) {
    if (($f['slug'] ?? '') === 'av-avcilik-atis-doga-sporlari-fuari') {
        $featured = $f;
        break;
    }
}
// DB'den çekemediyse hardcoded fallback
if (!$featured) {
    $featured = [
        'slug'        => 'av-avcilik-atis-doga-sporlari-fuari',
        'name_tr'     => 'KKTC Av, Atıcılık, Balıkçılık, Doğa Sporları ve Kamp Malzemeleri Fuarı',
        'name_en'     => 'TRNC Hunting, Shooting, Fishing, Outdoor Sports and Camping Equipment Fair',
        'summary_tr'  => 'Doğanın Tutkusunu Keşfet! 2–4 Ekim 2026 tarihleri arasında Eski Ercan Havalimanı\'nda Kıbrıs\'ın en kapsamlı doğa fuarı. Açık havada doğanın tutkusunu yaşamak isteyenler ve sektör profesyonelleri için kaçırılmayacak bir buluşma.',
        'summary_en'  => "Discover Nature's Passion! October 2–4, 2026 at Old Ercan Airport — TRNC's most comprehensive outdoor fair. An unmissable gathering for outdoor enthusiasts and industry professionals.",
        'next_date'   => '2026-10-02',
        'end_date'    => '2026-10-04',
        'location'    => 'Eski Ercan Havalimanı, KKTC',
        'image_hero'  => '/uploads/fairs/av-fuari-2026-poster.jpg',
    ];
}
$fName    = lang()==='en' ? ($featured['name_en'] ?? $featured['name_tr']) : $featured['name_tr'];
$fSummary = lang()==='en' ? ($featured['summary_en'] ?? $featured['summary_tr']) : ($featured['summary_tr'] ?? '');
$fStart   = !empty($featured['next_date']) ? strtotime($featured['next_date']) : null;
$fEnd     = !empty($featured['end_date'])  ? strtotime($featured['end_date'])  : $fStart;
$fEyebrow = null;
if ($fStart) {
    $months = lang()==='en'
        ? ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC']
        : ['OCAK','ŞUBAT','MART','NİSAN','MAYIS','HAZİRAN','TEMMUZ','AĞUSTOS','EYLÜL','EKİM','KASIM','ARALIK'];
    $mo = $months[(int)date('n', $fStart) - 1];
    if ($fEnd && date('Y-m', $fStart) === date('Y-m', $fEnd)) {
        $fEyebrow = date('j', $fStart).'–'.date('j', $fEnd).' '.$mo.' '.date('Y', $fStart);
    } else {
        $fEyebrow = date('j', $fStart).' '.$mo.' '.date('Y', $fStart);
    }
}
?>
<section class="section section-featured-fair bg-light" id="fuarlarimiz">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?= lang()==='en' ? 'Our Featured Fair' : 'Öne Çıkan Fuarımız' ?></h2>
            <p class="section-subtitle"><?= lang()==='en'
                ? 'A sector-specific fair we organise — under one roof.'
                : 'Kendi düzenlediğimiz sektörel fuar — tek çatı altında.' ?></p>
        </div>

        <a href="<?= url('fuarlarimiz/' . $featured['slug']) ?>" class="featured-fair-card">
            <div class="featured-fair-image">
                <?php if (!empty($featured['image_hero'])): ?>
                    <img src="<?= e($featured['image_hero']) ?>" alt="<?= e($fName) ?>" loading="lazy">
                <?php endif; ?>
                <div class="featured-fair-image-overlay"></div>
                <?php if ($fEyebrow): ?>
                <span class="featured-fair-badge"><?= e($fEyebrow) ?></span>
                <?php endif; ?>
            </div>
            <div class="featured-fair-body">
                <h3 class="featured-fair-title"><?= e($fName) ?></h3>
                <?php if ($fSummary): ?>
                <p class="featured-fair-summary"><?= e(mb_substr($fSummary, 0, 240)) ?></p>
                <?php endif; ?>
                <div class="featured-fair-meta">
                    <?php if ($fStart): ?>
                    <span class="featured-fair-meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <?= date('d.m.Y', $fStart) ?><?php if ($fEnd && $fEnd !== $fStart): ?> – <?= date('d.m.Y', $fEnd) ?><?php endif; ?>
                    </span>
                    <?php endif; ?>
                    <?php if (!empty($featured['location'])): ?>
                    <span class="featured-fair-meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        <?= e($featured['location']) ?>
                    </span>
                    <?php endif; ?>
                </div>
                <span class="featured-fair-cta">
                    <?= lang()==='en' ? 'Fair Details' : 'Fuar Detayları' ?>
                    <span aria-hidden="true">→</span>
                </span>
            </div>
        </a>
    </div>
</section>

<style>
.section-featured-fair { padding: clamp(4rem, 8vw, 7rem) 0; }
.featured-fair-card {
    display: grid; grid-template-columns: 1.1fr 1fr;
    gap: 0; max-width: 1180px; margin: 3rem auto 0;
    background: var(--white, #fff);
    border-radius: 28px; overflow: hidden;
    box-shadow: 0 30px 80px rgba(0,0,0,.08);
    text-decoration: none; color: inherit;
    transition: transform .35s cubic-bezier(.2,.7,.2,1), box-shadow .35s;
}
.featured-fair-card:hover { transform: translateY(-6px); box-shadow: 0 40px 100px rgba(0,0,0,.12); color: inherit; }
.featured-fair-image {
    position: relative;
    aspect-ratio: 3/4;
    background: linear-gradient(135deg, #1d1d1f 0%, #0a0a0a 100%);
    overflow: hidden;
}
.featured-fair-image img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .8s cubic-bezier(.2,.7,.2,1);
}
.featured-fair-card:hover .featured-fair-image img { transform: scale(1.04); }
.featured-fair-image-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,.15) 70%, rgba(0,0,0,.4) 100%);
}
.featured-fair-badge {
    position: absolute; top: 1.5rem; left: 1.5rem;
    background: rgba(227,6,19,.95); color: #fff;
    padding: .5rem 1rem; border-radius: 100px;
    font-size: .75rem; font-weight: 800;
    letter-spacing: .12em;
    backdrop-filter: blur(10px);
    box-shadow: 0 10px 30px rgba(227,6,19,.35);
}
.featured-fair-body {
    padding: clamp(2rem, 5vw, 3.5rem);
    display: flex; flex-direction: column; justify-content: center;
}
.featured-fair-title {
    font-size: clamp(1.5rem, 3vw, 2.25rem);
    font-weight: 800; letter-spacing: -.025em;
    color: var(--text, #1d1d1f);
    line-height: 1.15; margin: 0 0 1rem;
}
.featured-fair-summary {
    font-size: 1.0625rem;
    color: var(--text-muted, #6e6e73);
    line-height: 1.65;
    margin: 0 0 1.75rem;
}
.featured-fair-meta {
    display: flex; flex-wrap: wrap; gap: 1.25rem;
    padding: 1rem 0 1.5rem;
    border-top: 1px solid var(--border, #e5e5e7);
    border-bottom: 1px solid var(--border, #e5e5e7);
    margin-bottom: 1.75rem;
}
.featured-fair-meta-item {
    display: inline-flex; align-items: center; gap: .5rem;
    font-size: .9rem; color: var(--text, #1d1d1f); font-weight: 500;
}
.featured-fair-meta-item svg { color: var(--red, #E30613); flex-shrink: 0; }
.featured-fair-cta {
    display: inline-flex; align-items: center; gap: .5rem;
    align-self: flex-start;
    background: var(--red, #E30613); color: #fff;
    padding: 1rem 2rem; border-radius: 980px;
    font-size: 1rem; font-weight: 600;
    transition: transform .25s, box-shadow .25s;
}
.featured-fair-card:hover .featured-fair-cta {
    transform: translateX(4px);
    box-shadow: 0 12px 30px -8px rgba(227,6,19,.5);
}
@media (max-width: 900px) {
    .featured-fair-card { grid-template-columns: 1fr; }
    .featured-fair-image { aspect-ratio: 4/5; }
}
</style>

<!-- ═══════════════════════════════════════════════════════════════
     SECTION 4 — NEDEN EXPO CYPRUS?
═══════════════════════════════════════════════════════════════ -->
<section class="section section-why">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?= __('home.why_title') ?></h2>
        </div>
        <div class="why-grid">
            <div class="why-item">
                <div class="why-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                </div>
                <h3><?= __('home.why_1_title') ?></h3>
                <p><?= __('home.why_1_text') ?></p>
            </div>
            <div class="why-item">
                <div class="why-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                </div>
                <h3><?= __('home.why_2_title') ?></h3>
                <p><?= __('home.why_2_text') ?></p>
            </div>
            <div class="why-item">
                <div class="why-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <h3><?= __('home.why_3_title') ?></h3>
                <p><?= __('home.why_3_text') ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     SECTION 5 — SAYILARLA EXPO CYPRUS
═══════════════════════════════════════════════════════════════ -->
<section class="section section-stats bg-dark">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title text-white"><?= __('home.stats_title') ?></h2>
        </div>
        <div class="stats-grid">
            <?php $statsData = [
                ['num' => '22+', 'label' => __('home.trust_years')],
                ['num' => '4',   'label' => __('home.trust_fairs')],
                ['num' => '100+','label' => __('home.trust_stands')],
                ['num' => '10+', 'label' => __('home.trust_congress')],
                ['num' => '50K+','label' => __('home.stat_visitors')],
                ['num' => '1',   'label' => __('home.stat_contact')],
            ];
            foreach ($statsData as $st): ?>
            <div class="stat-item" data-animate="counter">
                <span class="stat-num"><?= e($st['num']) ?></span>
                <span class="stat-label"><?= e($st['label']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     SECTION 6 — BLOG / HABERLER
═══════════════════════════════════════════════════════════════ -->
<?php if (!empty($posts)): ?>
<section class="section section-blog bg-light">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?= __('home.blog_title') ?></h2>
            <a href="<?= url('blog') ?>" class="section-link"><?= __('home.blog_all') ?> →</a>
        </div>
        <div class="blog-grid">
            <?php foreach ($posts as $post): ?>
            <article class="blog-card">
                <?php if ($post['image']): ?>
                <a href="<?= url('blog/' . $post['slug']) ?>" class="blog-card-img-wrap">
                    <img src="<?= e($post['image']) ?>" alt="<?= e($post['title']) ?>" loading="lazy">
                </a>
                <?php endif; ?>
                <div class="blog-card-body">
                    <time class="blog-card-date" datetime="<?= date('Y-m-d', strtotime($post['published_at'])) ?>">
                        <?= date('d.m.Y', strtotime($post['published_at'])) ?>
                    </time>
                    <h3 class="blog-card-title">
                        <a href="<?= url('blog/' . $post['slug']) ?>"><?= e($post['title']) ?></a>
                    </h3>
                    <p class="blog-card-excerpt"><?= e(mb_substr(strip_tags($post['content'] ?? ''), 0, 120)) ?>...</p>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════════
     SECTION 7 — ALT CTA BANNER
═══════════════════════════════════════════════════════════════ -->
<section class="section-cta-banner">
    <div class="container">
        <h2 class="cta-banner-title"><?= __('home.cta_banner_title') ?></h2>
        <p class="cta-banner-text"><?= __('home.cta_banner_text') ?></p>
        <div class="cta-banner-actions">
            <a href="<?= url('teklif-al') ?>" class="btn btn-white btn-lg">
                <?= __('home.hero_cta_primary') ?> <span aria-hidden="true">→</span>
            </a>
            <a href="tel:<?= preg_replace('/\s+/', '', config('app.brand.phone')) ?>" class="btn btn-outline-white btn-lg">
                <?= __('home.cta_call') ?>: <?= e(config('app.brand.phone')) ?>
            </a>
        </div>
    </div>
</section>
