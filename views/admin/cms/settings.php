<?php
$pageTitle = 'Site Ayarları';
$pretitle  = 'CMS — Genel Yapılandırma';
$headerActions = '<a href="/admin/cms" class="btn btn-outline-secondary">← Sayfalar</a>';
$s = $settings ?? [];
?>

<form action="/admin/cms/settings" method="POST" enctype="multipart/form-data">

    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#st-general" type="button">🏢 Genel</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#st-header" type="button">📌 Header</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#st-footer" type="button">⬇️ Footer</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#st-social" type="button">📱 Sosyal Medya</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#st-seo" type="button">🔍 SEO & Analytics</button></li>
    </ul>

    <div class="tab-content">

        <!-- GENERAL -->
        <div class="tab-pane fade show active" id="st-general">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Firma & İletişim</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Site Adı</label>
                            <input type="text" name="site_name" class="form-control" value="<?= e($s['site_name'] ?? 'Expo Cyprus') ?>"></div>
                        <div class="col-md-6"><label class="form-label">Site Slogan (TR)</label>
                            <input type="text" name="site_tagline_tr" class="form-control" value="<?= e($s['site_tagline_tr'] ?? '') ?>" placeholder="22 yıllık deneyim, tek çatı altında"></div>
                        <div class="col-md-12"><label class="form-label">Site Slogan (EN)</label>
                            <input type="text" name="site_tagline_en" class="form-control" value="<?= e($s['site_tagline_en'] ?? '') ?>"></div>

                        <div class="col-md-6"><label class="form-label">Logo</label>
                            <?php if (!empty($s['site_logo'])): ?>
                            <div class="mb-2"><img src="<?= e($s['site_logo']) ?>" style="max-height:60px;background:#1d1d1f;padding:8px;border-radius:6px"></div>
                            <?php endif; ?>
                            <input type="file" name="site_logo_file" class="form-control" accept=".png,.svg,.jpg,.webp"></div>
                        <div class="col-md-6"><label class="form-label">Favicon</label>
                            <?php if (!empty($s['site_favicon'])): ?>
                            <div class="mb-2"><img src="<?= e($s['site_favicon']) ?>" style="width:32px;height:32px"></div>
                            <?php endif; ?>
                            <input type="file" name="site_favicon_file" class="form-control" accept=".ico,.png,.svg"></div>

                        <div class="col-md-12"><hr></div>

                        <div class="col-md-12"><label class="form-label">Adres</label>
                            <textarea name="company_address" class="form-control" rows="2"><?= e($s['company_address'] ?? '') ?></textarea></div>
                        <div class="col-md-4"><label class="form-label">Telefon 1</label>
                            <input type="text" name="company_phone" class="form-control" value="<?= e($s['company_phone'] ?? '') ?>"></div>
                        <div class="col-md-4"><label class="form-label">Telefon 2</label>
                            <input type="text" name="company_phone2" class="form-control" value="<?= e($s['company_phone2'] ?? '') ?>"></div>
                        <div class="col-md-4"><label class="form-label">E-posta</label>
                            <input type="email" name="company_email" class="form-control" value="<?= e($s['company_email'] ?? '') ?>"></div>
                        <div class="col-md-12"><label class="form-label">Çalışma Saatleri</label>
                            <input type="text" name="company_hours" class="form-control" value="<?= e($s['company_hours'] ?? '') ?>" placeholder="Pzt-Cum 09:00-18:00"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HEADER -->
        <div class="tab-pane fade" id="st-header">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Header / Üst Menü</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">CTA Buton Metni (TR)</label>
                            <input type="text" name="header_cta_text_tr" class="form-control" value="<?= e($s['header_cta_text_tr'] ?? 'Stand Teklifi Al') ?>"></div>
                        <div class="col-md-4"><label class="form-label">CTA Buton Metni (EN)</label>
                            <input type="text" name="header_cta_text_en" class="form-control" value="<?= e($s['header_cta_text_en'] ?? 'Get Stand Quote') ?>"></div>
                        <div class="col-md-4"><label class="form-label">CTA Buton URL</label>
                            <input type="text" name="header_cta_url" class="form-control" value="<?= e($s['header_cta_url'] ?? '/teklif-al') ?>"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="tab-pane fade" id="st-footer">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Footer</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Footer Hakkımızda (TR)</label>
                            <textarea name="footer_about_tr" class="form-control" rows="4"><?= e($s['footer_about_tr'] ?? '') ?></textarea></div>
                        <div class="col-md-6"><label class="form-label">Footer Hakkımızda (EN)</label>
                            <textarea name="footer_about_en" class="form-control" rows="4"><?= e($s['footer_about_en'] ?? '') ?></textarea></div>
                        <div class="col-md-12"><label class="form-label">Telif (Copyright)</label>
                            <input type="text" name="footer_copyright" class="form-control" value="<?= e($s['footer_copyright'] ?? '© ' . date('Y') . ' Expo Cyprus — UNIFEX Fuarcılık. Tüm hakları saklıdır.') ?>"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SOCIAL -->
        <div class="tab-pane fade" id="st-social">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Sosyal Medya Linkleri</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">📷 Instagram</label>
                            <input type="url" name="social_instagram" class="form-control" value="<?= e($s['social_instagram'] ?? '') ?>" placeholder="https://instagram.com/..."></div>
                        <div class="col-md-6"><label class="form-label">📘 Facebook</label>
                            <input type="url" name="social_facebook" class="form-control" value="<?= e($s['social_facebook'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">💼 LinkedIn</label>
                            <input type="url" name="social_linkedin" class="form-control" value="<?= e($s['social_linkedin'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">𝕏 Twitter / X</label>
                            <input type="url" name="social_twitter" class="form-control" value="<?= e($s['social_twitter'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">▶️ YouTube</label>
                            <input type="url" name="social_youtube" class="form-control" value="<?= e($s['social_youtube'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">💚 WhatsApp</label>
                            <input type="text" name="social_whatsapp" class="form-control" value="<?= e($s['social_whatsapp'] ?? '') ?>" placeholder="+90 ... veya wa.me/..."></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO -->
        <div class="tab-pane fade" id="st-seo">
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">SEO Doğrulama Kodları</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-label">Varsayılan Anahtar Kelimeler</label>
                            <textarea name="seo_default_keywords" class="form-control" rows="2" placeholder="virgülle ayır"><?= e($s['seo_default_keywords'] ?? '') ?></textarea></div>
                        <div class="col-md-6"><label class="form-label">Google Search Console Doğrulama</label>
                            <input type="text" name="seo_google_verification" class="form-control" value="<?= e($s['seo_google_verification'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">Bing Webmaster Doğrulama</label>
                            <input type="text" name="seo_bing_verification" class="form-control" value="<?= e($s['seo_bing_verification'] ?? '') ?>"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3 class="card-title">Analytics & Takip</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Google Analytics ID</label>
                            <input type="text" name="seo_ga_id" class="form-control" value="<?= e($s['seo_ga_id'] ?? '') ?>" placeholder="G-XXXXXXXXXX"></div>
                        <div class="col-md-4"><label class="form-label">Google Tag Manager ID</label>
                            <input type="text" name="seo_gtm_id" class="form-control" value="<?= e($s['seo_gtm_id'] ?? '') ?>" placeholder="GTM-XXXXXX"></div>
                        <div class="col-md-4"><label class="form-label">Facebook Pixel ID</label>
                            <input type="text" name="seo_facebook_pixel" class="form-control" value="<?= e($s['seo_facebook_pixel'] ?? '') ?>"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card mt-3"><div class="card-body text-end">
        <button class="btn btn-primary px-5"><i class="ti ti-device-floppy me-1"></i>Tüm Ayarları Kaydet</button>
    </div></div>
</form>
