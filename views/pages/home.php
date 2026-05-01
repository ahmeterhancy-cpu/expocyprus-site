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
<section class="section section-fairs bg-light" id="fuarlarimiz">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?= __('home.fairs_title') ?></h2>
            <p class="section-subtitle"><?= __('home.fairs_subtitle') ?></p>
        </div>
        <div class="fairs-grid">
            <?php foreach ($fairs as $f):
                $name = lang() === 'en' ? $f['name_en'] : $f['name_tr'];
                $summary = lang() === 'en' ? $f['summary_en'] : $f['summary_tr'];
            ?>
            <article class="fair-card">
                <div class="fair-card-img">
                    <?php if ($f['image_hero']): ?>
                        <img src="<?= e($f['image_hero']) ?>" alt="<?= e($name) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="fair-card-img-placeholder"></div>
                    <?php endif; ?>
                    <div class="fair-card-overlay"></div>
                </div>
                <div class="fair-card-body">
                    <h3 class="fair-card-title"><?= e($name) ?></h3>
                    <p class="fair-card-summary"><?= e($summary) ?></p>
                    <?php if ($f['next_date']): ?>
                        <p class="fair-card-date">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <?= date('d.m.Y', strtotime($f['next_date'])) ?>
                        </p>
                    <?php endif; ?>
                    <a href="<?= url('fuarlarimiz/' . $f['slug']) ?>" class="fair-card-link"><?= __('common.details') ?> →</a>
                </div>
            </article>
            <?php endforeach; ?>

            <?php if (empty($fairs)):
                $fPlaceholders = [
                    ['n'=>'Tüketici Fuarı','s'=>'Tüm Sektörler. Tek Çatı Altında.','slug'=>'tuketici-fuari'],
                    ['n'=>'Av, Avcılık & Doğa Sporları Fuarı','s'=>'Kıbrıs\'ın Tek İhtisas Fuarı.','slug'=>'av-avcilik-atis-doga-sporlari-fuari'],
                    ['n'=>'Tarım Hayvancılık Fuarı','s'=>'Kıbrıs Tarımının Buluşma Noktası.','slug'=>'tarim-hayvancilik-fuari'],
                    ['n'=>'Evlilik & Düğün Hazırlıkları Fuarı','s'=>'Hayallerinizdeki Düğün için Tüm Sektör Burada.','slug'=>'dugun-hazirliklari-fuari'],
                ];
                foreach ($fPlaceholders as $fp):
            ?>
            <article class="fair-card">
                <div class="fair-card-img"><div class="fair-card-img-placeholder"></div><div class="fair-card-overlay"></div></div>
                <div class="fair-card-body">
                    <h3 class="fair-card-title"><?= $fp['n'] ?></h3>
                    <p class="fair-card-summary"><?= $fp['s'] ?></p>
                    <a href="<?= url('fuarlarimiz/' . $fp['slug']) ?>" class="fair-card-link">Detaylar →</a>
                </div>
            </article>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

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
