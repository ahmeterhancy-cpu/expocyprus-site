<?php
$name    = lang() === 'en' ? ($fair['name_en'] ?? $fair['name_tr']) : $fair['name_tr'];
$summary = lang() === 'en' ? ($fair['summary_en'] ?? $fair['summary_tr']) : $fair['summary_tr'];
$content = lang() === 'en' ? ($fair['content_en'] ?? $fair['content_tr'] ?? '') : ($fair['content_tr'] ?? '');

$pageTitle       = e($name) . ' | Expo Cyprus';
$metaDescription = e(mb_substr(strip_tags($summary), 0, 160));
$bodyClass       = 'page-fair-detail';
$heroBg          = !empty($fair['image_hero']) ? 'background-image:url(' . e($fair['image_hero']) . ');' : '';
?>

<!-- ═══════════════════════════════════════════════════════════════
     LARGE HERO
═══════════════════════════════════════════════════════════════ -->
<section class="fair-hero" style="<?= $heroBg ?>">
    <div class="fair-hero-overlay"></div>
    <div class="container">
        <div class="fair-hero-content">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
                <span aria-hidden="true">›</span>
                <a href="<?= url('fuarlarimiz') ?>"><?= lang() === 'en' ? 'Our Fairs' : 'Fuarlarımız' ?></a>
                <span aria-hidden="true">›</span>
                <span><?= e($name) ?></span>
            </nav>
            <h1 class="fair-hero-title"><?= e($name) ?></h1>
            <?php if ($summary): ?>
            <p class="fair-hero-subtitle"><?= e($summary) ?></p>
            <?php endif; ?>

            <!-- Meta bilgileri -->
            <div class="fair-hero-meta">
                <?php if (!empty($fair['next_date'])): ?>
                <div class="fair-meta-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span><?= date('d.m.Y', strtotime($fair['next_date'])) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($fair['location'])): ?>
                <div class="fair-meta-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                    <span><?= e($fair['location']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     İÇERİK + KENAR ÇUBUĞU
═══════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="detail-layout">

            <!-- Ana İçerik -->
            <article class="detail-main">
                <a href="<?= url('fuarlarimiz') ?>" class="btn btn-outline btn-sm" style="margin-bottom:var(--space-xl);">
                    <span aria-hidden="true">←</span> <?= lang() === 'en' ? 'All Fairs' : 'Tüm Fuarlar' ?>
                </a>

                <?php if (!empty($content)): ?>
                <div class="prose">
                    <?= $content ?>
                </div>
                <?php else: ?>
                <div class="prose">
                    <?php if (lang() === 'en'): ?>
                    <h2>About <?= e($name) ?></h2>
                    <p>Detailed information about this fair is being prepared. Please <a href="<?= url('iletisim') ?>">contact us</a> for exhibitor participation and further details.</p>
                    <?php else: ?>
                    <h2><?= e($name) ?> Hakkında</h2>
                    <p>Bu fuar hakkında detaylı bilgi hazırlanmaktadır. Katılımcı katılımı ve daha fazla bilgi için lütfen <a href="<?= url('iletisim') ?>">bizimle iletişime geçin</a>.</p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Katılımcı Ol CTA -->
                <div class="fair-participate-cta">
                    <div>
                        <h3><?= lang() === 'en' ? 'Become an Exhibitor' : 'Katılımcı Ol' ?></h3>
                        <p><?= lang() === 'en'
                            ? 'Interested in participating in this fair? Request a stand quote or get in touch to learn about exhibitor packages.'
                            : 'Bu fuara katılmak istiyor musunuz? Stand teklifi alın veya katılımcı paketlerini öğrenmek için bizimle iletişime geçin.' ?></p>
                    </div>
                    <a href="<?= url('teklif-al') ?>" class="btn btn-primary btn-lg">
                        <?= lang() === 'en' ? 'Request Stand Quote' : 'Stand Teklifi Al' ?> <span aria-hidden="true">→</span>
                    </a>
                </div>
            </article>

            <!-- Kenar Çubuğu -->
            <aside class="detail-sidebar">

                <!-- Tarih & Konum -->
                <div class="sidebar-card">
                    <h3 class="sidebar-card-title">
                        <?= lang() === 'en' ? 'Fair Details' : 'Fuar Detayları' ?>
                    </h3>
                    <ul class="fair-detail-list">
                        <?php if (!empty($fair['next_date'])): ?>
                        <li>
                            <span class="detail-label"><?= lang() === 'en' ? 'Date' : 'Tarih' ?></span>
                            <span><?= date('d.m.Y', strtotime($fair['next_date'])) ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if (!empty($fair['end_date'])): ?>
                        <li>
                            <span class="detail-label"><?= lang() === 'en' ? 'End Date' : 'Bitiş' ?></span>
                            <span><?= date('d.m.Y', strtotime($fair['end_date'])) ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if (!empty($fair['location'])): ?>
                        <li>
                            <span class="detail-label"><?= lang() === 'en' ? 'Venue' : 'Mekan' ?></span>
                            <span><?= e($fair['location']) ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if (!empty($fair['city'])): ?>
                        <li>
                            <span class="detail-label"><?= lang() === 'en' ? 'City' : 'Şehir' ?></span>
                            <span><?= e($fair['city']) ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Hızlı Katılım Formu -->
                <div class="sidebar-card" style="margin-top:var(--space-lg);">
                    <h3 class="sidebar-card-title">
                        <?= lang() === 'en' ? 'Quick Participation Request' : 'Hızlı Katılım Talebi' ?>
                    </h3>
                    <form action="<?= url('iletisim') ?>" method="POST" style="display:flex; flex-direction:column; gap:.75rem;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="subject" value="<?= e($name) ?> - <?= lang() === 'en' ? 'Participation Request' : 'Katılım Talebi' ?>">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control"
                                   placeholder="<?= lang() === 'en' ? 'Your Name *' : 'Adınız *' ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="company" class="form-control"
                                   placeholder="<?= lang() === 'en' ? 'Company' : 'Şirket' ?>">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control"
                                   placeholder="<?= lang() === 'en' ? 'Email *' : 'E-posta *' ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control"
                                   placeholder="<?= lang() === 'en' ? 'Phone *' : 'Telefon *' ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <?= lang() === 'en' ? 'Send Request' : 'Talep Gönder' ?>
                        </button>
                    </form>
                </div>

            </aside>

        </div>
    </div>
</section>

<style>
.fair-hero {
    position: relative;
    min-height: 520px;
    display: flex;
    align-items: flex-end;
    background-size: cover;
    background-position: center;
    background-color: var(--gray-900);
    color: var(--white);
    padding: var(--space-3xl) 0;
}
.fair-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(10,10,10,.9) 0%, rgba(10,10,10,.4) 60%, transparent 100%);
}
.fair-hero .container { position: relative; z-index: 1; }
.fair-hero-content { max-width: 720px; }
.fair-hero-title { font-size: var(--font-size-5xl); font-weight: 800; color: var(--white); margin: .5rem 0; }
.fair-hero-subtitle { font-size: var(--font-size-lg); color: rgba(255,255,255,.85); margin-top: .5rem; }
.fair-hero-meta { display: flex; flex-wrap: wrap; gap: var(--space-lg); margin-top: var(--space-lg); }
.fair-meta-item { display: flex; align-items: center; gap: .5rem; color: rgba(255,255,255,.8); font-size: var(--font-size-sm); }
.breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.7); margin-bottom: .5rem; }
.breadcrumb a { color: rgba(255,255,255,.7); }
.breadcrumb a:hover { color: var(--white); }

.detail-layout { display: grid; grid-template-columns: 1fr 340px; gap: var(--space-3xl); align-items: start; }
.detail-main { min-width: 0; }
.prose { line-height: 1.8; color: var(--gray-700); }
.prose h2, .prose h3 { color: var(--text); margin: 1.5em 0 .5em; }
.prose p { margin-bottom: 1em; }
.prose ul, .prose ol { padding-left: 1.5em; margin-bottom: 1em; }
.prose a { color: var(--red); }
.prose img { border-radius: var(--radius-md); margin: 1.5em 0; }

.fair-participate-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-xl);
    background: var(--red-light);
    border: 1px solid rgba(227,6,19,.15);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
    margin-top: var(--space-3xl);
}
.fair-participate-cta h3 { font-size: var(--font-size-xl); margin-bottom: .5rem; }
.fair-participate-cta p { font-size: var(--font-size-sm); color: var(--text-muted); line-height: 1.6; }

.sidebar-card { background: var(--gray-50); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: var(--space-xl); }
.sidebar-card-title { font-size: var(--font-size-base); margin-bottom: var(--space-md); }
.fair-detail-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: .625rem; }
.fair-detail-list li { display: flex; flex-direction: column; gap: .125rem; font-size: var(--font-size-sm); }
.detail-label { font-weight: 600; color: var(--text-muted); font-size: var(--font-size-xs); text-transform: uppercase; letter-spacing: .05em; }
.form-group { display: flex; flex-direction: column; }
.form-control { padding: .625rem .875rem; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: var(--font-size-sm); font-family: var(--font); background: var(--white); color: var(--text); transition: border-color var(--transition); outline: none; }
.form-control:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(227,6,19,.08); }

@media (max-width: 960px) {
    .detail-layout { grid-template-columns: 1fr; }
    .fair-hero-title { font-size: var(--font-size-4xl); }
    .fair-participate-cta { flex-direction: column; align-items: flex-start; }
}
</style>
