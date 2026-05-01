<?php
$pageTitle       = lang() === 'en' ? 'Get a Quote | Expo Cyprus' : 'Fiyatsız Talep | Expo Cyprus';
$metaDescription = lang() === 'en' ? 'Request a custom quote without commitment.' : 'Bağlayıcı olmadan özel teklif isteyin.';
$bodyClass = 'page-inquiry';

$old = $old ?? [];
function _iq($key, $old) { return e($old[$key] ?? ''); }

$mn = '';
if (isset($model) && $model) {
    $mn = $model['model_no'] ?? '';
}
?>

<section class="page-hero page-hero-dark">
    <div class="page-hero-overlay"></div>
    <div class="container">
        <div class="page-hero-content">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
                <span aria-hidden="true">›</span>
                <a href="<?= url('stand-katalogu') ?>"><?= lang() === 'en' ? 'Catalog' : 'Katalog' ?></a>
                <span aria-hidden="true">›</span>
                <span><?= lang() === 'en' ? 'Get a Quote' : 'Fiyatsız Talep' ?></span>
            </nav>
            <h1 class="page-hero-title"><?= lang() === 'en' ? 'Get a Quote' : 'Fiyatsız Talep' ?></h1>
            <p class="page-hero-subtitle">
                <?= lang() === 'en'
                    ? 'Tell us your needs — we\'ll prepare a custom quote within 24 hours.'
                    : 'İhtiyaçlarınızı paylaşın — 24 saat içinde özel teklif hazırlayalım.' ?>
            </p>
        </div>
    </div>
</section>

<?php if (!empty($success)): ?>
<div class="container">
    <div class="flash flash-success" role="alert">
        <?= e($success) ?>
        <?php if ($mn): ?>
            <a href="<?= url('stand-katalogu') ?>" style="margin-left:1rem;color:var(--red);font-weight:600;text-decoration:underline;">
                <?= lang() === 'en' ? 'Browse other models →' : 'Başka model incele →' ?>
            </a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php if (!empty($error)): ?>
<div class="container"><div class="flash flash-error" role="alert"><?= e($error) ?></div></div>
<?php endif; ?>

<section class="section">
    <div class="container">
        <div class="inquiry-wrap">

            <?php if (!empty($model)):
                $name = lang() === 'en' ? ($model['name_en'] ?? $model['name_tr']) : ($model['name_tr'] ?? $model['name_en']);
            ?>
            <div class="inquiry-model">
                <div class="inquiry-model-img">
                    <?php if (!empty($model['image_main'])): ?>
                        <img src="<?= e($model['image_main']) ?>" alt="<?= e($name) ?>">
                    <?php else: ?>
                        <div class="inquiry-model-img-placeholder"><?= e($model['model_no']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="inquiry-model-meta">
                    <span class="inquiry-model-no"><?= e($model['model_no']) ?></span>
                    <h2><?= e($name) ?></h2>
                    <?php if (!empty($model['dimensions'])): ?>
                        <p class="inquiry-model-dim">📐 <?= e($model['dimensions']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <form action="<?= url('talep-formu') ?>" method="POST" class="inquiry-form" novalidate>
                <?= csrf_field() ?>
                <?php if ($mn): ?>
                    <input type="hidden" name="model_no" value="<?= e($mn) ?>">
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="customer_name"><?= lang() === 'en' ? 'Full Name' : 'Ad Soyad' ?> <span class="required">*</span></label>
                        <input type="text" id="customer_name" name="customer_name" class="form-input" value="<?= _iq('customer_name', $old) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="company"><?= lang() === 'en' ? 'Company Name' : 'Firma Adı' ?> <span class="required">*</span></label>
                        <input type="text" id="company" name="company" class="form-input" value="<?= _iq('company', $old) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="email"><?= lang() === 'en' ? 'Email' : 'E-posta' ?> <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-input" value="<?= _iq('email', $old) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phone"><?= lang() === 'en' ? 'Phone' : 'Telefon' ?> <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" class="form-input" value="<?= _iq('phone', $old) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="fair_name"><?= lang() === 'en' ? 'Congress / Fair / Event' : 'Kongre / Fuar / Etkinlik' ?></label>
                        <input type="text" id="fair_name" name="fair_name" class="form-input" value="<?= _iq('fair_name', $old) ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="fair_location"><?= lang() === 'en' ? 'Event Venue' : 'Etkinlik Yeri' ?></label>
                        <input type="text" id="fair_location" name="fair_location" class="form-input" value="<?= _iq('fair_location', $old) ?>" placeholder="<?= lang() === 'en' ? 'e.g. Istanbul' : 'Örn: İstanbul' ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="fair_date"><?= lang() === 'en' ? 'Event Date' : 'Etkinlik Tarihi' ?></label>
                        <input type="date" id="fair_date" name="fair_date" class="form-input" value="<?= _iq('fair_date', $old) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="message"><?= lang() === 'en' ? 'Message / Special Requests' : 'Mesaj / Özel İstekler' ?></label>
                    <textarea id="message" name="message" class="form-input" rows="5" placeholder="<?= lang() === 'en' ? 'Describe your booth needs, special features, etc...' : 'Stand ihtiyaçlarınızı, özel istekleri yazın...' ?>"><?= _iq('message', $old) ?></textarea>
                </div>

                <label class="kvkk-check">
                    <input type="checkbox" name="kvkk" value="1" required>
                    <span>
                        <?= lang() === 'en'
                            ? 'I have read and accept the <a href="' . url('kvkk') . '" target="_blank">KVKK</a> and <a href="' . url('gizlilik-politikasi') . '" target="_blank">Privacy Policy</a>.'
                            : '<a href="' . url('kvkk') . '" target="_blank">KVKK</a> ve <a href="' . url('gizlilik-politikasi') . '" target="_blank">Gizlilik Politikası</a>nı okudum, onaylıyorum.' ?>
                    </span>
                </label>

                <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">
                    <?= lang() === 'en' ? 'Send Request' : 'Talebimi Gönder' ?> →
                </button>
            </form>
        </div>
    </div>
</section>

<style>
.inquiry-wrap { max-width: 760px; margin: 0 auto; }
.inquiry-model { display: flex; gap: 1.25rem; align-items: center; padding: 1.25rem; background: var(--bg-alt); border-radius: var(--radius-xl); margin-bottom: 1.5rem; }
.inquiry-model-img { width: 120px; height: 90px; border-radius: var(--radius-md); overflow: hidden; flex-shrink: 0; background: var(--gray-100); }
.inquiry-model-img img { width: 100%; height: 100%; object-fit: cover; }
.inquiry-model-img-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--text-muted); }
.inquiry-model-meta { flex: 1; min-width: 0; }
.inquiry-model-no { display: inline-block; padding: .15rem .5rem; background: var(--red); color: var(--white); font-size: .65rem; font-weight: 800; border-radius: 4px; letter-spacing: .05em; margin-bottom: .35rem; }
.inquiry-model-meta h2 { font-size: 1.125rem; font-weight: 700; margin: 0 0 .25rem; color: var(--text); }
.inquiry-model-dim { font-size: .8125rem; color: var(--text-muted); margin: 0; }

.inquiry-form { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 2rem; }
.inquiry-form .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
@media (max-width: 600px) { .inquiry-form .form-row { grid-template-columns: 1fr; } }
.inquiry-form .form-group { margin-bottom: 1rem; }
.form-label { display: block; font-size: .8125rem; font-weight: 600; color: var(--text); margin-bottom: .35rem; }
.form-label .required { color: var(--red); }
.form-input { width: 100%; padding: .625rem .75rem; border: 1px solid var(--border); border-radius: var(--radius-md); background: var(--white); color: var(--text); font-size: .9375rem; transition: border-color .2s; }
.form-input:focus { outline: 0; border-color: var(--red); }

.kvkk-check { display: flex; gap: .65rem; align-items: flex-start; font-size: .875rem; color: var(--text); margin-top: 1rem; }
.kvkk-check input { margin-top: .25rem; flex-shrink: 0; }
.kvkk-check a { color: var(--red); text-decoration: underline; }

.btn-block { width: 100%; }
.mt-3 { margin-top: 1.5rem; }
</style>
