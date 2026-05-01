<?php
$pageTitle       = lang() === 'en'
    ? 'About Us | Expo Cyprus — 22 Years of Trade Fair Excellence in Cyprus'
    : 'Hakkımızda | Expo Cyprus — Kıbrıs\'ta 22 Yıllık Fuarcılık Mükemmelliği';
$metaDescription = lang() === 'en'
    ? 'Expo Cyprus — 22 years of building Cyprus exhibition industry. Founded 2004 under UNIFEX Fuarcılık. 4 annual fairs, 100+ stands, 10+ congresses.'
    : 'Expo Cyprus — Kıbrıs fuar sektörünü 22 yıldır inşa ediyor. 2004\'te UNIFEX Fuarcılık altında kuruldu. 4 yıllık fuar, 100+ stand, 10+ kongre.';
$bodyClass = 'page-about-apple';
$keywords = lang() === 'en'
    ? ['Expo Cyprus', 'UNIFEX', 'Cyprus fair', 'trade show Cyprus', 'congress Cyprus', 'stand design Cyprus', 'exhibition Cyprus']
    : ['Expo Cyprus', 'UNIFEX Fuarcılık', 'Kıbrıs fuar', 'KKTC fuar', 'kongre Kıbrıs', 'stand tasarım', 'fuar organizasyonu'];
$breadcrumb = [
    ['name' => lang() === 'en' ? 'Home' : 'Anasayfa', 'url' => '/'],
    ['name' => lang() === 'en' ? 'About' : 'Hakkımızda', 'url' => '/hakkimizda'],
];
$structured = [
    [
        '@type' => 'AboutPage',
        'name'  => $pageTitle,
        'description' => $metaDescription,
        'mainEntity' => [
            '@type' => 'Organization',
            'name'  => 'Expo Cyprus',
            'foundingDate' => '2004',
            'foundingLocation' => 'Lefkoşa, KKTC',
            'parentOrganization' => 'UNIFEX Fuarcılık Organizasyon Ltd.',
        ],
    ],
];
?>

<!-- ═══════════════════════════════════════════════════════════════
     CINEMATIC HERO — 3D parallax tilt
═══════════════════════════════════════════════════════════════ -->
<section class="ab-hero" data-scene>
    <div class="ab-hero-bg" data-parallax-bg>
        <div class="ab-hero-img" style="background-image: url('/assets/images/about-team.webp');"></div>
    </div>
    <div class="ab-hero-overlay"></div>
    <div class="ab-hero-content" data-tilt>
        <nav class="ab-breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span>›</span>
            <span><?= lang() === 'en' ? 'About' : 'Hakkımızda' ?></span>
        </nav>
        <span class="ab-eyebrow"><?= lang() === 'en' ? 'SINCE 2004' : '2004\'TEN BERİ' ?></span>
        <h1 class="ab-hero-title">
            <span class="ab-line">22 yıl</span>
            <span class="ab-line ab-line-mute"><?= lang() === 'en' ? 'Cyprus exhibition industry.' : 'Kıbrıs fuar sektörü.' ?></span>
            <span class="ab-line ab-line-accent"><?= lang() === 'en' ? 'Built by us.' : 'Bizim eserimiz.' ?></span>
        </h1>
        <div class="ab-hero-actions">
            <a href="#story" class="ab-btn ab-btn-ghost"><?= lang() === 'en' ? 'Our story' : 'Hikayemiz' ?> ↓</a>
        </div>
    </div>
    <div class="ab-scroll-indicator" aria-hidden="true"><span></span></div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     STORY — Big bold statement (Apple Pro page)
═══════════════════════════════════════════════════════════════ -->
<section class="ab-section ab-section-light" id="story">
    <div class="ab-container">
        <span class="ab-section-eyebrow" data-reveal>OUR STORY</span>
        <h2 class="ab-big-title" data-reveal>
            <?= lang() === 'en'
                ? 'Founded in 2004 under <strong>UNIFEX Fuarcılık</strong>, with one belief — Cyprus deserves world-class exhibition infrastructure.'
                : '2004\'te <strong>UNIFEX Fuarcılık</strong> bünyesinde tek bir inançla kuruldu — Kıbrıs dünya standartlarında fuar altyapısını hak ediyor.' ?>
        </h2>
        <div class="ab-story-grid">
            <div class="ab-story-text" data-reveal>
                <?php if (lang() === 'en'): ?>
                <p>What started as a passion project by a handful of professionals has grown into the island's most trusted name in fair and congress organisation.</p>
                <p>Today we run <strong>4 recurring trade fairs</strong>, deliver <strong>100+ stand installations</strong> annually, and host <strong>10+ international congresses</strong>.</p>
                <?php else: ?>
                <p>Bir avuç profesyonelin tutkuyla başlattığı bu yolculuk, bugün adanın en güvenilir fuar ve kongre organizatörüne dönüştü.</p>
                <p>Bugün <strong>4 periyodik ticaret fuarı</strong> düzenliyor, yıllık <strong>100+ stand kurulumu</strong> yapıyor ve <strong>10+ uluslararası kongre</strong> gerçekleştiriyoruz.</p>
                <?php endif; ?>
            </div>
            <div class="ab-story-visual" data-reveal>
                <div class="ab-3d-card" data-tilt-card>
                    <img src="/assets/images/hero-hall.webp" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     STATS — 3D rotating cube cards
═══════════════════════════════════════════════════════════════ -->
<section class="ab-section ab-section-dark">
    <div class="ab-container">
        <span class="ab-section-eyebrow" data-reveal><?= lang() === 'en' ? 'BY THE NUMBERS' : 'SAYILARLA' ?></span>
        <div class="ab-stats">
            <?php
            $stats = lang() === 'en' ? [
                ['num'=>'22+',   'label'=>'Years', 'sub'=>'In business since 2004'],
                ['num'=>'4',     'label'=>'Annual Fairs', 'sub'=>'Recurring trade fairs'],
                ['num'=>'100+',  'label'=>'Stands', 'sub'=>'Built and installed'],
                ['num'=>'10+',   'label'=>'Congresses', 'sub'=>'International events'],
                ['num'=>'50K+',  'label'=>'Visitors', 'sub'=>'Annual fair attendance'],
                ['num'=>'5',     'label'=>'Languages', 'sub'=>'TR / EN / RU / DE / AR'],
            ] : [
                ['num'=>'22+',   'label'=>'Yıl', 'sub'=>'2004\'ten bu yana'],
                ['num'=>'4',     'label'=>'Yıllık Fuar', 'sub'=>'Periyodik ticaret fuarları'],
                ['num'=>'100+',  'label'=>'Stand', 'sub'=>'Tasarlanan ve kurulan'],
                ['num'=>'10+',   'label'=>'Kongre', 'sub'=>'Uluslararası etkinlik'],
                ['num'=>'50K+',  'label'=>'Ziyaretçi', 'sub'=>'Yıllık fuar trafiği'],
                ['num'=>'5',     'label'=>'Dil', 'sub'=>'TR / EN / RU / DE / AR'],
            ];
            foreach ($stats as $i => $s): ?>
            <div class="ab-stat" data-reveal style="--reveal-delay:<?= $i * 60 ?>ms">
                <div class="ab-stat-cube" data-stat-cube>
                    <div class="ab-stat-face ab-stat-face-front">
                        <div class="ab-stat-num"><?= e($s['num']) ?></div>
                        <div class="ab-stat-label"><?= e($s['label']) ?></div>
                    </div>
                    <div class="ab-stat-face ab-stat-face-back">
                        <div class="ab-stat-sub"><?= e($s['sub']) ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     VALUES — Sticky scroll-reveal
═══════════════════════════════════════════════════════════════ -->
<section class="ab-section ab-section-light">
    <div class="ab-container">
        <span class="ab-section-eyebrow" data-reveal><?= lang() === 'en' ? 'WHAT WE STAND FOR' : 'NEYİ TEMSİL EDİYORUZ' ?></span>
        <h2 class="ab-big-title" data-reveal>
            <?= lang() === 'en'
                ? 'Three values. Every project.'
                : 'Üç değer. Her proje.' ?>
        </h2>

        <div class="ab-values">
            <?php
            $values = lang() === 'en' ? [
                ['n'=>'01','t'=>'Discipline','d'=>'Every detail tracked, every deadline kept. Production is a craft.'],
                ['n'=>'02','t'=>'Care','d'=>'A small exhibitor and a Fortune 500 receive the same level of attention.'],
                ['n'=>'03','t'=>'Locality','d'=>'Cyprus expertise. Local logistics, local relationships, local knowledge.'],
            ] : [
                ['n'=>'01','t'=>'Disiplin','d'=>'Her detay takipte, her teslim tarihi tutturulur. Üretim bir zanaattir.'],
                ['n'=>'02','t'=>'Özen','d'=>'Küçük bir KOBİ ve çok uluslu bir marka aynı özeni hak eder.'],
                ['n'=>'03','t'=>'Yerellik','d'=>'Kıbrıs uzmanlığı. Yerel lojistik, yerel ilişkiler, yerel bilgi.'],
            ];
            foreach ($values as $i => $v): ?>
            <div class="ab-value-card" data-reveal style="--reveal-delay:<?= $i * 100 ?>ms">
                <div class="ab-value-num"><?= e($v['n']) ?></div>
                <h3 class="ab-value-title"><?= e($v['t']) ?></h3>
                <p class="ab-value-desc"><?= e($v['d']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     TIMELINE — Horizontal scrolling 3D track
═══════════════════════════════════════════════════════════════ -->
<section class="ab-section ab-section-dark ab-timeline-section">
    <div class="ab-container">
        <span class="ab-section-eyebrow" data-reveal><?= lang() === 'en' ? 'THE JOURNEY' : 'YOLCULUK' ?></span>
        <h2 class="ab-big-title" data-reveal style="color:#fff">
            <?= lang() === 'en' ? 'Two decades of milestones.' : 'Yirmi yıllık dönüm noktaları.' ?>
        </h2>

        <div class="ab-timeline" data-reveal>
            <?php
            $events = lang() === 'en' ? [
                ['2004','Founded in Nicosia','First Consumer Fair launched.'],
                ['2008','First Specialty Fair','Hunting & Outdoor Sports — Cyprus\'s first specialty fair.'],
                ['2012','Agriculture Fair','Annual visitors passed 30,000+.'],
                ['2016','100th Stand','Custom stand installation milestone.'],
                ['2018','Wedding Fair','Wedding Preparations Fair launched.'],
                ['2020','Hybrid Era','Live streaming + digital infrastructure.'],
                ['2022','Expo Cyprus Brand','Rebrand. 50,000+ annual visitors.'],
                ['2024','Industry Leader','4 main fairs · 100+ stands · 10+ congresses.'],
                ['2026','Today','Cyprus\'s leading fair organiser.'],
            ] : [
                ['2004','Lefkoşa\'da Kuruluş','İlk Tüketici Fuarı düzenlendi.'],
                ['2008','İlk İhtisas Fuarı','Av & Doğa Sporları — Kıbrıs\'ın ilk ihtisas fuarı.'],
                ['2012','Tarım Fuarı','Yıllık ziyaretçi 30.000+ aştı.'],
                ['2016','100. Stand','Özel yapım stand kurulumu kilometre taşı.'],
                ['2018','Düğün Fuarı','Düğün Hazırlıkları Fuarı eklendi.'],
                ['2020','Hibrit Dönem','Canlı yayın + dijital altyapı.'],
                ['2022','Expo Cyprus','Marka yenileme. 50.000+ yıllık ziyaretçi.'],
                ['2024','Sektör Lideri','4 ana fuar · 100+ stand · 10+ kongre.'],
                ['2026','Bugün','Kıbrıs\'ın lider fuar organizatörü.'],
            ];
            foreach ($events as $i => $ev): ?>
            <div class="ab-tl-item" data-tl-card>
                <div class="ab-tl-year"><?= e($ev[0]) ?></div>
                <div class="ab-tl-content">
                    <h4><?= e($ev[1]) ?></h4>
                    <p><?= e($ev[2]) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     CTA
═══════════════════════════════════════════════════════════════ -->
<section class="ab-cta">
    <div class="ab-container">
        <h2 class="ab-cta-title" data-reveal><?= lang() === 'en' ? 'Let\'s build the next chapter together.' : 'Sıradaki bölümü birlikte yazalım.' ?></h2>
        <div class="ab-cta-actions" data-reveal>
            <a href="<?= url('teklif-al') ?>" class="ab-btn ab-btn-primary"><?= lang() === 'en' ? 'Start a project' : 'Projeyi başlat' ?> →</a>
            <a href="<?= url('iletisim') ?>" class="ab-btn ab-btn-secondary"><?= lang() === 'en' ? 'Contact us' : 'İletişime geç' ?></a>
        </div>
    </div>
</section>

<style>
/* ═══════════════════════════════════════════════════════════════
   APPLE-STYLE ABOUT — 3D & cinematic
═══════════════════════════════════════════════════════════════ */
.page-about-apple {
    --ab-bg:        #ffffff;
    --ab-bg-alt:    #f5f5f7;
    --ab-bg-dark:   #0a0a0a;
    --ab-text:      #1d1d1f;
    --ab-text-mute: #6e6e73;
    --ab-text-soft: #86868b;
    --ab-accent:    #E30613;
}

.ab-container {
    max-width: 1280px; margin: 0 auto;
    padding: 0 clamp(1.25rem, 4vw, 3rem);
}
.ab-section { padding: clamp(5rem, 10vw, 9rem) 0; }
.ab-section-light { background: var(--ab-bg); color: var(--ab-text); }
.ab-section-dark  { background: var(--ab-bg-dark); color: #fff; }

.ab-section-eyebrow {
    display: inline-block;
    font-size: .8rem; font-weight: 700; letter-spacing: .18em;
    color: var(--ab-accent); text-transform: uppercase;
    margin-bottom: 1.5rem;
}
.ab-big-title {
    font-size: clamp(1.75rem, 4.5vw, 4rem);
    font-weight: 700; letter-spacing: -.025em;
    line-height: 1.1; margin: 0 0 3rem;
    max-width: 1100px;
}
.ab-big-title strong { color: var(--ab-accent); }

/* —— Buttons —— */
.ab-btn {
    display: inline-flex; align-items: center; gap: .55rem;
    padding: 1rem 2rem; border-radius: 980px;
    font-size: 1rem; font-weight: 500;
    text-decoration: none;
    transition: transform .25s, box-shadow .25s;
}
.ab-btn-primary { background: var(--ab-accent); color: #fff; }
.ab-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 30px -10px var(--ab-accent); color:#fff; }
.ab-btn-secondary { background: rgba(0,0,0,.05); color: var(--ab-text); }
.ab-btn-secondary:hover { background: rgba(0,0,0,.1); color: var(--ab-text); }
.ab-btn-ghost {
    background: rgba(255,255,255,.12); color: #fff;
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.2);
}
.ab-btn-ghost:hover { background: rgba(255,255,255,.2); color: #fff; }

/* ═══════════════════════════════════════════════════════════════
   HERO — 3D parallax + tilt
═══════════════════════════════════════════════════════════════ */
.ab-hero {
    position: relative;
    min-height: 100vh; min-height: 100svh;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; color: #fff;
    isolation: isolate;
    perspective: 1500px;
}
.ab-hero-bg {
    position: absolute; inset: -10% -5%;
    z-index: -2; transition: transform .1s ease-out;
    will-change: transform;
}
.ab-hero-img {
    width: 100%; height: 100%;
    background-size: cover; background-position: center;
    transform: scale(1.1);
    animation: abKenBurns 25s ease-in-out infinite alternate;
}
@keyframes abKenBurns {
    0%   { transform: scale(1.05); }
    100% { transform: scale(1.2); }
}
.ab-hero-overlay {
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse at 30% 30%, rgba(227,6,19,.2) 0%, transparent 50%),
        radial-gradient(ellipse at center, rgba(0,0,0,.3) 0%, rgba(0,0,0,.7) 60%, rgba(0,0,0,.95) 100%);
    z-index: -1;
}
.ab-hero-content {
    text-align: center; max-width: 1100px;
    padding: 6rem 1.5rem 4rem;
    transform-style: preserve-3d;
    transition: transform .15s ease-out;
}
.ab-breadcrumb {
    display: flex; gap: .5rem; justify-content: center;
    font-size: .85rem; color: rgba(255,255,255,.6); margin-bottom: 1.5rem;
}
.ab-breadcrumb a { color: rgba(255,255,255,.6); text-decoration: none; }
.ab-eyebrow {
    display: inline-block;
    font-size: .8rem; font-weight: 700; letter-spacing: .2em;
    color: var(--ab-accent); text-transform: uppercase;
    background: rgba(255,255,255,.08); padding: .4rem 1.2rem;
    border-radius: 100px; backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.15);
    margin-bottom: 1.75rem;
}
.ab-hero-title {
    font-size: clamp(3rem, 9vw, 8rem);
    font-weight: 800; letter-spacing: -.045em;
    line-height: .95; margin: 0;
}
.ab-line { display: block; }
.ab-line-mute   { color: rgba(255,255,255,.55); font-weight: 600; }
.ab-line-accent { color: var(--ab-accent); }
.ab-hero-actions { margin-top: 2.5rem; }

.ab-scroll-indicator {
    position: absolute; bottom: 2rem; left: 50%;
    transform: translateX(-50%);
    width: 30px; height: 50px; border: 2px solid rgba(255,255,255,.4);
    border-radius: 100px;
}
.ab-scroll-indicator span {
    position: absolute; left: 50%; top: 8px;
    width: 4px; height: 8px;
    background: #fff; border-radius: 100px;
    transform: translateX(-50%);
    animation: abScroll 2s ease-in-out infinite;
}
@keyframes abScroll {
    0%   { opacity: 0; transform: translate(-50%, 0); }
    50%  { opacity: 1; }
    100% { opacity: 0; transform: translate(-50%, 18px); }
}

/* ═══════════════════════════════════════════════════════════════
   STORY — 3D tilt card
═══════════════════════════════════════════════════════════════ */
.ab-story-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 4rem; align-items: center; margin-top: 3rem;
    perspective: 1500px;
}
.ab-story-text { font-size: 1.125rem; line-height: 1.7; color: var(--ab-text-mute); }
.ab-story-text p { margin-bottom: 1.25rem; }
.ab-story-text strong { color: var(--ab-text); font-weight: 600; }

.ab-3d-card {
    position: relative;
    border-radius: 24px; overflow: hidden;
    aspect-ratio: 4/5;
    transform: rotateY(-8deg) rotateX(4deg);
    transform-style: preserve-3d;
    box-shadow:
        20px 30px 60px rgba(0,0,0,.15),
        -10px -10px 30px rgba(255,255,255,.5);
    transition: transform .4s cubic-bezier(.2,.7,.2,1);
}
.ab-3d-card:hover { transform: rotateY(0deg) rotateX(0deg) scale(1.02); }
.ab-3d-card img {
    width: 100%; height: 100%;
    object-fit: cover;
    transform: translateZ(20px);
}

@media (max-width: 768px) {
    .ab-story-grid { grid-template-columns: 1fr; gap: 2rem; }
    .ab-3d-card { transform: none; }
}

/* ═══════════════════════════════════════════════════════════════
   STATS — 3D flip cubes
═══════════════════════════════════════════════════════════════ */
.ab-stats {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    perspective: 1200px;
}
.ab-stat {}
.ab-stat-cube {
    position: relative; width: 100%; aspect-ratio: 5/3;
    transform-style: preserve-3d;
    transition: transform .8s cubic-bezier(.2,.7,.2,1);
    cursor: default;
}
.ab-stat:hover .ab-stat-cube { transform: rotateY(180deg); }
.ab-stat-face {
    position: absolute; inset: 0;
    backface-visibility: hidden;
    border-radius: 20px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 1.5rem;
}
.ab-stat-face-front {
    background: linear-gradient(135deg, rgba(255,255,255,.05) 0%, rgba(255,255,255,.02) 100%);
    border: 1px solid rgba(255,255,255,.1);
    backdrop-filter: blur(10px);
}
.ab-stat-face-back {
    background: linear-gradient(135deg, var(--ab-accent) 0%, #ff6b35 100%);
    transform: rotateY(180deg);
    color: #fff;
    text-align: center;
}
.ab-stat-num {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 700; letter-spacing: -.04em;
    line-height: 1;
    background: linear-gradient(135deg, #fff 0%, var(--ab-accent) 120%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: .25rem;
}
.ab-stat-label {
    font-size: .9375rem; color: rgba(255,255,255,.7);
    font-weight: 500; letter-spacing: .03em;
}
.ab-stat-sub {
    font-size: 1rem; line-height: 1.4; font-weight: 500;
}

@media (max-width: 768px) {
    .ab-stats { grid-template-columns: repeat(2, 1fr); }
}

/* ═══════════════════════════════════════════════════════════════
   VALUES — Numbered cards with hover lift
═══════════════════════════════════════════════════════════════ */
.ab-values {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 2rem; margin-top: 3rem;
}
.ab-value-card {
    background: var(--ab-bg-alt);
    border-radius: 24px; padding: 2.5rem 2rem;
    transition: transform .35s, box-shadow .35s;
    position: relative; overflow: hidden;
}
.ab-value-card::before {
    content: ''; position: absolute;
    top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--ab-accent), #ff6b35);
    transform: scaleX(0); transform-origin: left;
    transition: transform .4s;
}
.ab-value-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
}
.ab-value-card:hover::before { transform: scaleX(1); }
.ab-value-num {
    font-size: 4rem; font-weight: 800;
    color: var(--ab-accent); line-height: 1;
    margin-bottom: 1.5rem; letter-spacing: -.04em;
    -webkit-text-stroke: 2px var(--ab-accent);
    -webkit-text-fill-color: transparent;
}
.ab-value-card:hover .ab-value-num {
    -webkit-text-fill-color: var(--ab-accent);
}
.ab-value-title {
    font-size: 1.5rem; font-weight: 700;
    color: var(--ab-text); margin: 0 0 .75rem;
}
.ab-value-desc {
    color: var(--ab-text-mute); line-height: 1.6;
    margin: 0; font-size: 1rem;
}

@media (max-width: 768px) {
    .ab-values { grid-template-columns: 1fr; gap: 1rem; }
}

/* ═══════════════════════════════════════════════════════════════
   TIMELINE — Horizontal scroll 3D
═══════════════════════════════════════════════════════════════ */
.ab-timeline-section { background: linear-gradient(180deg, #0a0a0a 0%, #1d1d1f 100%); }
.ab-timeline {
    display: flex; gap: 1.5rem;
    overflow-x: auto; padding: 1rem 0 2rem;
    margin-top: 3rem;
    scroll-snap-type: x mandatory;
    perspective: 1200px;
}
.ab-timeline::-webkit-scrollbar { height: 8px; }
.ab-timeline::-webkit-scrollbar-track { background: rgba(255,255,255,.05); border-radius: 100px; }
.ab-timeline::-webkit-scrollbar-thumb { background: var(--ab-accent); border-radius: 100px; }

.ab-tl-item {
    flex: 0 0 280px; min-width: 280px;
    scroll-snap-align: start;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 20px; padding: 2rem;
    backdrop-filter: blur(20px);
    transition: all .35s cubic-bezier(.2,.7,.2,1);
    transform-style: preserve-3d;
}
.ab-tl-item:hover {
    transform: translateY(-6px) rotateX(5deg);
    background: rgba(255,255,255,.08);
    border-color: var(--ab-accent);
    box-shadow: 0 20px 40px rgba(227,6,19,.2);
}
.ab-tl-year {
    font-size: 2.5rem; font-weight: 800;
    background: linear-gradient(135deg, #fff 0%, var(--ab-accent) 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1; margin-bottom: 1rem;
    letter-spacing: -.03em;
}
.ab-tl-content h4 {
    font-size: 1.125rem; font-weight: 700;
    color: #fff; margin: 0 0 .5rem;
}
.ab-tl-content p {
    font-size: .9rem; color: rgba(255,255,255,.7);
    margin: 0; line-height: 1.5;
}

/* ═══════════════════════════════════════════════════════════════
   CTA
═══════════════════════════════════════════════════════════════ */
.ab-cta {
    background: var(--ab-bg-alt); text-align: center;
    padding: clamp(5rem, 10vw, 8rem) 0;
}
.ab-cta-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 700; letter-spacing: -.025em;
    line-height: 1.1; margin: 0 0 2.5rem;
    color: var(--ab-text);
}
.ab-cta-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

/* ═══════════════════════════════════════════════════════════════
   REVEAL
═══════════════════════════════════════════════════════════════ */
[data-reveal] {
    opacity: 0; transform: translateY(40px) rotateX(10deg);
    transition:
        opacity 1s cubic-bezier(.2,.7,.2,1) var(--reveal-delay, 0ms),
        transform 1s cubic-bezier(.2,.7,.2,1) var(--reveal-delay, 0ms);
}
[data-reveal].is-revealed {
    opacity: 1; transform: translateY(0) rotateX(0deg);
}
@media (prefers-reduced-motion: reduce) {
    [data-reveal] { opacity: 1; transform: none; transition: none; }
    .ab-hero-img,
    .ab-stat-cube,
    .ab-tl-item { animation: none; transform: none; transition: none; }
}

/* Dark mode */
@media (prefers-color-scheme: dark) {
    .page-about-apple {
        --ab-bg: #000; --ab-bg-alt: #1c1c1e;
        --ab-text: #f5f5f7; --ab-text-mute: #98989d;
    }
    .ab-btn-secondary { background: rgba(255,255,255,.08); color: var(--ab-text); }
    .ab-value-card { background: #1c1c1e; }
}
</style>

<script>
(function() {
    // 1. Reveal animations
    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-revealed');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: .1, rootMargin: '0px 0px -80px 0px' });
        document.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));
    } else {
        document.querySelectorAll('[data-reveal]').forEach(el => el.classList.add('is-revealed'));
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    // 2. Hero parallax background (scroll)
    const heroBg = document.querySelector('[data-parallax-bg]');
    if (heroBg) {
        let raf;
        const updateBg = () => {
            const y = window.scrollY;
            heroBg.style.transform = `translate3d(0, ${y * 0.4}px, 0)`;
            raf = null;
        };
        window.addEventListener('scroll', () => {
            if (!raf) raf = requestAnimationFrame(updateBg);
        }, { passive: true });
    }

    // 3. Hero 3D tilt on mouse move
    const tiltEl = document.querySelector('[data-tilt]');
    const scene  = document.querySelector('[data-scene]');
    if (tiltEl && scene) {
        scene.addEventListener('mousemove', (e) => {
            const rect = scene.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width  - 0.5;
            const y = (e.clientY - rect.top)  / rect.height - 0.5;
            tiltEl.style.transform = `rotateY(${x * 6}deg) rotateX(${-y * 6}deg) translateZ(0)`;
        });
        scene.addEventListener('mouseleave', () => {
            tiltEl.style.transform = 'rotateY(0) rotateX(0)';
        });
    }

    // 4. 3D card mouse-tracking
    document.querySelectorAll('[data-tilt-card]').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width  - 0.5;
            const y = (e.clientY - rect.top)  / rect.height - 0.5;
            card.style.transform = `rotateY(${x * 12}deg) rotateX(${-y * 8}deg) scale(1.02)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });

    // 5. Smooth scroll on hero CTA
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', (e) => {
            const id = a.getAttribute('href').slice(1);
            const t = document.getElementById(id);
            if (t) { e.preventDefault(); t.scrollIntoView({ behavior:'smooth' }); }
        });
    });
})();
</script>
