<?php
$pageTitle = 'Üye Kayıt | Expo Cyprus';
$bodyClass = 'page-member-auth';
$o = $old ?? [];
?>

<section class="ma-section">
    <div class="container">
        <div class="ma-box ma-box-wide">
            <div class="ma-brand">
                <img src="<?= asset('img/logo/unifex-logo.png') ?>" alt="Expo Cyprus" width="180" height="48">
                <p>Firma Üye Kayıt</p>
            </div>
            <h1>Firma Hesabı Oluştur</h1>
            <p class="ma-sub">Siparişlerinizi takip edin, üretim aşamalarını görün, dosyalara erişin.</p>

            <?php if (!empty($error)): ?>
            <div class="ma-flash ma-flash-err">! <?= e($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/uye/kayit" class="ma-form ma-form-2col">
                <?= csrf_field() ?>
                <div class="ma-field"><label>Firma Adı *</label>
                    <input type="text" name="company_name" value="<?= e($o['company_name'] ?? '') ?>" required></div>
                <div class="ma-field"><label>Yetkili Adı *</label>
                    <input type="text" name="contact_name" value="<?= e($o['contact_name'] ?? '') ?>" required></div>
                <div class="ma-field"><label>E-posta *</label>
                    <input type="email" name="email" value="<?= e($o['email'] ?? '') ?>" required></div>
                <div class="ma-field"><label>Telefon</label>
                    <input type="tel" name="phone" value="<?= e($o['phone'] ?? '') ?>" placeholder="+90 ..."></div>
                <div class="ma-field"><label>Vergi No / KKTC Sicil</label>
                    <input type="text" name="tax_no" value="<?= e($o['tax_no'] ?? '') ?>"></div>
                <div class="ma-field"><label>Web Sitesi</label>
                    <input type="url" name="website" value="<?= e($o['website'] ?? '') ?>" placeholder="https://..."></div>
                <div class="ma-field"><label>Şehir</label>
                    <input type="text" name="city" value="<?= e($o['city'] ?? '') ?>"></div>
                <div class="ma-field"><label>Ülke</label>
                    <select name="country">
                        <option value="KKTC" <?= ($o['country'] ?? 'KKTC')==='KKTC'?'selected':'' ?>>KKTC</option>
                        <option value="Türkiye" <?= ($o['country'] ?? '')==='Türkiye'?'selected':'' ?>>Türkiye</option>
                        <option value="Diğer" <?= ($o['country'] ?? '')==='Diğer'?'selected':'' ?>>Diğer</option>
                    </select></div>
                <div class="ma-field ma-col-2"><label>Adres</label>
                    <textarea name="address" rows="2"><?= e($o['address'] ?? '') ?></textarea></div>
                <div class="ma-field"><label>Şifre * <small>(min 8 karakter)</small></label>
                    <input type="password" name="password" required minlength="8"></div>
                <div class="ma-field"><label>Şifre Tekrar *</label>
                    <input type="password" name="password_confirm" required minlength="8"></div>
                <div class="ma-field ma-col-2 ma-kvkk">
                    <label class="ma-check">
                        <input type="checkbox" name="kvkk_accepted" value="1" required>
                        <span><a href="/kvkk" target="_blank">KVKK</a> ve <a href="/gizlilik-politikasi" target="_blank">Gizlilik Politikası</a>'nı okudum, kabul ediyorum. *</span>
                    </label>
                </div>
                <div class="ma-col-2">
                    <button type="submit" class="ma-btn ma-btn-primary" style="width:100%">Hesap Oluştur</button>
                </div>
            </form>

            <p class="ma-foot">
                Zaten hesabınız var mı? <a href="/uye/giris"><strong>Giriş yapın</strong></a>
            </p>
            <p class="ma-back"><a href="/">← Anasayfaya Dön</a></p>
        </div>
    </div>
</section>

