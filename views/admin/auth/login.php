<?php $pageTitle = 'Giriş Yap'; ?>
<div class="login-wrap">
    <div class="login-card">

        <!-- Logo -->
        <div class="login-logo">
            <img src="/assets/img/logo/unifex-logo-beyaz.svg" alt="Expo Cyprus" width="180" height="45">
        </div>

        <h1 class="login-title">Yönetim Paneli</h1>
        <p class="login-subtitle">Devam etmek için giriş yapın</p>

        <?php if ($error ?? false): ?>
        <div class="login-alert">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?= e($error) ?>
        </div>
        <?php endif; ?>

        <form class="login-form" action="/admin/login" method="POST" novalidate>

            <div class="login-field">
                <label for="email">E-posta Adresi</label>
                <input type="email" id="email" name="email"
                       value="<?= e($email ?? '') ?>"
                       placeholder="admin@expocyprus.com"
                       autocomplete="username" required autofocus>
            </div>

            <div class="login-field">
                <label for="password">
                    Şifre
                    <a href="#" class="login-forgot" tabindex="-1">Şifremi unuttum?</a>
                </label>
                <div class="password-wrap">
                    <input type="password" id="password" name="password"
                           placeholder="••••••••"
                           autocomplete="current-password" required>
                    <button type="button" class="password-toggle" aria-label="Şifreyi göster/gizle" tabindex="-1">
                        <svg class="eye-icon eye-open" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="eye-icon eye-closed" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="login-btn">
                Giriş Yap
            </button>
        </form>

        <p class="login-footer">
            <a href="/" style="color:#64748b;text-decoration:none;font-size:.8rem;">← Web Sitesine Dön</a>
        </p>
    </div>
</div>

<style>
.login-wrap    { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 2rem; }
.login-card    { background: #1e293b; border: 1px solid rgba(255,255,255,.08); border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 420px; }
.login-logo    { text-align: center; margin-bottom: 1.5rem; }
.login-title   { font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: #f1f5f9; text-align: center; margin: 0 0 .25rem; }
.login-subtitle{ font-size: .875rem; color: #64748b; text-align: center; margin: 0 0 1.75rem; }
.login-alert   { background: rgba(227,6,19,.12); border: 1px solid rgba(227,6,19,.3); color: #fca5a5; border-radius: 8px; padding: .75rem 1rem; font-size: .875rem; display: flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; }
.login-field   { margin-bottom: 1.25rem; }
.login-field label   { display: flex; justify-content: space-between; font-size: .8rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .04em; margin-bottom: .5rem; }
.login-forgot  { color: #E30613; text-decoration: none; font-weight: 400; font-size: .8rem; text-transform: none; letter-spacing: 0; }
.login-field input   { width: 100%; background: #0f172a; border: 1px solid #334155; border-radius: 8px; padding: .75rem 1rem; font-size: .9rem; color: #f1f5f9; font-family: 'Inter', sans-serif; outline: none; transition: border-color .15s; }
.login-field input:focus { border-color: #E30613; box-shadow: 0 0 0 3px rgba(227,6,19,.12); }
.password-wrap { position: relative; }
.password-wrap input { padding-right: 2.75rem; }
.password-toggle { position: absolute; right: .75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748b; padding: .25rem; }
.login-btn     { width: 100%; background: #E30613; color: #fff; border: none; border-radius: 8px; padding: .85rem; font-size: .9rem; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: background .15s; margin-top: .5rem; }
.login-btn:hover{ background: #c0050f; }
.login-footer  { text-align: center; margin: 1.25rem 0 0; }
</style>
<script>
document.querySelector('.password-toggle')?.addEventListener('click', function() {
    const inp = this.previousElementSibling || this.parentElement.querySelector('input');
    const isPass = inp.type === 'password';
    inp.type = isPass ? 'text' : 'password';
    this.querySelector('.eye-open').style.display  = isPass ? 'none' : '';
    this.querySelector('.eye-closed').style.display = isPass ? '' : 'none';
});
</script>
