<?php
$pageTitle = 'Profilim | Expo Cyprus';
$m = $member;
?>

<div class="mp-page-head">
    <h1>Profilim</h1>
    <p>Firma bilgilerinizi ve şifrenizi güncelleyebilirsiniz.</p>
</div>

<?php if (!empty($success)): ?>
<div class="mp-flash mp-flash-ok" style="margin-bottom:1.5rem">✓ <?= e($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
<div class="mp-flash mp-flash-err" style="margin-bottom:1.5rem">! <?= e($error) ?></div>
<?php endif; ?>

<form method="POST" action="/uye/profil" class="mp-form">
    <?= csrf_field() ?>

    <div class="mp-card">
        <h2>Firma Bilgileri</h2>
        <div class="mp-form-grid">
            <div><label>Firma Adı</label>
                <input type="text" name="company_name" value="<?= e($m['company_name']) ?>" required></div>
            <div><label>Yetkili Adı</label>
                <input type="text" name="contact_name" value="<?= e($m['contact_name']) ?>" required></div>
            <div><label>E-posta</label>
                <input type="email" value="<?= e($m['email']) ?>" disabled>
                <small>E-posta değiştirilemez</small></div>
            <div><label>Telefon</label>
                <input type="tel" name="phone" value="<?= e($m['phone'] ?? '') ?>"></div>
            <div><label>Vergi No / Sicil</label>
                <input type="text" name="tax_no" value="<?= e($m['tax_no'] ?? '') ?>"></div>
            <div><label>Web Sitesi</label>
                <input type="url" name="website" value="<?= e($m['website'] ?? '') ?>"></div>
            <div><label>Şehir</label>
                <input type="text" name="city" value="<?= e($m['city'] ?? '') ?>"></div>
            <div><label>Ülke</label>
                <select name="country">
                    <option value="KKTC" <?= ($m['country'] ?? 'KKTC')==='KKTC'?'selected':'' ?>>KKTC</option>
                    <option value="Türkiye" <?= ($m['country'] ?? '')==='Türkiye'?'selected':'' ?>>Türkiye</option>
                    <option value="Diğer" <?= ($m['country'] ?? '')==='Diğer'?'selected':'' ?>>Diğer</option>
                </select></div>
            <div class="mp-col-2"><label>Adres</label>
                <textarea name="address" rows="2"><?= e($m['address'] ?? '') ?></textarea></div>
        </div>
    </div>

    <div class="mp-card">
        <h2>Şifre Değiştir <small>(opsiyonel)</small></h2>
        <div class="mp-form-grid">
            <div><label>Yeni Şifre <small>min 8 karakter</small></label>
                <input type="password" name="new_password" minlength="8"></div>
            <div><label>Yeni Şifre (tekrar)</label>
                <input type="password" name="new_password_confirm" minlength="8"></div>
        </div>
    </div>

    <div class="mp-form-actions">
        <button type="submit" class="mp-btn">Değişiklikleri Kaydet</button>
    </div>
</form>

<style>
.mp-page-head { margin-bottom: 2rem; }
.mp-page-head h1 { font-size: 1.75rem; font-weight: 700; margin: 0 0 .25rem; color: #1d1d1f; }
.mp-page-head p { color: #6e6e73; margin: 0; }
.mp-flash { padding: 1rem 1.25rem; border-radius: 12px; font-size: .9375rem; }
.mp-flash-ok  { background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }
.mp-flash-err { background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; }
.mp-card { background: #fff; border-radius: 16px; padding: 2rem; border: 1px solid #e5e5e7; margin-bottom: 1.5rem; }
.mp-card h2 { font-size: 1.25rem; font-weight: 700; margin: 0 0 1.25rem; color: #1d1d1f; }
.mp-card h2 small { color: #86868b; font-size: .75rem; font-weight: 400; margin-left: .5rem; }
.mp-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.mp-col-2 { grid-column: 1 / -1; }
.mp-form-grid label { display: block; font-size: .8125rem; font-weight: 600; color: #1d1d1f; margin-bottom: .375rem; }
.mp-form-grid label small { color: #86868b; font-weight: 400; }
.mp-form-grid input,
.mp-form-grid select,
.mp-form-grid textarea {
    width: 100%; padding: .75rem 1rem;
    border: 1px solid #d2d2d7; border-radius: 12px;
    font-size: .9375rem; font-family: inherit;
}
.mp-form-grid input[disabled] { background: #f5f5f7; color: #86868b; }
.mp-form-grid small { display: block; font-size: .75rem; color: #86868b; margin-top: .25rem; }
.mp-form-actions { text-align: right; }
.mp-btn { padding: .85rem 2rem; border-radius: 12px; background: #E30613; color: #fff; border: 0; font-weight: 600; cursor: pointer; font-size: 1rem; }
.mp-btn:hover { background: #c00510; }
@media (max-width: 600px) { .mp-form-grid { grid-template-columns: 1fr; } }
</style>
