<?php
$pageTitle       = lang() === 'en'
    ? 'Request a Stand | Expo Cyprus — Detailed Stand Brief'
    : 'Stand Talep Formu | Expo Cyprus — Detaylı Stand Brifi';
$metaDescription = lang() === 'en'
    ? 'Submit a detailed stand request — fair info, dimensions, system, features and budget. We respond within 24 hours.'
    : 'Detaylı stand talep formu — fuar bilgileri, ölçüler, sistem, özellikler ve bütçe. 24 saat içinde yanıt veriyoruz.';
$bodyClass = 'page-quote';

// Repopulate from old input on validation error
$old = is_array($oldInput ?? null) ? $oldInput : [];
$o = function (string $k, $default = '') use ($old) {
    return $old[$k] ?? $default;
};
$oArr = function (string $k) use ($old) {
    $v = $old[$k] ?? [];
    return is_array($v) ? $v : [];
};

// ─── Seçenek listeleri (modüler, ileride kolayca genişletilebilir) ────────
$standTypes = [
    ['key' => '4-cephe',  'label_tr' => '4 Cephe Açık (Ada)',  'label_en' => '4 Sides Open (Island)',  'icon' => '◯'],
    ['key' => '3-cephe',  'label_tr' => '3 Cephe Açık',         'label_en' => '3 Sides Open',           'icon' => '◐'],
    ['key' => 'l-tipi',   'label_tr' => '2 Cephe Açık (L)',     'label_en' => '2 Sides Open (L)',       'icon' => '◑'],
    ['key' => 'tek-cephe','label_tr' => 'Tek Cephe Açık',       'label_en' => 'Single Side Open',       'icon' => '◒'],
];

$standSystems = [
    ['key' => 'ahsap',    'label_tr' => 'Ahşap Stand',          'label_en' => 'Wooden Stand',           'desc_tr' => 'Klasik, özel yapım',   'desc_en' => 'Classic, custom-built',  'img' => 'system-ahsap.jpg'],
    ['key' => 'maxima',   'label_tr' => 'Maxima Sistem',        'label_en' => 'Maxima System',          'desc_tr' => 'Modern alüminyum',     'desc_en' => 'Modern aluminium',       'img' => 'system-maxima.jpg'],
    ['key' => 'moduler',  'label_tr' => 'Modüler Max Sistem',   'label_en' => 'Modular Max System',     'desc_tr' => 'Hızlı kurulum',        'desc_en' => 'Fast assembly',          'img' => 'system-moduler.jpg'],
    ['key' => 'truss',    'label_tr' => 'Truss Sistem',         'label_en' => 'Truss System',           'desc_tr' => 'Hafif & taşınabilir',  'desc_en' => 'Lightweight & portable', 'img' => 'system-truss.jpg'],
];

$floorTypes = [
    'hali'       => ['tr' => 'Halı',           'en' => 'Carpet'],
    'podyum'     => ['tr' => 'Modüler Podyum', 'en' => 'Modular Podium'],
    'karolaj'    => ['tr' => 'Karolaj',        'en' => 'Tile'],
    'parke'      => ['tr' => 'Parke',          'en' => 'Parquet'],
    'suntalam'   => ['tr' => 'Suntalam',       'en' => 'Melamine'],
    'highgloss'  => ['tr' => 'Highgloss',      'en' => 'High Gloss'],
];

$extraSections = [
    'depo'             => ['tr' => 'Depo',                'en' => 'Storage'],
    'toplanti-odasi'   => ['tr' => 'Toplantı Odası',      'en' => 'Meeting Room'],
    'servis-bari'      => ['tr' => 'Servis Barı',         'en' => 'Service Bar'],
    'karsilama-bankosu'=> ['tr' => 'Karşılama Bankosu',   'en' => 'Reception Desk'],
    'video-wall'       => ['tr' => 'Video Wall',          'en' => 'Video Wall'],
    'led-tv'           => ['tr' => 'LED TV',              'en' => 'LED TV'],
    'mutfak'           => ['tr' => 'Mutfak',              'en' => 'Kitchen'],
    'su-lavabo'        => ['tr' => 'Su / Lavabo',         'en' => 'Water / Sink'],
    'brosurluk'        => ['tr' => 'Broşürlük',           'en' => 'Brochure Rack'],
    'podyum-platform'  => ['tr' => 'Podyum / Platform',   'en' => 'Podium / Platform'],
    'vip-koltuk'       => ['tr' => 'VIP Koltuk',          'en' => 'VIP Chair'],
    'cay-kahve'        => ['tr' => 'Çay-Kahve Otomatı',   'en' => 'Coffee Machine'],
    'bitki'            => ['tr' => 'Bitki / Çiçek',       'en' => 'Plants / Flowers'],
    'ses-sistemi'      => ['tr' => 'Ses Sistemi',         'en' => 'Sound System'],
];

$displayTypes = [
    'raf'      => ['tr' => 'Raf',          'en' => 'Shelf'],
    'vitrin'   => ['tr' => 'Vitrin',       'en' => 'Showcase'],
    'aski'     => ['tr' => 'Askı',         'en' => 'Hanger'],
    'kanal'    => ['tr' => 'Kanal Pano',   'en' => 'Channel Panel'],
    'box'      => ['tr' => 'Box',          'en' => 'Box'],
    'diger'    => ['tr' => 'Diğer',        'en' => 'Other'],
];

$lightingColors = [
    'beyaz'    => ['tr' => 'Beyaz',        'en' => 'White'],
    'gun-isigi'=> ['tr' => 'Gün Işığı',    'en' => 'Daylight'],
    'renkli'   => ['tr' => 'Renkli',       'en' => 'Colored'],
];
?>

<!-- ═══════════════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════════════ -->
<section class="quote-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
            <span aria-hidden="true">›</span>
            <span><?= lang() === 'en' ? 'Stand Request' : 'Stand Talep Formu' ?></span>
        </nav>
        <h1><?= lang() === 'en' ? 'Stand Request Form' : 'Stand Talep Formu' ?></h1>
        <p>
            <?= lang() === 'en'
                ? 'Tell us about your fair, dimensions and preferences. Our team will review and respond within 24 hours with a detailed proposal.'
                : 'Fuar bilgilerinizi, ölçülerinizi ve tercihlerinizi paylaşın. Ekibimiz inceleyip 24 saat içinde detaylı teklifle döner.' ?>
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     FLASH MESSAGES
═══════════════════════════════════════════════════════════════ -->
<?php if (!empty($success)): ?>
<div class="container">
    <div class="quote-flash quote-flash--ok">
        <strong>✓</strong> <?= e($success) ?>
    </div>
</div>
<?php endif; ?>
<?php if (!empty($error)): ?>
<div class="container">
    <div class="quote-flash quote-flash--err">
        <strong>!</strong> <?= e($error) ?>
    </div>
</div>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════════
     STAND REQUEST FORM
═══════════════════════════════════════════════════════════════ -->
<section class="section quote-section">
    <div class="container">
        <form method="POST" action="<?= url('teklif-al') ?>" class="quote-form" id="quoteForm" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- ── 1. ETKİNLİK BİLGİLERİ ──────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">1</span>
                    <span><?= lang() === 'en' ? 'Congress / Fair / Event Participation Info' : 'Kongre / Fuar / Organizasyon Katılım Bilgileri' ?></span>
                </legend>
                <div class="qf-grid">
                    <div class="qf-field qf-col-2">
                        <label for="fair_name"><?= lang() === 'en' ? 'Event Name' : 'Etkinlik Adı' ?> <span class="req">*</span></label>
                        <input type="text" id="fair_name" name="fair_name" value="<?= e($o('fair_name')) ?>" required>
                    </div>
                    <div class="qf-field">
                        <label for="fair_location"><?= lang() === 'en' ? 'Event Location' : 'Etkinlik Yeri' ?></label>
                        <input type="text" id="fair_location" name="fair_location" value="<?= e($o('fair_location')) ?>" placeholder="<?= lang() === 'en' ? 'e.g. Istanbul' : 'Örn: İstanbul' ?>">
                    </div>
                    <div class="qf-field">
                        <label for="fair_date"><?= lang() === 'en' ? 'Event Date' : 'Etkinlik Tarihi' ?></label>
                        <input type="date" id="fair_date" name="fair_date" value="<?= e($o('fair_date')) ?>">
                    </div>
                </div>
            </fieldset>

            <!-- ── 2. FİRMA BİLGİLERİ ─────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">2</span>
                    <span><?= lang() === 'en' ? 'Company Info' : 'Firma Bilgileri' ?></span>
                </legend>
                <div class="qf-grid">
                    <div class="qf-field">
                        <label for="company"><?= lang() === 'en' ? 'Company Name' : 'Firma Adı' ?></label>
                        <input type="text" id="company" name="company" value="<?= e($o('company')) ?>">
                    </div>
                    <div class="qf-field">
                        <label for="contact_name"><?= lang() === 'en' ? 'Contact Person' : 'Yetkili Adı' ?> <span class="req">*</span></label>
                        <input type="text" id="contact_name" name="contact_name" value="<?= e($o('contact_name')) ?>" required>
                    </div>
                    <div class="qf-field">
                        <label for="email"><?= lang() === 'en' ? 'Email' : 'E-posta' ?> <span class="req">*</span></label>
                        <input type="email" id="email" name="email" value="<?= e($o('email')) ?>" required>
                    </div>
                    <div class="qf-field">
                        <label for="phone"><?= lang() === 'en' ? 'Phone' : 'Telefon' ?> <span class="req">*</span></label>
                        <input type="tel" id="phone" name="phone" value="<?= e($o('phone')) ?>" required placeholder="+90 ...">
                    </div>
                    <div class="qf-field qf-col-2">
                        <label for="website"><?= lang() === 'en' ? 'Website' : 'Web Adresi' ?></label>
                        <input type="url" id="website" name="website" value="<?= e($o('website')) ?>" placeholder="https://...">
                    </div>
                </div>
            </fieldset>

            <!-- ── 3. STAND TİPİ ──────────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">3</span>
                    <span><?= lang() === 'en' ? 'Stand Type' : 'Stand Tipi' ?></span>
                </legend>
                <div class="qf-cards qf-cards--4">
                    <?php foreach ($standTypes as $st):
                        $checked = ($o('stand_type') === $st['key']) ? 'checked' : '';
                        $label   = lang() === 'en' ? $st['label_en'] : $st['label_tr'];
                    ?>
                    <label class="qf-card">
                        <input type="radio" name="stand_type" value="<?= e($st['key']) ?>" <?= $checked ?>>
                        <span class="qf-card-shape" data-type="<?= e($st['key']) ?>" aria-hidden="true"></span>
                        <span class="qf-card-label"><?= e($label) ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </fieldset>

            <!-- ── 4. BOYUTLAR ────────────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">4</span>
                    <span><?= lang() === 'en' ? 'Dimensions' : 'Boyutlar' ?></span>
                </legend>
                <div class="qf-grid qf-grid-4">
                    <div class="qf-field">
                        <label for="length_m"><?= lang() === 'en' ? 'Length (m)' : 'Boy (m)' ?></label>
                        <input type="number" step="0.1" min="0" id="length_m" name="length_m" value="<?= e($o('length_m')) ?>" oninput="calcSqm()">
                    </div>
                    <div class="qf-field">
                        <label for="width_m"><?= lang() === 'en' ? 'Width (m)' : 'En (m)' ?></label>
                        <input type="number" step="0.1" min="0" id="width_m" name="width_m" value="<?= e($o('width_m')) ?>" oninput="calcSqm()">
                    </div>
                    <div class="qf-field">
                        <label for="height_cm"><?= lang() === 'en' ? 'Height (cm)' : 'Yükseklik (cm)' ?></label>
                        <input type="number" step="1" min="0" id="height_cm" name="height_cm" value="<?= e($o('height_cm')) ?>" placeholder="250">
                    </div>
                    <div class="qf-field">
                        <label for="total_sqm"><?= lang() === 'en' ? 'Total (m²)' : 'Toplam (m²)' ?> <small><?= lang() === 'en' ? 'auto' : 'oto' ?></small></label>
                        <input type="number" step="0.01" min="0" id="total_sqm" name="total_sqm" value="<?= e($o('total_sqm')) ?>" readonly>
                    </div>
                </div>
            </fieldset>

            <!-- ── 5. STAND SİSTEMİ ───────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">5</span>
                    <span><?= lang() === 'en' ? 'Stand System' : 'Stand Sistemi' ?></span>
                </legend>
                <div class="qf-cards qf-cards--4">
                    <?php foreach ($standSystems as $ss):
                        $checked = ($o('stand_system') === $ss['key']) ? 'checked' : '';
                        $label   = lang() === 'en' ? $ss['label_en'] : $ss['label_tr'];
                        $desc    = lang() === 'en' ? $ss['desc_en'] : $ss['desc_tr'];
                    ?>
                    <label class="qf-card qf-card--photo">
                        <input type="radio" name="stand_system" value="<?= e($ss['key']) ?>" <?= $checked ?>>
                        <span class="qf-card-photo">
                            <img src="/assets/images/furniture/<?= e($ss['img']) ?>" alt="<?= e($label) ?>" loading="lazy" onerror="this.style.display='none'">
                        </span>
                        <span class="qf-card-label"><?= e($label) ?></span>
                        <small class="qf-card-desc"><?= e($desc) ?></small>
                    </label>
                    <?php endforeach; ?>
                </div>
            </fieldset>

            <!-- ── 6. YAPI VE ZEMİN ───────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">6</span>
                    <span><?= lang() === 'en' ? 'Structure & Floor' : 'Yapı ve Zemin' ?></span>
                </legend>
                <div class="qf-grid">
                    <div class="qf-field">
                        <label><?= lang() === 'en' ? 'Stand Structure' : 'Stand Yapısı' ?></label>
                        <div class="qf-radio-row">
                            <label class="qf-radio"><input type="radio" name="structure" value="tek-katli" <?= ($o('structure', 'tek-katli') === 'tek-katli') ? 'checked' : '' ?>><span><?= lang() === 'en' ? 'Single Floor' : 'Tek Katlı' ?></span></label>
                            <label class="qf-radio"><input type="radio" name="structure" value="iki-katli" <?= ($o('structure') === 'iki-katli') ? 'checked' : '' ?>><span><?= lang() === 'en' ? 'Two Floors' : 'İki Katlı' ?></span></label>
                        </div>
                    </div>
                    <div class="qf-field">
                        <label for="floor_type"><?= lang() === 'en' ? 'Floor Type' : 'Zemin Tipi' ?></label>
                        <select id="floor_type" name="floor_type">
                            <option value=""><?= lang() === 'en' ? '— Select —' : '— Seçin —' ?></option>
                            <?php foreach ($floorTypes as $key => $names): ?>
                            <option value="<?= e($key) ?>" <?= ($o('floor_type') === $key) ? 'selected' : '' ?>>
                                <?= e(lang() === 'en' ? $names['en'] : $names['tr']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- ── 7. ÖZELLİKLER ──────────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">7</span>
                    <span><?= lang() === 'en' ? 'Features' : 'Stand Özellikleri' ?></span>
                </legend>

                <div class="qf-subsection">
                    <p class="qf-sublabel"><?= lang() === 'en' ? 'Extra Sections' : 'Ek Bölümler' ?></p>
                    <div class="qf-checkbox-grid">
                        <?php $oldExtras = $oArr('extra_sections'); foreach ($extraSections as $key => $names): ?>
                        <label class="qf-check">
                            <input type="checkbox" name="extra_sections[]" value="<?= e($key) ?>" <?= in_array($key, $oldExtras, true) ? 'checked' : '' ?>>
                            <span><?= e(lang() === 'en' ? $names['en'] : $names['tr']) ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="qf-subsection">
                    <p class="qf-sublabel"><?= lang() === 'en' ? 'Display Type' : 'Sergileme Türü' ?></p>
                    <div class="qf-checkbox-grid qf-checkbox-grid--6">
                        <?php $oldDisp = $oArr('display_type'); foreach ($displayTypes as $key => $names): ?>
                        <label class="qf-check">
                            <input type="checkbox" name="display_type[]" value="<?= e($key) ?>" <?= in_array($key, $oldDisp, true) ? 'checked' : '' ?>>
                            <span><?= e(lang() === 'en' ? $names['en'] : $names['tr']) ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="qf-grid">
                    <div class="qf-field">
                        <label><?= lang() === 'en' ? 'Lighting Color' : 'Aydınlatma Rengi' ?></label>
                        <div class="qf-radio-row">
                            <?php foreach ($lightingColors as $key => $names): ?>
                            <label class="qf-radio">
                                <input type="radio" name="lighting_color" value="<?= e($key) ?>" <?= ($o('lighting_color') === $key) ? 'checked' : '' ?>>
                                <span><?= e(lang() === 'en' ? $names['en'] : $names['tr']) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="qf-field">
                        <label><?= lang() === 'en' ? 'Logo Type' : 'Logo Tipi' ?></label>
                        <div class="qf-radio-row">
                            <label class="qf-radio"><input type="radio" name="logo_type" value="isikli" <?= ($o('logo_type') === 'isikli') ? 'checked' : '' ?>><span><?= lang() === 'en' ? 'Illuminated' : 'Işıklı' ?></span></label>
                            <label class="qf-radio"><input type="radio" name="logo_type" value="3d" <?= ($o('logo_type') === '3d') ? 'checked' : '' ?>><span>3D</span></label>
                            <label class="qf-radio"><input type="radio" name="logo_type" value="vinil" <?= ($o('logo_type') === 'vinil') ? 'checked' : '' ?>><span><?= lang() === 'en' ? 'Vinyl' : 'Vinil' ?></span></label>
                        </div>
                    </div>
                    <div class="qf-field">
                        <label><?= lang() === 'en' ? 'Shelf Lighting' : 'Raf Işıklandırması' ?></label>
                        <div class="qf-radio-row">
                            <label class="qf-radio"><input type="radio" name="shelf_lighting" value="evet" <?= ($o('shelf_lighting') === 'evet') ? 'checked' : '' ?>><span><?= lang() === 'en' ? 'Yes' : 'İstiyorum' ?></span></label>
                            <label class="qf-radio"><input type="radio" name="shelf_lighting" value="hayir" <?= ($o('shelf_lighting') === 'hayir') ? 'checked' : '' ?>><span><?= lang() === 'en' ? 'No' : 'İstemiyorum' ?></span></label>
                        </div>
                    </div>
                    <div class="qf-field">
                        <label><?= lang() === 'en' ? 'Shelf Position' : 'Raf Konumu' ?></label>
                        <div class="qf-radio-row">
                            <label class="qf-radio"><input type="radio" name="shelf_position" value="duvar" <?= ($o('shelf_position') === 'duvar') ? 'checked' : '' ?>><span><?= lang() === 'en' ? 'On Walls' : 'Duvarlarda' ?></span></label>
                            <label class="qf-radio"><input type="radio" name="shelf_position" value="alan" <?= ($o('shelf_position') === 'alan') ? 'checked' : '' ?>><span><?= lang() === 'en' ? 'Stand Area' : 'Stand Alanında' ?></span></label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- ── 8. ADET GİRİŞLERİ ──────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">8</span>
                    <span><?= lang() === 'en' ? 'Quantity (Furniture & Equipment)' : 'Adet (Mobilya & Ekipman)' ?></span>
                </legend>
                <div class="qf-qty-grid">
                    <?php
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
                    foreach ($qtyFields as $name => $labels): ?>
                    <div class="qf-qty">
                        <div class="qf-qty-img">
                            <img src="/assets/images/furniture/<?= e($labels['img']) ?>"
                                 alt="<?= e($labels['tr']) ?>" loading="lazy"
                                 onerror="this.style.display='none'">
                        </div>
                        <label for="<?= e($name) ?>"><?= e(lang() === 'en' ? $labels['en'] : $labels['tr']) ?></label>
                        <input type="number" id="<?= e($name) ?>" name="<?= e($name) ?>" min="0" max="999" value="<?= (int)$o($name, 0) ?>">
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- LED TV Boyut Bazlı Adetler -->
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
                                   value="<?= (int)$o($name, 0) ?>" oninput="calcTvTotal()">
                        </div>
                        <?php endforeach; ?>
                        <div class="qf-tv-size qf-tv-total">
                            <span class="qf-tv-label"><?= lang() === 'en' ? 'Total' : 'Toplam' ?></span>
                            <input type="number" id="q_led_tv" name="q_led_tv" min="0" max="999" readonly value="<?= (int)$o('q_led_tv', 0) ?>">
                        </div>
                    </div>
                    <small class="qf-tv-hint">
                        <?= lang() === 'en' ? 'Specify quantity per screen size (e.g. 2× 55", 1× 75").' : 'Her ekran boyutu için adet girin (örn. 2 adet 55", 1 adet 75").' ?>
                    </small>
                </div>

                <!-- LED Ekran (Modüler Wall) Boyutları -->
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
                                   value="<?= (int)$o('q_led_screen', 0) ?>" placeholder="1">
                        </div>
                        <div class="qf-field">
                            <label for="led_screen_pitch"><?= lang() === 'en' ? 'Pixel Pitch' : 'Piksel Aralığı' ?></label>
                            <select id="led_screen_pitch" name="led_screen_pitch">
                                <option value=""><?= lang() === 'en' ? '— Select —' : '— Seçin —' ?></option>
                                <option value="P2"  <?= ($o('led_screen_pitch') === 'P2')  ? 'selected' : '' ?>>P2 (iç mekan, ultra HD)</option>
                                <option value="P3"  <?= ($o('led_screen_pitch') === 'P3')  ? 'selected' : '' ?>>P3 (iç mekan, HD)</option>
                                <option value="P4"  <?= ($o('led_screen_pitch') === 'P4')  ? 'selected' : '' ?>>P4 (iç mekan)</option>
                                <option value="P5"  <?= ($o('led_screen_pitch') === 'P5')  ? 'selected' : '' ?>>P5 (orta mesafe)</option>
                                <option value="P6"  <?= ($o('led_screen_pitch') === 'P6')  ? 'selected' : '' ?>>P6 (dış mekan)</option>
                                <option value="P8"  <?= ($o('led_screen_pitch') === 'P8')  ? 'selected' : '' ?>>P8 (dış mekan)</option>
                                <option value="P10" <?= ($o('led_screen_pitch') === 'P10') ? 'selected' : '' ?>>P10 (uzak mesafe)</option>
                            </select>
                        </div>
                    </div>
                    <small class="qf-tv-hint">
                        <?= lang() === 'en' ? 'Modular LED wall dimensions and pixel pitch (lower P = higher resolution).' : 'Modüler LED panel ölçüleri ve piksel aralığı (düşük P = daha yüksek çözünürlük).' ?>
                    </small>
                </div>

                <!-- Stand Hostes -->
                <div class="qf-subsection qf-hostess-section">
                    <p class="qf-sublabel">
                        <?= lang() === 'en' ? 'Stand Hostess (gender / quantity)' : 'Stand Hostes (cinsiyet / adet)' ?>
                    </p>
                    <div class="qf-grid qf-grid-3">
                        <div class="qf-field">
                            <label><?= lang() === 'en' ? 'Need Hostess?' : 'Hostes İhtiyacı' ?></label>
                            <div class="qf-radio-row">
                                <label class="qf-radio">
                                    <input type="radio" name="hostess" value="evet" <?= ($o('hostess') === 'evet') ? 'checked' : '' ?>>
                                    <span><?= lang() === 'en' ? 'Yes' : 'İstiyorum' ?></span>
                                </label>
                                <label class="qf-radio">
                                    <input type="radio" name="hostess" value="hayir" <?= ($o('hostess', 'hayir') === 'hayir') ? 'checked' : '' ?>>
                                    <span><?= lang() === 'en' ? 'No' : 'İstemiyorum' ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="qf-field">
                            <label for="hostess_male">
                                <?= lang() === 'en' ? 'Male — Quantity' : 'Erkek — Adet' ?>
                            </label>
                            <input type="number" id="hostess_male" name="hostess_male" min="0" max="50"
                                   value="<?= (int)$o('hostess_male', 0) ?>" placeholder="0">
                        </div>
                        <div class="qf-field">
                            <label for="hostess_female">
                                <?= lang() === 'en' ? 'Female — Quantity' : 'Kadın — Adet' ?>
                            </label>
                            <input type="number" id="hostess_female" name="hostess_female" min="0" max="50"
                                   value="<?= (int)$o('hostess_female', 0) ?>" placeholder="0">
                        </div>
                    </div>
                    <small class="qf-tv-hint">
                        <?= lang() === 'en'
                            ? 'Trained, multilingual professional staff. Specify quantity per gender.'
                            : 'Eğitimli, çok dilli profesyonel saha kadrosu. Cinsiyet bazlı adet girebilirsiniz.' ?>
                    </small>
                </div>
            </fieldset>

            <!-- ── 9. ÖRNEK PROJE / BRIF DOSYALARI ────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">9</span>
                    <span><?= lang() === 'en' ? 'Reference Files (optional)' : 'Örnek Proje / Brif Dosyaları (opsiyonel)' ?></span>
                </legend>
                <div class="qf-upload-wrap">
                    <label for="attachments" class="qf-upload-drop" id="qfUploadDrop">
                        <input type="file" id="attachments" name="attachments[]" multiple
                               accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.zip"
                               style="display:none">
                        <div class="qf-upload-icon" aria-hidden="true">
                            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <div class="qf-upload-text">
                            <strong><?= lang() === 'en' ? 'Click to upload or drag & drop' : 'Yüklemek için tıklayın veya sürükleyip bırakın' ?></strong>
                            <span class="qf-upload-hint">
                                <?= lang() === 'en'
                                    ? 'Reference images, brief PDFs, mood-boards (max 8 files, 10 MB each)'
                                    : 'Referans görseller, brif PDF, moodboard (en fazla 8 dosya, her biri 10 MB)' ?>
                            </span>
                            <span class="qf-upload-formats">JPG · PNG · WEBP · PDF · DOC · DOCX · ZIP</span>
                        </div>
                    </label>
                    <ul class="qf-upload-list" id="qfUploadList" hidden></ul>
                </div>
            </fieldset>

            <!-- ── 10. BÜTÇE & NOTLAR ─────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend">
                    <span class="qf-step">10</span>
                    <span><?= lang() === 'en' ? 'Budget & Notes' : 'Bütçe ve Notlar' ?></span>
                </legend>
                <div class="qf-grid qf-grid-3">
                    <div class="qf-field">
                        <label for="budget_min"><?= lang() === 'en' ? 'Budget Min' : 'Min. Bütçe' ?></label>
                        <input type="number" id="budget_min" name="budget_min" min="0" step="100" value="<?= e($o('budget_min')) ?>">
                    </div>
                    <div class="qf-field">
                        <label for="budget_max"><?= lang() === 'en' ? 'Budget Max' : 'Max. Bütçe' ?></label>
                        <input type="number" id="budget_max" name="budget_max" min="0" step="100" value="<?= e($o('budget_max')) ?>">
                    </div>
                    <div class="qf-field">
                        <label for="currency"><?= lang() === 'en' ? 'Currency' : 'Para Birimi' ?></label>
                        <select id="currency" name="currency">
                            <option value="EUR" <?= ($o('currency','EUR') === 'EUR') ? 'selected' : '' ?>>EUR (€)</option>
                            <option value="TRY" <?= ($o('currency') === 'TRY') ? 'selected' : '' ?>>TRY (₺)</option>
                            <option value="USD" <?= ($o('currency') === 'USD') ? 'selected' : '' ?>>USD ($)</option>
                            <option value="GBP" <?= ($o('currency') === 'GBP') ? 'selected' : '' ?>>GBP (£)</option>
                        </select>
                    </div>
                    <div class="qf-field qf-col-3">
                        <label for="notes"><?= lang() === 'en' ? 'Notes / Special Requests' : 'Notlar / Özel İstekler' ?></label>
                        <textarea id="notes" name="notes" rows="5" placeholder="<?= lang() === 'en' ? 'Brand colors, theme, references...' : 'Marka renkleri, tema, referanslar...' ?>"><?= e($o('notes')) ?></textarea>
                    </div>
                </div>
            </fieldset>

            <!-- ── 10. KVKK ───────────────────────────────── -->
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

            <!-- ── SUBMIT ─────────────────────────────────── -->
            <div class="qf-submit">
                <button type="submit" class="btn btn-primary btn-lg">
                    <?= lang() === 'en' ? 'Submit Stand Request' : 'Talebi Gönder' ?>
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
function calcSqm() {
    const l = parseFloat(document.getElementById('length_m').value) || 0;
    const w = parseFloat(document.getElementById('width_m').value) || 0;
    const total = (l * w);
    document.getElementById('total_sqm').value = total > 0 ? total.toFixed(2) : '';
}

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

// File upload preview
(function () {
    const input = document.getElementById('attachments');
    const list  = document.getElementById('qfUploadList');
    const drop  = document.getElementById('qfUploadDrop');
    if (!input || !list || !drop) return;

    const formatSize = (bytes) => {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1024 / 1024).toFixed(1) + ' MB';
    };

    const iconFor = (name) => {
        const ext = name.split('.').pop().toLowerCase();
        if (['jpg','jpeg','png','webp','gif'].includes(ext)) return '🖼️';
        if (['pdf'].includes(ext)) return '📄';
        if (['doc','docx'].includes(ext)) return '📝';
        if (['zip','rar'].includes(ext)) return '🗜️';
        return '📎';
    };

    const render = () => {
        list.innerHTML = '';
        const files = Array.from(input.files);
        if (files.length === 0) { list.hidden = true; return; }
        list.hidden = false;
        files.forEach((f, i) => {
            const li = document.createElement('li');
            li.className = 'qf-upload-item';
            li.innerHTML = `<span class="qf-upload-fileicon">${iconFor(f.name)}</span><span class="qf-upload-filename">${f.name}</span><span class="qf-upload-filesize">${formatSize(f.size)}</span>`;
            list.appendChild(li);
        });
    };

    input.addEventListener('change', render);

    // Drag & drop
    ['dragenter', 'dragover'].forEach(ev => {
        drop.addEventListener(ev, (e) => { e.preventDefault(); drop.classList.add('qf-upload-drop--over'); });
    });
    ['dragleave', 'drop'].forEach(ev => {
        drop.addEventListener(ev, (e) => { e.preventDefault(); drop.classList.remove('qf-upload-drop--over'); });
    });
    drop.addEventListener('drop', (e) => {
        e.preventDefault();
        if (e.dataTransfer && e.dataTransfer.files) {
            input.files = e.dataTransfer.files;
            render();
        }
    });
})();
</script>

<style>
/* ─── HERO ───────────────────────────────────────────── */
.quote-hero {
    background-color: var(--black);
    background-image: url('/assets/images/service-stand-design.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: var(--white);
    padding: var(--space-3xl) 0 var(--space-2xl);
    position: relative;
    min-height: 320px;
    display: flex;
    align-items: center;
}
.quote-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,10,10,.88) 0%, rgba(10,10,10,.65) 60%, rgba(10,10,10,.45) 100%);
    z-index: 0;
}
.quote-hero > .container { position: relative; z-index: 1; }
.quote-hero::after {
    content: '';
    position: absolute; left: 0; right: 0; bottom: 0;
    height: 3px; background: var(--red);
    z-index: 2;
}
.quote-hero .breadcrumb { display: flex; gap: .5rem; font-size: .875rem; color: rgba(255,255,255,.6); margin-bottom: .5rem; }
.quote-hero .breadcrumb a { color: rgba(255,255,255,.6); }
.quote-hero .breadcrumb a:hover { color: var(--white); }
.quote-hero h1 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    margin: .25rem 0 .75rem;
    font-weight: 800;
    color: var(--white) !important;
}
.quote-hero p {
    font-size: 1.0625rem;
    max-width: 720px;
    opacity: .85;
    line-height: 1.6;
    margin: 0;
    color: rgba(255,255,255,.92);
}
.quote-hero .breadcrumb,
.quote-hero .breadcrumb a,
.quote-hero .breadcrumb span { color: rgba(255,255,255,.7); }
.quote-hero .breadcrumb a:hover { color: var(--white); }

/* ─── FLASH MESSAGES ─────────────────────────────────── */
.quote-flash {
    margin-top: 1.25rem;
    padding: 1rem 1.25rem;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    gap: .75rem;
    font-size: .9375rem;
}
.quote-flash--ok  { background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }
.quote-flash--err { background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; }
.quote-flash strong { font-size: 1.125rem; }

/* ─── FORM CONTAINER ─────────────────────────────────── */
.quote-section { padding-top: var(--space-2xl); padding-bottom: var(--space-3xl); }
.quote-form { max-width: 1080px; margin: 0 auto; }

/* ─── FIELDSET GROUPS ────────────────────────────────── */
.qf-group {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    padding: 1.75rem 2rem;
    margin-bottom: 1.25rem;
}
.qf-group--kvkk { background: var(--bg-alt); }

.qf-legend {
    display: flex;
    align-items: center;
    gap: .75rem;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text);
    padding: 0 0 1.25rem;
    margin: 0 0 1.25rem;
    border-bottom: 1px solid var(--border);
    width: 100%;
}
.qf-step {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px; height: 28px;
    background: var(--red);
    color: var(--white);
    border-radius: 50%;
    font-size: .8125rem;
    font-weight: 700;
}

/* ─── GRIDS ──────────────────────────────────────────── */
.qf-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem 1.25rem;
}
.qf-grid-3 { grid-template-columns: repeat(3, 1fr); }
.qf-grid-4 { grid-template-columns: repeat(4, 1fr); }
.qf-col-2 { grid-column: span 2; }
.qf-col-3 { grid-column: 1 / -1; }
@media (max-width: 768px) {
    .qf-grid, .qf-grid-3, .qf-grid-4 { grid-template-columns: 1fr; }
    .qf-col-2 { grid-column: auto; }
    .qf-group { padding: 1.25rem; }
}

/* ─── FIELDS ─────────────────────────────────────────── */
.qf-field { display: flex; flex-direction: column; gap: .375rem; }
.qf-field label {
    font-size: .8125rem;
    font-weight: 600;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: .25rem;
}
.qf-field label small { color: var(--text-muted); font-weight: 400; font-size: .6875rem; }
.qf-field .req { color: var(--red); }

.qf-field input[type="text"],
.qf-field input[type="email"],
.qf-field input[type="tel"],
.qf-field input[type="url"],
.qf-field input[type="date"],
.qf-field input[type="number"],
.qf-field select,
.qf-field textarea {
    width: 100%;
    padding: .625rem .875rem;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    background: var(--white);
    font: inherit;
    font-size: .9375rem;
    color: var(--text);
    transition: border-color .15s, box-shadow .15s;
}
.qf-field input:focus,
.qf-field select:focus,
.qf-field textarea:focus {
    outline: 0;
    border-color: var(--red);
    box-shadow: 0 0 0 3px rgba(227,6,19,.1);
}
.qf-field textarea { resize: vertical; line-height: 1.5; }
.qf-field input[readonly] { background: var(--bg-alt); color: var(--text-muted); }

/* ─── RADIO ROW ──────────────────────────────────────── */
.qf-radio-row { display: flex; flex-wrap: wrap; gap: .5rem; }
.qf-radio { cursor: pointer; }
.qf-radio input { display: none; }
.qf-radio span {
    display: inline-block;
    padding: .5rem .9rem;
    border: 1px solid var(--border);
    border-radius: 100px;
    font-size: .8125rem;
    font-weight: 500;
    background: var(--white);
    transition: all .15s;
}
.qf-radio input:checked + span {
    background: var(--red);
    border-color: var(--red);
    color: var(--white);
}
.qf-radio:hover span { border-color: var(--red); }

/* ─── CARD SELECTORS (Stand Type / System) ─────────── */
.qf-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .875rem;
}
@media (max-width: 768px) { .qf-cards { grid-template-columns: repeat(2, 1fr); } }
.qf-card {
    cursor: pointer;
    border: 2px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.25rem .75rem;
    text-align: center;
    transition: all .2s;
    background: var(--white);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .5rem;
}
.qf-card input { display: none; }
.qf-card:hover { border-color: var(--red); transform: translateY(-2px); }
.qf-card:has(input:checked) {
    border-color: var(--red);
    background: var(--red-light);
    box-shadow: 0 4px 12px rgba(227,6,19,.15);
}
.qf-card-shape {
    width: 60px; height: 60px;
    border: 3px solid var(--gray-400);
    border-radius: 4px;
    background: var(--bg-alt);
    transition: border-color .2s;
    position: relative;
}
.qf-card:has(input:checked) .qf-card-shape { border-color: var(--red); }
/* Stand type shapes — open sides */
.qf-card-shape[data-type="4-cephe"]   { border: 3px dashed var(--gray-400); }
.qf-card-shape[data-type="3-cephe"]   { border-bottom: 3px solid var(--gray-400); border-top: 3px dashed var(--gray-400); border-left: 3px dashed var(--gray-400); border-right: 3px dashed var(--gray-400); }
.qf-card-shape[data-type="l-tipi"]    { border-top: 3px solid var(--gray-400); border-left: 3px solid var(--gray-400); border-bottom: 3px dashed var(--gray-400); border-right: 3px dashed var(--gray-400); }
.qf-card-shape[data-type="tek-cephe"] { border: 3px solid var(--gray-400); border-bottom: 3px dashed var(--gray-400); }
.qf-card:has(input:checked) .qf-card-shape[data-type] {
    border-color: var(--red) !important;
}

.qf-card-icon {
    width: 56px; height: 56px;
    border-radius: 12px;
    background: var(--bg-alt);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--red);
}

/* ─── Stand System Photo Cards ───────────────────────── */
.qf-card--photo { padding: 0; overflow: hidden; }
.qf-card--photo .qf-card-label { padding: 0 .75rem; margin-top: .25rem; }
.qf-card--photo .qf-card-desc  { padding: 0 .75rem .9rem; }
.qf-card-photo {
    width: 100%;
    aspect-ratio: 4/3;
    background: var(--bg-alt);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-bottom: 1px solid var(--border);
    transition: filter .25s;
}
.qf-card-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s;
}
.qf-card--photo:hover .qf-card-photo img { transform: scale(1.04); }
.qf-card--photo:has(input:checked) .qf-card-photo { filter: saturate(1.05); }

.qf-card-label { font-weight: 700; font-size: .875rem; color: var(--text); }
.qf-card-desc  { color: var(--text-muted); font-size: .75rem; }

/* ─── CHECKBOX GRIDS ─────────────────────────────────── */
.qf-subsection { margin-bottom: 1.5rem; }
.qf-sublabel {
    font-size: .8125rem;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 .625rem;
}
.qf-checkbox-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .375rem .75rem;
}
.qf-checkbox-grid--6 { grid-template-columns: repeat(6, 1fr); }
@media (max-width: 768px) {
    .qf-checkbox-grid, .qf-checkbox-grid--6 { grid-template-columns: repeat(2, 1fr); }
}
.qf-check {
    display: flex;
    align-items: center;
    gap: .5rem;
    cursor: pointer;
    padding: .25rem 0;
    font-size: .875rem;
    color: var(--text);
}
.qf-check input { width: 16px; height: 16px; accent-color: var(--red); cursor: pointer; }

/* ─── QUANTITY GRID ──────────────────────────────────── */
.qf-qty-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: .75rem;
}
@media (max-width: 1024px) { .qf-qty-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 600px)  { .qf-qty-grid { grid-template-columns: repeat(2, 1fr); } }
.qf-qty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .375rem;
    padding: .75rem .5rem;
    background: var(--bg-alt);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    transition: all .2s;
}
.qf-qty:hover { border-color: var(--red); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.05); }
.qf-qty:focus-within { border-color: var(--red); box-shadow: 0 0 0 3px rgba(227,6,19,.08); }
.qf-qty-img {
    width: 100%;
    aspect-ratio: 1;
    background: var(--white);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: .25rem;
}
.qf-qty-img img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
}
.qf-qty label {
    font-size: .8125rem;
    font-weight: 600;
    color: var(--text);
    text-align: center;
    margin: 0;
}
.qf-qty input {
    width: 100%;
    padding: .375rem .5rem;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    background: var(--white);
    font: inherit; font-size: .9375rem; font-weight: 600; text-align: center;
    transition: border-color .15s;
}
.qf-qty input:focus { outline: 0; border-color: var(--red); box-shadow: 0 0 0 3px rgba(227,6,19,.1); }

/* ─── LED TV Size Grid ──────────────────────────────── */
.qf-tv-section { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed var(--border); margin-bottom: 0; }
.qf-tv-grid {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: .5rem;
    margin-top: .25rem;
}
@media (max-width: 1024px) { .qf-tv-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 480px)  { .qf-tv-grid { grid-template-columns: repeat(2, 1fr); } }
.qf-tv-size {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .25rem;
    padding: .625rem .25rem;
    background: var(--bg-alt);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    transition: border-color .15s;
}
.qf-tv-size:focus-within { border-color: var(--red); }
.qf-tv-size:has(input:not([value="0"]):not([value=""])) {
    background: var(--red-light);
    border-color: var(--red);
}
.qf-tv-label {
    font-size: .8125rem;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -.02em;
}
.qf-tv-size input {
    width: 100%;
    padding: .25rem;
    border: 0;
    background: transparent;
    font: inherit;
    font-size: .9375rem;
    font-weight: 600;
    text-align: center;
    color: var(--text);
}
.qf-tv-size input:focus { outline: 0; }
.qf-tv-total {
    background: var(--text);
    border-color: var(--text);
}
.qf-tv-total .qf-tv-label,
.qf-tv-total input { color: var(--white); }
.qf-tv-total input { font-weight: 700; }
.qf-tv-hint {
    display: block;
    margin-top: .625rem;
    font-size: .75rem;
    color: var(--text-muted);
    font-style: italic;
}

/* ─── FILE UPLOAD ────────────────────────────────────── */
.qf-upload-wrap { display: flex; flex-direction: column; gap: 1rem; }
.qf-upload-drop {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .75rem;
    padding: 2rem 1.25rem;
    border: 2px dashed var(--border);
    border-radius: var(--radius-xl);
    background: var(--bg-alt);
    text-align: center;
    cursor: pointer;
    transition: all .2s;
}
.qf-upload-drop:hover,
.qf-upload-drop--over {
    border-color: var(--red);
    background: var(--red-light);
}
.qf-upload-icon { color: var(--red); }
.qf-upload-text strong {
    display: block;
    font-size: .9375rem;
    color: var(--text);
    margin-bottom: .25rem;
}
.qf-upload-hint {
    display: block;
    font-size: .8125rem;
    color: var(--text-muted);
    margin-top: .25rem;
}
.qf-upload-formats {
    display: inline-block;
    margin-top: .5rem;
    padding: .25rem .625rem;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 100px;
    font-size: .6875rem;
    font-weight: 600;
    color: var(--text-muted);
    letter-spacing: .03em;
}

.qf-upload-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: .375rem;
}
.qf-upload-item {
    display: flex;
    align-items: center;
    gap: .625rem;
    padding: .5rem .75rem;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    font-size: .8125rem;
}
.qf-upload-fileicon { font-size: 1.125rem; }
.qf-upload-filename { flex: 1; color: var(--text); font-weight: 500; word-break: break-all; }
.qf-upload-filesize { color: var(--text-muted); font-size: .75rem; white-space: nowrap; }

/* ─── KVKK ───────────────────────────────────────────── */
.qf-kvkk {
    align-items: flex-start;
    gap: .625rem;
    line-height: 1.55;
    font-size: .875rem;
}
.qf-kvkk a { color: var(--red); text-decoration: underline; }

/* ─── SUBMIT ─────────────────────────────────────────── */
.qf-submit {
    text-align: center;
    padding: 1.5rem 0 .5rem;
}
.qf-submit .btn {
    padding: .9rem 2.5rem;
    font-size: 1rem;
}
.qf-submit-note {
    display: block;
    margin-top: .75rem;
    color: var(--text-muted);
    font-size: .8125rem;
}
</style>
