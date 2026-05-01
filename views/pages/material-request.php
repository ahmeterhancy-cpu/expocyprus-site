<?php
$pageTitle       = lang() === 'en'
    ? 'Material Request | Expo Cyprus — Furniture & Equipment Order'
    : 'Malzeme Talebi | Expo Cyprus — Mobilya ve Ekipman Talep Formu';
$metaDescription = lang() === 'en'
    ? 'Order stand furniture and AV equipment quickly: tables, chairs, LED TVs, modular LED walls.'
    : 'Stand mobilyası ve AV ekipmanı için hızlı talep formu: masa, sandalye, LED TV, modüler LED wall.';
$bodyClass = 'page-material-request';

$old = is_array($oldInput ?? null) ? $oldInput : [];
$o = function (string $k, $default = '') use ($old) {
    return $old[$k] ?? $default;
};
$oldQty = $old['quantities'] ?? [];
$qty = function (string $k) use ($oldQty) {
    return isset($oldQty[$k]) ? (int)$oldQty[$k] : 0;
};

$qtyFields = [
    'q_tables'        => ['tr' => 'Masa (Yuvarlak)', 'en' => 'Table (Round)',  'img' => 'table.jpg'],
    'q_tables_2'      => ['tr' => 'Cam Masa',        'en' => 'Glass Table',    'img' => 'table-2.jpg'],
    'q_reception'     => ['tr' => 'Karşılama Desk',  'en' => 'Reception Desk', 'img' => 'reception.jpg'],
    'q_chair'         => ['tr' => 'Sandalye (Beyaz)','en' => 'Chair (White)',  'img' => 'chair.jpg'],
    'q_chair_2'       => ['tr' => 'Sandalye (Siyah)','en' => 'Chair (Black)',  'img' => 'chair-2.jpg'],
    'q_vip_chair'     => ['tr' => 'VIP Koltuk',      'en' => 'VIP Chairs',     'img' => 'vip-chair.jpg'],
    'q_sofa_group'    => ['tr' => 'Oturma Grubu',    'en' => 'Lounge Set',     'img' => 'sofa-group.jpg'],
    'q_bar_stool'     => ['tr' => 'Bar Taburesi',    'en' => 'Bar Stools',     'img' => 'bar-stool.jpg'],
    'q_brochure_rack' => ['tr' => 'Broşürlük',       'en' => 'Brochure Rack',  'img' => 'brochure-rack.jpg'],
];
?>

<section class="quote-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span aria-hidden="true">›</span>
            <span><?= lang() === 'en' ? 'Material Request' : 'Malzeme Talebi' ?></span>
        </nav>
        <h1><?= lang() === 'en' ? 'Material Request' : 'Malzeme Talebi' ?></h1>
        <p>
            <?= lang() === 'en'
                ? 'Quick request form for stand furniture and AV equipment. We respond within 24 hours.'
                : 'Stand mobilyası ve AV ekipmanı için hızlı talep formu. 24 saat içinde dönüş yapıyoruz.' ?>
        </p>
    </div>
</section>

<?php if (!empty($success)): ?>
<div class="container">
    <div class="quote-flash quote-flash--ok"><strong>✓</strong> <?= e($success) ?></div>
</div>
<?php endif; ?>
<?php if (!empty($error)): ?>
<div class="container">
    <div class="quote-flash quote-flash--err"><strong>!</strong> <?= e($error) ?></div>
</div>
<?php endif; ?>

<section class="section quote-section">
    <div class="container">
        <form method="POST" action="<?= url('malzeme-talebi') ?>" class="quote-form">
            <?= csrf_field() ?>

            <!-- ── 1. İLETİŞİM BİLGİLERİ ──────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">1</span>
                    <span><?= lang() === 'en' ? 'Contact Info' : 'İletişim Bilgileri' ?></span>
                </legend>
                <div class="qf-grid">
                    <div class="qf-field">
                        <label for="contact_name"><?= lang() === 'en' ? 'Full Name' : 'Ad Soyad' ?> <span class="req">*</span></label>
                        <input type="text" id="contact_name" name="contact_name" value="<?= e($o('contact_name')) ?>" required>
                    </div>
                    <div class="qf-field">
                        <label for="company"><?= lang() === 'en' ? 'Company Name' : 'Firma Adı' ?> <span class="req">*</span></label>
                        <input type="text" id="company" name="company" value="<?= e($o('company')) ?>" required>
                    </div>
                    <div class="qf-field">
                        <label for="email"><?= lang() === 'en' ? 'Email' : 'E-posta' ?> <span class="req">*</span></label>
                        <input type="email" id="email" name="email" value="<?= e($o('email')) ?>" required>
                    </div>
                    <div class="qf-field">
                        <label for="phone"><?= lang() === 'en' ? 'Phone' : 'Telefon' ?> <span class="req">*</span></label>
                        <input type="tel" id="phone" name="phone" value="<?= e($o('phone')) ?>" required placeholder="+90 ...">
                    </div>
                </div>
            </fieldset>

            <!-- ── 2. ETKİNLİK BİLGİLERİ (opsiyonel) ───────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">2</span>
                    <span><?= lang() === 'en' ? 'Event Info (optional)' : 'Etkinlik Bilgileri (opsiyonel)' ?></span>
                </legend>
                <div class="qf-grid">
                    <div class="qf-field qf-col-2">
                        <label for="event_name"><?= lang() === 'en' ? 'Congress / Fair / Event' : 'Kongre / Fuar / Etkinlik' ?></label>
                        <input type="text" id="event_name" name="event_name" value="<?= e($o('event_name')) ?>">
                    </div>
                    <div class="qf-field">
                        <label for="event_location"><?= lang() === 'en' ? 'Event Venue' : 'Etkinlik Yeri' ?></label>
                        <input type="text" id="event_location" name="event_location" value="<?= e($o('event_location')) ?>" placeholder="<?= lang() === 'en' ? 'e.g. Istanbul' : 'Örn: İstanbul' ?>">
                    </div>
                    <div class="qf-field">
                        <label for="event_date"><?= lang() === 'en' ? 'Event Date' : 'Etkinlik Tarihi' ?></label>
                        <input type="date" id="event_date" name="event_date" value="<?= e($o('event_date')) ?>">
                    </div>
                </div>
            </fieldset>

            <!-- ── 3. MOBİLYA & EKİPMAN ADET ───────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">3</span>
                    <span><?= lang() === 'en' ? 'Furniture & Equipment Quantity' : 'Mobilya & Ekipman Adet' ?></span>
                </legend>
                <div class="qf-qty-grid">
                    <?php foreach ($qtyFields as $name => $labels): ?>
                    <div class="qf-qty">
                        <div class="qf-qty-img">
                            <img src="/assets/images/furniture/<?= e($labels['img']) ?>"
                                 alt="<?= e($labels['tr']) ?>" loading="lazy"
                                 onerror="this.style.display='none'">
                        </div>
                        <label for="<?= e($name) ?>"><?= e(lang() === 'en' ? $labels['en'] : $labels['tr']) ?></label>
                        <input type="number" id="<?= e($name) ?>" name="<?= e($name) ?>" min="0" max="999" value="<?= $qty($name) ?>">
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- LED TV -->
                <div class="qf-subsection qf-tv-section">
                    <p class="qf-sublabel">
                        <?= lang() === 'en' ? 'LED TV (by size — quantity per size)' : 'LED TV (boyut bazlı adet)' ?>
                    </p>
                    <div class="qf-tv-grid">
                        <?php
                        $tvSizes = ['32', '43', '50', '55', '65', '75', '86'];
                        foreach ($tvSizes as $size):
                            $name = 'q_led_tv_' . $size;
                        ?>
                        <div class="qf-tv-size">
                            <span class="qf-tv-label"><?= $size ?>"</span>
                            <input type="number" id="<?= e($name) ?>" name="<?= e($name) ?>" min="0" max="99"
                                   value="<?= $qty($name) ?>" oninput="calcTvTotal()">
                        </div>
                        <?php endforeach; ?>
                        <div class="qf-tv-size qf-tv-total">
                            <span class="qf-tv-label"><?= lang() === 'en' ? 'Total' : 'Toplam' ?></span>
                            <input type="number" id="q_led_tv" name="q_led_tv" min="0" max="999" readonly value="<?= $qty('q_led_tv') ?>">
                        </div>
                    </div>
                </div>

                <!-- LED Ekran (Modüler Wall) -->
                <div class="qf-subsection qf-led-section">
                    <p class="qf-sublabel">
                        <?= lang() === 'en' ? 'LED Screen (Modular Wall) — Dimensions' : 'LED Ekran (Modüler Wall) — Ölçüler' ?>
                    </p>
                    <div class="qf-grid qf-grid-4">
                        <div class="qf-field">
                            <label for="led_screen_length"><?= lang() === 'en' ? 'Length (m)' : 'Boy (m)' ?></label>
                            <input type="number" step="0.1" min="0" max="50" id="led_screen_length" name="led_screen_length"
                                   value="<?= e($o('led_screen_length')) ?>" placeholder="3.0">
                        </div>
                        <div class="qf-field">
                            <label for="led_screen_width"><?= lang() === 'en' ? 'Height/Width (m)' : 'En (m)' ?></label>
                            <input type="number" step="0.1" min="0" max="20" id="led_screen_width" name="led_screen_width"
                                   value="<?= e($o('led_screen_width')) ?>" placeholder="2.0">
                        </div>
                        <div class="qf-field">
                            <label for="q_led_screen"><?= lang() === 'en' ? 'Quantity' : 'Adet' ?></label>
                            <input type="number" min="0" max="20" id="q_led_screen" name="q_led_screen"
                                   value="<?= $qty('q_led_screen') ?>" placeholder="1">
                        </div>
                        <div class="qf-field">
                            <label for="led_screen_pitch"><?= lang() === 'en' ? 'Pixel Pitch' : 'Piksel Aralığı' ?></label>
                            <select id="led_screen_pitch" name="led_screen_pitch">
                                <option value=""><?= lang() === 'en' ? '— Select —' : '— Seçin —' ?></option>
                                <?php foreach (['P2','P3','P4','P5','P6','P8','P10'] as $p): ?>
                                <option value="<?= $p ?>" <?= ($o('led_screen_pitch') === $p) ? 'selected' : '' ?>><?= $p ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- ── 4. NOTLAR ──────────────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">4</span>
                    <span><?= lang() === 'en' ? 'Notes' : 'Notlar' ?></span>
                </legend>
                <div class="qf-grid">
                    <div class="qf-field qf-col-2">
                        <label for="notes"><?= lang() === 'en' ? 'Special Requests' : 'Özel İstekler' ?></label>
                        <textarea id="notes" name="notes" rows="4" placeholder="<?= lang() === 'en' ? 'Any specific requirements...' : 'Özel istek veya not...' ?>"><?= e($o('notes')) ?></textarea>
                    </div>
                </div>
            </fieldset>

            <fieldset class="qf-group qf-group--kvkk">
                <label class="qf-check qf-kvkk">
                    <input type="checkbox" name="kvkk_accepted" value="1" required>
                    <span>
                        <?php if (lang() === 'en'): ?>
                            I have read and accept the <a href="<?= url('kvkk') ?>" target="_blank">KVKK Notice</a> and <a href="<?= url('gizlilik-politikasi') ?>" target="_blank">Privacy Policy</a>. <span class="req">*</span>
                        <?php else: ?>
                            <a href="<?= url('kvkk') ?>" target="_blank">KVKK Aydınlatma Metni</a> ve <a href="<?= url('gizlilik-politikasi') ?>" target="_blank">Gizlilik Politikası</a>'nı okudum, kabul ediyorum. <span class="req">*</span>
                        <?php endif; ?>
                    </span>
                </label>
            </fieldset>

            <div class="qf-submit">
                <button type="submit" class="btn btn-primary btn-lg">
                    <?= lang() === 'en' ? 'Submit Material Request' : 'Talebi Gönder' ?>
                    <span aria-hidden="true">→</span>
                </button>
                <small class="qf-submit-note">
                    <?= lang() === 'en' ? 'We respond within 24 hours.' : '24 saat içinde dönüş yapıyoruz.' ?>
                </small>
            </div>
        </form>
    </div>
</section>

<script>
function calcTvTotal() {
    const sizes = ['32', '43', '50', '55', '65', '75', '86'];
    let sum = 0;
    sizes.forEach(s => {
        const v = parseInt(document.getElementById('q_led_tv_' + s)?.value || '0', 10);
        if (!isNaN(v) && v > 0) sum += v;
    });
    const totalEl = document.getElementById('q_led_tv');
    if (totalEl) totalEl.value = sum;
}
document.addEventListener('DOMContentLoaded', calcTvTotal);
</script>

<style>
/* Reuse styles from quote.php */
.page-material-request .quote-hero {
    background-color: var(--black);
    background-image: url('/assets/images/service-stand-design.webp');
    background-size: cover;
    background-position: center;
    color: var(--white);
    padding: var(--space-3xl) 0 var(--space-2xl);
    position: relative;
    min-height: 280px;
    display: flex;
    align-items: center;
}
.page-material-request .quote-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,10,10,.88) 0%, rgba(10,10,10,.55) 100%);
}
.page-material-request .quote-hero > .container { position: relative; z-index: 1; }
.page-material-request .quote-hero h1 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    margin: .25rem 0 .5rem;
    font-weight: 800;
    color: var(--white) !important;
}
.page-material-request .quote-hero p {
    font-size: 1.0625rem;
    max-width: 720px;
    opacity: .85;
    color: rgba(255,255,255,.92);
    margin: 0;
}
.page-material-request .quote-hero .breadcrumb { color: rgba(255,255,255,.6); margin-bottom: .5rem; }
.page-material-request .quote-hero .breadcrumb a { color: rgba(255,255,255,.6); }

.page-material-request .quote-section { padding: var(--space-2xl) 0 var(--space-3xl); }
.page-material-request .quote-form { max-width: 1080px; margin: 0 auto; }
.page-material-request .qf-group {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    padding: 1.75rem 2rem;
    margin-bottom: 1.25rem;
}
.page-material-request .qf-group--kvkk { background: var(--bg-alt); }
.page-material-request .qf-legend {
    display: flex; align-items: center; gap: .75rem;
    font-size: 1.125rem; font-weight: 700;
    padding: 0 0 1.25rem; margin: 0 0 1.25rem;
    border-bottom: 1px solid var(--border); width: 100%;
}
.page-material-request .qf-step {
    display: inline-flex; align-items: center; justify-content: center;
    width: 28px; height: 28px;
    background: var(--red); color: var(--white);
    border-radius: 50%; font-size: .8125rem; font-weight: 700;
}
.page-material-request .qf-grid {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem 1.25rem;
}
.page-material-request .qf-grid-4 { grid-template-columns: repeat(4, 1fr); }
.page-material-request .qf-col-2 { grid-column: span 2; }
.page-material-request .qf-field { display: flex; flex-direction: column; gap: .375rem; }
.page-material-request .qf-field label {
    font-size: .8125rem; font-weight: 600;
    display: flex; align-items: center; gap: .25rem;
}
.page-material-request .qf-field .req { color: var(--red); }
.page-material-request .qf-field input,
.page-material-request .qf-field select,
.page-material-request .qf-field textarea {
    width: 100%; padding: .625rem .875rem;
    border: 1px solid var(--border); border-radius: var(--radius-md);
    background: var(--white); font: inherit; font-size: .9375rem;
}
.page-material-request .qf-field input[readonly] { background: var(--bg-alt); color: var(--text-muted); }

.page-material-request .qf-qty-grid {
    display: grid; grid-template-columns: repeat(6, 1fr); gap: .75rem;
}
@media (max-width: 1024px) { .page-material-request .qf-qty-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 600px)  { .page-material-request .qf-qty-grid { grid-template-columns: repeat(2, 1fr); } }
.page-material-request .qf-qty {
    display: flex; flex-direction: column; align-items: center; gap: .375rem;
    padding: .75rem .5rem; background: var(--bg-alt);
    border: 1px solid var(--border); border-radius: var(--radius-lg);
    transition: all .2s;
}
.page-material-request .qf-qty:hover { border-color: var(--red); transform: translateY(-2px); }
.page-material-request .qf-qty:focus-within { border-color: var(--red); box-shadow: 0 0 0 3px rgba(227,6,19,.08); }
.page-material-request .qf-qty-img {
    width: 100%; aspect-ratio: 1; background: var(--white);
    border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}
.page-material-request .qf-qty-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
.page-material-request .qf-qty label {
    font-size: .8125rem; font-weight: 600; text-align: center; margin: 0;
}
.page-material-request .qf-qty input {
    width: 100%; padding: .375rem .5rem;
    border: 1px solid var(--border); border-radius: var(--radius-md);
    background: var(--white); font: inherit; font-size: .9375rem;
    font-weight: 600; text-align: center;
}

.page-material-request .qf-subsection { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed var(--border); }
.page-material-request .qf-sublabel { font-size: .8125rem; font-weight: 600; margin: 0 0 .625rem; }
.page-material-request .qf-tv-grid {
    display: grid; grid-template-columns: repeat(8, 1fr); gap: .5rem;
}
@media (max-width: 1024px) { .page-material-request .qf-tv-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 480px)  { .page-material-request .qf-tv-grid { grid-template-columns: repeat(2, 1fr); } }
.page-material-request .qf-tv-size {
    display: flex; flex-direction: column; align-items: center; gap: .25rem;
    padding: .625rem .25rem;
    background: var(--bg-alt); border: 1px solid var(--border);
    border-radius: var(--radius-md);
}
.page-material-request .qf-tv-size:has(input:not([value="0"]):not([value=""])) {
    background: var(--red-light); border-color: var(--red);
}
.page-material-request .qf-tv-label { font-size: .8125rem; font-weight: 700; }
.page-material-request .qf-tv-size input {
    width: 100%; padding: .25rem; border: 0; background: transparent;
    font: inherit; font-size: .9375rem; font-weight: 600; text-align: center;
}
.page-material-request .qf-tv-total { background: var(--text); border-color: var(--text); }
.page-material-request .qf-tv-total .qf-tv-label,
.page-material-request .qf-tv-total input { color: var(--white); }

.page-material-request .qf-kvkk {
    align-items: flex-start; gap: .625rem;
    line-height: 1.55; font-size: .875rem; display: flex;
}
.page-material-request .qf-kvkk a { color: var(--red); text-decoration: underline; }
.page-material-request .qf-kvkk input { width: 16px; height: 16px; accent-color: var(--red); margin-top: .25rem; }

.page-material-request .qf-submit { text-align: center; padding: 1.5rem 0 .5rem; }
.page-material-request .qf-submit .btn { padding: .9rem 2.5rem; font-size: 1rem; }
.page-material-request .qf-submit-note { display: block; margin-top: .75rem; color: var(--text-muted); font-size: .8125rem; }

.page-material-request .quote-flash {
    margin-top: 1.25rem; padding: 1rem 1.25rem;
    border-radius: var(--radius-md);
    display: flex; align-items: center; gap: .75rem;
    font-size: .9375rem;
}
.page-material-request .quote-flash--ok { background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }
.page-material-request .quote-flash--err { background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; }

@media (max-width: 768px) {
    .page-material-request .qf-grid,
    .page-material-request .qf-grid-4 { grid-template-columns: 1fr; }
    .page-material-request .qf-col-2 { grid-column: auto; }
    .page-material-request .qf-group { padding: 1.25rem; }
}
</style>
