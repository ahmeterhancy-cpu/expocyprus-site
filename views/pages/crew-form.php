<?php
$pageTitle       = 'Unifex Crew Başvuru Formu | Ekibimize Katıl';
$metaDescription = 'Unifex Crew\'e başvur — hostes, MC, süpervizör, model ve daha fazlası. KKTC\'nin önde gelen etkinlik kadrosu ağına katıl.';
$bodyClass = 'page-crew';

$old = is_array($oldInput ?? null) ? $oldInput : [];
$o = function (string $k, $default = '') use ($old) { return $old[$k] ?? $default; };

// Multi-select positions: support both array (from session old) and CSV (from DB error reload)
$oldPositions = [];
if (isset($old['positions'])) {
    $oldPositions = is_array($old['positions'])
        ? $old['positions']
        : array_filter(array_map('trim', explode(',', (string)$old['positions'])));
}

$positions   = \App\Models\CrewApplication::POSITIONS;
$regions     = \App\Models\CrewApplication::REGIONS;
$marital     = \App\Models\CrewApplication::MARITAL_STATUSES;
$education   = \App\Models\CrewApplication::EDUCATION_LEVELS;
$transport   = \App\Models\CrewApplication::TRANSPORTATION_OPTIONS;
$workTypes   = \App\Models\CrewApplication::WORK_TYPES;
?>

<section class="crew-hero">
    <div class="crew-hero-bg" style="background-image: url('/assets/images/about-team.png');"></div>
    <div class="crew-hero-overlay"></div>
    <div class="crew-hero-content">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="color:rgba(255,255,255,.7);font-size:.85rem;display:flex;gap:.5rem;justify-content:center;margin-bottom:1rem;">
            <a href="<?= url() ?>" style="color:rgba(255,255,255,.7);text-decoration:none;">Anasayfa</a>
            <span>›</span>
            <span>Unifex Crew</span>
        </nav>
        <span class="crew-eyebrow">EKİBİMİZE KATIL</span>
        <h1>Unifex Crew Başvuru Formu</h1>
        <p>Hostes, MC, süpervizör, model, fotoğrafçı ve daha fazlası. Kıbrıs'ın önde gelen etkinlik kadrosu ağına katılmak için <strong>tüm zorunlu alanları</strong> doldur.</p>
    </div>
</section>

<?php if (!empty($success)): ?>
<div class="container"><div class="quote-flash quote-flash--ok"><strong>✓</strong> <?= e($success) ?></div></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
<div class="container"><div class="quote-flash quote-flash--err"><strong>!</strong> <?= e($error) ?></div></div>
<?php endif; ?>

<section class="section quote-section">
    <div class="container">
        <form method="POST" action="<?= url('unifex-crew') ?>" class="quote-form" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- ── 1. KİŞİSEL BİLGİLER ─────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">1</span><span>Kişisel Bilgiler</span></legend>
                <div class="qf-grid">
                    <div class="qf-field"><label>Ad <span class="req">*</span></label>
                        <input type="text" name="first_name" value="<?= e($o('first_name')) ?>" required></div>
                    <div class="qf-field"><label>Soyad <span class="req">*</span></label>
                        <input type="text" name="last_name" value="<?= e($o('last_name')) ?>" required></div>
                    <div class="qf-field"><label>Doğum Tarihi <span class="req">*</span></label>
                        <input type="date" name="birth_date" value="<?= e($o('birth_date')) ?>" required></div>
                    <div class="qf-field"><label>Yaş</label>
                        <input type="number" min="16" max="80" name="age" value="<?= e($o('age')) ?>" placeholder="Otomatik hesaplanır"></div>
                    <div class="qf-field"><label>Cinsiyet <span class="req">*</span></label>
                        <div class="qf-radio-row">
                            <label class="qf-radio"><input type="radio" name="gender" value="kadin" <?= $o('gender')==='kadin'?'checked':'' ?> required><span>Kadın</span></label>
                            <label class="qf-radio"><input type="radio" name="gender" value="erkek" <?= $o('gender')==='erkek'?'checked':'' ?>><span>Erkek</span></label>
                            <label class="qf-radio"><input type="radio" name="gender" value="diger" <?= $o('gender')==='diger'?'checked':'' ?>><span>Diğer</span></label>
                        </div>
                    </div>
                    <div class="qf-field"><label>Medeni Durum <span class="req">*</span></label>
                        <div class="qf-radio-row">
                            <?php foreach ($marital as $k => $label): ?>
                            <label class="qf-radio"><input type="radio" name="marital_status" value="<?= e($k) ?>" <?= $o('marital_status')===$k?'checked':'' ?> required><span><?= e($label) ?></span></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="qf-field"><label>Uyruk</label>
                        <input type="text" name="nationality" value="<?= e($o('nationality')) ?>" placeholder="KKTC, TC, vb."></div>
                    <div class="qf-field"><label>Kimlik No</label>
                        <input type="text" name="id_number" value="<?= e($o('id_number')) ?>"></div>
                </div>
            </fieldset>

            <!-- ── 2. İLETİŞİM ────────────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">2</span><span>İletişim Bilgileri</span></legend>
                <div class="qf-grid">
                    <div class="qf-field"><label>Cep Telefonu <span class="req">*</span></label>
                        <input type="tel" name="phone" value="<?= e($o('phone')) ?>" required placeholder="+90 / +90 5XX ..."></div>
                    <div class="qf-field"><label>E-posta <span class="req">*</span></label>
                        <input type="email" name="email" value="<?= e($o('email')) ?>" required></div>
                    <div class="qf-field"><label>Instagram / Facebook</label>
                        <input type="text" name="instagram" value="<?= e($o('instagram')) ?>" placeholder="@kullaniciadi veya link"></div>
                    <div class="qf-field"><label>Şehir <span class="req">*</span></label>
                        <input type="text" name="city" value="<?= e($o('city')) ?>" required placeholder="Lefkoşa, Girne, ..."></div>
                    <div class="qf-field qf-col-2"><label>Adres <span class="req">*</span></label>
                        <textarea name="address" rows="2" required><?= e($o('address')) ?></textarea></div>
                </div>
            </fieldset>

            <!-- ── 3. FİZİKSEL BİLGİLER ───────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">3</span><span>Fiziksel Bilgiler</span></legend>
                <div class="qf-grid qf-grid-4">
                    <div class="qf-field"><label>Boy (cm)</label>
                        <input type="number" min="100" max="220" name="height_cm" value="<?= e($o('height_cm')) ?>"></div>
                    <div class="qf-field"><label>Kilo (kg)</label>
                        <input type="number" min="30" max="200" name="weight_kg" value="<?= e($o('weight_kg')) ?>"></div>
                    <div class="qf-field"><label>Beden</label>
                        <select name="body_size">
                            <option value="">—</option>
                            <?php foreach (['XS','S','M','L','XL','XXL'] as $s): ?>
                            <option value="<?= $s ?>" <?= $o('body_size')===$s?'selected':'' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select></div>
                    <div class="qf-field"><label>Ayakkabı No</label>
                        <input type="text" name="shoe_size" value="<?= e($o('shoe_size')) ?>"></div>
                    <div class="qf-field"><label>Gömlek Bedeni</label>
                        <input type="text" name="shirt_size" value="<?= e($o('shirt_size')) ?>"></div>
                    <div class="qf-field"><label>Saç Rengi</label>
                        <input type="text" name="hair_color" value="<?= e($o('hair_color')) ?>"></div>
                    <div class="qf-field"><label>Göz Rengi</label>
                        <input type="text" name="eye_color" value="<?= e($o('eye_color')) ?>"></div>
                </div>
            </fieldset>

            <!-- ── 4. EĞİTİM & DİL ────────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">4</span><span>Eğitim & Diller</span></legend>
                <div class="qf-grid">
                    <div class="qf-field"><label>Eğitim / Mezuniyet Durumu <span class="req">*</span></label>
                        <div class="qf-radio-row">
                            <?php foreach ($education as $k => $label): ?>
                            <label class="qf-radio"><input type="radio" name="education" value="<?= e($k) ?>" <?= $o('education')===$k?'checked':'' ?> required><span><?= e($label) ?></span></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="qf-field qf-col-2"><label>Yabancı Dil ve Seviyeleri <span class="req">*</span></label>
                        <textarea name="languages" rows="2" required placeholder="Örn: İngilizce (ileri), Rusça (orta), Almanca (başlangıç)"><?= e($o('languages')) ?></textarea></div>
                </div>
            </fieldset>

            <!-- ── 5. ÇALIŞMA TERCİHLERİ ──────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">5</span><span>Çalışma Tercihleri</span></legend>

                <div class="qf-subsection">
                    <p class="qf-sublabel">Çalışmak İstediğin Pozisyonlar (birden fazla seçilebilir) <span class="req">*</span></p>
                    <div class="qf-checkbox-grid">
                        <?php foreach ($positions as $k => $label): ?>
                        <label class="qf-check">
                            <input type="checkbox" name="positions[]" value="<?= e($k) ?>" <?= in_array($k, $oldPositions, true) ? 'checked' : '' ?>>
                            <span><?= e($label) ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="qf-grid">
                    <div class="qf-field qf-col-2"><label>"Diğer" ise belirt</label>
                        <input type="text" name="position_other" value="<?= e($o('position_other')) ?>"></div>

                    <div class="qf-field"><label>Çalışma Şekli <span class="req">*</span></label>
                        <div class="qf-radio-row">
                            <?php foreach ($workTypes as $k => $label): ?>
                            <label class="qf-radio"><input type="radio" name="work_type" value="<?= e($k) ?>" <?= $o('work_type')===$k?'checked':'' ?> required><span><?= e($label) ?></span></label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="qf-field"><label>Çalışmak İstediğin Bölge <span class="req">*</span></label>
                        <select name="regions" required>
                            <option value="">— Seçin —</option>
                            <?php foreach ($regions as $k => $label): ?>
                            <option value="<?= e($k) ?>" <?= $o('regions')===$k?'selected':'' ?>><?= e($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="qf-tv-hint" style="margin-top:.25rem">KKTC bölgeleri + Türkiye / Yurtdışı</small>
                    </div>

                    <div class="qf-field qf-col-2"><label>Müsaitlik / Ne zaman çalışabilirsin?</label>
                        <input type="text" name="availability" value="<?= e($o('availability')) ?>" placeholder="Hafta sonu, akşamları, full-time..."></div>
                </div>
            </fieldset>

            <!-- ── 6. KISITLAR & ULAŞIM ───────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">6</span><span>Çalışma Koşulları</span></legend>
                <div class="qf-grid">
                    <div class="qf-field"><label>Seyahat Engelin Var mı? <span class="req">*</span></label>
                        <div class="qf-radio-row">
                            <label class="qf-radio"><input type="radio" name="travel_constraint" value="0" <?= (string)$o('travel_constraint','0')==='0'?'checked':'' ?> required><span>Hayır</span></label>
                            <label class="qf-radio"><input type="radio" name="travel_constraint" value="1" <?= (string)$o('travel_constraint')==='1'?'checked':'' ?>><span>Evet</span></label>
                        </div>
                    </div>
                    <div class="qf-field"><label>Gece Etkinliklerinde Çalışır mısın? <span class="req">*</span></label>
                        <div class="qf-radio-row">
                            <label class="qf-radio"><input type="radio" name="night_work" value="1" <?= (string)$o('night_work','1')==='1'?'checked':'' ?> required><span>Evet</span></label>
                            <label class="qf-radio"><input type="radio" name="night_work" value="0" <?= (string)$o('night_work')==='0'?'checked':'' ?>><span>Hayır</span></label>
                        </div>
                    </div>
                    <div class="qf-field qf-col-2"><label>Ulaşım Sorunun Var mı?</label>
                        <div class="qf-radio-row">
                            <?php foreach ($transport as $k => $label): ?>
                            <label class="qf-radio"><input type="radio" name="transportation" value="<?= e($k) ?>" <?= $o('transportation')===$k?'checked':'' ?>><span><?= e($label) ?></span></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- ── 7. DENEYİM ─────────────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">7</span><span>Deneyim</span></legend>
                <div class="qf-grid">
                    <div class="qf-field"><label>Daha önce benzer pozisyonda çalıştın mı? <span class="req">*</span></label>
                        <div class="qf-radio-row">
                            <label class="qf-radio"><input type="radio" name="prior_experience" value="1" <?= (string)$o('prior_experience')==='1'?'checked':'' ?> required><span>Evet</span></label>
                            <label class="qf-radio"><input type="radio" name="prior_experience" value="0" <?= (string)$o('prior_experience','0')==='0'?'checked':'' ?>><span>Hayır</span></label>
                        </div>
                    </div>
                    <div class="qf-field"><label>Deneyim (kaç yıl)</label>
                        <input type="number" min="0" max="50" name="experience_years" value="<?= e($o('experience_years', 0)) ?>"></div>
                    <div class="qf-field qf-col-2"><label>Deneyimin varsa kısaca açıkla</label>
                        <textarea name="experience_text" rows="3" placeholder="Hangi etkinliklerde çalıştın? Hangi markalarla? Süpervizörlük yaptın mı?"><?= e($o('experience_text')) ?></textarea></div>
                </div>
            </fieldset>

            <!-- ── 8. ÜCRET (opsiyonel) ───────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">8</span><span>Ücret Beklentisi (opsiyonel)</span></legend>
                <div class="qf-grid">
                    <div class="qf-field"><label>Günlük Ücret Beklentisi</label>
                        <input type="number" step="0.01" min="0" name="daily_rate" value="<?= e($o('daily_rate')) ?>"></div>
                    <div class="qf-field"><label>Para Birimi</label>
                        <select name="currency">
                            <?php foreach (['EUR'=>'EUR (€)','TRY'=>'TRY (₺)','USD'=>'USD ($)','GBP'=>'GBP (£)'] as $c => $cl): ?>
                            <option value="<?= $c ?>" <?= ($o('currency','EUR')===$c)?'selected':'' ?>><?= $cl ?></option>
                            <?php endforeach; ?>
                        </select></div>
                </div>
            </fieldset>

            <!-- ── 9. FOTOĞRAFLAR & CV ────────────────────── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">9</span><span>Fotoğraflar & CV</span></legend>
                <div class="qf-grid qf-grid-4">
                    <div class="qf-field"><label>Portre Fotoğraf <span class="req">*</span></label>
                        <input type="file" name="photo_portrait" accept="image/jpeg,image/png,image/webp" required></div>
                    <div class="qf-field"><label>Tam Boy Fotoğraf <span class="req">*</span></label>
                        <input type="file" name="photo_full" accept="image/jpeg,image/png,image/webp" required></div>
                    <div class="qf-field"><label>Profil Fotoğraf</label>
                        <input type="file" name="photo_profile" accept="image/jpeg,image/png,image/webp"></div>
                    <div class="qf-field"><label>Ek Fotoğraf</label>
                        <input type="file" name="photo_extra" accept="image/jpeg,image/png,image/webp"></div>
                    <div class="qf-field qf-col-2"><label>CV / Özgeçmiş</label>
                        <input type="file" name="cv" accept=".pdf,.doc,.docx"></div>
                    <div class="qf-field qf-col-2"><label>Fotoğraflarınız web sitesinde / sosyal medyada kullanılabilir mi? <span class="req">*</span></label>
                        <div class="qf-radio-row">
                            <label class="qf-radio"><input type="radio" name="photo_usage_consent" value="1" <?= (string)$o('photo_usage_consent')==='1'?'checked':'' ?> required><span>Evet</span></label>
                            <label class="qf-radio"><input type="radio" name="photo_usage_consent" value="0" <?= (string)$o('photo_usage_consent','0')==='0'?'checked':'' ?>><span>Hayır</span></label>
                        </div>
                    </div>
                </div>
                <small class="qf-tv-hint">JPG / PNG / WEBP, her biri max 8 MB. CV: PDF/DOC/DOCX, max 10 MB.</small>
            </fieldset>

            <!-- ── 10. KENDİNİZİ ANLATIN & İLETMEK İSTEDİKLERİNİZ ── -->
            <fieldset class="qf-group">
                <legend class="qf-legend"><span class="qf-step">10</span><span>Kendinizi Anlatın</span></legend>
                <div class="qf-grid">
                    <div class="qf-field qf-col-2"><label>Kendinizi Kısaca Anlatın</label>
                        <textarea name="self_description" rows="4" placeholder="Karakteriniz, güçlü yanlarınız, hobiler, yetenekler..."><?= e($o('self_description')) ?></textarea></div>
                    <div class="qf-field qf-col-2"><label>İletmek İstedikleriniz / Notlar</label>
                        <textarea name="notes" rows="3" placeholder="Özel notlar, özel isteklerin, sertifikalar, önemli ek bilgi..."><?= e($o('notes')) ?></textarea></div>
                </div>
            </fieldset>

            <!-- ── KVKK ─────────────────────────────────── -->
            <fieldset class="qf-group qf-group--kvkk">
                <label class="qf-check qf-kvkk">
                    <input type="checkbox" name="kvkk_accepted" value="1" required>
                    <span>
                        <a href="<?= url('kvkk') ?>" target="_blank">KVKK Aydınlatma Metni</a> ve
                        <a href="<?= url('gizlilik-politikasi') ?>" target="_blank">Gizlilik Politikası</a>'nı okudum, kabul ediyorum. Kişisel verilerimin başvuru değerlendirmesi ve sonrasında benimle iletişim kurulması amacıyla işlenmesine onay veriyorum. <span class="req">*</span>
                    </span>
                </label>
            </fieldset>

            <div class="qf-submit">
                <button type="submit" class="btn btn-primary btn-lg">Başvuru Formunu Gönder <span aria-hidden="true">→</span></button>
                <small class="qf-submit-note">Bilgileriniz gizli tutulur ve sadece kadro değerlendirmesi için kullanılır.</small>
            </div>
        </form>
    </div>
</section>

<script>
// Auto-calc age from birth_date
(function() {
    const bd = document.querySelector('input[name="birth_date"]');
    const ageInput = document.querySelector('input[name="age"]');
    if (!bd || !ageInput) return;
    const calcAge = () => {
        if (!bd.value) return;
        const birth = new Date(bd.value);
        const now = new Date();
        let age = now.getFullYear() - birth.getFullYear();
        const m = now.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && now.getDate() < birth.getDate())) age--;
        if (age >= 0 && age < 120) ageInput.value = age;
    };
    bd.addEventListener('change', calcAge);
    calcAge();
})();
</script>

<style>
.page-crew .crew-hero {
    position: relative; min-height: 50vh;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; color: #fff; text-align: center;
}
.page-crew .crew-hero-bg {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
    transform: scale(1.05);
    animation: kbCrew 20s ease-in-out infinite alternate;
    z-index: -2;
}
@keyframes kbCrew { 0% { transform: scale(1.05); } 100% { transform: scale(1.18); } }
.page-crew .crew-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(10,10,10,.85) 0%, rgba(227,6,19,.4) 100%);
    z-index: -1;
}
.page-crew .crew-hero-content { max-width: 800px; padding: 4rem 1.5rem; }
.page-crew .crew-eyebrow {
    display: inline-block;
    font-size: .8rem; font-weight: 700; letter-spacing: .18em;
    background: rgba(255,255,255,.1); padding: .35rem 1rem;
    border-radius: 100px; backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.2); margin-bottom: 1rem;
}
.page-crew .crew-hero h1 {
    font-size: clamp(2rem, 5vw, 3.75rem);
    font-weight: 700; letter-spacing: -.03em;
    line-height: 1.05; margin: 0 0 1rem; color: #fff;
}
.page-crew .crew-hero p {
    font-size: 1.0625rem; color: rgba(255,255,255,.85);
    max-width: 640px; margin: 0 auto;
}

.page-crew .quote-section { padding: var(--space-2xl) 0 var(--space-3xl); }
.page-crew .quote-form { max-width: 1080px; margin: 0 auto; }
.page-crew .qf-group {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--radius-xl); padding: 1.75rem 2rem;
    margin-bottom: 1.25rem;
}
.page-crew .qf-group--kvkk { background: var(--bg-alt); }
.page-crew .qf-legend {
    display: flex; align-items: center; gap: .75rem;
    font-size: 1.125rem; font-weight: 700;
    padding: 0 0 1.25rem; margin: 0 0 1.25rem;
    border-bottom: 1px solid var(--border); width: 100%;
}
.page-crew .qf-step {
    display: inline-flex; align-items: center; justify-content: center;
    width: 28px; height: 28px;
    background: var(--red); color: var(--white);
    border-radius: 50%; font-size: .8125rem; font-weight: 700;
}
.page-crew .qf-grid {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem 1.25rem;
}
.page-crew .qf-grid-3 { grid-template-columns: repeat(3, 1fr); }
.page-crew .qf-grid-4 { grid-template-columns: repeat(4, 1fr); }
.page-crew .qf-col-2 { grid-column: span 2; }
.page-crew .qf-field { display: flex; flex-direction: column; gap: .375rem; }
.page-crew .qf-field label { font-size: .8125rem; font-weight: 600; }
.page-crew .qf-field .req { color: var(--red); }
.page-crew .qf-field input,
.page-crew .qf-field select,
.page-crew .qf-field textarea {
    width: 100%; padding: .625rem .875rem;
    border: 1px solid var(--border); border-radius: var(--radius-md);
    background: var(--white); font: inherit; font-size: .9375rem;
}

.page-crew .qf-radio-row { display: flex; flex-wrap: wrap; gap: .5rem; }
.page-crew .qf-radio { cursor: pointer; }
.page-crew .qf-radio input { display: none; }
.page-crew .qf-radio span {
    display: inline-block; padding: .5rem .9rem;
    border: 1px solid var(--border); border-radius: 100px;
    font-size: .8125rem; font-weight: 500;
    background: var(--white); transition: all .15s;
}
.page-crew .qf-radio input:checked + span {
    background: var(--red); border-color: var(--red); color: var(--white);
}
.page-crew .qf-radio:hover span { border-color: var(--red); }

.page-crew .qf-subsection { margin-bottom: 1.5rem; }
.page-crew .qf-sublabel { font-size: .8125rem; font-weight: 600; margin: 0 0 .625rem; }
.page-crew .qf-checkbox-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: .5rem .75rem;
}
@media (max-width: 768px) { .page-crew .qf-checkbox-grid { grid-template-columns: 1fr; } }
.page-crew .qf-check {
    display: flex; align-items: center; gap: .5rem;
    cursor: pointer; padding: .5rem .75rem;
    background: var(--bg-alt); border: 1px solid var(--border);
    border-radius: var(--radius-md);
    font-size: .875rem; transition: all .15s;
}
.page-crew .qf-check:hover { border-color: var(--red); background: var(--white); }
.page-crew .qf-check input { width: 16px; height: 16px; accent-color: var(--red); cursor: pointer; flex-shrink: 0; }
.page-crew .qf-check:has(input:checked) { background: var(--red-light); border-color: var(--red); }

.page-crew .qf-tv-hint { display: block; margin-top: .5rem; color: var(--text-muted); font-size: .75rem; font-style: italic; }
.page-crew .qf-kvkk {
    align-items: flex-start; gap: .625rem;
    line-height: 1.55; font-size: .875rem;
    background: transparent !important; border: 0 !important; padding: 0 !important;
}
.page-crew .qf-kvkk a { color: var(--red); text-decoration: underline; }
.page-crew .qf-kvkk input { width: 16px; height: 16px; accent-color: var(--red); margin-top: .25rem; }
.page-crew .qf-submit { text-align: center; padding: 1.5rem 0 .5rem; }
.page-crew .qf-submit .btn { padding: .9rem 2.5rem; font-size: 1rem; }
.page-crew .qf-submit-note { display: block; margin-top: .75rem; color: var(--text-muted); font-size: .8125rem; }

.page-crew .quote-flash {
    margin-top: 1.25rem; padding: 1rem 1.25rem;
    border-radius: var(--radius-md);
    display: flex; align-items: center; gap: .75rem;
    font-size: .9375rem;
}
.page-crew .quote-flash--ok { background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }
.page-crew .quote-flash--err { background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; }

@media (max-width: 768px) {
    .page-crew .qf-grid,
    .page-crew .qf-grid-3,
    .page-crew .qf-grid-4 { grid-template-columns: 1fr; }
    .page-crew .qf-col-2 { grid-column: auto; }
    .page-crew .qf-group { padding: 1.25rem; }
}
</style>
