<?php
$name    = lang() === 'en' ? ($fair['name_en'] ?? $fair['name_tr']) : $fair['name_tr'];
$summary = lang() === 'en' ? ($fair['summary_en'] ?? $fair['summary_tr']) : $fair['summary_tr'];
$content = lang() === 'en' ? ($fair['content_en'] ?? $fair['content_tr'] ?? '') : ($fair['content_tr'] ?? '');

$pageTitle       = e($name) . ' | Expo Cyprus';
$metaDescription = e(mb_substr(strip_tags($summary), 0, 160));
$bodyClass       = 'page-fair-detail';
$heroBg          = !empty($fair['image_hero']) ? e($fair['image_hero']) : '';
$accent          = $fair['accent_color'] ?? '#E30613';

// Tarih hesaplamaları
$startDate = !empty($fair['next_date']) ? strtotime($fair['next_date']) : null;
$endDate   = !empty($fair['end_date'])  ? strtotime($fair['end_date'])  : $startDate;
$dayCount  = $startDate && $endDate ? (int)(($endDate - $startDate) / 86400) + 1 : null;

// Eyebrow (etkinlik tarih badge'i)
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

// Günleri liste olarak çıkar (program kartları için)
$days = [];
if ($startDate && $endDate) {
    $weekdaysTr = ['Pazar','Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi'];
    $weekdaysEn = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    $weekdays = lang()==='en' ? $weekdaysEn : $weekdaysTr;
    for ($d = $startDate; $d <= $endDate; $d += 86400) {
        $days[] = [
            'day_num'  => date('j', $d),
            'month'    => date('M', $d),
            'weekday'  => $weekdays[(int)date('w', $d)],
            'hours'    => (date('w', $d) == 5 || $d === $startDate) ? '18:00 – 22:00' : '10:00 – 22:00',
            'is_first' => ($d === $startDate),
        ];
    }
}
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
                <span>
                    <?= date('d M', $startDate) ?><?php if ($endDate && $endDate !== $startDate): ?> – <?= date('d M Y', $endDate) ?><?php else: ?> <?= date('Y', $startDate) ?><?php endif; ?>
                </span>
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

<!-- ═══════════════════════════════════════════════════════════════
     3. STATS — bir bakışta
═══════════════════════════════════════════════════════════════ -->
<section class="fd-stats-section">
    <div class="fd-container">
        <div class="fd-stats-grid">
            <?php if ($dayCount): ?>
            <div class="fd-stat">
                <div class="fd-stat-num"><?= $dayCount ?></div>
                <div class="fd-stat-label"><?= lang()==='en' ? 'Days' : 'Gün' ?></div>
            </div>
            <?php endif; ?>
            <div class="fd-stat">
                <div class="fd-stat-num">12+</div>
                <div class="fd-stat-label"><?= lang()==='en' ? 'Hours Daily' : 'Saatlik Açılış' ?></div>
            </div>
            <div class="fd-stat">
                <div class="fd-stat-num">50+</div>
                <div class="fd-stat-label"><?= lang()==='en' ? 'Exhibitors' : 'Katılımcı' ?></div>
            </div>
            <div class="fd-stat">
                <div class="fd-stat-num">∞</div>
                <div class="fd-stat-label"><?= lang()==='en' ? 'Free Entry' : 'Ücretsiz' ?></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     4. ANA İÇERİK + STICKY FORM
═══════════════════════════════════════════════════════════════ -->
<section class="fd-main-section">
    <div class="fd-container">
        <div class="fd-layout">

            <!-- SOL: İÇERİK -->
            <article class="fd-main">

                <!-- 4A. Günlük Program -->
                <?php if (!empty($days)): ?>
                <div id="program" class="fd-block">
                    <div class="fd-block-head">
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
                <?php endif; ?>

                <!-- 4B. Hakkında (content) -->
                <?php if (!empty($content)): ?>
                <div class="fd-block">
                    <div class="fd-block-head">
                        <span class="fd-block-eyebrow"><?= lang()==='en' ? 'ABOUT' : 'HAKKINDA' ?></span>
                    </div>
                    <div class="fd-prose">
                        <?= $content ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="fd-block">
                    <div class="fd-prose">
                        <?php if (lang() === 'en'): ?>
                        <h2>About <?= e($name) ?></h2>
                        <p>Detailed information about this fair is being prepared. Please <a href="<?= url('iletisim') ?>">contact us</a> for exhibitor participation and further details.</p>
                        <?php else: ?>
                        <h2><?= e($name) ?> Hakkında</h2>
                        <p>Bu fuar hakkında detaylı bilgi hazırlanmaktadır. Katılımcı katılımı ve daha fazla bilgi için lütfen <a href="<?= url('iletisim') ?>">bizimle iletişime geçin</a>.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 4C. Lokasyon kart -->
                <?php if (!empty($fair['location'])): ?>
                <div class="fd-block">
                    <div class="fd-block-head">
                        <span class="fd-block-eyebrow"><?= lang()==='en' ? 'VENUE' : 'KONUM' ?></span>
                        <h2 class="fd-block-title"><?= e($fair['location']) ?></h2>
                    </div>
                    <div class="fd-map-wrap">
                        <iframe class="fd-map"
                                src="https://www.google.com/maps?q=<?= urlencode($fair['location']) ?>&output=embed"
                                width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <?php endif; ?>

            </article>

            <!-- SAĞ: STICKY FORM -->
            <aside class="fd-sidebar">
                <div id="katilim-form" class="fd-form-card" style="scroll-margin-top:90px;">
                    <span class="fd-form-eyebrow"><?= lang()==='en' ? 'EXHIBITOR APPLICATION' : 'KATILIMCI BAŞVURUSU' ?></span>
                    <h3 class="fd-form-title"><?= lang()==='en' ? 'Apply to this fair' : 'Bu fuara katıl' ?></h3>
                    <p class="fd-form-sub">
                        <?= lang() === 'en'
                            ? 'Submit your application. We respond within 24 hours with stand options and packages.'
                            : 'Başvurunuzu gönderin. 24 saat içinde stand seçenekleri ve paketler ile dönüş yapıyoruz.' ?>
                    </p>

                    <form action="<?= url('iletisim') ?>" method="POST" class="fd-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="subject" value="<?= e($name) ?> - <?= lang()==='en' ? 'Fair Application' : 'Fuar Katılım Başvurusu' ?>">

                        <div class="fd-form-group">
                            <input type="text" name="name" class="fd-input"
                                   placeholder="<?= lang() === 'en' ? 'Your Name *' : 'Adınız *' ?>" required>
                        </div>
                        <div class="fd-form-group">
                            <input type="text" name="company" class="fd-input"
                                   placeholder="<?= lang() === 'en' ? 'Company / Brand' : 'Şirket / Marka' ?>">
                        </div>
                        <div class="fd-form-group">
                            <input type="email" name="email" class="fd-input"
                                   placeholder="<?= lang() === 'en' ? 'Email *' : 'E-posta *' ?>" required>
                        </div>
                        <div class="fd-form-group">
                            <input type="tel" name="phone" class="fd-input"
                                   placeholder="<?= lang() === 'en' ? 'Phone *' : 'Telefon *' ?>" required>
                        </div>
                        <div class="fd-form-group">
                            <textarea name="message" rows="3" class="fd-input"
                                      placeholder="<?= lang() === 'en' ? 'Stand size, sector, notes…' : 'Stand ihtiyacı, sektör, notlar…' ?>"></textarea>
                        </div>
                        <button type="submit" class="fd-btn fd-btn-primary fd-btn-block">
                            <?= lang() === 'en' ? 'Submit Application' : 'Başvuruyu Gönder' ?>
                            <span aria-hidden="true">→</span>
                        </button>

                        <p class="fd-form-foot">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span><?= lang()==='en' ? '24h response guaranteed' : '24 saat içinde dönüş garantili' ?></span>
                        </p>
                    </form>
                </div>

                <!-- Sidecard: hızlı erişim -->
                <div class="fd-side-meta">
                    <a href="tel:+905488303000" class="fd-side-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13 1 .37 1.97.72 2.91a2 2 0 0 1-.45 2.11L8.09 10.09a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.94.35 1.91.59 2.91.72A2 2 0 0 1 22 16.92z"/></svg>
                        <span>+90 548 830 30 00</span>
                    </a>
                    <a href="mailto:info@expocyprus.com" class="fd-side-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span>info@expocyprus.com</span>
                    </a>
                </div>
            </aside>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     5. BOTTOM CTA — full-width
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
                <?= lang() === 'en'
                    ? 'Your brand at this fair.'
                    : 'Markanız bu fuarda.' ?>
            </h2>
            <p class="fd-cta-sub">
                <?= lang() === 'en'
                    ? 'Apply now to secure your stand. Limited spots available.'
                    : 'Standınızı bugünden ayırtın. Sınırlı kontenjan.' ?>
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
     STYLE — Apple-style fair detail
═══════════════════════════════════════════════════════════════ -->
<style>
.page-fair-detail {
    --fd-bg:        #ffffff;
    --fd-bg-alt:    #f5f5f7;
    --fd-bg-dark:   #0a0a0a;
    --fd-text:      #1d1d1f;
    --fd-text-mute: #6e6e73;
    --fd-text-soft: #86868b;
    --fd-accent:    <?= e($accent) ?>;
    --fd-border:    #e5e5e7;
}

.fd-container { max-width: 1280px; margin: 0 auto; padding: 0 clamp(1.25rem, 4vw, 3rem); }

/* ═══ BUTONS ═══ */
.fd-btn {
    display: inline-flex; align-items: center; gap: .55rem;
    padding: .95rem 1.75rem; border-radius: 980px;
    font-size: .9375rem; font-weight: 600;
    text-decoration: none; border: 0; cursor: pointer;
    transition: transform .25s, box-shadow .25s, background .2s;
    font-family: inherit;
}
.fd-btn-primary { background: var(--fd-accent); color: #fff; }
.fd-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 16px 32px -10px var(--fd-accent); color: #fff; }
.fd-btn-ghost {
    background: rgba(255,255,255,.12); color: #fff;
    backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,.2);
}
.fd-btn-ghost:hover { background: rgba(255,255,255,.2); color: #fff; }
.fd-btn-block { width: 100%; justify-content: center; }
.fd-btn-sm { padding: .55rem 1.1rem; font-size: .85rem; }
.fd-btn-lg { padding: 1.15rem 2.25rem; font-size: 1.0625rem; }

/* ═══ EYEBROW ═══ */
.fd-eyebrow {
    display: inline-block;
    font-size: .75rem; font-weight: 700; letter-spacing: .2em;
    color: var(--fd-accent); text-transform: uppercase;
    background: rgba(255,255,255,.08); padding: .4rem 1.1rem;
    border-radius: 100px; backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.15);
    margin-bottom: 1.5rem;
}

/* ═══════════════════════════════════════════════════════════════
   1. HERO — cinematic
═══════════════════════════════════════════════════════════════ */
.fd-hero {
    position: relative;
    min-height: 92vh; min-height: 92svh;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; isolation: isolate;
    color: #fff; text-align: center;
}
.fd-hero-bg {
    position: absolute; inset: -10%; z-index: -2;
    background-size: cover; background-position: center;
    transform: scale(1.08);
    animation: fdKenBurns 22s ease-in-out infinite alternate;
}
@keyframes fdKenBurns { 0% { transform: scale(1.08); } 100% { transform: scale(1.18); } }
.fd-hero-overlay {
    position: absolute; inset: 0; z-index: -1;
    background:
        radial-gradient(ellipse at 50% 30%, rgba(0,0,0,.35) 0%, rgba(0,0,0,.75) 60%, rgba(0,0,0,.95) 100%);
}
.fd-hero-content {
    max-width: 980px; padding: 7rem 1.5rem 4rem;
}
.fd-breadcrumb {
    display: flex; gap: .5rem; justify-content: center; align-items: center;
    font-size: .85rem; color: rgba(255,255,255,.6); margin-bottom: 1.5rem;
}
.fd-breadcrumb a { color: rgba(255,255,255,.7); text-decoration: none; transition: color .2s; }
.fd-breadcrumb a:hover { color: #fff; }
.fd-title {
    font-size: clamp(2.25rem, 6vw, 5rem);
    font-weight: 800; letter-spacing: -.04em;
    line-height: 1.02; margin: 0 0 1rem;
    color: #fff;
}
.fd-tagline {
    font-size: clamp(1rem, 1.6vw, 1.3rem);
    color: rgba(255,255,255,.82); line-height: 1.5;
    max-width: 740px; margin: 0 auto 2rem;
}

.fd-hero-meta {
    display: flex; flex-wrap: wrap; gap: .75rem;
    justify-content: center; margin-bottom: 2.5rem;
}
.fd-meta-pill {
    display: inline-flex; align-items: center; gap: .5rem;
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.15);
    padding: .55rem 1.1rem;
    border-radius: 100px;
    font-size: .875rem; color: rgba(255,255,255,.92);
    font-weight: 500;
}
.fd-meta-pill svg { opacity: .8; flex-shrink: 0; }
.fd-meta-pill-accent {
    background: var(--fd-accent);
    border-color: var(--fd-accent);
    color: #fff;
}
.fd-meta-pill-accent svg { opacity: 1; }

.fd-hero-actions {
    display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;
}

.fd-scroll-indicator {
    position: absolute; bottom: 2rem; left: 50%;
    transform: translateX(-50%);
}
.fd-scroll-line {
    width: 1px; height: 50px;
    background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(255,255,255,.6) 100%);
    animation: fdScroll 2.4s ease-in-out infinite;
}
@keyframes fdScroll { 0%, 100% { opacity: .3; } 50% { opacity: 1; } }

/* ═══════════════════════════════════════════════════════════════
   2. STICKY BAR
═══════════════════════════════════════════════════════════════ */
.fd-sticky-bar {
    position: sticky; top: 0; z-index: 90;
    background: rgba(255,255,255,.85);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border-bottom: 1px solid var(--fd-border);
    opacity: 0; pointer-events: none;
    transform: translateY(-10px);
    transition: opacity .3s, transform .3s;
}
.fd-sticky-bar.is-visible { opacity: 1; pointer-events: auto; transform: translateY(0); }
.fd-sticky-inner {
    padding: .85rem 0;
    display: flex; justify-content: space-between; align-items: center; gap: 1rem;
}
.fd-sticky-info {
    display: flex; gap: .5rem; align-items: center;
    font-size: .9rem; color: var(--fd-text);
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.fd-sticky-date { font-weight: 700; color: var(--fd-accent); letter-spacing: .03em; }
.fd-sticky-divider { color: var(--fd-text-soft); }
.fd-sticky-loc { color: var(--fd-text-mute); }
@media (max-width: 600px) {
    .fd-sticky-divider, .fd-sticky-loc { display: none; }
}

/* ═══════════════════════════════════════════════════════════════
   3. STATS
═══════════════════════════════════════════════════════════════ */
.fd-stats-section {
    padding: clamp(3rem, 5vw, 4.5rem) 0;
    background: var(--fd-bg-alt);
    border-bottom: 1px solid var(--fd-border);
}
.fd-stats-grid {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}
.fd-stat {
    text-align: center;
    padding: 1.5rem 1rem;
}
.fd-stat-num {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800; letter-spacing: -.04em;
    background: linear-gradient(180deg, var(--fd-text) 0%, var(--fd-accent) 140%);
    -webkit-background-clip: text; background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1; margin-bottom: .35rem;
}
.fd-stat-label {
    font-size: .85rem; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase;
    color: var(--fd-text-mute);
}
@media (max-width: 700px) {
    .fd-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0; }
    .fd-stat { padding: 1rem .5rem; }
}

/* ═══════════════════════════════════════════════════════════════
   4. MAIN LAYOUT
═══════════════════════════════════════════════════════════════ */
.fd-main-section {
    padding: clamp(3rem, 7vw, 6rem) 0;
    background: var(--fd-bg);
}
.fd-layout {
    display: grid; grid-template-columns: 1fr 380px;
    gap: clamp(2rem, 5vw, 5rem);
    align-items: start;
}
.fd-main { min-width: 0; }
@media (max-width: 980px) {
    .fd-layout { grid-template-columns: 1fr; }
}

/* Block (içerik bölümü) */
.fd-block { margin-bottom: clamp(2.5rem, 5vw, 4rem); }
.fd-block-head { margin-bottom: 1.5rem; }
.fd-block-eyebrow {
    display: inline-block;
    font-size: .75rem; font-weight: 700;
    letter-spacing: .18em; color: var(--fd-accent);
    text-transform: uppercase; margin-bottom: .75rem;
}
.fd-block-title {
    font-size: clamp(1.5rem, 3vw, 2.25rem);
    font-weight: 700; letter-spacing: -.025em;
    color: var(--fd-text); line-height: 1.15;
    margin: 0;
}

/* 4A. DAY PROGRAM */
.fd-program-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}
.fd-day-card {
    position: relative;
    background: var(--fd-bg-alt);
    border: 1px solid var(--fd-border);
    border-radius: 20px;
    padding: 1.5rem;
    display: flex; align-items: center; gap: 1rem;
    transition: transform .25s, box-shadow .25s, border-color .25s;
}
.fd-day-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px rgba(0,0,0,.06);
    border-color: var(--fd-accent);
}
.fd-day-num {
    flex-shrink: 0;
    width: 56px; height: 56px;
    background: linear-gradient(135deg, var(--fd-accent), #ff6b35);
    color: #fff;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; font-weight: 800; letter-spacing: -.02em;
    box-shadow: 0 8px 18px -6px var(--fd-accent);
}
.fd-day-info { flex: 1; min-width: 0; }
.fd-day-name {
    font-size: 1rem; font-weight: 700; color: var(--fd-text);
    margin-bottom: .25rem;
}
.fd-day-hours {
    display: flex; align-items: center; gap: .35rem;
    font-size: .85rem; color: var(--fd-text-mute);
}
.fd-day-badge {
    position: absolute; top: -10px; right: 1rem;
    background: var(--fd-accent); color: #fff;
    padding: .25rem .75rem;
    border-radius: 100px;
    font-size: .65rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
}

/* 4B. PROSE */
.fd-prose { line-height: 1.75; color: var(--fd-text-mute); font-size: 1.0625rem; }
.fd-prose > *:first-child { margin-top: 0; }
.fd-prose > *:last-child { margin-bottom: 0; }
.fd-prose h2 {
    font-size: clamp(1.5rem, 2.8vw, 2rem);
    font-weight: 700; letter-spacing: -.025em;
    color: var(--fd-text); line-height: 1.2;
    margin: 2.5rem 0 1rem;
}
.fd-prose h3 {
    font-size: 1.25rem; font-weight: 700;
    color: var(--fd-text); margin: 2rem 0 .75rem;
    display: flex; align-items: center; gap: .5rem;
}
.fd-prose p { margin: 0 0 1.25em; }
.fd-prose ul, .fd-prose ol { padding-left: 1.5rem; margin: 0 0 1.25em; }
.fd-prose li { margin-bottom: .5em; }
.fd-prose a { color: var(--fd-accent); text-decoration: none; font-weight: 500; }
.fd-prose a:hover { text-decoration: underline; }
.fd-prose strong { color: var(--fd-text); font-weight: 600; }
.fd-prose em { color: var(--fd-text-soft); }

/* 4C. MAP */
.fd-map-wrap {
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(0,0,0,.08);
}
.fd-map { display: block; }

/* ═══════════════════════════════════════════════════════════════
   5. SIDEBAR FORM
═══════════════════════════════════════════════════════════════ */
.fd-sidebar { position: sticky; top: 90px; }
@media (max-width: 980px) {
    .fd-sidebar { position: static; }
}
.fd-form-card {
    background: var(--fd-bg);
    border: 1px solid var(--fd-border);
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 20px 50px rgba(0,0,0,.06);
}
.fd-form-eyebrow {
    display: block;
    font-size: .7rem; font-weight: 700;
    letter-spacing: .2em; color: var(--fd-accent);
    text-transform: uppercase; margin-bottom: .75rem;
}
.fd-form-title {
    font-size: 1.5rem; font-weight: 700;
    color: var(--fd-text); letter-spacing: -.02em;
    line-height: 1.2; margin: 0 0 .5rem;
}
.fd-form-sub {
    font-size: .875rem; color: var(--fd-text-mute);
    line-height: 1.5; margin: 0 0 1.5rem;
}
.fd-form { display: flex; flex-direction: column; gap: .75rem; }
.fd-form-group { display: flex; flex-direction: column; }
.fd-input {
    width: 100%;
    padding: .85rem 1rem;
    background: var(--fd-bg-alt);
    border: 1px solid var(--fd-border);
    border-radius: 12px;
    color: var(--fd-text); font-size: .9375rem;
    font-family: inherit;
    transition: border-color .2s, box-shadow .2s, background .2s;
}
.fd-input::placeholder { color: var(--fd-text-soft); }
.fd-input:focus {
    outline: 0; background: #fff;
    border-color: var(--fd-accent);
    box-shadow: 0 0 0 3px rgba(227,6,19,.08);
}
textarea.fd-input { resize: vertical; min-height: 70px; line-height: 1.5; }
.fd-form-foot {
    display: flex; align-items: center; gap: .35rem;
    font-size: .75rem; color: var(--fd-text-soft);
    margin: 1rem 0 0; justify-content: center;
}
.fd-form-foot svg { color: #10b981; flex-shrink: 0; }

/* Sidecard meta */
.fd-side-meta {
    margin-top: 1.25rem;
    display: flex; flex-direction: column; gap: .5rem;
}
.fd-side-link {
    display: flex; align-items: center; gap: .65rem;
    padding: .85rem 1.1rem;
    background: var(--fd-bg-alt);
    border: 1px solid var(--fd-border);
    border-radius: 14px;
    color: var(--fd-text); font-size: .9rem; font-weight: 500;
    text-decoration: none;
    transition: background .2s, border-color .2s, transform .2s;
}
.fd-side-link:hover {
    background: #fff; border-color: var(--fd-accent);
    color: var(--fd-accent); transform: translateX(2px);
}
.fd-side-link svg { color: var(--fd-accent); flex-shrink: 0; }

/* ═══════════════════════════════════════════════════════════════
   6. BOTTOM CTA BANNER
═══════════════════════════════════════════════════════════════ */
.fd-cta-banner {
    position: relative;
    padding: clamp(4rem, 9vw, 8rem) 0;
    overflow: hidden; isolation: isolate;
    color: #fff; text-align: center;
}
.fd-cta-bg {
    position: absolute; inset: 0; z-index: -2;
    background-size: cover; background-position: center;
    transform: scale(1.05);
    filter: brightness(.45);
    animation: fdKenBurns 22s ease-in-out infinite alternate;
}
.fd-cta-overlay {
    position: absolute; inset: 0; z-index: -1;
    background: linear-gradient(135deg, rgba(10,10,10,.65) 0%, rgba(227,6,19,.4) 100%);
}
.fd-cta-content { max-width: 900px; margin: 0 auto; }
.fd-cta-title {
    font-size: clamp(2rem, 5vw, 3.75rem);
    font-weight: 800; letter-spacing: -.03em;
    color: #fff; line-height: 1.1;
    margin: 1rem 0 1.25rem;
}
.fd-cta-sub {
    font-size: clamp(1rem, 1.5vw, 1.25rem);
    color: rgba(255,255,255,.85); line-height: 1.5;
    margin: 0 auto 2.5rem; max-width: 600px;
}
.fd-cta-actions {
    display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;
}

/* ═══ ACCESSIBILITY ═══ */
@media (prefers-reduced-motion: reduce) {
    .fd-hero-bg, .fd-cta-bg, .fd-scroll-line { animation: none; transform: none; }
    .fd-btn-primary:hover, .fd-day-card:hover, .fd-side-link:hover { transform: none; }
}

/* ═══ DARK MODE ═══ */
@media (prefers-color-scheme: dark) {
    .page-fair-detail {
        --fd-bg: #000;
        --fd-bg-alt: #1c1c1e;
        --fd-text: #f5f5f7;
        --fd-text-mute: #98989d;
        --fd-text-soft: #6e6e73;
        --fd-border: #2c2c2e;
    }
    .fd-sticky-bar { background: rgba(0,0,0,.85); }
    .fd-input { background: #1c1c1e; color: #fff; }
    .fd-input:focus { background: #2c2c2e; }
}
</style>

<script>
/* Sticky bar — hero geçince görünür yap */
(function () {
    const sticky = document.querySelector('[data-fd-sticky]');
    const hero = document.querySelector('[data-fd-hero]');
    if (!sticky || !hero) return;

    const obs = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                sticky.classList.toggle('is-visible', !e.isIntersecting);
            });
        },
        { rootMargin: '-30% 0px 0px 0px' }
    );
    obs.observe(hero);

    // Yumuşak scroll (anchor link'leri)
    document.querySelectorAll('a[href^="#"]').forEach((a) => {
        a.addEventListener('click', (ev) => {
            const id = a.getAttribute('href').slice(1);
            const target = document.getElementById(id);
            if (target) {
                ev.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
})();
</script>
