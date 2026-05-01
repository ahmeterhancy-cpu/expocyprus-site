<?php
$pageTitle       = lang() === 'en'
    ? 'Trade Fairs in Cyprus | Expo Cyprus — 4 Annual Sector Fairs'
    : 'Kıbrıs\'ta Fuarlar | Expo Cyprus — 4 Sektörel Yıllık Fuar';
$metaDescription = lang() === 'en'
    ? '4 annual trade fairs in Cyprus: Consumer Fair, Hunting & Outdoor Sports, Agriculture & Livestock, Wedding Preparations. Over 50,000 visitors yearly.'
    : '4 yıllık ticaret fuarı: Tüketici Fuarı, Av & Doğa Sporları, Tarım Hayvancılık, Düğün Hazırlıkları. Yıllık 50.000+ ziyaretçi.';
$bodyClass = 'page-fairs-apple';
$keywords = lang() === 'en'
    ? ['trade fair Cyprus', 'consumer fair', 'hunting fair Cyprus', 'agriculture fair', 'wedding fair', 'expo Cyprus']
    : ['Kıbrıs fuarı', 'tüketici fuarı', 'av fuarı', 'tarım fuarı', 'düğün fuarı', 'KKTC fuar'];
$breadcrumb = [
    ['name' => lang() === 'en' ? 'Home' : 'Anasayfa', 'url' => '/'],
    ['name' => lang() === 'en' ? 'Fairs' : 'Fuarlar', 'url' => '/fuarlarimiz'],
];
$structured = [];

// Per-fair Apple-style metadata
$fairMeta = [
    'tuketici-fuari' => [
        'tagline_tr' => 'Tüm sektörler. Tek çatı.',
        'tagline_en' => 'Every sector. One roof.',
        'accent'     => '#E30613',
        'image'      => '/assets/images/hero-hall.png',
        'icon'       => '🛍️',
        'stats'      => [
            ['n' => '15K+',  'l' => 'Ziyaretçi'],
            ['n' => '120+',  'l' => 'Katılımcı'],
            ['n' => '5',     'l' => 'Gün'],
        ],
    ],
    'av-avcilik-atis-doga-sporlari-fuari' => [
        'tagline_tr' => 'Doğanın peşinde.',
        'tagline_en' => 'Hunt for the wild.',
        'accent'     => '#0F766E',
        'image'      => '/assets/images/service-cyprus.png',
        'icon'       => '🎯',
        'stats'      => [
            ['n' => '8K+',   'l' => 'Ziyaretçi'],
            ['n' => '60+',   'l' => 'Katılımcı'],
            ['n' => '3',     'l' => 'Gün'],
        ],
    ],
    'tarim-hayvancilik-fuari' => [
        'tagline_tr' => 'Toprak. Hasat. Gelecek.',
        'tagline_en' => 'Soil. Harvest. Future.',
        'accent'     => '#059669',
        'image'      => '/assets/images/service-fair-org.png',
        'icon'       => '🌾',
        'stats'      => [
            ['n' => '12K+',  'l' => 'Ziyaretçi'],
            ['n' => '80+',   'l' => 'Katılımcı'],
            ['n' => '4',     'l' => 'Gün'],
        ],
    ],
    'dugun-hazirliklari-fuari' => [
        'tagline_tr' => 'Hayatın en özel günü.',
        'tagline_en' => 'The most special day.',
        'accent'     => '#EC4899',
        'image'      => '/assets/images/about-team.png',
        'icon'       => '💍',
        'stats'      => [
            ['n' => '6K+',   'l' => 'Ziyaretçi'],
            ['n' => '90+',   'l' => 'Katılımcı'],
            ['n' => '3',     'l' => 'Gün'],
        ],
    ],
];

$displayFairs = !empty($fairs) ? $fairs : [
    ['slug'=>'tuketici-fuari','name_tr'=>'Tüketici Fuarı','name_en'=>'Consumer Fair','summary_tr'=>'Tüm sektörler, tek çatı altında. Kıbrıs\'ın en kapsamlı tüketici fuarı.','summary_en'=>'Every sector, under one roof. Cyprus\'s most comprehensive consumer fair.','status'=>'active'],
    ['slug'=>'av-avcilik-atis-doga-sporlari-fuari','name_tr'=>'Av, Avcılık & Doğa Sporları Fuarı','name_en'=>'Hunting & Outdoor Sports Fair','summary_tr'=>'KKTC\'nin ilk ihtisas fuarı. Av, avcılık, atış sporları, kamp ekipmanları.','summary_en'=>'Cyprus\'s first specialty fair. Hunting, shooting, outdoor sports.','status'=>'active'],
    ['slug'=>'tarim-hayvancilik-fuari','name_tr'=>'Tarım Hayvancılık Fuarı','name_en'=>'Agriculture & Livestock Fair','summary_tr'=>'Tarım teknolojisi, hayvancılık, gıda işleme — bölgenin en büyük tarım fuarı.','summary_en'=>'Agritech, livestock, food processing — region\'s largest agriculture fair.','status'=>'active'],
    ['slug'=>'dugun-hazirliklari-fuari','name_tr'=>'Düğün Hazırlıkları Fuarı','name_en'=>'Wedding Preparations Fair','summary_tr'=>'Mekan, gelinlik, fotoğraf, balayı — düğün için her şey bir arada.','summary_en'=>'Venues, dresses, photo, honeymoon — everything for a wedding.','status'=>'active'],
];
?>

<!-- HERO -->
<section class="fa-hero" data-scene>
    <div class="fa-hero-bg"></div>
    <div class="fa-hero-overlay"></div>
    <div class="fa-hero-content" data-tilt>
        <nav class="fa-breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span>›</span><span><?= lang() === 'en' ? 'Fairs' : 'Fuarlar' ?></span>
        </nav>
        <span class="fa-eyebrow"><?= lang() === 'en' ? 'OUR FAIRS' : 'KENDİ FUARLARIMIZ' ?></span>
        <h1 class="fa-hero-title">
            <span class="fa-line">Dört Fuar.</span>
            <span class="fa-line fa-line-mute"><?= lang() === 'en' ? 'One leader.' : 'Bir öncü.' ?></span>
            <span class="fa-line fa-line-accent"><?= lang() === 'en' ? 'Cyprus.' : 'Kıbrıs.' ?></span>
        </h1>
        <p class="fa-hero-sub">
            <?= lang() === 'en'
                ? 'Annual trade fairs that bring together thousands of visitors with hundreds of exhibitors.'
                : 'Binlerce ziyaretçiyi yüzlerce katılımcıyla buluşturan yıllık ticaret fuarları.' ?>
        </p>
    </div>
</section>

<!-- FAIR CARDS — Stacked perspective -->
<section class="fa-section">
    <div class="fa-container">
        <span class="fa-section-eyebrow" data-reveal>4 SEKTÖREL FUAR</span>
        <h2 class="fa-section-title" data-reveal>
            <?= lang() === 'en'
                ? 'Specialised. Curated. Trusted.'
                : 'Uzmanlık. Kürasyon. Güven.' ?>
        </h2>

        <div class="fa-grid">
            <?php foreach ($displayFairs as $i => $f):
                $name = lang() === 'en' ? ($f['name_en'] ?? $f['name_tr']) : ($f['name_tr'] ?? $f['name_en']);
                $summary = lang() === 'en' ? ($f['summary_en'] ?? $f['summary_tr']) : ($f['summary_tr'] ?? $f['summary_en']);
                $slug = $f['slug'] ?? '';
                $meta = $fairMeta[$slug] ?? null;
                $tagline = $meta ? (lang() === 'en' ? $meta['tagline_en'] : $meta['tagline_tr']) : '';
                $accent  = $meta['accent']  ?? '#E30613';
                $image   = $meta['image']   ?? ($f['image_hero'] ?? '/assets/images/hero-hall.png');
                $icon    = $meta['icon']    ?? '◆';
                $stats   = $meta['stats']   ?? [];
            ?>
            <a href="<?= url('fuarlarimiz/' . $slug) ?>" class="fa-card"
               style="--accent: <?= e($accent) ?>; --reveal-delay: <?= $i * 80 ?>ms"
               data-reveal data-fair-card>

                <div class="fa-card-img" style="background-image: url('<?= e($image) ?>')"></div>
                <div class="fa-card-overlay"></div>

                <div class="fa-card-body">
                    <div class="fa-card-icon"><?= $icon ?></div>
                    <?php if ($tagline): ?>
                    <span class="fa-card-tagline"><?= e($tagline) ?></span>
                    <?php endif; ?>
                    <h3 class="fa-card-title"><?= e($name) ?></h3>
                    <p class="fa-card-summary"><?= e($summary) ?></p>

                    <?php if (!empty($stats)): ?>
                    <div class="fa-card-stats">
                        <?php foreach ($stats as $s): ?>
                        <div class="fa-card-stat">
                            <div class="fa-card-stat-num"><?= e($s['n']) ?></div>
                            <div class="fa-card-stat-label"><?= e($s['l']) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <span class="fa-card-link">
                        <?= lang() === 'en' ? 'Discover' : 'Keşfet' ?>
                        <span class="fa-card-arrow">→</span>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- WHY OUR FAIRS — Big statement -->
<section class="fa-section fa-section-dark">
    <div class="fa-container">
        <span class="fa-section-eyebrow" data-reveal style="color:#fff">NEDEN BİZ?</span>
        <h2 class="fa-big-quote" data-reveal>
            <?= lang() === 'en'
                ? 'We don\'t just <em>host</em> fairs.<br>We <strong>build</strong> them.'
                : 'Biz fuarları sadece <em>düzenlemiyoruz</em>.<br>Onları <strong>inşa ediyoruz</strong>.' ?>
        </h2>
        <p class="fa-quote-sub" data-reveal>
            <?= lang() === 'en'
                ? 'Concept, marketing, exhibitor sales, on-site operations, post-event reports — all from one team.'
                : 'Konsept, pazarlama, katılımcı satışı, sahada operasyon, etkinlik sonrası raporlar — tek bir ekipten.' ?>
        </p>
    </div>
</section>

<!-- CTA -->
<section class="fa-cta">
    <div class="fa-container">
        <h2 class="fa-cta-title" data-reveal><?= lang() === 'en' ? 'Plan your participation.' : 'Katılımınızı planlayın.' ?></h2>
        <p class="fa-cta-sub" data-reveal><?= lang() === 'en' ? 'Let\'s help you stand out at the next fair.' : 'Bir sonraki fuarda öne çıkmanıza yardım edelim.' ?></p>
        <div class="fa-cta-actions" data-reveal>
            <a href="<?= url('teklif-al') ?>" class="fa-btn fa-btn-primary"><?= lang() === 'en' ? 'Get a Quote' : 'Teklif İste' ?> →</a>
            <a href="<?= url('iletisim') ?>" class="fa-btn fa-btn-secondary"><?= lang() === 'en' ? 'Contact us' : 'İletişime geç' ?></a>
        </div>
    </div>
</section>

<style>
.page-fairs-apple {
    --fa-bg:#fff; --fa-bg-alt:#f5f5f7; --fa-bg-dark:#0a0a0a;
    --fa-text:#1d1d1f; --fa-text-mute:#6e6e73; --fa-accent:#E30613;
}
.fa-container { max-width:1280px; margin:0 auto; padding:0 clamp(1.25rem,4vw,3rem); }
.fa-section { padding: clamp(5rem,10vw,9rem) 0; background: var(--fa-bg); color: var(--fa-text); }
.fa-section-dark { background: var(--fa-bg-dark); color:#fff; text-align:center; }
.fa-section-eyebrow {
    display:inline-block; font-size:.8rem; font-weight:700; letter-spacing:.18em;
    color: var(--fa-accent); text-transform:uppercase; margin-bottom:1.5rem;
}
.fa-section-title {
    font-size: clamp(2rem,5vw,4rem); font-weight:700;
    letter-spacing:-.025em; line-height:1.1; margin:0 0 4rem;
    max-width: 1100px;
}
.fa-big-quote {
    font-size: clamp(1.75rem, 5vw, 4rem);
    font-weight:600; letter-spacing:-.025em;
    line-height:1.15; margin:0 auto 1.5rem;
    max-width: 1000px; text-align:center;
}
.fa-big-quote em { color: rgba(255,255,255,.55); font-style:normal; font-weight:500; }
.fa-big-quote strong { color: var(--fa-accent); font-weight:800; }
.fa-quote-sub {
    font-size: 1.125rem; color: rgba(255,255,255,.7);
    max-width: 700px; margin: 0 auto;
}

.fa-btn {
    display:inline-flex; align-items:center; gap:.5rem;
    padding:1rem 2rem; border-radius:980px;
    font-size:1rem; font-weight:500;
    text-decoration:none; transition: transform .25s, box-shadow .25s;
}
.fa-btn-primary { background: var(--fa-accent); color:#fff; }
.fa-btn-primary:hover { transform:translateY(-2px); box-shadow: 0 12px 30px -10px var(--fa-accent); color:#fff; }
.fa-btn-secondary { background: rgba(0,0,0,.05); color: var(--fa-text); }
.fa-btn-secondary:hover { background: rgba(0,0,0,.1); color: var(--fa-text); }

/* HERO */
.fa-hero {
    position:relative; min-height:90vh; min-height:90svh;
    display:flex; align-items:center; justify-content:center;
    overflow:hidden; color:#fff; isolation:isolate; perspective:1500px;
}
.fa-hero-bg {
    position:absolute; inset:-5%; z-index:-2;
    background:
        linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    animation: faGradient 15s ease-in-out infinite alternate;
}
@keyframes faGradient {
    0%   { filter: hue-rotate(0deg); }
    100% { filter: hue-rotate(40deg); }
}
.fa-hero-overlay {
    position:absolute; inset:0; z-index:-1;
    background:
        radial-gradient(ellipse at 20% 20%, rgba(227,6,19,.3) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 80%, rgba(255,107,53,.25) 0%, transparent 50%),
        radial-gradient(ellipse at center, transparent 0%, rgba(0,0,0,.6) 100%);
}
.fa-hero-content {
    text-align:center; max-width:1100px; padding:6rem 1.5rem 4rem;
    transform-style:preserve-3d; transition: transform .15s ease-out;
}
.fa-breadcrumb {
    display:flex; gap:.5rem; justify-content:center;
    color: rgba(255,255,255,.6); font-size:.85rem; margin-bottom:1.5rem;
}
.fa-breadcrumb a { color: rgba(255,255,255,.6); text-decoration:none; }
.fa-eyebrow {
    display:inline-block; font-size:.8rem; font-weight:700; letter-spacing:.2em;
    color:#fff; text-transform:uppercase;
    background: rgba(227,6,19,.2); padding:.4rem 1.2rem;
    border-radius:100px; backdrop-filter: blur(20px);
    border:1px solid rgba(255,255,255,.15); margin-bottom:1.75rem;
}
.fa-hero-title {
    font-size: clamp(3rem, 9vw, 8rem);
    font-weight:800; letter-spacing:-.045em;
    line-height:.95; margin:0 0 1.5rem;
}
.fa-line { display:block; }
.fa-line-mute { color: rgba(255,255,255,.55); font-weight:600; }
.fa-line-accent { color: var(--fa-accent); }
.fa-hero-sub {
    font-size: clamp(1.05rem,1.7vw,1.4rem);
    color: rgba(255,255,255,.85);
    max-width:680px; margin:0 auto;
}

/* FAIR GRID */
.fa-grid {
    display:grid; grid-template-columns: repeat(2, 1fr);
    gap:1.5rem; perspective:1500px;
}
.fa-card {
    position:relative; aspect-ratio: 4/5;
    border-radius: 28px; overflow:hidden;
    text-decoration:none; color:#fff; isolation:isolate;
    transition: transform .5s cubic-bezier(.2,.7,.2,1);
    transform-style:preserve-3d;
}
.fa-card:hover { transform: translateY(-10px) rotateX(2deg); }
.fa-card:hover .fa-card-img { transform: scale(1.08); }
.fa-card-img {
    position:absolute; inset:0; z-index:-2;
    background-size:cover; background-position:center;
    transition: transform .8s cubic-bezier(.2,.7,.2,1);
}
.fa-card-overlay {
    position:absolute; inset:0; z-index:-1;
    background:
        linear-gradient(180deg, transparent 0%, transparent 30%, rgba(0,0,0,.5) 60%, rgba(0,0,0,.95) 100%);
}
.fa-card::before {
    content:''; position:absolute; inset:0; z-index:-1;
    background: linear-gradient(135deg, var(--accent) 0%, transparent 60%);
    opacity:.25; mix-blend-mode: overlay;
}
.fa-card-body {
    position:absolute; bottom:0; left:0; right:0;
    padding: clamp(1.75rem, 3.5vw, 2.75rem);
    display:flex; flex-direction:column; gap:.75rem;
}
.fa-card-icon { font-size:2.5rem; line-height:1; margin-bottom:.5rem; }
.fa-card-tagline {
    display:inline-block; font-size:.8rem; font-weight:700;
    letter-spacing:.12em; text-transform:uppercase;
    color: var(--accent); margin-bottom:.25rem;
    text-shadow: 0 2px 10px rgba(0,0,0,.4);
}
.fa-card-title {
    font-size: clamp(1.5rem, 2.5vw, 2.25rem);
    font-weight:700; letter-spacing:-.02em; line-height:1.1;
    margin:0; color:#fff;
}
.fa-card-summary {
    font-size:.95rem; color: rgba(255,255,255,.85);
    line-height:1.5; margin:0; max-width: 520px;
}
.fa-card-stats {
    display:flex; gap:1.5rem; padding:.75rem 0;
    border-top: 1px solid rgba(255,255,255,.15);
    border-bottom: 1px solid rgba(255,255,255,.15);
    margin-top: .5rem;
}
.fa-card-stat-num {
    font-size: 1.25rem; font-weight:700;
    color:#fff; line-height:1; letter-spacing:-.02em;
}
.fa-card-stat-label {
    font-size:.7rem; color: rgba(255,255,255,.6);
    text-transform:uppercase; letter-spacing:.05em; margin-top:.15rem;
}
.fa-card-link {
    display:inline-flex; align-items:center; gap:.5rem;
    font-size:.95rem; font-weight:500; color:#fff; margin-top:.5rem;
}
.fa-card-arrow {
    width:32px; height:32px; border-radius:50%;
    background: var(--accent);
    display:inline-flex; align-items:center; justify-content:center;
    transition: transform .25s;
}
.fa-card:hover .fa-card-arrow { transform: translateX(4px); }

/* CTA */
.fa-cta { background: var(--fa-bg-alt); text-align:center; padding: clamp(5rem,10vw,8rem) 0; }
.fa-cta-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight:700; letter-spacing:-.025em; line-height:1.1;
    margin:0 0 1rem; color: var(--fa-text);
}
.fa-cta-sub { font-size: 1.125rem; color: var(--fa-text-mute); margin: 0 auto 2.5rem; max-width: 560px; }
.fa-cta-actions { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; }

/* REVEAL */
[data-reveal] {
    opacity:0; transform: translateY(40px) rotateX(8deg);
    transition: opacity 1s cubic-bezier(.2,.7,.2,1) var(--reveal-delay,0ms),
                transform 1s cubic-bezier(.2,.7,.2,1) var(--reveal-delay,0ms);
}
[data-reveal].is-revealed { opacity:1; transform: translateY(0) rotateX(0); }
@media (prefers-reduced-motion: reduce) {
    [data-reveal] { opacity:1; transform:none; transition:none; }
    .fa-hero-bg { animation:none; }
}

@media (max-width: 768px) {
    .fa-grid { grid-template-columns: 1fr; }
    .fa-card { aspect-ratio: 16/10; }
    .fa-card:hover { transform: translateY(-4px); }
}

/* Dark mode */
@media (prefers-color-scheme: dark) {
    .page-fairs-apple { --fa-bg:#000; --fa-bg-alt:#1c1c1e; --fa-text:#f5f5f7; --fa-text-mute:#98989d; }
    .fa-btn-secondary { background: rgba(255,255,255,.08); color: var(--fa-text); }
}
</style>

<script>
(function() {
    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('is-revealed'); obs.unobserve(e.target); }
            });
        }, { threshold: .1, rootMargin: '0px 0px -60px 0px' });
        document.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));
    } else {
        document.querySelectorAll('[data-reveal]').forEach(el => el.classList.add('is-revealed'));
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    // Hero 3D tilt
    const tiltEl = document.querySelector('[data-tilt]');
    const scene = document.querySelector('[data-scene]');
    if (tiltEl && scene) {
        scene.addEventListener('mousemove', (e) => {
            const r = scene.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - .5;
            const y = (e.clientY - r.top)  / r.height - .5;
            tiltEl.style.transform = `rotateY(${x * 5}deg) rotateX(${-y * 5}deg)`;
        });
        scene.addEventListener('mouseleave', () => tiltEl.style.transform = '');
    }

    // Card 3D tilt on mouse
    document.querySelectorAll('[data-fair-card]').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const r = card.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - .5;
            const y = (e.clientY - r.top)  / r.height - .5;
            card.style.transform = `translateY(-10px) rotateY(${x * 5}deg) rotateX(${-y * 5}deg)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });
})();
</script>
