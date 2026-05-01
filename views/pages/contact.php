<?php
$pageTitle       = lang() === 'en'
    ? 'Contact | Expo Cyprus — Get in Touch'
    : 'İletişim | Expo Cyprus — Bize Ulaşın';
$metaDescription = lang() === 'en'
    ? 'Contact the Expo Cyprus team for fair, congress and stand organisation enquiries. Nicosia-based, quick response guaranteed.'
    : 'Fuar, kongre ve stand organizasyonu sorularınız için Expo Cyprus ekibiyle iletişime geçin. Lefkoşa merkezli, hızlı yanıt garantili.';
$bodyClass = 'page-contact';
$breadcrumb = [
    ['name' => lang() === 'en' ? 'Home' : 'Anasayfa', 'url' => '/'],
    ['name' => lang() === 'en' ? 'Contact' : 'İletişim', 'url' => '/iletisim'],
];
$structured = [
    [
        '@type' => 'ContactPage',
        'name'  => $pageTitle,
        'description' => $metaDescription,
    ],
];
$keywords = lang() === 'en'
    ? ['contact Expo Cyprus', 'fair organisation contact', 'Nicosia exhibition company']
    : ['Expo Cyprus iletişim', 'fuar organizasyonu iletişim', 'Lefkoşa fuar firması'];
?>

<!-- ═══════════════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════════════ -->
<section class="page-hero page-hero-dark">
    <div class="page-hero-overlay"></div>
    <div class="container">
        <div class="page-hero-content">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
                <span aria-hidden="true">›</span>
                <span><?= lang() === 'en' ? 'Contact' : 'İletişim' ?></span>
            </nav>
            <h1 class="page-hero-title">
                <?= lang() === 'en' ? 'Contact Us' : 'İletişim' ?>
            </h1>
            <p class="page-hero-subtitle">
                <?= lang() === 'en'
                    ? 'We respond within 24 hours. Tell us about your project.'
                    : '24 saat içinde yanıt veriyoruz. Projenizi bize anlatın.' ?>
            </p>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     FLASH MESAJLARI
═══════════════════════════════════════════════════════════════ -->
<?php if (!empty($success)): ?>
<div class="flash flash-success" role="alert">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
    </svg>
    <?= e($success) ?>
</div>
<?php endif; ?>
<?php if (!empty($error)): ?>
<div class="flash flash-error" role="alert">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    <?= e($error) ?>
</div>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════════
     İLETİŞİM FORMU + BİLGİLERİ
═══════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="contact-layout">

            <!-- Sol: Form -->
            <div class="contact-form-wrap">
                <h2 class="contact-section-title">
                    <?= lang() === 'en' ? 'Send a Message' : 'Mesaj Gönder' ?>
                </h2>
                <p class="contact-section-text">
                    <?= lang() === 'en'
                        ? 'Fill in the form below and we\'ll get back to you as soon as possible.'
                        : 'Aşağıdaki formu doldurun, en kısa sürede size geri döneceğiz.' ?>
                </p>

                <form action="<?= url('iletisim') ?>" method="POST" class="contact-form" novalidate>
                    <?= csrf_field() ?>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="contact_name">
                                <?= lang() === 'en' ? 'Full Name' : 'Ad Soyad' ?> <span class="required" aria-hidden="true">*</span>
                            </label>
                            <input type="text" id="contact_name" name="name" class="form-control"
                                   placeholder="<?= lang() === 'en' ? 'John Smith' : 'Ad Soyad' ?>" required
                                   autocomplete="name">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact_email">
                                <?= lang() === 'en' ? 'Email Address' : 'E-posta Adresi' ?> <span class="required" aria-hidden="true">*</span>
                            </label>
                            <input type="email" id="contact_email" name="email" class="form-control"
                                   placeholder="ornek@sirket.com" required
                                   autocomplete="email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="contact_phone">
                                <?= lang() === 'en' ? 'Phone' : 'Telefon' ?>
                            </label>
                            <input type="tel" id="contact_phone" name="phone" class="form-control"
                                   placeholder="+90 392 000 00 00"
                                   autocomplete="tel">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact_subject">
                                <?= lang() === 'en' ? 'Subject' : 'Konu' ?>
                            </label>
                            <input type="text" id="contact_subject" name="subject" class="form-control"
                                   placeholder="<?= lang() === 'en' ? 'e.g. Stand design enquiry' : 'Örn. Stand tasarım talebi' ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact_message">
                            <?= lang() === 'en' ? 'Message' : 'Mesaj' ?> <span class="required" aria-hidden="true">*</span>
                        </label>
                        <textarea id="contact_message" name="message" class="form-control form-textarea"
                                  rows="6" required
                                  placeholder="<?= lang() === 'en' ? 'Tell us about your project or enquiry...' : 'Projeniz veya sorunuz hakkında bilgi verin...' ?>"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <?= lang() === 'en' ? 'Send Message' : 'Mesaj Gönder' ?> <span aria-hidden="true">→</span>
                    </button>
                </form>
            </div>

            <!-- Sağ: İletişim Bilgileri -->
            <div class="contact-info-wrap">
                <h2 class="contact-section-title">
                    <?= lang() === 'en' ? 'Contact Information' : 'İletişim Bilgileri' ?>
                </h2>

                <ul class="contact-info-list">
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.6 19.79 19.79 0 0 1 1.61 5 2 2 0 0 1 3.59 3h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.6a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 17z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="contact-info-label"><?= lang() === 'en' ? 'Phone' : 'Telefon' ?></span>
                            <a href="tel:+905001234567" class="contact-info-value">+90 500 123 45 67</a>
                        </div>
                    </li>
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <div>
                            <span class="contact-info-label">E-posta</span>
                            <a href="mailto:info@expocyprus.com" class="contact-info-value">info@expocyprus.com</a>
                        </div>
                    </li>
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                        </div>
                        <div>
                            <span class="contact-info-label"><?= lang() === 'en' ? 'Address' : 'Adres' ?></span>
                            <span class="contact-info-value">
                                <?= lang() === 'en'
                                    ? 'UNIFEX Fuarcılık Organizasyon Ltd.<br>Nicosia, North Cyprus'
                                    : 'UNIFEX Fuarcılık Organizasyon Ltd.<br>Lefkoşa, Kuzey Kıbrıs' ?>
                            </span>
                        </div>
                    </li>
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <div>
                            <span class="contact-info-label"><?= lang() === 'en' ? 'Working Hours' : 'Çalışma Saatleri' ?></span>
                            <span class="contact-info-value">
                                <?= lang() === 'en'
                                    ? 'Mon – Fri: 09:00 – 18:00'
                                    : 'Pzt – Cum: 09:00 – 18:00' ?>
                            </span>
                        </div>
                    </li>
                </ul>

                <!-- Google Maps Placeholder -->
                <div class="map-placeholder" aria-label="<?= lang() === 'en' ? 'Map location' : 'Harita konumu' ?>">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                    <p><?= lang() === 'en' ? 'Map embed goes here' : 'Harita burada görüntülenecek' ?></p>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
.page-hero {
    position: relative;
    min-height: 340px;
    display: flex;
    align-items: center;
    color: var(--white);
    padding: var(--space-4xl) 0 var(--space-3xl);
}
.page-hero-dark { background-color: var(--gray-900); }
.page-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,10,10,.85) 0%, rgba(227,6,19,.3) 100%);
}
.page-hero .container { position: relative; z-index: 1; }
.page-hero-content { max-width: 640px; }
.page-hero-title { font-size: var(--font-size-5xl); font-weight: 800; color: var(--white); margin: .5rem 0; }
.page-hero-subtitle { font-size: var(--font-size-lg); color: rgba(255,255,255,.85); margin-top: .75rem; }
.breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.7); margin-bottom: .5rem; }
.breadcrumb a { color: rgba(255,255,255,.7); }
.breadcrumb a:hover { color: var(--white); }
.flash {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: var(--space-md) var(--space-lg);
    font-size: var(--font-size-sm);
    font-weight: 500;
}
.flash-success { background: #ECFDF5; color: #065F46; border-bottom: 2px solid #10B981; }
.flash-error   { background: #FEF2F2; color: #991B1B; border-bottom: 2px solid #EF4444; }
.contact-layout { display: grid; grid-template-columns: 1fr 420px; gap: var(--space-3xl); align-items: start; }
.contact-section-title { font-size: var(--font-size-2xl); margin-bottom: .5rem; }
.contact-section-text { color: var(--text-muted); font-size: var(--font-size-sm); margin-bottom: var(--space-xl); line-height: 1.6; }
.contact-form { display: flex; flex-direction: column; gap: var(--space-lg); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-lg); }
.form-group { display: flex; flex-direction: column; gap: .375rem; }
.form-label { font-size: var(--font-size-sm); font-weight: 600; color: var(--gray-700); }
.required { color: var(--red); }
.form-control { padding: .75rem 1rem; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: var(--font-size-sm); font-family: var(--font); background: var(--white); color: var(--text); transition: border-color var(--transition), box-shadow var(--transition); outline: none; }
.form-control:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(227,6,19,.08); }
.form-textarea { resize: vertical; line-height: 1.6; }
.contact-info-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: var(--space-lg); margin-bottom: var(--space-xl); }
.contact-info-item { display: flex; align-items: flex-start; gap: var(--space-md); }
.contact-info-icon { width: 44px; height: 44px; border-radius: var(--radius-md); background: var(--red-light); color: var(--red); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.contact-info-label { display: block; font-size: var(--font-size-xs); font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--text-muted); margin-bottom: .125rem; }
.contact-info-value { font-size: var(--font-size-sm); color: var(--text); line-height: 1.5; }
a.contact-info-value { color: var(--red); }
a.contact-info-value:hover { color: var(--red-dark); }
.map-placeholder { background: var(--gray-100); border-radius: var(--radius-lg); height: 220px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--gray-400); gap: .5rem; }
.map-placeholder p { font-size: var(--font-size-sm); }
@media (max-width: 960px) {
    .contact-layout { grid-template-columns: 1fr; }
    .page-hero-title { font-size: var(--font-size-4xl); }
}
@media (max-width: 600px) {
    .form-row { grid-template-columns: 1fr; }
}
</style>
