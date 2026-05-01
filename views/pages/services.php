<?php
$pageTitle       = lang() === 'en'
    ? 'Services | Fair, Congress & Stand Build in Cyprus | Expo Cyprus'
    : 'Hizmetler | Kıbrıs Fuar, Kongre ve Stand Hizmetleri | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? '6 specialised services: fair organisation, congress management, stand design & build, exhibitor consulting, hostess staff, PR. All under one roof in Cyprus.'
    : '6 uzman hizmet: fuar organizasyonu, kongre yönetimi, stand tasarım & kurulum, fuar danışmanlığı, hostes kadro, PR. Kıbrıs\'ta tek çatı altında.';
$bodyClass = 'page-services';
$keywords = lang() === 'en'
    ? ['fair organisation Cyprus', 'congress organisation', 'stand design Cyprus', 'stand build', 'exhibitor consulting', 'hostess staff', 'PR services Cyprus']
    : ['fuar organizasyonu', 'kongre organizasyonu', 'stand tasarım', 'stand kurulum', 'fuar danışmanlığı', 'hostes hizmeti', 'PR Kıbrıs'];
$breadcrumb = [
    ['name' => lang() === 'en' ? 'Home' : 'Anasayfa', 'url' => '/'],
    ['name' => lang() === 'en' ? 'Services' : 'Hizmetler', 'url' => '/hizmetler'],
];
$structured = [];
if (!empty($services)) {
    $items = [];
    foreach ($services as $i => $s) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'item' => [
                '@type' => 'Service',
                'name'  => lang() === 'en' ? ($s['title_en'] ?? $s['title_tr']) : ($s['title_tr'] ?? ''),
                'description' => lang() === 'en' ? ($s['summary_en'] ?? '') : ($s['summary_tr'] ?? ''),
                'provider' => ['@type' => 'Organization', 'name' => 'Expo Cyprus'],
                'url' => '/hizmetler/' . $s['slug'],
            ],
        ];
    }
    $structured[] = ['@type' => 'ItemList', 'itemListElement' => $items];
}

// Per-service curated metadata (same as service-detail.php for consistency)
$serviceMeta = [
    'fuar-organizasyonu' => [
        'tagline_tr' => 'Konseptten kapanışa.',
        'tagline_en' => 'From concept to close.',
        'accent'     => '#E30613',
        'image'      => '/assets/images/service-fair-org.webp',
    ],
    'kongre-organizasyonu' => [
        'tagline_tr' => 'Bilim sahnede.',
        'tagline_en' => 'Science on stage.',
        'accent'     => '#0066CC',
        'image'      => '/assets/images/service-fair-org.webp',
    ],
    'stand-tasarim-kurulum' => [
        'tagline_tr' => 'Markanız. Sahnede.',
        'tagline_en' => 'Your brand. On stage.',
        'accent'     => '#FF6B35',
        'image'      => '/assets/images/service-stand-design.webp',
    ],
    'fuar-katilim-danismanligi' => [
        'tagline_tr' => 'Fuara değil, dönüşüme git.',
        'tagline_en' => 'Don\'t attend. Convert.',
        'accent'     => '#00875A',
        'image'      => '/assets/images/service-consulting.webp',
    ],
    'hostes-stand-gorevlisi' => [
        'tagline_tr' => 'Standınızın yüzü.',
        'tagline_en' => 'The face of your stand.',
        'accent'     => '#9333EA',
        'image'      => '/assets/images/service-logistics.webp',
    ],
    'pr-tanitim' => [
        'tagline_tr' => 'Görünür ol. Hatırlan.',
        'tagline_en' => 'Be seen. Be remembered.',
        'accent'     => '#EC4899',
        'image'      => '/assets/images/service-digital.webp',
    ],
];
?>

<!-- ═══════════════════════════════════════════════════════════════
     CINEMATIC HERO
═══════════════════════════════════════════════════════════════ -->
<section class="sl-hero">
    <div class="sl-hero-bg" style="background-image: url('/assets/images/hero-hall.webp');"></div>
    <div class="sl-hero-overlay"></div>
    <div class="sl-hero-content">
        <nav class="sl-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span>›</span>
            <span><?= lang() === 'en' ? 'Services' : 'Hizmetler' ?></span>
        </nav>
        <h1 class="sl-hero-title">
            <?= lang() === 'en'
                ? 'Six services.<br>One responsibility.'
                : 'Altı hizmet.<br>Tek sorumluluk.' ?>
        </h1>
        <p class="sl-hero-sub">
            <?= lang() === 'en'
                ? 'Everything from fair organisation to PR — designed, built and delivered by our team.'
                : 'Fuar organizasyonundan PR\'a — her şey ekibimiz tarafından tasarlanır, üretilir ve teslim edilir.' ?>
        </p>
    </div>
    <div class="sl-hero-scroll" aria-hidden="true">
        <span class="sl-hero-scroll-line"></span>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     SERVICES BIG GRID — Apple-style mosaic
═══════════════════════════════════════════════════════════════ -->
<section class="sl-section">
    <div class="sl-container">
        <span class="sl-eyebrow" data-reveal>
            <?= lang() === 'en' ? 'OUR SERVICES' : 'HİZMETLERİMİZ' ?>
        </span>
        <h2 class="sl-section-title" data-reveal>
            <?= lang() === 'en'
                ? 'Built for events that matter.'
                : 'Önemli etkinlikler için kurulduk.' ?>
        </h2>

        <?php
        // Use DB services if available, else fallback to placeholders
        $serviceList = !empty($services) ? $services : [
            ['slug' => 'fuar-organizasyonu',     'title_tr' => 'Fuar Organizasyonu',     'title_en' => 'Fair Organisation',
             'summary_tr' => 'Kendi sektörel fuarlarımızı düzenleriz. Sizin fuarınızı da konseptten kuruluma A\'dan Z\'ye yönetiriz.',
             'summary_en' => 'We organise our own sector fairs. We also manage your fair from concept to build, A to Z.'],
            ['slug' => 'kongre-organizasyonu',   'title_tr' => 'Kongre Organizasyonu',   'title_en' => 'Congress Organisation',
             'summary_tr' => 'Akademik, tıbbi, kurumsal kongreler. Konuşmacı yönetiminden sosyal programa, tüm operasyon bizden.',
             'summary_en' => 'Academic, medical, corporate congresses. From speaker management to social programme — all operations handled.'],
            ['slug' => 'stand-tasarim-kurulum',  'title_tr' => 'Stand Tasarım & Kurulum','title_en' => 'Stand Design & Build',
             'summary_tr' => 'İç teknik ekibimizle 100+ stand kurulumu. Modüler, özel yapım veya hibrit — markanıza özel tasarım.',
             'summary_en' => '100+ stand installations with our in-house team. Modular, custom-built or hybrid — designed for your brand.'],
            ['slug' => 'fuar-katilim-danismanligi','title_tr' => 'Fuar Katılım Danışmanlığı','title_en' => 'Exhibitor Consulting',
             'summary_tr' => 'Fuara hazırlıksız gitmeyin. Stratejiden ROI hesabına, hazırlıktan sonrası takibe — yanınızdayız.',
             'summary_en' => 'Don\'t go to a fair unprepared. From strategy to ROI to follow-up — we\'re with you.'],
            ['slug' => 'hostes-stand-gorevlisi', 'title_tr' => 'Hostes & Stand Görevlisi','title_en' => 'Hostess & Stand Staff',
             'summary_tr' => 'Eğitimli, profesyonel saha kadrosu. Karşılamadan demoya, ürün tanıtımından lead toplamaya.',
             'summary_en' => 'Trained, professional field staff. From welcoming to demos, presentations to lead capture.'],
            ['slug' => 'pr-tanitim',             'title_tr' => 'PR & Tanıtım',           'title_en' => 'PR & Promotion',
             'summary_tr' => 'Etkinlik öncesi-sırası-sonrası iletişim yönetimi. Basın bülteninden sosyal medyaya, tek elden.',
             'summary_en' => 'Communication management before, during and after the event. From press to social — single source.'],
        ];
        ?>

        <div class="sl-grid">
            <?php foreach ($serviceList as $i => $s):
                $slug    = $s['slug'];
                $title   = lang() === 'en' ? ($s['title_en'] ?? $s['title_tr']) : $s['title_tr'];
                $summary = lang() === 'en' ? ($s['summary_en'] ?? $s['summary_tr']) : $s['summary_tr'];
                $sm      = $serviceMeta[$slug] ?? null;
                $tagline = lang() === 'en' ? ($sm['tagline_en'] ?? '') : ($sm['tagline_tr'] ?? '');
                $accent  = $sm['accent'] ?? '#E30613';
                $image   = $sm['image']  ?? ($s['image'] ?? '/assets/images/hero-hall.webp');
                // Make first card span 2 columns for visual rhythm (Apple-style mosaic)
                $featured = ($i === 0);
            ?>
            <a href="<?= url('hizmetler/' . $slug) ?>"
               class="sl-card <?= $featured ? 'sl-card-featured' : '' ?>"
               style="--accent: <?= e($accent) ?>; --reveal-delay: <?= $i * 60 ?>ms;"
               data-reveal>
                <div class="sl-card-img" style="background-image: url('<?= e($image) ?>');"></div>
                <div class="sl-card-overlay"></div>
                <div class="sl-card-body">
                    <?php if ($tagline): ?>
                    <span class="sl-card-tagline"><?= e($tagline) ?></span>
                    <?php endif; ?>
                    <h3 class="sl-card-title"><?= e($title) ?></h3>
                    <p class="sl-card-text"><?= e($summary) ?></p>
                    <span class="sl-card-link">
                        <?= lang() === 'en' ? 'Learn more' : 'Detaylı bilgi' ?>
                        <span class="sl-card-arrow" aria-hidden="true">→</span>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     CTA
═══════════════════════════════════════════════════════════════ -->
<section class="sl-cta">
    <div class="sl-container">
        <h2 class="sl-cta-title" data-reveal>
            <?= lang() === 'en' ? 'Need a custom solution?' : 'Özel çözüme mi ihtiyacınız var?' ?>
        </h2>
        <p class="sl-cta-sub" data-reveal>
            <?= lang() === 'en'
                ? 'Every event is unique. Tell us yours, we\'ll design the package around it.'
                : 'Her etkinlik benzersiz. Bize anlatın, hizmet paketini etrafında tasarlayalım.' ?>
        </p>
        <div class="sl-cta-actions" data-reveal>
            <a href="<?= url('teklif-al') ?>" class="sl-btn sl-btn-primary">
                <?= lang() === 'en' ? 'Request a Quote' : 'Teklif İste' ?>
                <span aria-hidden="true">→</span>
            </a>
            <a href="<?= url('iletisim') ?>" class="sl-btn sl-btn-ghost">
                <?= lang() === 'en' ? 'Contact us' : 'İletişime geç' ?>
            </a>
        </div>
    </div>
</section>

<style>
/* ═══════════════════════════════════════════════════════════════
   APPLE-STYLE SERVICE LIST
═══════════════════════════════════════════════════════════════ */
.page-services {
    --sl-bg:        #ffffff;
    --sl-bg-alt:    #f5f5f7;
    --sl-text:      #1d1d1f;
    --sl-text-mute: #6e6e73;
    --sl-border:    rgba(0,0,0,.08);
}

.sl-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 clamp(1.25rem, 4vw, 3rem);
}
.sl-section { padding: clamp(4rem, 9vw, 7rem) 0; background: var(--sl-bg); }

/* —— Buttons —— */
.sl-btn {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    padding: 1.05rem 2.2rem;
    border-radius: 980px;
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
    transition: transform .25s, background-color .25s, box-shadow .25s;
}
.sl-btn-primary { background: #E30613; color: #fff; }
.sl-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 12px 30px -10px #E30613; color: #fff; }
.sl-btn-ghost { background: rgba(0,0,0,.05); color: var(--sl-text); }
.sl-btn-ghost:hover { background: rgba(0,0,0,.08); color: var(--sl-text); }

/* ═══════════════════════════════════════════════════════════════
   HERO
═══════════════════════════════════════════════════════════════ */
.sl-hero {
    position: relative;
    min-height: 80vh;
    min-height: 80svh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: #fff;
    isolation: isolate;
}
.sl-hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transform: scale(1.05);
    animation: slKenBurns 25s ease-in-out infinite alternate;
    z-index: -2;
}
@keyframes slKenBurns {
    0%   { transform: scale(1.05); }
    100% { transform: scale(1.18); }
}
.sl-hero-overlay {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at center, rgba(0,0,0,.25) 0%, rgba(0,0,0,.6) 60%, rgba(0,0,0,.85) 100%);
    z-index: -1;
}
.sl-hero-content {
    text-align: center;
    max-width: 920px;
    padding: 5rem 1.5rem 4rem;
}
.sl-breadcrumb {
    display: flex; align-items: center; justify-content: center;
    gap: .5rem; font-size: .85rem;
    color: rgba(255,255,255,.65);
    margin-bottom: 1.5rem;
}
.sl-breadcrumb a { color: rgba(255,255,255,.65); text-decoration: none; }
.sl-breadcrumb a:hover { color: #fff; }
.sl-hero-title {
    font-size: clamp(2.5rem, 8vw, 6.5rem);
    font-weight: 700;
    letter-spacing: -.04em;
    line-height: .95;
    margin: 0 0 1.5rem;
    color: #fff;
}
.sl-hero-sub {
    font-size: clamp(1.05rem, 1.8vw, 1.4rem);
    line-height: 1.4;
    color: rgba(255,255,255,.85);
    max-width: 640px;
    margin: 0 auto;
}
.sl-hero-scroll {
    position: absolute;
    bottom: 2.5rem;
    left: 50%;
    transform: translateX(-50%);
    width: 1px; height: 50px;
    background: rgba(255,255,255,.25);
    overflow: hidden;
}
.sl-hero-scroll-line {
    position: absolute;
    inset: 0;
    background: #fff;
    transform: translateY(-100%);
    animation: slScrollLine 2.5s ease-in-out infinite;
}
@keyframes slScrollLine {
    0%   { transform: translateY(-100%); }
    50%  { transform: translateY(0); }
    100% { transform: translateY(100%); }
}

/* ═══════════════════════════════════════════════════════════════
   SECTION HEADERS
═══════════════════════════════════════════════════════════════ */
.sl-eyebrow {
    display: block;
    font-size: .82rem;
    font-weight: 700;
    letter-spacing: .18em;
    color: #E30613;
    text-transform: uppercase;
    margin-bottom: 1rem;
}
.sl-section-title {
    font-size: clamp(2rem, 5vw, 3.75rem);
    font-weight: 700;
    letter-spacing: -.025em;
    line-height: 1.1;
    color: var(--sl-text);
    margin: 0 0 4rem;
    max-width: 900px;
}

/* ═══════════════════════════════════════════════════════════════
   GRID — Apple mosaic
═══════════════════════════════════════════════════════════════ */
.sl-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-auto-rows: minmax(380px, auto);
    gap: 1.25rem;
}
.sl-card {
    position: relative;
    overflow: hidden;
    border-radius: 24px;
    text-decoration: none;
    color: #fff;
    isolation: isolate;
    transition: transform .35s cubic-bezier(.2,.7,.2,1);
    min-height: 380px;
}
.sl-card:hover { transform: translateY(-8px); color: #fff; }

/* Featured card — first one spans full width */
.sl-card-featured {
    grid-column: 1 / -1;
    min-height: 480px;
}

.sl-card-img {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transition: transform .8s cubic-bezier(.2,.7,.2,1);
    z-index: -2;
}
.sl-card:hover .sl-card-img { transform: scale(1.06); }

.sl-card-overlay {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(180deg, transparent 0%, transparent 35%, rgba(0,0,0,.4) 65%, rgba(0,0,0,.9) 100%);
    z-index: -1;
}

.sl-card-body {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: clamp(1.75rem, 3.5vw, 2.75rem);
    display: flex;
    flex-direction: column;
    gap: .75rem;
}
.sl-card-tagline {
    font-size: .85rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: .25rem;
    text-shadow: 0 2px 10px rgba(0,0,0,.4);
}
.sl-card-title {
    font-size: clamp(1.5rem, 2.5vw, 2.25rem);
    font-weight: 700;
    letter-spacing: -.02em;
    line-height: 1.1;
    margin: 0;
    color: #fff;
}
.sl-card-featured .sl-card-title {
    font-size: clamp(2rem, 4vw, 3.25rem);
}
.sl-card-text {
    font-size: 1rem;
    line-height: 1.5;
    color: rgba(255,255,255,.85);
    max-width: 620px;
    margin: 0;
}
.sl-card-link {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-size: .95rem;
    font-weight: 500;
    color: #fff;
    margin-top: .75rem;
}
.sl-card-arrow {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--accent);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .95rem;
    transition: transform .25s;
}
.sl-card:hover .sl-card-arrow { transform: translateX(5px); }

/* ═══════════════════════════════════════════════════════════════
   CTA
═══════════════════════════════════════════════════════════════ */
.sl-cta {
    background: var(--sl-bg-alt);
    text-align: center;
    padding: clamp(5rem, 10vw, 8rem) 0;
}
.sl-cta-title {
    font-size: clamp(2.25rem, 5.5vw, 4rem);
    font-weight: 700;
    letter-spacing: -.025em;
    line-height: 1.05;
    color: var(--sl-text);
    margin: 0 0 1rem;
}
.sl-cta-sub {
    font-size: clamp(1rem, 1.5vw, 1.25rem);
    color: var(--sl-text-mute);
    margin: 0 auto 2.5rem;
    max-width: 560px;
}
.sl-cta-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

/* ═══════════════════════════════════════════════════════════════
   REVEAL
═══════════════════════════════════════════════════════════════ */
[data-reveal] {
    opacity: 0;
    transform: translateY(28px);
    transition:
        opacity .9s cubic-bezier(.2,.7,.2,1) var(--reveal-delay, 0ms),
        transform .9s cubic-bezier(.2,.7,.2,1) var(--reveal-delay, 0ms);
}
[data-reveal].is-revealed {
    opacity: 1; transform: translateY(0);
}
@media (prefers-reduced-motion: reduce) {
    [data-reveal] { opacity: 1; transform: none; transition: none; }
    .sl-hero-bg { animation: none; }
    .sl-hero-scroll-line { animation: none; }
}

/* ═══════════════════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
    .sl-hero { min-height: 75vh; min-height: 75svh; }
    .sl-grid { grid-template-columns: 1fr; }
    .sl-card-featured { grid-column: auto; min-height: 420px; }
    .sl-cta-actions { flex-direction: column; align-items: center; }
    .sl-cta-actions .sl-btn { width: 100%; max-width: 320px; justify-content: center; }
}

/* Dark mode */
@media (prefers-color-scheme: dark) {
    .page-services {
        --sl-bg:        #000;
        --sl-bg-alt:    #1c1c1e;
        --sl-text:      #f5f5f7;
        --sl-text-mute: #98989d;
    }
    .sl-btn-ghost { background: rgba(255,255,255,.08); color: var(--sl-text); }
    .sl-btn-ghost:hover { background: rgba(255,255,255,.12); color: var(--sl-text); }
}
</style>

<script>
(function () {
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
})();
</script>
