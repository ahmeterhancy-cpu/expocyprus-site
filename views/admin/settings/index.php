<?php $pageTitle = 'Site Ayarları'; $pretitle = 'Sistem'; ?>

<div class="row">
    <div class="col-lg-3 mb-4">
        <!-- Settings Nav -->
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="#site-info" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                    <i class="ti ti-info-circle me-2"></i>Site Bilgileri
                </a>
                <a href="#social" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="ti ti-brand-instagram me-2"></i>Sosyal Medya
                </a>
                <a href="#email-settings" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="ti ti-mail me-2"></i>E-posta (SMTP)
                </a>
                <a href="#integrations" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="ti ti-plug me-2"></i>Entegrasyonlar
                </a>
                <hr class="m-0">
                <a href="/admin/settings/users" class="list-group-item list-group-item-action">
                    <i class="ti ti-users me-2"></i>Kullanıcılar →
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <form action="/admin/settings" method="POST" id="settingsForm">

            <div class="tab-content">

                <!-- Site Info -->
                <div class="tab-pane show active" id="site-info">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Site Bilgileri</h3></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Site Adı</label>
                                    <input type="text" name="site_name" class="form-control" value="<?= e($settings['site_name'] ?? 'Expo Cyprus') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slogan / Tagline</label>
                                    <input type="text" name="site_tagline" class="form-control" value="<?= e($settings['site_tagline'] ?? 'Her Detay. Tek Ekip. 22 Yıl Deneyim.') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">E-posta</label>
                                    <input type="email" name="site_email" class="form-control" value="<?= e($settings['site_email'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Telefon</label>
                                    <input type="text" name="site_phone" class="form-control" value="<?= e($settings['site_phone'] ?? '') ?>">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Adres</label>
                                    <input type="text" name="site_address" class="form-control" value="<?= e($settings['site_address'] ?? 'Lefkoşa, KKTC') ?>">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Footer Telif Metni</label>
                                    <input type="text" name="footer_copyright" class="form-control" value="<?= e($settings['footer_copyright'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="tab-pane" id="social">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Sosyal Medya Linkleri</h3></div>
                        <div class="card-body">
                            <?php $socials = [
                                ['field' => 'social_linkedin',  'icon' => 'brand-linkedin',  'label' => 'LinkedIn'],
                                ['field' => 'social_instagram', 'icon' => 'brand-instagram', 'label' => 'Instagram'],
                                ['field' => 'social_facebook',  'icon' => 'brand-facebook',  'label' => 'Facebook'],
                                ['field' => 'social_youtube',   'icon' => 'brand-youtube',   'label' => 'YouTube'],
                            ]; foreach ($socials as $soc): ?>
                            <div class="mb-3 input-group">
                                <span class="input-group-text"><i class="ti ti-<?= $soc['icon'] ?>"></i></span>
                                <input type="url" name="<?= $soc['field'] ?>" class="form-control"
                                       placeholder="<?= $soc['label'] ?> profil URL"
                                       value="<?= e($settings[$soc['field']] ?? '') ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="tab-pane" id="email-settings">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">E-posta / SMTP Ayarları</h3></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gönderen Ad</label>
                                    <input type="text" name="mail_from_name" class="form-control" value="<?= e($settings['mail_from_name'] ?? 'Expo Cyprus') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gönderen E-posta</label>
                                    <input type="email" name="mail_from" class="form-control" value="<?= e($settings['mail_from'] ?? '') ?>">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">SMTP Sunucu</label>
                                    <input type="text" name="mail_smtp_host" class="form-control" value="<?= e($settings['mail_smtp_host'] ?? '') ?>" placeholder="smtp.gmail.com">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Port</label>
                                    <input type="number" name="mail_smtp_port" class="form-control" value="<?= e($settings['mail_smtp_port'] ?? '587') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">SMTP Kullanıcı Adı</label>
                                    <input type="text" name="mail_smtp_user" class="form-control" value="<?= e($settings['mail_smtp_user'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">SMTP Şifre</label>
                                    <input type="password" name="mail_smtp_pass" class="form-control" placeholder="Değiştirmek için girin">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Integrations -->
                <div class="tab-pane" id="integrations">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Entegrasyonlar</h3></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Google Analytics ID</label>
                                    <input type="text" name="ga_id" class="form-control" value="<?= e($settings['ga_id'] ?? '') ?>" placeholder="G-XXXXXXXXXX">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Facebook Pixel ID</label>
                                    <input type="text" name="fb_pixel" class="form-control" value="<?= e($settings['fb_pixel'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">reCAPTCHA Site Key</label>
                                    <input type="text" name="recaptcha_site" class="form-control" value="<?= e($settings['recaptcha_site'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">reCAPTCHA Secret Key</label>
                                    <input type="text" name="recaptcha_secret" class="form-control" value="<?= e($settings['recaptcha_secret'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Bar -->
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="ti ti-device-floppy me-1"></i>Ayarları Kaydet
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Tab navigation for sidebar links
document.querySelectorAll('.list-group a[href^="#"]').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('.list-group a').forEach(l => l.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('show', 'active'));
        this.classList.add('active');
        const target = document.querySelector(this.getAttribute('href'));
        if (target) { target.classList.add('show', 'active'); }
    });
});
</script>
