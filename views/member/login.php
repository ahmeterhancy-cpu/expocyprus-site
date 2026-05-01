<?php
$pageTitle = 'Üye Girişi | Expo Cyprus';
$bodyClass = 'page-member-auth';
?>

<section class="ma-section">
    <div class="container">
        <div class="ma-box">
            <div class="ma-brand">
                <img src="<?= asset('img/logo/unifex-logo.png') ?>" alt="Expo Cyprus" width="180" height="48">
                <p>Firma Üye Paneli</p>
            </div>

            <h1>Hoş Geldiniz</h1>
            <p class="ma-sub">Siparişlerinizi takip etmek için giriş yapın.</p>

            <?php if (!empty($success)): ?>
            <div class="ma-flash ma-flash-ok">✓ <?= e($success) ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
            <div class="ma-flash ma-flash-err">! <?= e($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/uye/giris" class="ma-form">
                <?= csrf_field() ?>
                <div class="ma-field">
                    <label>E-posta</label>
                    <input type="email" name="email" value="<?= e($old['email'] ?? '') ?>" required autofocus>
                </div>
                <div class="ma-field">
                    <label>Şifre</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="ma-btn ma-btn-primary">Giriş Yap</button>
            </form>

            <p class="ma-foot">
                Hesabınız yok mu? <a href="/uye/kayit"><strong>Hemen kayıt olun</strong></a>
            </p>
            <p class="ma-back"><a href="/">← Anasayfaya Dön</a></p>
        </div>
    </div>
</section>

