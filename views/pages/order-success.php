<?php
$pageTitle       = lang() === 'en' ? 'Order Received | Expo Cyprus' : 'Sipariş Alındı | Expo Cyprus';
$metaDescription = lang() === 'en' ? 'Your order has been received.' : 'Siparişiniz alındı.';
$bodyClass = 'page-order-success';

$symbols = ['EUR'=>'€','USD'=>'$','GBP'=>'£','TRY'=>'₺'];
$cur = $order['currency'] ?? 'EUR';
$sym = $symbols[$cur] ?? $cur;
$isBank = ($order['payment_method'] ?? '') === 'bank_transfer';
?>

<section class="section order-success-section">
    <div class="container">
        <div class="order-success-card">
            <div class="order-success-tick">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <h1 class="order-success-title">
                <?= lang() === 'en' ? 'Order Received!' : 'Sipariş Alındı!' ?>
            </h1>
            <p class="order-success-sub">
                <?= lang() === 'en' ? 'Thank you. Your order has been recorded.' : 'Teşekkürler. Siparişiniz başarıyla kaydedildi.' ?>
            </p>

            <div class="order-no-box">
                <small><?= lang() === 'en' ? 'Order Number' : 'Sipariş Numarası' ?></small>
                <strong id="orderNo"><?= e($order['order_no']) ?></strong>
                <button type="button" class="order-no-copy" onclick="navigator.clipboard.writeText(document.getElementById('orderNo').textContent.trim()); this.textContent = '<?= lang() === 'en' ? 'Copied' : 'Kopyalandı' ?>'; setTimeout(()=>{this.textContent='<?= lang() === 'en' ? 'Copy' : 'Kopyala' ?>'},2000);">
                    <?= lang() === 'en' ? 'Copy' : 'Kopyala' ?>
                </button>
            </div>

            <?php if ($isBank): ?>
            <div class="order-info-card">
                <h3><?= lang() === 'en' ? 'Bank Transfer Details' : 'Havale Bilgileri' ?></h3>
                <p class="order-info-note">
                    <?= lang() === 'en'
                        ? 'Please transfer the total amount to the bank account below. Use your order number as the description.'
                        : 'Aşağıdaki banka hesabına toplam tutarı gönderin. Açıklama kısmına sipariş numaranızı yazın.' ?>
                </p>
                <table class="order-info-table">
                    <tr><th><?= lang() === 'en' ? 'Bank' : 'Banka' ?></th><td>Türkiye İş Bankası</td></tr>
                    <tr><th><?= lang() === 'en' ? 'Account Holder' : 'Alıcı' ?></th><td>Unifex Fuarcılık Organizasyon Ltd.</td></tr>
                    <tr><th>IBAN</th><td><code>TR00 0000 0000 0000 0000 0000 00</code></td></tr>
                    <tr><th>SWIFT</th><td>ISBKTRIS</td></tr>
                    <tr><th><?= lang() === 'en' ? 'Amount' : 'Tutar' ?></th><td><strong><?= $sym ?> <?= number_format((float)$order['total'], 2, ',', '.') ?></strong></td></tr>
                    <tr><th><?= lang() === 'en' ? 'Description' : 'Açıklama' ?></th><td><code><?= e($order['order_no']) ?></code></td></tr>
                </table>
                <p class="order-info-cta">
                    <?= lang() === 'en'
                        ? 'After making the transfer, please notify us:'
                        : 'Havale yaptığınızda lütfen bize bildirin:' ?>
                    <a href="mailto:info@expocyprus.com">info@expocyprus.com</a>
                </p>
            </div>
            <?php else: ?>
            <div class="order-info-card order-info-card--demo">
                <h3><?= lang() === 'en' ? 'Payment Pending' : 'Ödeme Bekleniyor' ?></h3>
                <p>
                    <?= lang() === 'en'
                        ? 'This is a demo / sandbox flow — no real charge has been made. We will contact you to complete payment.'
                        : 'Bu demo / sandbox akışıdır — gerçek tahsilat yapılmadı. Ödemeyi tamamlamak için sizinle iletişime geçeceğiz.' ?>
                </p>
            </div>
            <?php endif; ?>

            <div class="order-summary-card">
                <h3><?= lang() === 'en' ? 'Your Order' : 'Sipariş Detayı' ?></h3>
                <ul class="order-items">
                    <?php foreach ($items as $it):
                        $name = lang() === 'en' ? ($it['name_en'] ?? ($it['model_no'] ?? '')) : ($it['name_tr'] ?? ($it['model_no'] ?? ''));
                        $rowSub = (float)($it['price'] ?? 0) * (int)($it['qty'] ?? 0);
                    ?>
                    <li>
                        <div>
                            <strong><?= e($name) ?></strong>
                            <span><?= e($it['model_no'] ?? '') ?> · ×<?= (int)($it['qty'] ?? 0) ?></span>
                        </div>
                        <div class="order-items-price"><?= $sym ?> <?= number_format($rowSub, 0, ',', '.') ?></div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="order-total-row">
                    <span><?= lang() === 'en' ? 'Total' : 'Toplam' ?></span>
                    <strong><?= $sym ?> <?= number_format((float)$order['total'], 2, ',', '.') ?></strong>
                </div>
            </div>

            <div class="order-actions">
                <a href="<?= url('iletisim') ?>" class="btn btn-outline btn-lg">
                    <?= lang() === 'en' ? 'Contact Us' : 'İletişim' ?>
                </a>
                <a href="<?= url() ?>" class="btn btn-primary btn-lg">
                    <?= lang() === 'en' ? 'Back to Home' : 'Anasayfaya Dön' ?>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.order-success-section { padding: var(--space-3xl) 0; }
.order-success-card { max-width: 720px; margin: 0 auto; background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 2.5rem; text-align: center; }
.order-success-tick { width: 96px; height: 96px; margin: 0 auto 1.25rem; background: rgba(34,197,94,.12); color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.order-success-title { font-size: clamp(1.5rem, 4vw, 2rem); font-weight: 800; margin: 0 0 .35rem; color: var(--text); }
.order-success-sub { color: var(--text-muted); margin: 0 0 2rem; }

.order-no-box { display: inline-flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem; background: var(--bg-alt); border: 2px dashed var(--border); border-radius: var(--radius-lg); margin-bottom: 2rem; flex-wrap: wrap; justify-content: center; }
.order-no-box small { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--text-muted); }
.order-no-box strong { font-size: 1.5rem; font-weight: 800; color: var(--red); font-family: monospace; letter-spacing: .04em; }
.order-no-copy { padding: .35rem .75rem; background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-md); font-size: .75rem; font-weight: 600; cursor: pointer; color: var(--text); }
.order-no-copy:hover { border-color: var(--red); color: var(--red); }

.order-info-card { background: var(--bg-alt); border-left: 4px solid var(--red); padding: 1.5rem; border-radius: var(--radius-lg); text-align: left; margin-bottom: 1.5rem; }
.order-info-card--demo { border-left-color: #f97316; }
.order-info-card h3 { font-size: 1.0625rem; font-weight: 700; margin: 0 0 .75rem; color: var(--text); }
.order-info-note { color: var(--text-muted); font-size: .875rem; margin: 0 0 1rem; }
.order-info-table { width: 100%; border-collapse: collapse; }
.order-info-table th { text-align: left; padding: .35rem .75rem .35rem 0; font-size: .8125rem; font-weight: 600; color: var(--text-muted); width: 30%; }
.order-info-table td { padding: .35rem 0; font-size: .9375rem; color: var(--text); }
.order-info-table code { background: var(--white); padding: .15rem .4rem; border-radius: 4px; font-size: .85rem; }
.order-info-cta { margin: 1rem 0 0; font-size: .875rem; color: var(--text); }
.order-info-cta a { color: var(--red); font-weight: 600; }

.order-summary-card { background: var(--bg-alt); padding: 1.5rem; border-radius: var(--radius-lg); text-align: left; margin-bottom: 1.5rem; }
.order-summary-card h3 { font-size: 1rem; font-weight: 700; margin: 0 0 1rem; color: var(--text); }
.order-items { list-style: none; padding: 0; margin: 0 0 1rem; }
.order-items li { display: flex; justify-content: space-between; padding: .65rem 0; border-bottom: 1px dashed var(--border); }
.order-items li:last-child { border-bottom: 0; }
.order-items strong { display: block; font-size: .9375rem; color: var(--text); }
.order-items span { font-size: .75rem; color: var(--text-muted); }
.order-items-price { font-weight: 700; color: var(--text); white-space: nowrap; }
.order-total-row { display: flex; justify-content: space-between; padding-top: 1rem; border-top: 2px solid var(--border); font-size: 1.0625rem; }
.order-total-row strong { color: var(--red); font-size: 1.25rem; }

.order-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 1.5rem; }
@media (max-width: 600px) { .order-actions .btn { width: 100%; } }
</style>
