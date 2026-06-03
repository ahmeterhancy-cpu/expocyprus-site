<?php
$name    = lang() === 'en' ? ($fair['name_en'] ?? $fair['name_tr']) : $fair['name_tr'];
$summary = lang() === 'en' ? ($fair['summary_en'] ?? $fair['summary_tr']) : $fair['summary_tr'];
$content = lang() === 'en' ? ($fair['content_en'] ?? $fair['content_tr'] ?? '') : ($fair['content_tr'] ?? '');

$pageTitle       = e($name) . ' | Expo Cyprus';
$metaDescription = e(mb_substr(strip_tags($summary), 0, 160));
$bodyClass       = 'page-fair-detail';
$heroBg          = !empty($fair['image_hero']) ? e($fair['image_hero']) : '';
$accent          = $fair['accent_color'] ?? '#E30613';

// ─── Tarih hesaplamaları ───
$startDate = !empty($fair['next_date']) ? strtotime($fair['next_date']) : null;
$endDate   = !empty($fair['end_date'])  ? strtotime($fair['end_date'])  : $startDate;
$dayCount  = $startDate && $endDate ? (int)(($endDate - $startDate) / 86400) + 1 : null;

// ─── Eyebrow (etkinlik tarih badge'i) ───
$eyebrow = $fair['hero_eyebrow_tr'] ?? null;
if (!$eyebrow && $startDate) {
    $months = lang()==='en'
        ? ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC']
        : ['OCAK','ŞUBAT','MART','NİSAN','MAYIS','HAZİRAN','TEMMUZ','AĞUSTOS','EYLÜL','EKİM','KASIM','ARALIK'];
    $startMonth = $months[(int)date('n', $startDate) - 1];
    if ($endDate && date('Y-m', $startDate) === date('Y-m', $endDate)) {
        $eyebrow = date('j', $startDate) . '–' . date('j', $endDate) . ' ' . $startMonth . ' ' . date('Y', $startDate);
    } else {
        $eyebrow = date('j', $startDate) . ' ' . $startMonth . ' ' . date('Y', $startDate);
    }
}

// ─── Günleri liste olarak çıkar ───
$days = [];
if ($startDate && $endDate) {
    $weekdaysTr = ['Pazar','Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi'];
    $weekdaysEn = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    $weekdays = lang()==='en' ? $weekdaysEn : $weekdaysTr;
    for ($d = $startDate; $d <= $endDate; $d += 86400) {
        $isFirst = ($d === $startDate);
        $hours   = $isFirst ? '18:00 – 22:00' : '10:00 – 22:00';
        $days[] = [
            'day_num'  => date('j', $d),
            'month'    => date('M', $d),
            'weekday'  => $weekdays[(int)date('w', $d)],
            'hours'    => $hours,
            'is_first' => $isFirst,
        ];
    }
}

// ─── Fuar-özel zenginleştirme (slug keyed) ───
// Her fuar için: sektörler, mekan özellikleri, katılımcı ROI, federasyon partner
$fairExtras = [
    'av-avcilik-atis-doga-sporlari-fuari' => [
        'partner' => [
            'label_tr' => 'Resmi Destekçiler',
            'label_en' => 'Official Supporters',
            'tagline_tr' => "Kıbrıs Türk Avcılık Federasyonu'nun resmi destekçiliği, KKTC Başbakanlık ve İç İşleri Bakanlığı'nın katkılarıyla",
            'tagline_en' => "Officially supported by the TRNC Hunting Federation, with contributions from the TRNC Prime Ministry and Ministry of Interior",
            'items' => [
                [
                    'name_tr' => 'KKTC Başbakanlık',
                    'name_en' => 'TRNC Prime Ministry',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 21h18"/><path d="M5 21V8l7-5 7 5v13"/><path d="M9 21v-6h6v6"/><path d="M9 11h.01"/><path d="M15 11h.01"/></svg>',
                ],
                [
                    'name_tr' => 'KKTC İç İşleri Bakanlığı',
                    'name_en' => 'TRNC Ministry of Interior',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>',
                ],
                [
                    'name_tr' => 'KKTC Avcılık Federasyonu',
                    'name_en' => 'TRNC Hunting Federation',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
                ],
            ],
        ],
        'narrative' => [
            'eyebrow_tr' => 'DOĞANIN TUTKUSU',
            'eyebrow_en' => "NATURE'S PASSION",
            'title_tr'   => 'Burada buluşuyor.',
            'title_en'   => 'Meets here.',
            'body_tr'    => "Kıbrıs Türk Avcılık Federasyonu'nun resmi destekçiliğinde, Unifex Fuarcılık'ın 22 yıllık tecrübesiyle düzenlenen KKTC Av, Atıcılık, Balıkçılık, Doğa Sporları ve Kamp Malzemeleri Fuarı; Cyprus Expo 26 markası altında, 2–4 Ekim 2026 tarihlerinde Eski Ercan Havalimanı Binası'nda kapılarını ardına kadar açıyor.\n\nBu fuar yalnızca bir ticaret platformu değil; aynı zamanda Kıbrıs'ta doğanın tüm tutkularını taşıyan binlerce insanı bir araya getiren kültürel bir buluşma. Av sezonu açılışının hemen öncesinde gerçekleşen bu üç gün, sektörün hem profesyonelleri hem son kullanıcıları için yılın en kritik takvim noktası olmaya hazırlanıyor.",
            'body_en'    => "Officially supported by the TRNC Hunting Federation and organised with Unifex Fuarcılık's 22 years of experience, the TRNC Hunting, Shooting, Fishing, Outdoor Sports and Camping Equipment Fair opens its doors at the Old Ercan Airport Building under the Cyprus Expo 26 brand on October 2–4, 2026.\n\nMore than a trade platform — a cultural meeting that brings together thousands sharing nature's passions in Cyprus. Held just before hunting season opens, these three days are set to become the year's most critical calendar moment for both industry professionals and end consumers.",
        ],
        'sectors' => [
            [
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
                'name_tr' => 'Av Ekipmanları',  'name_en' => 'Hunting Gear',
                'desc_tr' => 'Tüfek, optik, kamuflaj, av aksesuarları',
                'desc_en' => 'Rifles, optics, camouflage, hunting accessories',
            ],
            [
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="10"/><line x1="22" y1="12" x2="18" y2="12"/><line x1="6" y1="12" x2="2" y2="12"/><line x1="12" y1="6" x2="12" y2="2"/><line x1="12" y1="22" x2="12" y2="18"/></svg>',
                'name_tr' => 'Atıcılık',  'name_en' => 'Shooting Sports',
                'desc_tr' => 'Atış sporları malzemeleri, profesyonel ve amatör ekipman',
                'desc_en' => 'Shooting sports equipment, pro & amateur gear',
            ],
            [
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M6.5 12c.94-3.46 4.94-6 8.5-6 3.56 0 6.06 2.54 7 6-.94 3.47-3.44 6-7 6s-7.56-2.53-8.5-6Z"/><path d="M2 12c1.5 1.5 5 1.5 7 0"/></svg>',
                'name_tr' => 'Balıkçılık', 'name_en' => 'Fishing',
                'desc_tr' => 'Olta, makine, kamış, dalış, tekne ekipmanı',
                'desc_en' => 'Rods, reels, diving and boat equipment',
            ],
            [
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="m8 3 4 8 5-5 5 15H2L8 3z"/></svg>',
                'name_tr' => 'Doğa Sporları', 'name_en' => 'Outdoor Sports',
                'desc_tr' => 'Dağcılık, trekking, outdoor giyim, navigasyon',
                'desc_en' => 'Mountaineering, trekking, outdoor clothing, navigation',
            ],
            [
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3.5 21 14 3"/><path d="M20.5 21 10 3"/><path d="M15.5 21 12 15l-3.5 6"/><path d="M2 21h20"/></svg>',
                'name_tr' => 'Kamp Malzemeleri', 'name_en' => 'Camping Gear',
                'desc_tr' => 'Çadır, uyku tulumu, mutfak, taşınabilir teknoloji',
                'desc_en' => 'Tents, sleeping bags, kitchen and portable tech',
            ],
        ],
        'sectors_note_tr'      => 've birçok alanlarda.',
        'sectors_note_en'      => 'and many more areas.',
        'sectors_highlight_tr' => '3 gün boyunca 50.000\'i aşkın ziyaretçi, sahada profesyonel demo gösterileri ile fuarda doğanın tutkusunu yaşıyor.',
        'sectors_highlight_en' => 'Over 50,000 visitors across 3 days experience nature\'s passion with professional on-site demos.',
        'venue' => [
            'image'    => '/assets/images/hero-hall.webp',
            'eyebrow_tr' => 'MEKAN',  'eyebrow_en' => 'VENUE',
            'title_tr' => 'Neden Eski Ercan Havalimanı?',
            'title_en' => 'Why Old Ercan Airport?',
            'body_tr'  => "KKTC'nin en ikonik kamu yapılarından biri olan Eski Ercan Havalimanı Binası; yüksek tavanlı geniş holü, doğal ışık alan iç mekanı ve dış alanıyla bu ölçekteki bir fuara ev sahipliği yapmak için ideal. Ziyaretçilerin deneyimi kusursuz tasarlandı.",
            'body_en'  => "One of the most iconic public buildings in TRNC, the Old Ercan Airport Building — with its high-ceilinged hall, naturally lit interior and outdoor area — is ideal for hosting a fair of this scale. Visitor experience is meticulously designed.",
            'stats'    => [
                ['value' => '1.300', 'unit' => 'm²',   'label_tr' => 'Kapalı Sergi & Demo Alanı', 'label_en' => 'Indoor Exhibition & Demo'],
                ['value' => 'Açık',  'unit' => 'alan', 'label_tr' => 'Kamp Sahnelemesi',         'label_en' => 'Camping Showcase'],
                ['value' => '1.000', 'unit' => 'araç', 'label_tr' => 'Ücretsiz Otopark',         'label_en' => 'Free Parking'],
            ],
        ],
        'federation_support' => [
            'eyebrow_tr' => 'FEDERASYON DESTEĞİ',
            'eyebrow_en' => 'FEDERATION SUPPORT',
            'title_tr'   => 'Sektörün otoritesi onayında.',
            'title_en'   => 'Approved by the industry authority.',
            'body_tr'    => "Kıbrıs Türk Avcılık Federasyonu'nun resmi destekçiliği, fuara yalnızca prestij değil; kayıtlı federasyon üyelerine doğrudan davet, atıcılık kulüplerinin organize katılımı ve sektörün otoritesi tarafından onaylanmış güvenilirlik mührü kazandırıyor. Av sezonu açılış mevzuatına dair resmi platform da bu fuar oluyor.",
            'body_en'    => "The official endorsement of the TRNC Hunting Federation brings more than prestige: direct invitations to registered federation members, organised participation by shooting clubs, and a seal of credibility approved by the industry authority. The fair also becomes the official platform for the hunting season opening regulations.",
            'pillars'    => [
                ['tr' => 'Kayıtlı üyelere doğrudan davet',      'en' => 'Direct invitation to registered members'],
                ['tr' => 'Atıcılık kulüplerinin organize katılımı', 'en' => 'Organised club participation'],
                ['tr' => 'Sektörel güvenilirlik mührü',         'en' => 'Industry credibility seal'],
                ['tr' => 'Av sezonu açılışı resmi platformu',   'en' => 'Official platform for season opening'],
            ],
        ],
        'brand_perspective' => [
            'eyebrow_tr' => 'KATILIMCI MARKALAR İÇİN',
            'eyebrow_en' => 'FOR EXHIBITING BRANDS',
            'title_tr'   => 'Marka perspektifinden ne anlama geliyor?',
            'title_en'   => 'What this means from a brand perspective.',
            'blocks'     => [
                [
                    'kicker_tr' => '01',
                    'kicker_en' => '01',
                    'title_tr'  => 'Katılımcı için fuarın anlamı',
                    'title_en'  => 'What the fair means for exhibitors',
                    'body_tr'   => "KKTC pazarındaki sektör profesyonelleri için bu fuar; yıllık satış hacimlerinin önemli bir kısmını yaratacak, sezon trendlerini belirleyecek ve marka tanınırlığını sıçramayla artıracak kritik bir takvim noktası. Eski Ercan'ın geniş demo alanları ise sadece ürün satışı değil, canlı deneyim yaratma imkanı sağlıyor — bir kamp çadırının kurulu halde sergilenmesi, bir oltanın test havuzunda kullanıcının elinde tutulması.",
                    'body_en'   => "For industry professionals in the TRNC market, this fair is a critical calendar point that will generate a significant portion of annual sales, set seasonal trends and dramatically boost brand recognition. Old Ercan's expansive demo areas allow not just product sales but live experience creation — a tent set up on display, a fishing rod held by the user at a test pool.",
                ],
                [
                    'kicker_tr' => '02',
                    'kicker_en' => '02',
                    'title_tr'  => 'Hedef marka kategorisi',
                    'title_en'  => 'Target brand category',
                    'body_tr'   => "Hem lokal KKTC markalarına kendi pazarlarındaki konumlarını güçlendirme, hem TR'den gelen markalar için KKTC pazarına ve TR'ye dönen turist avcılara doğrudan erişim sağlayan fuar; her seviyedeki katılımcı için lead maliyetini 9–10 TL bandına çeken istisnai bir ROI sunuyor.",
                    'body_en'   => "The fair provides local TRNC brands with the chance to strengthen their market position, and brands from Turkey with direct access to the TRNC market and to hunters returning to Turkey as tourists — offering exceptional ROI by reducing lead cost to the 9–10 TRY range for exhibitors at every level.",
                ],
                [
                    'kicker_tr' => '03',
                    'kicker_en' => '03',
                    'title_tr'  => 'Federasyon çarpanı',
                    'title_en'  => 'Federation multiplier',
                    'body_tr'   => "Kıbrıs Türk Avcılık Federasyonu'nun resmi davet kanalı, kayıtlı üye veri tabanına doğrudan erişim sağlıyor. Rastgele bir ziyaretçinin değil; sektörel kimliği belli, satın alma niyeti yüksek, federasyon kanalıyla doğrulanmış bir ziyaretçinin fuara gelmesini garanti ediyor.",
                    'body_en'   => "The TRNC Hunting Federation's official invitation channel provides direct access to the registered member database. Not a random visitor — a visitor with a clear sector identity, high purchase intent, verified through the federation channel is guaranteed to attend.",
                ],
                [
                    'kicker_tr' => '04',
                    'kicker_en' => '04',
                    'title_tr'  => 'Stand sahipleri için ne anlama geliyor?',
                    'title_en'  => 'What it means for stand owners',
                    'body_tr'   => "Yukarıdaki profil bir sayı değil; standınıza yaklaşan her ziyaretçinin sizin ürününüze gerçekten ilgi duyma olasılığının çarpıcı yüksek olduğu anlamına geliyor. Standart bir B2C fuarında 1000 ziyaretçi içinden 35–50 kişi lead olurken, bu fuarda aynı sayı 150–200 kişiye çıkıyor — yani sektörel ihtisas fuarlarının doğal ROI üstünlüğü.",
                    'body_en'   => "The profile above isn't just a number — it means every visitor approaching your stand has a dramatically higher likelihood of being genuinely interested in your product. While a standard B2C fair converts 35–50 leads per 1,000 visitors, here that number jumps to 150–200 — the natural ROI advantage of sector-specific specialised fairs.",
                ],
            ],
        ],
        'sponsors' => [
            'eyebrow_tr' => 'DESTEKLEYENLER',
            'eyebrow_en' => 'OFFICIAL SUPPORTERS',
            'items' => [
                ['name' => 'KKTC Başbakanlık',         'sub' => '',     'badge' => 'B'],
                ['name' => 'KKTC İç İşleri Bakanlığı', 'sub' => '',     'badge' => 'İ'],
                ['name' => 'KKTC Avcılık Federasyonu', 'sub' => '1971', 'badge' => 'A'],
                ['name' => 'Cyprus Expo 26',           'sub' => 'by UNIFEX Fuarcılık', 'badge' => 'C'],
            ],
        ],
    ],
];

$extras = $fairExtras[$fair['slug'] ?? ''] ?? null;
?>

<!-- ═══════════════════════════════════════════════════════════════
     1. CINEMATIC HERO
═══════════════════════════════════════════════════════════════ -->
<section class="fd-hero" data-fd-hero>
    <?php if ($heroBg): ?>
    <div class="fd-hero-bg" style="background-image:url('<?= $heroBg ?>');"></div>
    <?php endif; ?>
    <div class="fd-hero-overlay"></div>

    <div class="fd-hero-content">
        <nav class="fd-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span aria-hidden="true">›</span>
            <a href="<?= url('fuarlarimiz') ?>"><?= lang() === 'en' ? 'Our Fairs' : 'Fuarlarımız' ?></a>
        </nav>

        <?php if ($eyebrow): ?>
        <span class="fd-eyebrow"><?= e($eyebrow) ?></span>
        <?php endif; ?>

        <h1 class="fd-title"><?= e($name) ?></h1>

        <?php if ($summary): ?>
        <p class="fd-tagline"><?= e(mb_substr($summary, 0, 200)) ?></p>
        <?php endif; ?>

        <div class="fd-hero-meta">
            <?php if ($startDate): ?>
            <div class="fd-meta-pill">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span><?= date('d M', $startDate) ?><?php if ($endDate && $endDate !== $startDate): ?> – <?= date('d M Y', $endDate) ?><?php else: ?> <?= date('Y', $startDate) ?><?php endif; ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($fair['location'])): ?>
            <div class="fd-meta-pill">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                <span><?= e($fair['location']) ?></span>
            </div>
            <?php endif; ?>
            <div class="fd-meta-pill fd-meta-pill-accent">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <span><?= lang() === 'en' ? 'Free Entry' : 'Ücretsiz Giriş' ?></span>
            </div>
        </div>

        <div class="fd-hero-actions">
            <a href="#katilim-form" class="fd-btn fd-btn-primary">
                <?= lang() === 'en' ? 'Apply to Exhibit' : 'Fuara Katıl' ?>
                <span aria-hidden="true">→</span>
            </a>
            <a href="#program" class="fd-btn fd-btn-ghost">
                <?= lang() === 'en' ? 'View Program' : 'Programı Gör' ?>
            </a>
        </div>
    </div>

    <div class="fd-scroll-indicator" aria-hidden="true">
        <div class="fd-scroll-line"></div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     2. STICKY INFO BAR
═══════════════════════════════════════════════════════════════ -->
<div class="fd-sticky-bar" data-fd-sticky>
    <div class="fd-container">
        <div class="fd-sticky-inner">
            <div class="fd-sticky-info">
                <?php if ($eyebrow): ?>
                <span class="fd-sticky-date"><?= e($eyebrow) ?></span>
                <?php endif; ?>
                <span class="fd-sticky-divider">·</span>
                <?php if (!empty($fair['location'])): ?>
                <span class="fd-sticky-loc"><?= e($fair['location']) ?></span>
                <?php endif; ?>
            </div>
            <a href="#katilim-form" class="fd-btn fd-btn-primary fd-btn-sm">
                <?= lang() === 'en' ? 'Apply' : 'Katıl' ?> →
            </a>
        </div>
    </div>
</div>

<?php if ($extras && !empty($extras['narrative'])): ?>
<!-- ═══════════════════════════════════════════════════════════════
     3. NARRATIVE — kültürel buluşma + federasyon partner badge
═══════════════════════════════════════════════════════════════ -->
<section class="fd-narrative">
    <div class="fd-container">
        <div class="fd-narrative-grid">
            <div class="fd-narrative-text">
                <span class="fd-block-eyebrow"><?= e(lang()==='en' ? $extras['narrative']['eyebrow_en'] : $extras['narrative']['eyebrow_tr']) ?></span>
                <h2 class="fd-narrative-title"><?= e(lang()==='en' ? $extras['narrative']['title_en'] : $extras['narrative']['title_tr']) ?></h2>
                <p class="fd-narrative-body"><?= e(lang()==='en' ? $extras['narrative']['body_en'] : $extras['narrative']['body_tr']) ?></p>
            </div>
            <?php if (!empty($extras['partner']) && !empty($extras['partner']['items'])): ?>
            <aside class="fd-partner-card">
                <span class="fd-partner-label"><?= e(lang()==='en' ? $extras['partner']['label_en'] : $extras['partner']['label_tr']) ?></span>
                <div class="fd-partner-list">
                    <?php foreach ($extras['partner']['items'] as $p): ?>
                    <div class="fd-partner-item">
                        <div class="fd-partner-icon"><?= $p['icon'] ?></div>
                        <div class="fd-partner-info">
                            <h4 class="fd-partner-name"><?= e(lang()==='en' ? $p['name_en'] : $p['name_tr']) ?></h4>
                            <?php if (!empty($p['sub'])): ?>
                            <span class="fd-partner-sub"><?= e($p['sub']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <p class="fd-partner-tagline"><?= e(lang()==='en' ? $extras['partner']['tagline_en'] : $extras['partner']['tagline_tr']) ?></p>
            </aside>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($extras && !empty($extras['sectors'])): ?>
<!-- ═══════════════════════════════════════════════════════════════
     4. SECTORS GRID — Üç Gün, Beş Sektör, Bir Tutku
═══════════════════════════════════════════════════════════════ -->
<section class="fd-sectors">
    <div class="fd-container">
        <div class="fd-block-head fd-block-head-center">
            <span class="fd-block-eyebrow"><?= lang()==='en' ? 'THREE DAYS, FIVE SECTORS, ONE PASSION' : 'ÜÇ GÜN, BEŞ SEKTÖR, BİR TUTKU' ?></span>
            <h2 class="fd-block-title"><?= lang()==='en' ? 'Five core categories.' : 'Beş ana sektör başlığı.' ?></h2>
        </div>
        <div class="fd-sectors-grid">
            <?php foreach ($extras['sectors'] as $i => $s): ?>
            <div class="fd-sector-card" style="--fd-delay:<?= $i * 60 ?>ms">
                <div class="fd-sector-icon"><?= $s['icon'] ?></div>
                <h3 class="fd-sector-name"><?= e(lang()==='en' ? $s['name_en'] : $s['name_tr']) ?></h3>
                <p class="fd-sector-desc"><?= e(lang()==='en' ? $s['desc_en'] : $s['desc_tr']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($extras['sectors_note_tr'])): ?>
        <p class="fd-sectors-note"><?= e(lang()==='en' ? $extras['sectors_note_en'] : $extras['sectors_note_tr']) ?></p>
        <?php endif; ?>
        <?php if (!empty($extras['sectors_highlight_tr'])): ?>
        <div class="fd-sectors-highlight">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <p><?= e(lang()==='en' ? $extras['sectors_highlight_en'] : $extras['sectors_highlight_tr']) ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php if ($extras && !empty($extras['venue'])): ?>
<!-- ═══════════════════════════════════════════════════════════════
     5. VENUE SPOTLIGHT — Eski Ercan
═══════════════════════════════════════════════════════════════ -->
<section class="fd-venue">
    <div class="fd-container">
        <div class="fd-venue-grid">
            <div class="fd-venue-image">
                <img src="<?= e($extras['venue']['image']) ?>" alt="<?= e(lang()==='en' ? $extras['venue']['title_en'] : $extras['venue']['title_tr']) ?>" loading="lazy">
            </div>
            <div class="fd-venue-text">
                <span class="fd-block-eyebrow"><?= e(lang()==='en' ? $extras['venue']['eyebrow_en'] : $extras['venue']['eyebrow_tr']) ?></span>
                <h2 class="fd-block-title"><?= e(lang()==='en' ? $extras['venue']['title_en'] : $extras['venue']['title_tr']) ?></h2>
                <p class="fd-venue-body"><?= e(lang()==='en' ? $extras['venue']['body_en'] : $extras['venue']['body_tr']) ?></p>
                <div class="fd-venue-stats">
                    <?php foreach ($extras['venue']['stats'] as $st): ?>
                    <div class="fd-venue-stat">
                        <div class="fd-venue-stat-value">
                            <?= e($st['value']) ?>
                            <?php if (!empty($st['unit'])): ?><span class="fd-venue-stat-unit"><?= e($st['unit']) ?></span><?php endif; ?>
                        </div>
                        <div class="fd-venue-stat-label"><?= e(lang()==='en' ? $st['label_en'] : $st['label_tr']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($extras && !empty($extras['federation_support'])): ?>
<!-- ═══════════════════════════════════════════════════════════════
     6. FEDERASYON DESTEĞİ
═══════════════════════════════════════════════════════════════ -->
<section class="fd-fed">
    <div class="fd-container">
        <div class="fd-fed-grid">
            <div class="fd-fed-text">
                <span class="fd-block-eyebrow"><?= e(lang()==='en' ? $extras['federation_support']['eyebrow_en'] : $extras['federation_support']['eyebrow_tr']) ?></span>
                <h2 class="fd-block-title"><?= e(lang()==='en' ? $extras['federation_support']['title_en'] : $extras['federation_support']['title_tr']) ?></h2>
                <p class="fd-fed-body"><?= e(lang()==='en' ? $extras['federation_support']['body_en'] : $extras['federation_support']['body_tr']) ?></p>
            </div>
            <div class="fd-fed-pillars">
                <?php foreach ($extras['federation_support']['pillars'] as $p): ?>
                <div class="fd-fed-pillar">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>
                    <span><?= e(lang()==='en' ? $p['en'] : $p['tr']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($extras && !empty($extras['brand_perspective'])): ?>
<!-- ═══════════════════════════════════════════════════════════════
     7. BRAND PERSPECTIVE — Katılımcı Marka için 4 alt blok
═══════════════════════════════════════════════════════════════ -->
<section class="fd-roi">
    <div class="fd-container">
        <div class="fd-block-head fd-block-head-center">
            <span class="fd-block-eyebrow"><?= e(lang()==='en' ? $extras['brand_perspective']['eyebrow_en'] : $extras['brand_perspective']['eyebrow_tr']) ?></span>
            <h2 class="fd-block-title fd-block-title-inverse"><?= e(lang()==='en' ? $extras['brand_perspective']['title_en'] : $extras['brand_perspective']['title_tr']) ?></h2>
        </div>
        <div class="fd-bp-grid">
            <?php foreach ($extras['brand_perspective']['blocks'] as $b): ?>
            <article class="fd-bp-card">
                <span class="fd-bp-kicker"><?= e(lang()==='en' ? $b['kicker_en'] : $b['kicker_tr']) ?></span>
                <h3 class="fd-bp-title"><?= e(lang()==='en' ? $b['title_en'] : $b['title_tr']) ?></h3>
                <p class="fd-bp-body"><?= e(lang()==='en' ? $b['body_en'] : $b['body_tr']) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($extras && !empty($extras['sponsors'])): ?>
<!-- ═══════════════════════════════════════════════════════════════
     8. SPONSORS — destekleyenler
═══════════════════════════════════════════════════════════════ -->
<section class="fd-sponsors">
    <div class="fd-container">
        <div class="fd-block-head fd-block-head-center">
            <span class="fd-block-eyebrow"><?= e(lang()==='en' ? $extras['sponsors']['eyebrow_en'] : $extras['sponsors']['eyebrow_tr']) ?></span>
        </div>
        <div class="fd-sponsors-grid">
            <?php foreach ($extras['sponsors']['items'] as $sp): ?>
            <div class="fd-sponsor">
                <div class="fd-sponsor-badge"><?= e($sp['badge']) ?></div>
                <div class="fd-sponsor-name"><?= e($sp['name']) ?></div>
                <?php if (!empty($sp['sub'])): ?>
                <div class="fd-sponsor-sub"><?= e($sp['sub']) ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($days)): ?>
<!-- ═══════════════════════════════════════════════════════════════
     7. PROGRAM — gün gün
═══════════════════════════════════════════════════════════════ -->
<section id="program" class="fd-program">
    <div class="fd-container">
        <div class="fd-block-head fd-block-head-center">
            <span class="fd-block-eyebrow"><?= lang()==='en' ? 'PROGRAM' : 'PROGRAM' ?></span>
            <h2 class="fd-block-title"><?= lang()==='en' ? 'Day by day schedule.' : 'Gün gün program.' ?></h2>
        </div>
        <div class="fd-program-grid">
            <?php foreach ($days as $day): ?>
            <div class="fd-day-card">
                <div class="fd-day-num"><?= e($day['day_num']) ?></div>
                <div class="fd-day-info">
                    <div class="fd-day-name"><?= e($day['weekday']) ?></div>
                    <div class="fd-day-hours">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span><?= e($day['hours']) ?></span>
                    </div>
                </div>
                <?php if ($day['is_first']): ?>
                <span class="fd-day-badge"><?= lang()==='en' ? 'Opening' : 'Açılış' ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!$extras && !empty($content)): ?>
<!-- ═══════════════════════════════════════════════════════════════
     7B. PROSE FALLBACK — extras yoksa content_tr göster
═══════════════════════════════════════════════════════════════ -->
<section class="fd-prose-section">
    <div class="fd-container">
        <div class="fd-prose"><?= $content ?></div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($fair['location'])): ?>
<!-- ═══════════════════════════════════════════════════════════════
     8. MAP
═══════════════════════════════════════════════════════════════ -->
<section class="fd-map-section">
    <div class="fd-container">
        <div class="fd-block-head">
            <span class="fd-block-eyebrow"><?= lang()==='en' ? 'LOCATION' : 'KONUM' ?></span>
            <h2 class="fd-block-title"><?= e($fair['location']) ?></h2>
        </div>
        <div class="fd-map-wrap">
            <iframe class="fd-map" src="https://www.google.com/maps?q=<?= urlencode($fair['location']) ?>&output=embed" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════════
     9. KATILIM FORMU — full-width centered card
═══════════════════════════════════════════════════════════════ -->
<section class="fd-form-section">
    <div class="fd-container">
        <div id="katilim-form" class="fd-form-card" style="scroll-margin-top:90px;">
            <span class="fd-form-eyebrow"><?= lang()==='en' ? 'EXHIBITOR APPLICATION' : 'KATILIMCI BAŞVURUSU' ?></span>
            <h3 class="fd-form-title"><?= lang()==='en' ? 'Apply to this fair' : 'Bu fuara katıl' ?></h3>
            <p class="fd-form-sub">
                <?= lang() === 'en'
                    ? 'Submit your application. We respond within 24 hours with stand options and packages tailored to this event.'
                    : 'Başvurunuzu gönderin. 24 saat içinde, bu etkinliğe özel stand seçenekleri ve paketler ile dönüş yapıyoruz.' ?>
            </p>

            <form action="<?= url('iletisim') ?>" method="POST" class="fd-form">
                <?= csrf_field() ?>
                <input type="hidden" name="subject" value="<?= e($name) ?> - <?= lang()==='en' ? 'Fair Application' : 'Fuar Katılım Başvurusu' ?>">

                <div class="fd-form-row">
                    <div class="fd-form-group">
                        <input type="text" name="name" class="fd-input" placeholder="<?= lang() === 'en' ? 'Your Name *' : 'Adınız *' ?>" required>
                    </div>
                    <div class="fd-form-group">
                        <input type="text" name="company" class="fd-input" placeholder="<?= lang() === 'en' ? 'Company / Brand' : 'Şirket / Marka' ?>">
                    </div>
                </div>
                <div class="fd-form-row">
                    <div class="fd-form-group">
                        <input type="email" name="email" class="fd-input" placeholder="<?= lang() === 'en' ? 'Email *' : 'E-posta *' ?>" required>
                    </div>
                    <div class="fd-form-group">
                        <input type="tel" name="phone" class="fd-input" placeholder="<?= lang() === 'en' ? 'Phone *' : 'Telefon *' ?>" required>
                    </div>
                </div>
                <div class="fd-form-group">
                    <textarea name="message" rows="3" class="fd-input" placeholder="<?= lang() === 'en' ? 'Stand size, sector, notes…' : 'Stand ihtiyacı, sektör, notlar…' ?>"></textarea>
                </div>
                <button type="submit" class="fd-btn fd-btn-primary fd-btn-lg fd-btn-block">
                    <?= lang() === 'en' ? 'Submit Application' : 'Başvuruyu Gönder' ?>
                    <span aria-hidden="true">→</span>
                </button>
                <p class="fd-form-foot">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span><?= lang()==='en' ? '24h response guaranteed · Free consultation' : '24 saat içinde dönüş garantili · Ücretsiz danışma' ?></span>
                </p>
            </form>

            <div class="fd-form-contact">
                <a href="tel:+905488303000" class="fd-side-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13 1 .37 1.97.72 2.91a2 2 0 0 1-.45 2.11L8.09 10.09a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.94.35 1.91.59 2.91.72A2 2 0 0 1 22 16.92z"/></svg>
                    <span>+90 548 830 30 00</span>
                </a>
                <a href="mailto:info@expocyprus.com" class="fd-side-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span>info@expocyprus.com</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     10. BOTTOM CTA BANNER
═══════════════════════════════════════════════════════════════ -->
<section class="fd-cta-banner">
    <?php if ($heroBg): ?>
    <div class="fd-cta-bg" style="background-image:url('<?= $heroBg ?>');"></div>
    <?php endif; ?>
    <div class="fd-cta-overlay"></div>
    <div class="fd-container">
        <div class="fd-cta-content">
            <span class="fd-eyebrow"><?= lang()==='en' ? 'READY?' : 'HAZIR MISIN?' ?></span>
            <h2 class="fd-cta-title">
                <?= lang() === 'en' ? 'Your brand at this fair.' : 'Markanız bu fuarda.' ?>
            </h2>
            <p class="fd-cta-sub">
                <?= lang() === 'en' ? 'Apply now to secure your stand. Limited spots available.' : 'Standınızı bugünden ayırtın. Sınırlı kontenjan.' ?>
            </p>
            <div class="fd-cta-actions">
                <a href="#katilim-form" class="fd-btn fd-btn-primary fd-btn-lg">
                    <?= lang() === 'en' ? 'Apply Now' : 'Hemen Başvur' ?> →
                </a>
                <a href="<?= url('iletisim') ?>" class="fd-btn fd-btn-ghost fd-btn-lg">
                    <?= lang() === 'en' ? 'Contact Us' : 'Bize Ulaşın' ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     STYLE
═══════════════════════════════════════════════════════════════ -->
<style>
.page-fair-detail {
    --fd-bg: #ffffff; --fd-bg-alt: #f5f5f7; --fd-bg-dark: #0a0a0a;
    --fd-text: #1d1d1f; --fd-text-mute: #6e6e73; --fd-text-soft: #86868b;
    --fd-accent: <?= e($accent) ?>; --fd-border: #e5e5e7;
}
.fd-container { max-width: 1280px; margin: 0 auto; padding: 0 clamp(1.25rem, 4vw, 3rem); }

/* ═══ BUTONS ═══ */
.fd-btn { display: inline-flex; align-items: center; gap: .55rem; padding: .95rem 1.75rem; border-radius: 980px; font-size: .9375rem; font-weight: 600; text-decoration: none; border: 0; cursor: pointer; transition: transform .25s, box-shadow .25s, background .2s; font-family: inherit; }
.fd-btn-primary { background: var(--fd-accent); color: #fff; }
.fd-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 16px 32px -10px var(--fd-accent); color: #fff; }
.fd-btn-ghost { background: rgba(255,255,255,.12); color: #fff; backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,.2); }
.fd-btn-ghost:hover { background: rgba(255,255,255,.2); color: #fff; }
.fd-btn-block { width: 100%; justify-content: center; }
.fd-btn-sm { padding: .55rem 1.1rem; font-size: .85rem; }
.fd-btn-lg { padding: 1.15rem 2.25rem; font-size: 1.0625rem; }

.fd-eyebrow { display: inline-block; font-size: .75rem; font-weight: 700; letter-spacing: .2em; color: var(--fd-accent); text-transform: uppercase; background: rgba(255,255,255,.08); padding: .4rem 1.1rem; border-radius: 100px; backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,.15); margin-bottom: 1.5rem; }
.fd-block-head { margin-bottom: 2.5rem; }
.fd-block-head-center { text-align: center; max-width: 760px; margin-left: auto; margin-right: auto; }
.fd-block-eyebrow { display: inline-block; font-size: .75rem; font-weight: 700; letter-spacing: .18em; color: var(--fd-accent); text-transform: uppercase; margin-bottom: .75rem; }
.fd-block-title { font-size: clamp(1.75rem, 3.5vw, 2.75rem); font-weight: 700; letter-spacing: -.025em; color: var(--fd-text); line-height: 1.15; margin: 0; }
.fd-block-title-inverse { color: #fff; }

/* ═══ 1. HERO ═══ */
.fd-hero { position: relative; min-height: 92vh; min-height: 92svh; display: flex; align-items: center; justify-content: center; overflow: hidden; isolation: isolate; color: #fff; text-align: center; }
.fd-hero-bg { position: absolute; inset: -10%; z-index: -2; background-size: cover; background-position: center; transform: scale(1.08); animation: fdKenBurns 22s ease-in-out infinite alternate; }
@keyframes fdKenBurns { 0% { transform: scale(1.08); } 100% { transform: scale(1.18); } }
.fd-hero-overlay { position: absolute; inset: 0; z-index: -1; background: radial-gradient(ellipse at 50% 30%, rgba(0,0,0,.35) 0%, rgba(0,0,0,.75) 60%, rgba(0,0,0,.95) 100%); }
.fd-hero-content { max-width: 980px; padding: 7rem 1.5rem 4rem; }
.fd-breadcrumb { display: flex; gap: .5rem; justify-content: center; align-items: center; font-size: .85rem; color: rgba(255,255,255,.6); margin-bottom: 1.5rem; }
.fd-breadcrumb a { color: rgba(255,255,255,.7); text-decoration: none; transition: color .2s; }
.fd-breadcrumb a:hover { color: #fff; }
.fd-title { font-size: clamp(2.25rem, 6vw, 5rem); font-weight: 800; letter-spacing: -.04em; line-height: 1.02; margin: 0 0 1rem; color: #fff; }
.fd-tagline { font-size: clamp(1rem, 1.6vw, 1.3rem); color: rgba(255,255,255,.82); line-height: 1.5; max-width: 740px; margin: 0 auto 2rem; }
.fd-hero-meta { display: flex; flex-wrap: wrap; gap: .75rem; justify-content: center; margin-bottom: 2.5rem; }
.fd-meta-pill { display: inline-flex; align-items: center; gap: .5rem; background: rgba(255,255,255,.1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,.15); padding: .55rem 1.1rem; border-radius: 100px; font-size: .875rem; color: rgba(255,255,255,.92); font-weight: 500; }
.fd-meta-pill svg { opacity: .8; flex-shrink: 0; }
.fd-meta-pill-accent { background: var(--fd-accent); border-color: var(--fd-accent); color: #fff; }
.fd-meta-pill-accent svg { opacity: 1; }
.fd-hero-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
.fd-scroll-indicator { position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); }
.fd-scroll-line { width: 1px; height: 50px; background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(255,255,255,.6) 100%); animation: fdScroll 2.4s ease-in-out infinite; }
@keyframes fdScroll { 0%, 100% { opacity: .3; } 50% { opacity: 1; } }

/* ═══ 2. STICKY BAR ═══ */
.fd-sticky-bar { position: sticky; top: 0; z-index: 90; background: rgba(255,255,255,.85); backdrop-filter: blur(20px) saturate(180%); -webkit-backdrop-filter: blur(20px) saturate(180%); border-bottom: 1px solid var(--fd-border); opacity: 0; pointer-events: none; transform: translateY(-10px); transition: opacity .3s, transform .3s; }
.fd-sticky-bar.is-visible { opacity: 1; pointer-events: auto; transform: translateY(0); }
.fd-sticky-inner { padding: .85rem 0; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
.fd-sticky-info { display: flex; gap: .5rem; align-items: center; font-size: .9rem; color: var(--fd-text); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.fd-sticky-date { font-weight: 700; color: var(--fd-accent); letter-spacing: .03em; }
.fd-sticky-divider { color: var(--fd-text-soft); }
.fd-sticky-loc { color: var(--fd-text-mute); }
@media (max-width: 600px) { .fd-sticky-divider, .fd-sticky-loc { display: none; } }

/* ═══ 3. NARRATIVE ═══ */
.fd-narrative { padding: clamp(4rem, 8vw, 7rem) 0; background: var(--fd-bg); }
.fd-narrative-grid { display: grid; grid-template-columns: 1.5fr 1fr; gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.fd-narrative-title { font-size: clamp(2rem, 4.5vw, 3.5rem); font-weight: 800; letter-spacing: -.03em; color: var(--fd-text); line-height: 1.05; margin: 1rem 0 1.5rem; }
.fd-narrative-body { font-size: clamp(1rem, 1.4vw, 1.1875rem); color: var(--fd-text-mute); line-height: 1.7; margin: 0; }
.fd-partner-card { background: linear-gradient(180deg, var(--fd-bg-alt) 0%, var(--fd-bg) 100%); border: 1px solid var(--fd-border); border-radius: 24px; padding: 1.75rem 1.5rem 1.5rem; position: relative; }
.fd-partner-card::before { content: ''; position: absolute; top: 0; left: 24px; right: 24px; height: 3px; background: linear-gradient(90deg, var(--fd-accent), #ff6b35); border-radius: 0 0 100px 100px; }
.fd-partner-label { display: block; font-size: .7rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; color: var(--fd-accent); margin-bottom: 1.25rem; text-align: center; }
.fd-partner-list { display: flex; flex-direction: column; gap: .65rem; margin-bottom: 1.25rem; }
.fd-partner-item { display: flex; align-items: center; gap: .85rem; padding: .85rem; background: var(--fd-bg); border: 1px solid var(--fd-border); border-radius: 14px; transition: border-color .25s, transform .25s, background .25s; }
.fd-partner-item:hover { border-color: var(--fd-accent); transform: translateX(2px); background: #fff; }
.fd-partner-icon { flex-shrink: 0; width: 42px; height: 42px; border-radius: 12px; background: rgba(227,6,19,.08); color: var(--fd-accent); display: flex; align-items: center; justify-content: center; transition: background .25s, color .25s; }
.fd-partner-icon svg { width: 20px; height: 20px; }
.fd-partner-item:hover .fd-partner-icon { background: var(--fd-accent); color: #fff; }
.fd-partner-info { flex: 1; min-width: 0; }
.fd-partner-name { font-size: .9375rem; font-weight: 700; color: var(--fd-text); margin: 0; line-height: 1.25; }
.fd-partner-sub { font-size: .75rem; color: var(--fd-text-soft); font-weight: 600; letter-spacing: .05em; }
.fd-partner-tagline { font-size: .85rem; color: var(--fd-text-mute); line-height: 1.55; margin: 0; padding-top: 1rem; border-top: 1px solid var(--fd-border); text-align: center; font-style: italic; }
@media (max-width: 900px) { .fd-narrative-grid { grid-template-columns: 1fr; } }

/* ═══ 4. SECTORS GRID ═══ */
.fd-sectors { padding: clamp(4rem, 8vw, 7rem) 0; background: var(--fd-bg-alt); }
.fd-sectors-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; }
.fd-sector-card { background: var(--fd-bg); border: 1px solid var(--fd-border); border-radius: 20px; padding: 1.75rem 1.5rem; text-align: left; transition: transform .3s, box-shadow .3s, border-color .3s; position: relative; overflow: hidden; }
.fd-sector-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--fd-accent), #ff6b35); transform: scaleX(0); transform-origin: left; transition: transform .4s; }
.fd-sector-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.08); border-color: var(--fd-accent); }
.fd-sector-card:hover::before { transform: scaleX(1); }
.fd-sector-icon { width: 52px; height: 52px; border-radius: 14px; background: rgba(227,6,19,.08); color: var(--fd-accent); display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; transition: background .3s; }
.fd-sector-icon svg { width: 26px; height: 26px; }
.fd-sector-card:hover .fd-sector-icon { background: var(--fd-accent); color: #fff; }
.fd-sector-name { font-size: 1.0625rem; font-weight: 700; color: var(--fd-text); margin: 0 0 .35rem; letter-spacing: -.01em; }
.fd-sector-desc { font-size: .875rem; color: var(--fd-text-mute); line-height: 1.5; margin: 0; }

/* ═══ 5. VENUE ═══ */
.fd-venue { padding: clamp(4rem, 8vw, 7rem) 0; background: var(--fd-bg); }
.fd-venue-grid { display: grid; grid-template-columns: 1fr 1fr; gap: clamp(2rem, 5vw, 4.5rem); align-items: center; }
.fd-venue-image { border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.1); aspect-ratio: 4/3; }
.fd-venue-image img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .6s; }
.fd-venue-image:hover img { transform: scale(1.04); }
.fd-venue-body { font-size: 1.0625rem; color: var(--fd-text-mute); line-height: 1.7; margin: 1.25rem 0 2rem; }
.fd-venue-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
.fd-venue-stat { padding: 1.25rem 1rem; background: var(--fd-bg-alt); border-radius: 16px; border: 1px solid var(--fd-border); }
.fd-venue-stat-value { font-size: clamp(1.5rem, 2.5vw, 2rem); font-weight: 800; letter-spacing: -.03em; color: var(--fd-text); line-height: 1; margin-bottom: .35rem; }
.fd-venue-stat-unit { font-size: .65em; color: var(--fd-text-mute); margin-left: .15em; font-weight: 600; }
.fd-venue-stat-label { font-size: .75rem; font-weight: 600; letter-spacing: .05em; color: var(--fd-text-mute); text-transform: uppercase; }
@media (max-width: 900px) { .fd-venue-grid { grid-template-columns: 1fr; } .fd-venue-image { aspect-ratio: 16/10; } }
@media (max-width: 500px) { .fd-venue-stats { grid-template-columns: 1fr; } }

/* ═══ Sectors note + highlight ═══ */
.fd-sectors-note { text-align: center; font-style: italic; color: var(--fd-text-soft); margin: 1.5rem 0 0; font-size: .95rem; }
.fd-sectors-highlight { margin: 2.5rem auto 0; max-width: 760px; display: flex; align-items: center; gap: 1rem; padding: 1.25rem 1.5rem; background: linear-gradient(135deg, rgba(227,6,19,.05), rgba(255,107,53,.03)); border: 1px solid var(--fd-border); border-left: 4px solid var(--fd-accent); border-radius: 14px; }
.fd-sectors-highlight svg { color: var(--fd-accent); flex-shrink: 0; }
.fd-sectors-highlight p { margin: 0; font-size: 1rem; line-height: 1.55; color: var(--fd-text); font-weight: 500; }

/* ═══ 6. FEDERASYON DESTEĞİ ═══ */
.fd-fed { padding: clamp(4rem, 8vw, 7rem) 0; background: var(--fd-bg-alt); }
.fd-fed-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: clamp(2rem, 4vw, 3.5rem); align-items: start; }
.fd-fed-body { font-size: 1.0625rem; color: var(--fd-text-mute); line-height: 1.75; margin: 1.25rem 0 0; }
.fd-fed-pillars { display: grid; gap: .85rem; }
.fd-fed-pillar { display: flex; align-items: center; gap: .85rem; padding: 1.1rem 1.35rem; background: var(--fd-bg); border: 1px solid var(--fd-border); border-radius: 14px; font-size: .9375rem; font-weight: 600; color: var(--fd-text); transition: transform .25s, border-color .25s, background .25s; }
.fd-fed-pillar:hover { transform: translateX(4px); border-color: var(--fd-accent); background: #fff; }
.fd-fed-pillar svg { color: var(--fd-accent); flex-shrink: 0; }
@media (max-width: 900px) { .fd-fed-grid { grid-template-columns: 1fr; } }

/* ═══ 7. BRAND PERSPECTIVE ═══ */
.fd-roi { padding: clamp(4rem, 8vw, 7rem) 0; background: var(--fd-bg-dark); color: #fff; position: relative; overflow: hidden; }
.fd-roi::before { content: ''; position: absolute; top: -20%; left: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(227,6,19,.18) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
.fd-roi::after { content: ''; position: absolute; bottom: -20%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,107,53,.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
.fd-roi .fd-block-eyebrow { color: #ff6b35; }
.fd-bp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; position: relative; z-index: 1; }
.fd-bp-card { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); backdrop-filter: blur(20px); border-radius: 24px; padding: 2.25rem 2rem; transition: transform .3s, border-color .3s, background .3s; position: relative; }
.fd-bp-card:hover { transform: translateY(-4px); border-color: var(--fd-accent); background: rgba(255,255,255,.06); }
.fd-bp-kicker { display: inline-block; font-size: 1rem; font-weight: 800; letter-spacing: .04em; color: var(--fd-accent); margin-bottom: 1rem; padding: .35rem .85rem; background: rgba(227,6,19,.12); border-radius: 100px; }
.fd-bp-title { font-size: clamp(1.125rem, 1.8vw, 1.4rem); font-weight: 700; letter-spacing: -.015em; color: #fff; line-height: 1.25; margin: 0 0 1rem; }
.fd-bp-body { font-size: .9375rem; color: rgba(255,255,255,.78); line-height: 1.7; margin: 0; }
@media (max-width: 900px) { .fd-bp-grid { grid-template-columns: 1fr; } }

/* ═══ 8. SPONSORS ═══ */
.fd-sponsors { padding: clamp(3rem, 6vw, 5rem) 0; background: var(--fd-bg); }
.fd-sponsors-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; max-width: 1000px; margin: 0 auto; }
.fd-sponsor { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem 1.25rem; background: var(--fd-bg-alt); border: 1px solid var(--fd-border); border-radius: 18px; transition: transform .25s, border-color .25s, background .25s; }
.fd-sponsor:hover { transform: translateY(-3px); border-color: var(--fd-accent); background: #fff; }
.fd-sponsor-badge { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--fd-accent), #ff6b35); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; box-shadow: 0 8px 18px -6px var(--fd-accent); }
.fd-sponsor-name { font-size: .9375rem; font-weight: 700; color: var(--fd-text); line-height: 1.3; }
.fd-sponsor-sub { font-size: .75rem; font-weight: 600; color: var(--fd-text-soft); letter-spacing: .03em; margin-top: .25rem; }

/* ═══ 7. PROGRAM ═══ */
.fd-program { padding: clamp(4rem, 7vw, 6rem) 0; background: var(--fd-bg); }
.fd-program-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; max-width: 920px; margin: 0 auto; }
.fd-day-card { position: relative; background: var(--fd-bg-alt); border: 1px solid var(--fd-border); border-radius: 20px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem; transition: transform .25s, box-shadow .25s, border-color .25s; }
.fd-day-card:hover { transform: translateY(-4px); box-shadow: 0 16px 32px rgba(0,0,0,.06); border-color: var(--fd-accent); }
.fd-day-num { flex-shrink: 0; width: 56px; height: 56px; background: linear-gradient(135deg, var(--fd-accent), #ff6b35); color: #fff; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; letter-spacing: -.02em; box-shadow: 0 8px 18px -6px var(--fd-accent); }
.fd-day-info { flex: 1; min-width: 0; }
.fd-day-name { font-size: 1rem; font-weight: 700; color: var(--fd-text); margin-bottom: .25rem; }
.fd-day-hours { display: flex; align-items: center; gap: .35rem; font-size: .85rem; color: var(--fd-text-mute); }
.fd-day-badge { position: absolute; top: -10px; right: 1rem; background: var(--fd-accent); color: #fff; padding: .25rem .75rem; border-radius: 100px; font-size: .65rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }

/* ═══ 7B. PROSE FALLBACK ═══ */
.fd-prose-section { padding: clamp(4rem, 7vw, 6rem) 0; background: var(--fd-bg); }
.fd-prose { line-height: 1.75; color: var(--fd-text-mute); font-size: 1.0625rem; max-width: 760px; margin: 0 auto; }
.fd-prose h2 { font-size: clamp(1.5rem, 2.8vw, 2rem); font-weight: 700; color: var(--fd-text); margin: 2.5rem 0 1rem; letter-spacing: -.025em; }
.fd-prose h3 { font-size: 1.25rem; font-weight: 700; color: var(--fd-text); margin: 2rem 0 .75rem; }
.fd-prose p { margin: 0 0 1.25em; }
.fd-prose ul, .fd-prose ol { padding-left: 1.5rem; margin: 0 0 1.25em; }
.fd-prose a { color: var(--fd-accent); text-decoration: none; }
.fd-prose a:hover { text-decoration: underline; }
.fd-prose strong { color: var(--fd-text); }

/* ═══ 8. MAP ═══ */
.fd-map-section { padding: clamp(3rem, 6vw, 5rem) 0; background: var(--fd-bg-alt); }
.fd-map-wrap { border-radius: 18px; overflow: hidden; box-shadow: 0 16px 40px rgba(0,0,0,.08); }
.fd-map { display: block; }

/* ═══ 9. FORM SECTION ═══ */
.fd-form-section { padding: clamp(4rem, 7vw, 6rem) 0; background: var(--fd-bg); }
.fd-form-card { max-width: 720px; margin: 0 auto; background: var(--fd-bg); border: 1px solid var(--fd-border); border-radius: 28px; padding: clamp(1.75rem, 4vw, 3rem); box-shadow: 0 24px 60px rgba(0,0,0,.06); position: relative; }
.fd-form-card::before { content: ''; position: absolute; top: 0; left: 28px; right: 28px; height: 3px; background: linear-gradient(90deg, var(--fd-accent), #ff6b35); border-radius: 0 0 100px 100px; }
.fd-form-eyebrow { display: block; font-size: .7rem; font-weight: 700; letter-spacing: .2em; color: var(--fd-accent); text-transform: uppercase; margin-bottom: .75rem; }
.fd-form-title { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; color: var(--fd-text); letter-spacing: -.02em; line-height: 1.2; margin: 0 0 .75rem; }
.fd-form-sub { font-size: .9375rem; color: var(--fd-text-mute); line-height: 1.6; margin: 0 0 2rem; }
.fd-form { display: flex; flex-direction: column; gap: .75rem; }
.fd-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
.fd-form-group { display: flex; flex-direction: column; }
.fd-input { width: 100%; padding: .95rem 1rem; background: var(--fd-bg-alt); border: 1px solid var(--fd-border); border-radius: 12px; color: var(--fd-text); font-size: .9375rem; font-family: inherit; transition: border-color .2s, box-shadow .2s, background .2s; }
.fd-input::placeholder { color: var(--fd-text-soft); }
.fd-input:focus { outline: 0; background: #fff; border-color: var(--fd-accent); box-shadow: 0 0 0 3px rgba(227,6,19,.08); }
textarea.fd-input { resize: vertical; min-height: 80px; line-height: 1.5; }
.fd-form-foot { display: flex; align-items: center; gap: .35rem; font-size: .75rem; color: var(--fd-text-soft); margin: 1rem 0 0; justify-content: center; }
.fd-form-foot svg { color: #10b981; flex-shrink: 0; }
.fd-form-contact { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--fd-border); }
.fd-side-link { display: flex; align-items: center; gap: .65rem; padding: .85rem 1.1rem; background: var(--fd-bg-alt); border: 1px solid var(--fd-border); border-radius: 14px; color: var(--fd-text); font-size: .9rem; font-weight: 500; text-decoration: none; transition: background .2s, border-color .2s, transform .2s; }
.fd-side-link:hover { background: #fff; border-color: var(--fd-accent); color: var(--fd-accent); transform: translateX(2px); }
.fd-side-link svg { color: var(--fd-accent); flex-shrink: 0; }
@media (max-width: 600px) { .fd-form-row, .fd-form-contact { grid-template-columns: 1fr; } }

/* ═══ 10. BOTTOM CTA ═══ */
.fd-cta-banner { position: relative; padding: clamp(4rem, 9vw, 8rem) 0; overflow: hidden; isolation: isolate; color: #fff; text-align: center; }
.fd-cta-bg { position: absolute; inset: 0; z-index: -2; background-size: cover; background-position: center; transform: scale(1.05); filter: brightness(.45); animation: fdKenBurns 22s ease-in-out infinite alternate; }
.fd-cta-overlay { position: absolute; inset: 0; z-index: -1; background: linear-gradient(135deg, rgba(10,10,10,.65) 0%, rgba(227,6,19,.4) 100%); }
.fd-cta-content { max-width: 900px; margin: 0 auto; }
.fd-cta-title { font-size: clamp(2rem, 5vw, 3.75rem); font-weight: 800; letter-spacing: -.03em; color: #fff; line-height: 1.1; margin: 1rem 0 1.25rem; }
.fd-cta-sub { font-size: clamp(1rem, 1.5vw, 1.25rem); color: rgba(255,255,255,.85); line-height: 1.5; margin: 0 auto 2.5rem; max-width: 600px; }
.fd-cta-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

/* ═══ MOTION + DARK MODE ═══ */
@media (prefers-reduced-motion: reduce) {
    .fd-hero-bg, .fd-cta-bg, .fd-scroll-line { animation: none; transform: none; }
    .fd-btn-primary:hover, .fd-day-card:hover, .fd-side-link:hover,
    .fd-sector-card:hover, .fd-roi-card:hover, .fd-venue-image:hover img { transform: none; }
}
@media (prefers-color-scheme: dark) {
    .page-fair-detail { --fd-bg: #000; --fd-bg-alt: #1c1c1e; --fd-text: #f5f5f7; --fd-text-mute: #98989d; --fd-text-soft: #6e6e73; --fd-border: #2c2c2e; }
    .fd-sticky-bar { background: rgba(0,0,0,.85); }
    .fd-input { background: #1c1c1e; color: #fff; }
    .fd-input:focus { background: #2c2c2e; }
}
</style>

<script>
(function () {
    const sticky = document.querySelector('[data-fd-sticky]');
    const hero = document.querySelector('[data-fd-hero]');
    if (sticky && hero) {
        const obs = new IntersectionObserver(
            (entries) => entries.forEach((e) => sticky.classList.toggle('is-visible', !e.isIntersecting)),
            { rootMargin: '-30% 0px 0px 0px' }
        );
        obs.observe(hero);
    }

    document.querySelectorAll('a[href^="#"]').forEach((a) => {
        a.addEventListener('click', (ev) => {
            const id = a.getAttribute('href').slice(1);
            const target = document.getElementById(id);
            if (target) { ev.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
        });
    });
})();
</script>
