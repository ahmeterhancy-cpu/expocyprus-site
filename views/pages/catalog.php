<?php
$pageTitle       = lang() === 'en'
    ? 'Stand Catalog | Expo Cyprus — Ready-to-Order Booth Designs'
    : 'Stand Kataloğu | Expo Cyprus — Hazır Tasarım Standlar';
$metaDescription = lang() === 'en'
    ? 'Browse our ready-to-order stand catalog by size — 3×2m, 6×2m, 9×2m and 6×4m island booths.'
    : 'Hazır stand kataloğumuzdan beden seçin — 3×2m, 6×2m, 9×2m ve 6×4m ada stant modelleri.';
$bodyClass = 'page-catalog';

// Categories — DB'den dinamik yüklenir (admin paneli üzerinden yönetilir)
$cats = [];
foreach (\App\Models\CatalogCategory::active() as $c) {
    $cats[$c['cat_key']] = [
        'tr'      => $c['label_tr'] ?? '',
        'en'      => $c['label_en'] ?? ($c['label_tr'] ?? ''),
        'dim_tr'  => $c['dimensions_tr'] ?? '',
        'dim_en'  => $c['dimensions_en'] ?? ($c['dimensions_tr'] ?? ''),
        'desc_tr' => $c['description_tr'] ?? '',
        'desc_en' => $c['description_en'] ?? ($c['description_tr'] ?? ''),
    ];
}

// Group items by category from $data
$itemsByCat = [];
foreach (($data ?? []) as $row) {
    $cat = $row['size_category'] ?? 'bir-birim';
    $itemsByCat[$cat][] = $row;
}
?>

<!-- ═══════════════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════════════ -->
<section class="catalog-hero">
    <div class="container">
        <nav class="breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span>›</span>
            <span><?= lang() === 'en' ? 'Stand Catalog' : 'Stand Kataloğu' ?></span>
        </nav>
        <h1><?= lang() === 'en' ? 'Stand Catalog' : 'Stand Kataloğu' ?></h1>
        <p>
            <?= lang() === 'en'
                ? 'Browse our ready-to-order stand designs. Pick the right size and model — we handle the rest from production to on-site setup.'
                : 'Hazır tasarımlı stand modellerimizden bedeninize uygun olanı seçin. Üretimden sahada kuruluma her şey bizden.' ?>
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     CATEGORIES & MODELS
═══════════════════════════════════════════════════════════════ -->
<section class="section catalog-section">
    <div class="container">

        <!-- Category Quick Nav -->
        <nav class="cat-quick-nav" aria-label="<?= lang() === 'en' ? 'Categories' : 'Kategoriler' ?>">
            <?php foreach ($cats as $key => $cat):
                $count = count($itemsByCat[$key] ?? []);
                $label = lang() === 'en' ? $cat['en'] : $cat['tr'];
                $dim   = lang() === 'en' ? $cat['dim_en'] : $cat['dim_tr'];
            ?>
            <a href="#cat-<?= e($key) ?>" class="cat-quick">
                <strong><?= e($label) ?></strong>
                <small><?= e($dim) ?> <span class="cat-quick-count">· <?= $count ?> <?= lang() === 'en' ? 'model' : 'model' ?></span></small>
            </a>
            <?php endforeach; ?>
        </nav>

        <?php foreach ($cats as $catKey => $cat):
            $items = $itemsByCat[$catKey] ?? [];
            if (empty($items)) continue;
            $catLabel = lang() === 'en' ? $cat['en'] : $cat['tr'];
            $catDim   = lang() === 'en' ? $cat['dim_en'] : $cat['dim_tr'];
            $catDesc  = lang() === 'en' ? $cat['desc_en'] : $cat['desc_tr'];
        ?>

        <section class="cat-block" id="cat-<?= e($catKey) ?>">
            <header class="cat-header">
                <div>
                    <span class="cat-dim"><?= e($catDim) ?></span>
                    <h2 class="cat-title"><?= e($catLabel) ?></h2>
                    <p class="cat-desc"><?= e($catDesc) ?></p>
                </div>
                <span class="cat-count"><?= count($items) ?> <?= lang() === 'en' ? 'Model' : 'Model' ?></span>
            </header>

            <div class="model-grid">
                <?php foreach ($items as $m):
                    $name = lang() === 'en' ? ($m['name_en'] ?? $m['name_tr']) : ($m['name_tr'] ?? $m['name_en']);
                    $desc = lang() === 'en' ? ($m['description_en'] ?? $m['description']) : ($m['description'] ?? $m['description_en']);
                    $features = [];
                    if (!empty($m['features_json'])) {
                        $decoded = json_decode((string)$m['features_json'], true);
                        if (is_array($decoded)) $features = $decoded;
                    }
                    $price = !empty($m['price']) ? (float)$m['price'] : 0;
                    $currency = $m['currency'] ?? 'EUR';
                    $symbol = ['EUR'=>'€','USD'=>'$','GBP'=>'£','TRY'=>'₺'][$currency] ?? $currency;
                ?>
                <article class="model-card">
                    <div class="model-card-img">
                        <?php if (!empty($m['image_main'])): ?>
                            <img src="<?= e($m['image_main']) ?>" alt="<?= e($name) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="model-card-img-placeholder"><?= e($m['model_no']) ?></div>
                        <?php endif; ?>
                        <span class="model-card-badge"><?= e($m['model_no']) ?></span>
                    </div>
                    <div class="model-card-body">
                        <div class="model-card-meta">
                            <span class="model-card-dim">📐 <?= e($m['dimensions']) ?></span>
                        </div>
                        <h3 class="model-card-name"><?= e($name) ?></h3>
                        <p class="model-card-desc"><?= e(strip_tags((string)$desc)) ?></p>
                        <?php if (!empty($features)): ?>
                        <ul class="model-card-features">
                            <?php foreach ($features as $f): ?>
                            <li>✓ <?= e($f) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                        <div class="model-card-footer">
                            <?php if ($price > 0): ?>
                                <!-- FİYAT VAR — sadece "Sepete Ekle" -->
                                <div class="model-card-price">
                                    <small><?= lang() === 'en' ? 'Starting from' : 'Başlangıç' ?></small>
                                    <strong><?= $symbol ?> <?= number_format($price, 0, ',', '.') ?></strong>
                                </div>
                                <div class="model-card-actions">
                                    <form action="<?= url('sepete-ekle') ?>" method="POST" class="model-card-add">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="model_no" value="<?= e($m['model_no']) ?>">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="model-card-cta model-card-cta--primary">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
                                            <?= lang() === 'en' ? 'Add to Cart' : 'Sepete Ekle' ?>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <!-- FİYAT YOK — sadece "Fiyat Talep Et" butonu (label yok, buton zaten anlatıyor) -->
                                <div class="model-card-actions model-card-actions--full">
                                    <a href="<?= url('talep-formu') ?>?model=<?= e($m['model_no']) ?>" class="model-card-cta model-card-cta--primary">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                        <?= lang() === 'en' ? 'Request Price' : 'Fiyat Talep Et' ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endforeach; ?>

        <?php if (empty(array_filter($itemsByCat))): ?>
        <div class="empty-state">
            <p><?= lang() === 'en' ? 'No stand models in catalog yet.' : 'Henüz stand modeli bulunmuyor.' ?></p>
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
            <?= lang() === 'en' ? 'Custom-Designed Stands for Your Brand' : 'Firmaya Özel Tasarım Standlar' ?>
        </h2>
        <p class="cta-banner-text">
            <?= lang() === 'en'
                ? 'Can\'t find the model you\'re looking for? Share your details and we\'ll prepare a custom design for you.'
                : 'Aradığınız modeli göremediniz mi? Bilgilerinizi paylaşın, size özel tasarım hazırlayalım.' ?>
        </p>
        <div class="cta-banner-actions">
            <a href="<?= url('teklif-al') ?>" class="btn btn-white btn-lg">
                <?= lang() === 'en' ? 'Custom Quote' : 'Özel Teklif Al' ?> →
            </a>
            <a href="<?= url('iletisim') ?>" class="btn btn-outline-white btn-lg">
                <?= lang() === 'en' ? 'Contact Us' : 'İletişim' ?>
            </a>
        </div>
    </div>
</section>

<style>
/* ─── HERO ───────────────────────────────────────────── */
.catalog-hero {
    background-color: var(--black);
    background-image: linear-gradient(135deg, rgba(10,10,10,.8), rgba(10,10,10,.5)), url('/assets/images/stand-models/AD-01.webp');
    background-size: cover;
    background-position: center;
    color: var(--white);
    padding: var(--space-3xl) 0 var(--space-2xl);
    position: relative;
    min-height: 320px;
    display: flex;
    align-items: center;
}
.catalog-hero::after {
    content: '';
    position: absolute; left: 0; right: 0; bottom: 0;
    height: 3px; background: var(--red);
}
.catalog-hero .breadcrumb { display: flex; gap: .5rem; font-size: .875rem; color: rgba(255,255,255,.7); margin-bottom: .5rem; }
.catalog-hero .breadcrumb a { color: rgba(255,255,255,.7); }
.catalog-hero .breadcrumb a:hover { color: var(--white); }
.catalog-hero h1 { font-size: clamp(1.75rem, 4vw, 2.75rem); margin: .25rem 0 .75rem; font-weight: 800; color: var(--white) !important; }
.catalog-hero p { font-size: 1.0625rem; max-width: 760px; opacity: .92; line-height: 1.6; margin: 0; color: rgba(255,255,255,.92); }

/* ─── QUICK NAV ──────────────────────────────────────── */
.cat-quick-nav {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .75rem;
    margin-bottom: var(--space-3xl);
}
@media (max-width: 768px) { .cat-quick-nav { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .cat-quick-nav { grid-template-columns: 1fr; } }
.cat-quick {
    display: flex;
    flex-direction: column;
    gap: .25rem;
    padding: 1rem 1.25rem;
    background: var(--bg-alt);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    text-decoration: none;
    color: var(--text);
    transition: all .2s;
}
.cat-quick:hover { border-color: var(--red); background: var(--red-light); transform: translateY(-2px); }
.cat-quick strong { font-size: .9375rem; }
.cat-quick small { font-size: .75rem; color: var(--text-muted); }
.cat-quick-count { font-weight: 600; }

/* ─── CATEGORY HEADER ────────────────────────────────── */
.cat-block { margin-bottom: var(--space-3xl); scroll-margin-top: 100px; }
.cat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: var(--space-xl);
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border);
}
.cat-dim {
    display: inline-block;
    padding: .25rem .75rem;
    background: var(--red);
    color: var(--white);
    font-size: .75rem;
    font-weight: 700;
    border-radius: 100px;
    margin-bottom: .375rem;
    letter-spacing: .04em;
}
.cat-title { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 800; margin: 0; color: var(--text); }
.cat-desc { color: var(--text-muted); margin: .25rem 0 0; font-size: .9375rem; }
.cat-count {
    font-size: .8125rem;
    font-weight: 700;
    color: var(--red);
    padding: .375rem .75rem;
    background: var(--red-light);
    border-radius: 100px;
    white-space: nowrap;
}

/* ─── MODEL GRID ─────────────────────────────────────── */
.model-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-xl);
}
@media (max-width: 1024px) { .model-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .model-grid { grid-template-columns: 1fr; } }

.model-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: all .25s;
}
.model-card:hover {
    border-color: transparent;
    box-shadow: var(--shadow-xl);
    transform: translateY(-4px);
}
.model-card-img {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
    background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
    display: flex;
    align-items: center;
    justify-content: center;
}
.model-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .4s;
}
.model-card:hover .model-card-img img { transform: scale(1.04); }
.model-card-img-placeholder {
    color: var(--text-muted);
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: .1em;
}
.model-card-badge {
    position: absolute;
    top: .75rem; left: .75rem;
    padding: .25rem .625rem;
    background: var(--black);
    color: var(--white);
    font-size: .6875rem;
    font-weight: 700;
    border-radius: 6px;
    letter-spacing: .08em;
    z-index: 2;
}

.model-card-body {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    gap: .5rem;
    flex: 1;
}
.model-card-meta { display: flex; gap: .5rem; align-items: center; }
.model-card-dim { font-size: .75rem; color: var(--text-muted); font-weight: 600; }
.model-card-name { font-size: 1.0625rem; font-weight: 700; margin: 0; color: var(--text); line-height: 1.3; }
.model-card-desc { font-size: .8125rem; color: var(--text-muted); line-height: 1.55; margin: 0; flex: 1; }

.model-card-features {
    list-style: none;
    padding: 0;
    margin: .5rem 0 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .25rem .75rem;
}
.model-card-features li { font-size: .75rem; color: var(--text); line-height: 1.4; }

.model-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: .75rem;
    margin-top: .875rem;
    padding-top: .875rem;
    border-top: 1px dashed var(--border);
}
.model-card-price { display: flex; flex-direction: column; line-height: 1.1; }
.model-card-price small { font-size: .6875rem; color: var(--text-muted); font-weight: 500; }
.model-card-price strong { font-size: 1.125rem; color: var(--text); font-weight: 800; }
.model-card-actions { display: flex; flex-direction: column; gap: .375rem; flex: 1; min-width: 0; }
.model-card-actions--full { flex: 1 1 100%; }
.model-card-actions--full .model-card-cta--primary { width: 100%; justify-content: center; padding: .75rem 1rem; font-size: .875rem; }
.model-card-add { width: 100%; margin: 0; }
.model-card-cta--primary {
    background: var(--red);
    color: var(--white);
    border: 0;
    padding: .55rem .9rem;
    font-size: .8125rem;
    font-weight: 700;
    border-radius: var(--radius-md);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    transition: all .2s;
    width: 100%;
}
.model-card-cta--primary:hover { background: #c0050f; transform: translateY(-1px); }
.model-card-cta--primary svg { flex-shrink: 0; }
.model-card-cta--outline {
    background: transparent;
    color: var(--text);
    border: 1px solid var(--border);
    padding: .5rem .9rem;
    font-size: .75rem;
    font-weight: 600;
    border-radius: var(--radius-md);
    text-align: center;
    text-decoration: none;
    transition: all .2s;
    width: 100%;
}
.model-card-cta--outline:hover { border-color: var(--red); color: var(--red); }
@media (max-width: 600px) {
    .model-card-footer { flex-direction: column; align-items: stretch; }
}

.empty-state {
    text-align: center;
    padding: var(--space-3xl);
    background: var(--bg-alt);
    border-radius: var(--radius-xl);
    color: var(--text-muted);
}
</style>
