<?php
$pageTitle       = lang() === 'en' ? 'My Cart | Expo Cyprus' : 'Sepetim | Expo Cyprus';
$metaDescription = lang() === 'en' ? 'Review your selected stand models and proceed to checkout.' : 'Seçtiğiniz stand modellerini gözden geçirin ve ödemeye geçin.';
$bodyClass = 'page-cart';

$symbols = ['EUR'=>'€','USD'=>'$','GBP'=>'£','TRY'=>'₺'];
$cur = $currency ?? 'EUR';
$sym = $symbols[$cur] ?? $cur;
?>

<section class="page-hero page-hero-dark">
    <div class="page-hero-overlay"></div>
    <div class="container">
        <div class="page-hero-content">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
                <span aria-hidden="true">›</span>
                <span><?= lang() === 'en' ? 'My Cart' : 'Sepetim' ?></span>
            </nav>
            <h1 class="page-hero-title"><?= lang() === 'en' ? 'My Cart' : 'Sepetim' ?></h1>
            <p class="page-hero-subtitle">
                <?= lang() === 'en' ? 'Review your selected stand models before checkout.' : 'Seçtiğiniz modelleri ödemeden önce gözden geçirin.' ?>
            </p>
        </div>
    </div>
</section>

<?php if (!empty($success)): ?>
<div class="container"><div class="flash flash-success" role="alert"><?= e($success) ?></div></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
<div class="container"><div class="flash flash-error" role="alert"><?= e($error) ?></div></div>
<?php endif; ?>

<section class="section">
    <div class="container">
        <?php if (empty($items)): ?>
            <div class="cart-empty">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
                <h2><?= lang() === 'en' ? 'Your cart is empty' : 'Sepetiniz boş' ?></h2>
                <p><?= lang() === 'en' ? 'Browse our catalog to add stand models to your cart.' : 'Katalogdan stand modelleri ekleyebilirsiniz.' ?></p>
                <a href="<?= url('stand-katalogu') ?>" class="btn btn-primary btn-lg">
                    <?= lang() === 'en' ? 'Browse Catalog' : 'Kataloğa Git' ?> →
                </a>
            </div>
        <?php else: ?>

        <form action="<?= url('sepet/guncelle') ?>" method="POST" class="cart-form">
            <?= csrf_field() ?>
            <div class="cart-table-wrap">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th class="cart-th-img"></th>
                            <th><?= lang() === 'en' ? 'Model' : 'Model' ?></th>
                            <th><?= lang() === 'en' ? 'Price' : 'Fiyat' ?></th>
                            <th class="cart-th-qty"><?= lang() === 'en' ? 'Qty' : 'Adet' ?></th>
                            <th class="cart-th-subtotal"><?= lang() === 'en' ? 'Subtotal' : 'Toplam' ?></th>
                            <th class="cart-th-action"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $modelNo => $it):
                            $name = lang() === 'en' ? ($it['name_en'] ?? $modelNo) : ($it['name_tr'] ?? $modelNo);
                            $rowSub = (float)$it['price'] * (int)$it['qty'];
                        ?>
                        <tr>
                            <td class="cart-td-img">
                                <?php if (!empty($it['image'])): ?>
                                    <img src="<?= e($it['image']) ?>" alt="<?= e($name) ?>" loading="lazy">
                                <?php else: ?>
                                    <div class="cart-img-placeholder"><?= e($modelNo) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="cart-model-no"><?= e($modelNo) ?></div>
                                <div class="cart-model-name"><?= e($name) ?></div>
                                <?php if (!empty($it['dimensions'])): ?>
                                    <div class="cart-model-dim"><?= e($it['dimensions']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="cart-price"><?= $sym ?> <?= number_format((float)$it['price'], 0, ',', '.') ?></td>
                            <td class="cart-qty">
                                <input type="number" name="items[<?= e($modelNo) ?>]" value="<?= (int)$it['qty'] ?>" min="0" class="cart-qty-input" aria-label="Adet">
                            </td>
                            <td class="cart-subtotal"><?= $sym ?> <?= number_format($rowSub, 0, ',', '.') ?></td>
                            <td class="cart-action">
                                <button type="submit" name="items[<?= e($modelNo) ?>]" value="0" class="cart-remove" aria-label="<?= lang() === 'en' ? 'Remove' : 'Kaldır' ?>" title="<?= lang() === 'en' ? 'Remove' : 'Kaldır' ?>">×</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="cart-bottom">
                <div class="cart-update-wrap">
                    <button type="submit" class="btn btn-outline btn-sm">
                        <?= lang() === 'en' ? 'Update Cart' : 'Sepeti Güncelle' ?>
                    </button>
                </div>
                <div class="cart-total-box">
                    <div class="cart-total-row">
                        <span><?= lang() === 'en' ? 'Subtotal' : 'Ara Toplam' ?></span>
                        <strong><?= $sym ?> <?= number_format((float)$subtotal, 2, ',', '.') ?></strong>
                    </div>
                    <div class="cart-total-row cart-total-grand">
                        <span><?= lang() === 'en' ? 'Total' : 'Toplam' ?></span>
                        <strong><?= $sym ?> <?= number_format((float)$subtotal, 2, ',', '.') ?></strong>
                    </div>
                </div>
            </div>
        </form>

        <div class="cart-actions">
            <a href="<?= url('stand-katalogu') ?>" class="btn btn-outline">
                ← <?= lang() === 'en' ? 'Continue Shopping' : 'Alışverişe Devam' ?>
            </a>
            <a href="<?= url('odeme') ?>" class="btn btn-primary btn-lg">
                <?= lang() === 'en' ? 'Proceed to Checkout' : 'Ödemeye Geç' ?> →
            </a>
        </div>

        <?php endif; ?>
    </div>
</section>

<style>
.cart-empty { text-align: center; padding: var(--space-3xl) var(--space-xl); background: var(--bg-alt); border-radius: var(--radius-xl); }
.cart-empty svg { color: var(--text-muted); margin-bottom: 1rem; opacity: .5; }
.cart-empty h2 { font-size: 1.5rem; font-weight: 700; margin: 0 0 .5rem; color: var(--text); }
.cart-empty p { color: var(--text-muted); margin-bottom: 1.5rem; }

.cart-form { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-xl); overflow: hidden; }
.cart-table-wrap { overflow-x: auto; }
.cart-table { width: 100%; border-collapse: collapse; }
.cart-table thead th {
    text-align: left;
    padding: 1rem 1.25rem;
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
    background: var(--bg-alt);
}
.cart-table tbody td { padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
.cart-table tbody tr:last-child td { border-bottom: 0; }
.cart-th-qty, .cart-th-subtotal { text-align: right; }
.cart-th-action { width: 40px; }

.cart-td-img { width: 90px; }
.cart-td-img img { width: 80px; height: 60px; object-fit: cover; border-radius: var(--radius-md); }
.cart-img-placeholder {
    width: 80px; height: 60px;
    background: var(--gray-100);
    border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 700; color: var(--text-muted);
}
.cart-model-no { font-size: .7rem; font-weight: 700; color: var(--red); letter-spacing: .05em; }
.cart-model-name { font-weight: 600; color: var(--text); margin: .15rem 0; }
.cart-model-dim { font-size: .75rem; color: var(--text-muted); }
.cart-price { font-weight: 600; color: var(--text); white-space: nowrap; }
.cart-qty { text-align: right; }
.cart-qty-input {
    width: 70px;
    padding: .4rem .5rem;
    text-align: center;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    background: var(--white);
    color: var(--text);
    font-weight: 600;
}
.cart-subtotal { text-align: right; font-weight: 700; color: var(--text); white-space: nowrap; }
.cart-action { text-align: center; }
.cart-remove {
    width: 28px; height: 28px;
    border: 0; background: transparent;
    color: var(--text-muted);
    font-size: 1.5rem;
    cursor: pointer;
    border-radius: 50%;
    line-height: 1;
    transition: all .2s;
}
.cart-remove:hover { background: var(--red-light); color: var(--red); }

.cart-bottom { display: flex; justify-content: space-between; align-items: flex-start; gap: 1.5rem; padding: 1.25rem; flex-wrap: wrap; }
.cart-update-wrap { padding-top: .25rem; }
.cart-total-box { min-width: 280px; margin-left: auto; }
.cart-total-row { display: flex; justify-content: space-between; padding: .5rem 0; color: var(--text); }
.cart-total-grand { border-top: 2px solid var(--border); margin-top: .5rem; padding-top: .85rem; font-size: 1.1rem; }
.cart-total-grand strong { color: var(--red); font-size: 1.25rem; }

.cart-actions { display: flex; justify-content: space-between; gap: 1rem; margin-top: 1.5rem; flex-wrap: wrap; }

@media (max-width: 768px) {
    .cart-table thead { display: none; }
    .cart-table, .cart-table tbody, .cart-table tr, .cart-table td { display: block; width: 100%; }
    .cart-table tr { border-bottom: 1px solid var(--border); padding: .5rem 0; }
    .cart-table tbody td { border-bottom: 0; padding: .35rem 1rem; }
    .cart-th-qty, .cart-th-subtotal { text-align: left; }
    .cart-qty, .cart-subtotal { text-align: left; }
    .cart-bottom { flex-direction: column; }
    .cart-total-box { min-width: 100%; }
}
</style>
