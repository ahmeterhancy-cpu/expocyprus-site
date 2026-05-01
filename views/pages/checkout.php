<?php
$pageTitle       = lang() === 'en' ? 'Checkout | Expo Cyprus' : 'Ödeme | Expo Cyprus';
$metaDescription = lang() === 'en' ? 'Complete your stand order with bank transfer or credit card.' : 'Stand siparişinizi havale veya kredi kartı ile tamamlayın.';
$bodyClass = 'page-checkout';

$symbols = ['EUR'=>'€','USD'=>'$','GBP'=>'£','TRY'=>'₺'];
$cur = $currency ?? 'EUR';
$sym = $symbols[$cur] ?? $cur;

$old = $old ?? [];
function _ck($key, $old) { return e($old[$key] ?? ''); }
?>

<section class="page-hero page-hero-dark">
    <div class="page-hero-overlay"></div>
    <div class="container">
        <div class="page-hero-content">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
                <span aria-hidden="true">›</span>
                <a href="<?= url('sepet') ?>"><?= lang() === 'en' ? 'Cart' : 'Sepet' ?></a>
                <span aria-hidden="true">›</span>
                <span><?= lang() === 'en' ? 'Checkout' : 'Ödeme' ?></span>
            </nav>
            <h1 class="page-hero-title"><?= lang() === 'en' ? 'Checkout' : 'Ödeme' ?></h1>
            <p class="page-hero-subtitle">
                <?= lang() === 'en' ? 'Complete your order in a few easy steps.' : 'Siparişinizi birkaç adımda tamamlayın.' ?>
            </p>
        </div>
    </div>
</section>

<?php if (!empty($error)): ?>
<div class="container"><div class="flash flash-error" role="alert"><?= e($error) ?></div></div>
<?php endif; ?>

<section class="section">
    <div class="container">
        <form action="<?= url('odeme/tamamla') ?>" method="POST" class="checkout-grid" novalidate>
            <?= csrf_field() ?>

            <!-- LEFT: FORM -->
            <div class="checkout-main">

                <!-- 1. CUSTOMER INFO -->
                <div class="checkout-section">
                    <h2 class="checkout-section-title">
                        <span class="checkout-step">1</span>
                        <?= lang() === 'en' ? 'Customer Information' : 'Müşteri Bilgileri' ?>
                    </h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="customer_name"><?= lang() === 'en' ? 'Full Name' : 'Ad Soyad' ?> <span class="required">*</span></label>
                            <input type="text" id="customer_name" name="customer_name" class="form-input" value="<?= _ck('customer_name', $old) ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="customer_email"><?= lang() === 'en' ? 'Email' : 'E-posta' ?> <span class="required">*</span></label>
                            <input type="email" id="customer_email" name="customer_email" class="form-input" value="<?= _ck('customer_email', $old) ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="customer_phone"><?= lang() === 'en' ? 'Phone' : 'Telefon' ?> <span class="required">*</span></label>
                            <input type="tel" id="customer_phone" name="customer_phone" class="form-input" value="<?= _ck('customer_phone', $old) ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="customer_company"><?= lang() === 'en' ? 'Company' : 'Firma' ?></label>
                            <input type="text" id="customer_company" name="customer_company" class="form-input" value="<?= _ck('customer_company', $old) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="customer_address"><?= lang() === 'en' ? 'Address' : 'Adres' ?></label>
                        <textarea id="customer_address" name="customer_address" class="form-input" rows="2"><?= _ck('customer_address', $old) ?></textarea>
                    </div>
                </div>

                <!-- 2. FAIR INFO -->
                <div class="checkout-section">
                    <h2 class="checkout-section-title">
                        <span class="checkout-step">2</span>
                        <?= lang() === 'en' ? 'Fair Details' : 'Etkinlik Bilgileri' ?>
                    </h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="fair_name"><?= lang() === 'en' ? 'Fair Name' : 'Fuar Adı' ?></label>
                            <input type="text" id="fair_name" name="fair_name" class="form-input" value="<?= _ck('fair_name', $old) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="fair_date"><?= lang() === 'en' ? 'Fair Date' : 'Fuar Tarihi' ?></label>
                            <input type="date" id="fair_date" name="fair_date" class="form-input" value="<?= _ck('fair_date', $old) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="fair_location"><?= lang() === 'en' ? 'Fair Location' : 'Fuar Yeri' ?></label>
                        <input type="text" id="fair_location" name="fair_location" class="form-input" value="<?= _ck('fair_location', $old) ?>">
                    </div>
                </div>

                <!-- 3. PAYMENT METHOD -->
                <div class="checkout-section">
                    <h2 class="checkout-section-title">
                        <span class="checkout-step">3</span>
                        <?= lang() === 'en' ? 'Payment Method' : 'Ödeme Yöntemi' ?>
                    </h2>
                    <?php $payOld = $old['payment_method'] ?? 'bank_transfer'; ?>

                    <label class="pay-option">
                        <input type="radio" name="payment_method" value="bank_transfer" <?= $payOld === 'bank_transfer' ? 'checked' : '' ?>>
                        <div class="pay-option-body">
                            <div class="pay-option-head">
                                <strong><?= lang() === 'en' ? 'Bank Transfer / EFT' : 'Havale / EFT' ?></strong>
                                <span class="pay-badge"><?= lang() === 'en' ? 'Recommended' : 'Önerilen' ?></span>
                            </div>
                            <p><?= lang() === 'en' ? 'Pay via bank transfer. We\'ll confirm and start production.' : 'Banka havalesi ile ödeyin. Onayladıktan sonra üretim başlar.' ?></p>
                            <div class="pay-bank-info">
                                <div><strong>Banka:</strong> Türkiye İş Bankası</div>
                                <div><strong>Alıcı:</strong> Unifex Fuarcılık Organizasyon Ltd.</div>
                                <div><strong>IBAN:</strong> TR00 0000 0000 0000 0000 0000 00</div>
                                <div><strong>SWIFT:</strong> ISBKTRIS</div>
                            </div>
                        </div>
                    </label>

                    <label class="pay-option">
                        <input type="radio" name="payment_method" value="credit_card" <?= $payOld === 'credit_card' ? 'checked' : '' ?>>
                        <div class="pay-option-body">
                            <div class="pay-option-head">
                                <strong><?= lang() === 'en' ? 'Credit Card' : 'Kredi Kartı' ?></strong>
                                <span class="pay-badge pay-badge-demo">DEMO</span>
                            </div>
                            <p><?= lang() === 'en' ? 'Sandbox / Demo — no real charges.' : 'Sandbox / Demo — gerçek tahsilat yapılmaz.' ?></p>
                            <div class="pay-card-fields">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Kart No</label>
                                        <input type="text" class="form-input" placeholder="0000 0000 0000 0000" disabled>
                                    </div>
                                    <div class="form-group" style="max-width:120px;">
                                        <label class="form-label">SKT</label>
                                        <input type="text" class="form-input" placeholder="MM/YY" disabled>
                                    </div>
                                    <div class="form-group" style="max-width:90px;">
                                        <label class="form-label">CVV</label>
                                        <input type="text" class="form-input" placeholder="123" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- 4. NOTES -->
                <div class="checkout-section">
                    <h2 class="checkout-section-title">
                        <span class="checkout-step">4</span>
                        <?= lang() === 'en' ? 'Notes (optional)' : 'Notlar (opsiyonel)' ?>
                    </h2>
                    <div class="form-group">
                        <textarea name="notes" class="form-input" rows="3" placeholder="<?= lang() === 'en' ? 'Any special requests...' : 'Özel istekleriniz...' ?>"><?= _ck('notes', $old) ?></textarea>
                    </div>
                </div>

                <!-- 5. KVKK -->
                <div class="checkout-section">
                    <label class="kvkk-check">
                        <input type="checkbox" name="kvkk" value="1" required>
                        <span>
                            <?= lang() === 'en'
                                ? 'I have read and accept the <a href="' . url('kvkk') . '" target="_blank">KVKK</a> and <a href="' . url('gizlilik-politikasi') . '" target="_blank">Privacy Policy</a>.'
                                : '<a href="' . url('kvkk') . '" target="_blank">KVKK</a> ve <a href="' . url('gizlilik-politikasi') . '" target="_blank">Gizlilik Politikası</a>nı okudum, onaylıyorum.' ?>
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    <?= lang() === 'en' ? 'Confirm Order' : 'Siparişi Onayla' ?> →
                </button>
            </div>

            <!-- RIGHT: SUMMARY -->
            <aside class="checkout-summary">
                <div class="checkout-summary-inner">
                    <div class="checkout-summary-head">
                        <h3><?= lang() === 'en' ? 'Order Summary' : 'Sipariş Özeti' ?></h3>
                        <a href="<?= url('sepet') ?>" class="checkout-summary-edit"><?= lang() === 'en' ? 'Edit' : 'Düzenle' ?></a>
                    </div>

                    <ul class="checkout-summary-list">
                        <?php foreach ($items as $modelNo => $it):
                            $name = lang() === 'en' ? ($it['name_en'] ?? $modelNo) : ($it['name_tr'] ?? $modelNo);
                            $rowSub = (float)$it['price'] * (int)$it['qty'];
                        ?>
                        <li>
                            <?php if (!empty($it['image'])): ?>
                                <img src="<?= e($it['image']) ?>" alt="<?= e($name) ?>" loading="lazy">
                            <?php else: ?>
                                <div class="checkout-summary-thumb"><?= e($modelNo) ?></div>
                            <?php endif; ?>
                            <div class="checkout-summary-meta">
                                <strong><?= e($name) ?></strong>
                                <span><?= e($modelNo) ?> · ×<?= (int)$it['qty'] ?></span>
                            </div>
                            <div class="checkout-summary-price"><?= $sym ?> <?= number_format($rowSub, 0, ',', '.') ?></div>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="checkout-summary-totals">
                        <div class="checkout-summary-row">
                            <span><?= lang() === 'en' ? 'Subtotal' : 'Ara Toplam' ?></span>
                            <strong><?= $sym ?> <?= number_format((float)$subtotal, 2, ',', '.') ?></strong>
                        </div>
                        <div class="checkout-summary-row">
                            <span><?= lang() === 'en' ? 'VAT (0%)' : 'KDV (%0)' ?></span>
                            <strong>—</strong>
                        </div>
                        <div class="checkout-summary-row checkout-summary-grand">
                            <span><?= lang() === 'en' ? 'Total' : 'Toplam' ?></span>
                            <strong><?= $sym ?> <?= number_format((float)$subtotal, 2, ',', '.') ?></strong>
                        </div>
                    </div>
                </div>
            </aside>
        </form>
    </div>
</section>

<style>
.checkout-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 2rem; align-items: flex-start; }
@media (max-width: 900px) { .checkout-grid { grid-template-columns: 1fr; } }

.checkout-main { display: flex; flex-direction: column; gap: 1.25rem; }
.checkout-section { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 1.5rem; }
.checkout-section-title { display: flex; align-items: center; gap: .65rem; font-size: 1.125rem; font-weight: 700; margin: 0 0 1.25rem; color: var(--text); }
.checkout-step { width: 28px; height: 28px; border-radius: 50%; background: var(--red); color: var(--white); font-size: .8rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-row .form-group { margin: 0; }
@media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
.form-group { margin-bottom: 1rem; }
.form-label { display: block; font-size: .8125rem; font-weight: 600; color: var(--text); margin-bottom: .35rem; }
.form-label .required { color: var(--red); }
.form-input { width: 100%; padding: .625rem .75rem; border: 1px solid var(--border); border-radius: var(--radius-md); background: var(--white); color: var(--text); font-size: .9375rem; transition: border-color .2s; }
.form-input:focus { outline: 0; border-color: var(--red); }

.pay-option { display: flex; gap: .85rem; align-items: flex-start; padding: 1rem; border: 1px solid var(--border); border-radius: var(--radius-lg); cursor: pointer; transition: all .2s; margin-bottom: .75rem; }
.pay-option:hover { border-color: var(--red); }
.pay-option:has(input:checked) { border-color: var(--red); background: var(--red-light); }
.pay-option input[type=radio] { margin-top: .25rem; flex-shrink: 0; }
.pay-option-body { flex: 1; }
.pay-option-head { display: flex; gap: .75rem; align-items: center; margin-bottom: .25rem; }
.pay-option-head strong { font-size: 1rem; color: var(--text); }
.pay-badge { font-size: .65rem; font-weight: 700; padding: .15rem .5rem; background: #16a34a; color: #fff; border-radius: 100px; letter-spacing: .04em; }
.pay-badge-demo { background: #f97316; }
.pay-option-body p { font-size: .8125rem; color: var(--text-muted); margin: 0 0 .75rem; }
.pay-bank-info { padding: .75rem; background: var(--bg-alt); border-radius: var(--radius-md); font-size: .8125rem; line-height: 1.7; color: var(--text); }
.pay-bank-info strong { color: var(--text-muted); display: inline-block; min-width: 60px; font-weight: 600; }
.pay-card-fields { padding: .5rem 0 0; }

.kvkk-check { display: flex; gap: .65rem; align-items: flex-start; font-size: .875rem; color: var(--text); }
.kvkk-check input { margin-top: .25rem; flex-shrink: 0; }
.kvkk-check a { color: var(--red); text-decoration: underline; }

.btn-block { width: 100%; }

.checkout-summary { position: sticky; top: 100px; }
.checkout-summary-inner { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 1.5rem; }
.checkout-summary-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border); }
.checkout-summary-head h3 { font-size: 1.0625rem; font-weight: 700; margin: 0; color: var(--text); }
.checkout-summary-edit { font-size: .8125rem; color: var(--red); text-decoration: none; font-weight: 600; }
.checkout-summary-edit:hover { text-decoration: underline; }
.checkout-summary-list { list-style: none; padding: 0; margin: 0 0 1rem; display: flex; flex-direction: column; gap: .75rem; }
.checkout-summary-list li { display: flex; gap: .65rem; align-items: center; padding-bottom: .75rem; border-bottom: 1px dashed var(--border); }
.checkout-summary-list li:last-child { border-bottom: 0; }
.checkout-summary-list img, .checkout-summary-thumb { width: 50px; height: 40px; object-fit: cover; border-radius: var(--radius-md); flex-shrink: 0; }
.checkout-summary-thumb { background: var(--gray-100); display: flex; align-items: center; justify-content: center; font-size: .65rem; font-weight: 700; color: var(--text-muted); }
.checkout-summary-meta { flex: 1; min-width: 0; }
.checkout-summary-meta strong { display: block; font-size: .8125rem; color: var(--text); font-weight: 600; line-height: 1.3; }
.checkout-summary-meta span { font-size: .7rem; color: var(--text-muted); }
.checkout-summary-price { font-size: .8125rem; font-weight: 700; color: var(--text); white-space: nowrap; }
.checkout-summary-totals { padding-top: 1rem; border-top: 1px solid var(--border); }
.checkout-summary-row { display: flex; justify-content: space-between; padding: .35rem 0; font-size: .875rem; color: var(--text); }
.checkout-summary-grand { margin-top: .5rem; padding-top: .85rem; border-top: 2px solid var(--border); font-size: 1.0625rem; }
.checkout-summary-grand strong { color: var(--red); font-size: 1.25rem; }
</style>
