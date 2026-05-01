<?php
$title   = lang() === 'en' ? ($service['title_en'] ?? $service['title_tr']) : $service['title_tr'];
$summary = lang() === 'en' ? ($service['summary_en'] ?? $service['summary_tr']) : $service['summary_tr'];
$content = lang() === 'en' ? ($service['content_en'] ?? $service['content_tr'] ?? '') : ($service['content_tr'] ?? '');

$pageTitle       = e($title) . ' | Expo Cyprus';
$metaDescription = e(mb_substr(strip_tags($summary), 0, 160));
$bodyClass       = 'page-service-detail';

// ─── Per-service curated metadata (Apple-style hero, stats, accent, gallery) ──
$slug = $service['slug'] ?? '';
$meta = [
    'fuar-organizasyonu' => [
        'eyebrow_tr' => 'FUAR ORGANİZASYONU',
        'eyebrow_en' => 'FAIR ORGANISATION',
        'tagline_tr' => 'Konseptten kapanışa.',
        'tagline_en' => 'From concept to close.',
        'subline_tr' => 'Tek bir partner. Tüm operasyon. 22 yılın özgüveniyle.',
        'subline_en' => 'One partner. The full operation. With 22 years of confidence.',
        'accent'     => '#E30613',
        'hero'       => '/assets/images/service-fair-org.webp',
        'showcase'   => '/assets/images/hero-hall.webp',
        'stats' => [
            ['num' => '22+', 'tr' => 'Yıllık Tecrübe',     'en' => 'Years Experience'],
            ['num' => '4',   'tr' => 'Kendi Fuarımız',     'en' => 'Own Fairs'],
            ['num' => '50K+','tr' => 'Yıllık Ziyaretçi',   'en' => 'Annual Visitors'],
            ['num' => '100+','tr' => 'Yönetilen Etkinlik', 'en' => 'Events Managed'],
        ],
    ],
    'kongre-organizasyonu' => [
        'eyebrow_tr' => 'KONGRE ORGANİZASYONU',
        'eyebrow_en' => 'CONGRESS ORGANISATION',
        'tagline_tr' => 'Bilim sahnede.',
        'tagline_en' => 'Science on stage.',
        'subline_tr' => 'Akademik, tıbbi, kurumsal — her ölçekte kongre operasyonu.',
        'subline_en' => 'Academic, medical, corporate — congress operations at every scale.',
        'accent'     => '#0066CC',
        'hero'       => '/assets/images/service-fair-org.webp',
        'showcase'   => '/assets/images/hotels-conference.webp',
        'stats' => [
            ['num' => '10+',  'tr' => 'Uluslararası Kongre', 'en' => 'Int\'l Congresses'],
            ['num' => '1500', 'tr' => 'Maks. Katılımcı',    'en' => 'Max Attendees'],
            ['num' => '5',    'tr' => 'Çalışma Dili',        'en' => 'Languages'],
            ['num' => '24/7', 'tr' => 'Bilim Sekreteryası',  'en' => 'Sci. Secretariat'],
        ],
    ],
    'stand-tasarim-kurulum' => [
        'eyebrow_tr' => 'STAND TASARIM & KURULUM',
        'eyebrow_en' => 'STAND DESIGN & BUILD',
        'tagline_tr' => 'Markanız. Sahnede.',
        'tagline_en' => 'Your brand. On stage.',
        'subline_tr' => '3D tasarımdan saha kurulumuna — kendi atölyemizde, kendi ekibimizle.',
        'subline_en' => 'From 3D design to on-site build — in our workshop, with our team.',
        'accent'     => '#FF6B35',
        'hero'       => '/assets/images/service-stand-design.webp',
        'showcase'   => '/assets/images/stand-models',
        'stats' => [
            ['num' => '100+', 'tr' => 'Stand Kurulumu',  'en' => 'Stands Built'],
            ['num' => '800', 'tr' => 'm² Atölye',        'en' => 'm² Workshop'],
            ['num' => '15',  'tr' => 'Gün Üretim Süresi', 'en' => 'Days to Produce'],
            ['num' => '24/7','tr' => 'Saha Desteği',     'en' => 'On-Site Support'],
        ],
    ],
    'fuar-katilim-danismanligi' => [
        'eyebrow_tr' => 'FUAR KATILIM DANIŞMANLIĞI',
        'eyebrow_en' => 'EXHIBITOR CONSULTING',
        'tagline_tr' => 'Fuara değil, dönüşüme git.',
        'tagline_en' => 'Don\'t attend. Convert.',
        'subline_tr' => 'Stratejiden ROI raporuna — fuarı yatırıma çeviriyoruz.',
        'subline_en' => 'From strategy to ROI report — turning the fair into a real investment.',
        'accent'     => '#00875A',
        'hero'       => '/assets/images/service-consulting.webp',
        'showcase'   => '/assets/images/service-cyprus.webp',
        'stats' => [
            ['num' => '+35%','tr' => 'Daha Fazla Lead',   'en' => 'More Leads'],
            ['num' => '3×',  'tr' => 'Dönüşüm Artışı',    'en' => 'Conversion Lift'],
            ['num' => '20%', 'tr' => 'Maliyet Tasarrufu', 'en' => 'Cost Saving'],
            ['num' => '90',  'tr' => 'Gün Takip Raporu',  'en' => 'Day Follow-up'],
        ],
    ],
    'hostes-stand-gorevlisi' => [
        'eyebrow_tr' => 'HOSTES & STAND GÖREVLİSİ',
        'eyebrow_en' => 'HOSTESS & STAND STAFF',
        'tagline_tr' => 'Standınızın yüzü.',
        'tagline_en' => 'The face of your stand.',
        'subline_tr' => 'Eğitimli, çok dilli, sektör tecrübeli profesyonel saha kadrosu.',
        'subline_en' => 'Trained, multilingual, sector-experienced professional field staff.',
        'accent'     => '#9333EA',
        'hero'       => '/assets/images/service-logistics.webp',
        'showcase'   => '/assets/images/about-team.webp',
        'stats' => [
            ['num' => '5',    'tr' => 'Dil Seçeneği',       'en' => 'Language Options'],
            ['num' => '2',    'tr' => 'Aşamalı Eğitim',     'en' => 'Stage Training'],
            ['num' => '100%', 'tr' => 'Yedek Garantisi',    'en' => 'Backup Guarantee'],
            ['num' => '24/7', 'tr' => 'Operasyon Desteği',  'en' => 'Ops Support'],
        ],
    ],
    'pr-tanitim' => [
        'eyebrow_tr' => 'PR & TANITIM',
        'eyebrow_en' => 'PR & PROMOTION',
        'tagline_tr' => 'Görünür ol. Hatırlan.',
        'tagline_en' => 'Be seen. Be remembered.',
        'subline_tr' => 'Etkinlik öncesi, sırasında ve sonrası — 360° iletişim yönetimi.',
        'subline_en' => 'Before, during and after — 360° communications management.',
        'accent'     => '#EC4899',
        'hero'       => '/assets/images/service-digital.webp',
        'showcase'   => '/assets/images/service-cyprus.webp',
        'stats' => [
            ['num' => '5',    'tr' => 'Hizmet Kategorisi',   'en' => 'Service Categories'],
            ['num' => '1M+',  'tr' => 'Reach Hedefi',       'en' => 'Reach Target'],
            ['num' => '12',   'tr' => 'Hafta Kampanya',     'en' => 'Week Campaign'],
            ['num' => 'TR/EN','tr' => 'İçerik Dilleri',     'en' => 'Content Languages'],
        ],
    ],
];
$m = $meta[$slug] ?? [
    'eyebrow_tr' => 'HİZMET',
    'eyebrow_en' => 'SERVICE',
    'tagline_tr' => $title,
    'tagline_en' => $title,
    'subline_tr' => $summary,
    'subline_en' => $summary,
    'accent'     => '#E30613',
    'hero'       => $service['image'] ?? '/assets/images/hero-hall.webp',
    'showcase'   => '/assets/images/hero-hall.webp',
    'stats'      => [],
];

// ── DB'den gelen Apple-style alanları, hardcoded $meta'yı override eder ──
if (!empty($service['hero_eyebrow_tr']))  $m['eyebrow_tr'] = $service['hero_eyebrow_tr'];
if (!empty($service['hero_eyebrow_en']))  $m['eyebrow_en'] = $service['hero_eyebrow_en'];
if (!empty($service['hero_tagline_tr']))  $m['tagline_tr'] = $service['hero_tagline_tr'];
if (!empty($service['hero_tagline_en']))  $m['tagline_en'] = $service['hero_tagline_en'];
if (!empty($service['hero_subline_tr']))  $m['subline_tr'] = $service['hero_subline_tr'];
if (!empty($service['hero_subline_en']))  $m['subline_en'] = $service['hero_subline_en'];
if (!empty($service['accent_color']))     $m['accent']     = $service['accent_color'];
if (!empty($service['image']))            $m['hero']       = $service['image'];
if (!empty($service['showcase_image']))   $m['showcase']   = $service['showcase_image'];
if (!empty($service['stats_json'])) {
    $dec = json_decode((string)$service['stats_json'], true);
    if (is_array($dec) && !empty($dec)) $m['stats'] = $dec;
}
$accent  = $m['accent'];
$eyebrow = lang() === 'en' ? $m['eyebrow_en'] : $m['eyebrow_tr'];
$tagline = lang() === 'en' ? $m['tagline_en'] : $m['tagline_tr'];
$subline = lang() === 'en' ? $m['subline_en'] : $m['subline_tr'];

$otherServices = [
    ['slug' => 'fuar-organizasyonu',     'tr' => 'Fuar Organizasyonu',     'en' => 'Fair Organisation'],
    ['slug' => 'kongre-organizasyonu',   'tr' => 'Kongre Organizasyonu',   'en' => 'Congress Organisation'],
    ['slug' => 'stand-tasarim-kurulum',  'tr' => 'Stand Tasarım & Kurulum','en' => 'Stand Design & Build'],
    ['slug' => 'fuar-katilim-danismanligi','tr' => 'Fuar Katılım Danışmanlığı','en' => 'Exhibitor Consulting'],
    ['slug' => 'hostes-stand-gorevlisi', 'tr' => 'Hostes & Stand Görevlisi','en' => 'Hostess & Stand Staff'],
    ['slug' => 'pr-tanitim',             'tr' => 'PR & Tanıtım',           'en' => 'PR & Promotion'],
];
?>

<!-- ═══════════════════════════════════════════════════════════════
     CINEMATIC HERO — Apple-style full-bleed
═══════════════════════════════════════════════════════════════ -->
<section class="sd-hero" style="--accent: <?= e($accent) ?>;">
    <div class="sd-hero-bg" style="background-image: url('<?= e($m['hero']) ?>');"></div>
    <div class="sd-hero-overlay"></div>

    <div class="sd-hero-content">
        <nav class="sd-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span>›</span>
            <a href="<?= url('hizmetler') ?>"><?= lang() === 'en' ? 'Services' : 'Hizmetler' ?></a>
        </nav>
        <span class="sd-eyebrow"><?= e($eyebrow) ?></span>
        <h1 class="sd-hero-title"><?= e($tagline) ?></h1>
        <p class="sd-hero-sub"><?= e($subline) ?></p>
        <div class="sd-hero-cta">
            <a href="<?= url('teklif-al') ?>" class="sd-btn sd-btn-primary">
                <?= lang() === 'en' ? 'Start a project' : 'Projeyi başlat' ?>
                <span aria-hidden="true">→</span>
            </a>
            <a href="#sd-overview" class="sd-btn sd-btn-ghost">
                <?= lang() === 'en' ? 'Discover more' : 'Keşfet' ?>
                <span aria-hidden="true">↓</span>
            </a>
        </div>
    </div>

    <div class="sd-hero-scroll" aria-hidden="true">
        <span class="sd-hero-scroll-line"></span>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     OVERVIEW — Big lead statement (Apple Pro pages style)
═══════════════════════════════════════════════════════════════ -->
<section id="sd-overview" class="sd-section sd-overview" style="--accent: <?= e($accent) ?>;">
    <div class="sd-container">
        <span class="sd-section-eyebrow" data-reveal>
            <?= lang() === 'en' ? 'OVERVIEW' : 'GENEL BAKIŞ' ?>
        </span>
        <h2 class="sd-overview-title" data-reveal>
            <?= e($title) ?>.<br>
            <span class="sd-overview-title-mute"><?= e($summary) ?></span>
        </h2>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     STATS BAND — Massive numbers (Apple specs style)
═══════════════════════════════════════════════════════════════ -->
<?php if (!empty($m['stats'])): ?>
<section class="sd-section sd-stats" style="--accent: <?= e($accent) ?>;">
    <div class="sd-container">
        <div class="sd-stats-grid">
            <?php foreach ($m['stats'] as $i => $stat): ?>
            <div class="sd-stat" data-reveal style="--reveal-delay: <?= $i * 80 ?>ms;">
                <div class="sd-stat-num"><?= e($stat['num']) ?></div>
                <div class="sd-stat-label">
                    <?= e(lang() === 'en' ? $stat['en'] : $stat['tr']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════════
     PARALLAX SHOWCASE — Full-bleed image break
═══════════════════════════════════════════════════════════════ -->
<section class="sd-showcase" data-parallax>
    <div class="sd-showcase-img" style="background-image: url('<?= e($m['showcase']) ?>');"></div>
    <div class="sd-showcase-overlay">
        <div class="sd-container">
            <h3 class="sd-showcase-text" data-reveal>
                <?= lang() === 'en'
                    ? 'Crafted with detail. Delivered with discipline.'
                    : 'Detayla işlenmiş. Disiplinle teslim edilmiş.' ?>
            </h3>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     RICH CONTENT — Apple-style prose
═══════════════════════════════════════════════════════════════ -->
<section class="sd-section sd-content" style="--accent: <?= e($accent) ?>;">
    <div class="sd-container sd-container-narrow">
        <div class="sd-prose" data-reveal>
            <?= $content ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     CTA — Bold full-screen call-to-action
═══════════════════════════════════════════════════════════════ -->
<section class="sd-cta" style="--accent: <?= e($accent) ?>;">
    <div class="sd-container">
        <h2 class="sd-cta-title" data-reveal>
            <?= lang() === 'en'
                ? 'Ready to make it happen?'
                : 'Hazır mısınız?' ?>
        </h2>
        <p class="sd-cta-sub" data-reveal>
            <?= lang() === 'en'
                ? '24-hour response. Tailored proposal. No commitment.'
                : '24 saatte dönüş. Özel teklif. Bağlayıcılık yok.' ?>
        </p>
        <div class="sd-cta-actions" data-reveal>
            <a href="<?= url('teklif-al') ?>" class="sd-btn sd-btn-primary sd-btn-lg">
                <?= lang() === 'en' ? 'Request a Quote' : 'Teklif İste' ?>
                <span aria-hidden="true">→</span>
            </a>
            <a href="<?= url('iletisim') ?>" class="sd-btn sd-btn-ghost sd-btn-lg">
                <?= lang() === 'en' ? 'Contact us' : 'İletişime geç' ?>
            </a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     OTHER SERVICES — Horizontal scroll showcase
═══════════════════════════════════════════════════════════════ -->
<section class="sd-section sd-others">
    <div class="sd-container">
        <span class="sd-section-eyebrow" data-reveal>
            <?= lang() === 'en' ? 'EXPLORE' : 'KEŞFEDİN' ?>
        </span>
        <h2 class="sd-others-title" data-reveal>
            <?= lang() === 'en' ? 'Other Services' : 'Diğer Hizmetler' ?>
        </h2>

        <div class="sd-others-grid">
            <?php
            foreach ($otherServices as $os):
                if ($os['slug'] === $slug) continue;
                $osMeta = $meta[$os['slug']] ?? null;
                $osImg  = $osMeta['hero'] ?? '/assets/images/hero-hall.webp';
                $osAcc  = $osMeta['accent'] ?? '#E30613';
            ?>
            <a href="<?= url('hizmetler/' . $os['slug']) ?>" class="sd-other-card" style="--accent: <?= e($osAcc) ?>;">
                <div class="sd-other-img" style="background-image: url('<?= e($osImg) ?>');"></div>
                <div class="sd-other-body">
                    <h3 class="sd-other-title"><?= e(lang() === 'en' ? $os['en'] : $os['tr']) ?></h3>
                    <span class="sd-other-arrow" aria-hidden="true">→</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
/* ═══════════════════════════════════════════════════════════════
   APPLE-STYLE SERVICE DETAIL
═══════════════════════════════════════════════════════════════ */
.page-service-detail {
    --sd-bg:        #ffffff;
    --sd-bg-alt:    #f5f5f7;
    --sd-bg-dark:   #1d1d1f;
    --sd-text:      #1d1d1f;
    --sd-text-mute: #6e6e73;
    --sd-text-soft: #86868b;
    --sd-border:    rgba(0,0,0,.08);
}

/* —— Container —— */
.sd-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 clamp(1.25rem, 4vw, 3rem);
}
.sd-container-narrow { max-width: 860px; }

.sd-section {
    padding: clamp(4rem, 10vw, 8rem) 0;
}

/* —— Buttons —— */
.sd-btn {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    padding: .85rem 1.6rem;
    border-radius: 980px;
    font-size: .95rem;
    font-weight: 500;
    text-decoration: none;
    transition: transform .25s cubic-bezier(.2,.7,.2,1), background-color .25s, box-shadow .25s;
    line-height: 1;
    white-space: nowrap;
}
.sd-btn-primary {
    background: var(--accent);
    color: #fff;
}
.sd-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 12px 30px -10px var(--accent);
    color: #fff;
}
.sd-btn-ghost {
    background: rgba(255,255,255,.12);
    color: #fff;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.2);
}
.sd-btn-ghost:hover { background: rgba(255,255,255,.2); color: #fff; }
.sd-btn-lg { padding: 1.05rem 2.2rem; font-size: 1.05rem; }

/* —— On-light variant (CTA section) —— */
.sd-cta .sd-btn-ghost {
    background: rgba(0,0,0,.05);
    color: var(--sd-text);
    border-color: rgba(0,0,0,.1);
}
.sd-cta .sd-btn-ghost:hover { background: rgba(0,0,0,.08); color: var(--sd-text); }

/* ═══════════════════════════════════════════════════════════════
   HERO (cinematic full-bleed with Ken-Burns zoom)
═══════════════════════════════════════════════════════════════ */
.sd-hero {
    position: relative;
    min-height: 100vh;
    min-height: 100svh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: #fff;
    isolation: isolate;
}
.sd-hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transform: scale(1.08);
    animation: sdKenBurns 22s ease-in-out infinite alternate;
    z-index: -2;
}
@keyframes sdKenBurns {
    0%   { transform: scale(1.05) translate3d(0,0,0); }
    100% { transform: scale(1.18) translate3d(-2%, -1%, 0); }
}
.sd-hero-overlay {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at center, rgba(0,0,0,.25) 0%, rgba(0,0,0,.55) 50%, rgba(0,0,0,.85) 100%),
        linear-gradient(180deg, rgba(0,0,0,.35) 0%, rgba(0,0,0,.15) 30%, rgba(0,0,0,.65) 100%);
    z-index: -1;
}
.sd-hero-content {
    text-align: center;
    max-width: 920px;
    padding: 6rem 1.5rem 4rem;
    z-index: 1;
}
.sd-breadcrumb {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    font-size: .85rem;
    color: rgba(255,255,255,.65);
    margin-bottom: 1.5rem;
    letter-spacing: .02em;
}
.sd-breadcrumb a {
    color: rgba(255,255,255,.65);
    text-decoration: none;
    transition: color .2s;
}
.sd-breadcrumb a:hover { color: #fff; }
.sd-breadcrumb span { opacity: .5; }

.sd-eyebrow {
    display: inline-block;
    font-size: .8rem;
    font-weight: 700;
    letter-spacing: .18em;
    color: var(--accent);
    text-transform: uppercase;
    margin-bottom: 1rem;
    padding: .35rem 1rem;
    background: rgba(255,255,255,.08);
    backdrop-filter: blur(20px);
    border-radius: 100px;
    border: 1px solid rgba(255,255,255,.12);
}
.sd-hero-title {
    font-size: clamp(3rem, 9vw, 7.5rem);
    font-weight: 700;
    letter-spacing: -.04em;
    line-height: .95;
    margin: 0 0 1.5rem;
    color: #fff;
    text-shadow: 0 2px 30px rgba(0,0,0,.3);
}
.sd-hero-sub {
    font-size: clamp(1.05rem, 1.8vw, 1.5rem);
    line-height: 1.4;
    color: rgba(255,255,255,.85);
    max-width: 720px;
    margin: 0 auto 2.5rem;
    font-weight: 400;
}
.sd-hero-cta {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.sd-hero-scroll {
    position: absolute;
    bottom: 2.5rem;
    left: 50%;
    transform: translateX(-50%);
    width: 1px;
    height: 50px;
    background: rgba(255,255,255,.25);
    overflow: hidden;
}
.sd-hero-scroll-line {
    position: absolute;
    inset: 0;
    background: #fff;
    transform: translateY(-100%);
    animation: sdScrollLine 2.5s ease-in-out infinite;
}
@keyframes sdScrollLine {
    0%   { transform: translateY(-100%); }
    50%  { transform: translateY(0); }
    100% { transform: translateY(100%); }
}

/* ═══════════════════════════════════════════════════════════════
   OVERVIEW — Apple Pro page big text
═══════════════════════════════════════════════════════════════ */
.sd-overview {
    background: var(--sd-bg);
    padding: clamp(5rem, 12vw, 10rem) 0;
}
.sd-section-eyebrow {
    display: block;
    font-size: .82rem;
    font-weight: 700;
    letter-spacing: .18em;
    color: var(--accent);
    text-transform: uppercase;
    margin-bottom: 1.5rem;
}
.sd-overview-title {
    font-size: clamp(2rem, 5.5vw, 4.5rem);
    font-weight: 700;
    letter-spacing: -.025em;
    line-height: 1.05;
    color: var(--sd-text);
    margin: 0;
    max-width: 1100px;
}
.sd-overview-title-mute {
    color: var(--sd-text-mute);
    font-weight: 600;
}

/* ═══════════════════════════════════════════════════════════════
   STATS BAND
═══════════════════════════════════════════════════════════════ */
.sd-stats {
    background: var(--sd-bg-dark);
    color: #fff;
    padding: clamp(4rem, 9vw, 7rem) 0;
}
.sd-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: clamp(2rem, 4vw, 4rem);
    text-align: center;
}
.sd-stat-num {
    font-size: clamp(3rem, 7vw, 5.5rem);
    font-weight: 700;
    letter-spacing: -.04em;
    line-height: .95;
    background: linear-gradient(135deg, #fff 0%, var(--accent) 120%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: .5rem;
}
.sd-stat-label {
    font-size: .9rem;
    color: rgba(255,255,255,.65);
    letter-spacing: .02em;
}

/* ═══════════════════════════════════════════════════════════════
   PARALLAX SHOWCASE
═══════════════════════════════════════════════════════════════ */
.sd-showcase {
    position: relative;
    height: 70vh;
    min-height: 500px;
    overflow: hidden;
    isolation: isolate;
}
.sd-showcase-img {
    position: absolute;
    inset: -10% 0;
    background-size: cover;
    background-position: center;
    transform: translate3d(0, 0, 0);
    will-change: transform;
    z-index: -1;
}
.sd-showcase-overlay {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    background: linear-gradient(180deg, rgba(0,0,0,.45) 0%, rgba(0,0,0,.65) 100%);
}
.sd-showcase-text {
    color: #fff;
    font-size: clamp(1.75rem, 4.5vw, 3.5rem);
    font-weight: 600;
    letter-spacing: -.02em;
    line-height: 1.15;
    max-width: 880px;
    margin: 0;
}

/* ═══════════════════════════════════════════════════════════════
   RICH CONTENT (Apple-style prose)
═══════════════════════════════════════════════════════════════ */
.sd-content { background: var(--sd-bg); }
.sd-prose {
    color: var(--sd-text);
    font-size: 1.0625rem;
    line-height: 1.6;
}
.sd-prose .lead {
    font-size: clamp(1.4rem, 2.5vw, 1.875rem);
    font-weight: 400;
    line-height: 1.4;
    color: var(--sd-text);
    margin: 0 0 3rem;
    letter-spacing: -.012em;
}
.sd-prose .lead strong { color: var(--accent); font-weight: 600; }
.sd-prose h2 {
    font-size: clamp(1.75rem, 3.5vw, 2.5rem);
    font-weight: 700;
    letter-spacing: -.02em;
    line-height: 1.15;
    color: var(--sd-text);
    margin: 4rem 0 1.5rem;
}
.sd-prose h3 {
    font-size: clamp(1.25rem, 2.2vw, 1.5rem);
    font-weight: 600;
    letter-spacing: -.012em;
    color: var(--sd-text);
    margin: 2.5rem 0 1rem;
}
.sd-prose p {
    margin: 0 0 1.25em;
    color: var(--sd-text-mute);
}
.sd-prose strong { color: var(--sd-text); font-weight: 600; }
.sd-prose em {
    font-style: normal;
    color: var(--accent);
    font-weight: 500;
}
.sd-prose ul, .sd-prose ol {
    list-style: none;
    padding: 0;
    margin: 1rem 0 2rem;
    display: grid;
    gap: .85rem;
}
.sd-prose ul li, .sd-prose ol li {
    position: relative;
    padding-left: 2.25rem;
    color: var(--sd-text-mute);
    line-height: 1.55;
}
.sd-prose ul li::before {
    content: '';
    position: absolute;
    left: 0;
    top: .5rem;
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 50%;
    background: var(--accent);
    box-shadow: 0 4px 12px -2px color-mix(in srgb, var(--accent) 50%, transparent);
}
.sd-prose ul li::after {
    content: '✓';
    position: absolute;
    left: .25rem;
    top: .35rem;
    color: #fff;
    font-size: .75rem;
    font-weight: 800;
    width: 1.25rem;
    text-align: center;
}
.sd-prose ol {
    counter-reset: sd-step;
}
.sd-prose ol li {
    counter-increment: sd-step;
    padding-left: 3rem;
}
.sd-prose ol li::before {
    content: counter(sd-step);
    position: absolute;
    left: 0;
    top: 0;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: var(--sd-bg-alt);
    color: var(--accent);
    border: 2px solid var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    font-weight: 700;
}
.sd-prose ol li strong { display: inline-block; margin-right: .25rem; }

/* ═══════════════════════════════════════════════════════════════
   CTA
═══════════════════════════════════════════════════════════════ */
.sd-cta {
    background: var(--sd-bg-alt);
    text-align: center;
    padding: clamp(5rem, 10vw, 8rem) 0;
}
.sd-cta-title {
    font-size: clamp(2.25rem, 6vw, 4.5rem);
    font-weight: 700;
    letter-spacing: -.025em;
    line-height: 1.05;
    color: var(--sd-text);
    margin: 0 0 1rem;
}
.sd-cta-sub {
    font-size: clamp(1rem, 1.5vw, 1.25rem);
    color: var(--sd-text-mute);
    margin: 0 auto 2.5rem;
    max-width: 560px;
}
.sd-cta-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

/* ═══════════════════════════════════════════════════════════════
   OTHER SERVICES (horizontal showcase)
═══════════════════════════════════════════════════════════════ */
.sd-others {
    background: var(--sd-bg);
    padding-bottom: clamp(5rem, 10vw, 8rem);
}
.sd-others-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    letter-spacing: -.02em;
    color: var(--sd-text);
    margin: 0 0 3rem;
}
.sd-others-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
}
.sd-other-card {
    position: relative;
    border-radius: 22px;
    overflow: hidden;
    aspect-ratio: 4/5;
    text-decoration: none;
    transition: transform .35s cubic-bezier(.2,.7,.2,1);
    isolation: isolate;
}
.sd-other-card:hover { transform: translateY(-6px); }
.sd-other-img {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transition: transform .6s cubic-bezier(.2,.7,.2,1);
    z-index: -2;
}
.sd-other-card:hover .sd-other-img { transform: scale(1.07); }
.sd-other-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 35%, rgba(0,0,0,.85) 100%);
    z-index: -1;
}
.sd-other-body {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.75rem;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    color: #fff;
}
.sd-other-title {
    font-size: 1.5rem;
    font-weight: 600;
    letter-spacing: -.012em;
    line-height: 1.15;
    margin: 0;
}
.sd-other-arrow {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
    transition: transform .25s;
}
.sd-other-card:hover .sd-other-arrow { transform: translateX(4px); }

/* ═══════════════════════════════════════════════════════════════
   REVEAL ANIMATIONS
═══════════════════════════════════════════════════════════════ */
[data-reveal] {
    opacity: 0;
    transform: translateY(28px);
    transition:
        opacity .9s cubic-bezier(.2,.7,.2,1) var(--reveal-delay, 0ms),
        transform .9s cubic-bezier(.2,.7,.2,1) var(--reveal-delay, 0ms);
}
[data-reveal].is-revealed {
    opacity: 1;
    transform: translateY(0);
}
@media (prefers-reduced-motion: reduce) {
    [data-reveal] { opacity: 1; transform: none; transition: none; }
    .sd-hero-bg { animation: none; }
    .sd-hero-scroll-line { animation: none; }
}

/* ═══════════════════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
    .sd-hero { min-height: 90vh; min-height: 90svh; }
    .sd-hero-content { padding: 5rem 1.25rem 3rem; }
    .sd-hero-cta { flex-direction: column; align-items: center; }
    .sd-hero-cta .sd-btn { width: 100%; max-width: 320px; justify-content: center; }
    .sd-stats-grid { grid-template-columns: repeat(2, 1fr); }
    .sd-cta-actions { flex-direction: column; align-items: center; }
    .sd-cta-actions .sd-btn { width: 100%; max-width: 320px; justify-content: center; }
    .sd-others-grid { grid-template-columns: 1fr; }
    .sd-other-card { aspect-ratio: 16/10; }
}

/* ═══════════════════════════════════════════════════════════════
   THEME — Dark mode honoured (Apple respects system)
═══════════════════════════════════════════════════════════════ */
@media (prefers-color-scheme: dark) {
    .page-service-detail {
        --sd-bg:        #000000;
        --sd-bg-alt:    #1c1c1e;
        --sd-text:      #f5f5f7;
        --sd-text-mute: #98989d;
        --sd-text-soft: #6e6e73;
        --sd-border:    rgba(255,255,255,.1);
    }
    .sd-prose ol li::before { background: rgba(255,255,255,.05); }
}
</style>

<script>
(function () {
    // Intersection Observer reveal animations
    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

        document.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));
    } else {
        document.querySelectorAll('[data-reveal]').forEach(el => el.classList.add('is-revealed'));
    }

    // Parallax on showcase image (cheap, GPU-accelerated)
    const showcase = document.querySelector('[data-parallax] .sd-showcase-img');
    if (showcase && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const parent = showcase.closest('[data-parallax]');
        let raf;
        const update = () => {
            const rect = parent.getBoundingClientRect();
            const vh = window.innerHeight;
            if (rect.bottom > 0 && rect.top < vh) {
                const progress = (vh - rect.top) / (vh + rect.height);
                const offset = (progress - 0.5) * 80; // ±40px
                showcase.style.transform = `translate3d(0, ${offset}px, 0)`;
            }
            raf = null;
        };
        const onScroll = () => { if (!raf) raf = requestAnimationFrame(update); };
        window.addEventListener('scroll', onScroll, { passive: true });
        update();
    }

    // Smooth scroll for hash links (overview button)
    document.querySelectorAll('.sd-hero-cta a[href^="#"]').forEach(a => {
        a.addEventListener('click', (e) => {
            const id = a.getAttribute('href').slice(1);
            const target = document.getElementById(id);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
})();
</script>
