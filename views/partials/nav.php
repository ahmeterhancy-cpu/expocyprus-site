<?php $currentLang = lang(); $switchUrl = \App\Core\Lang::switch(); ?>
<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">

            <!-- Logo -->
            <?php $cmsLogo = setting('site_logo'); ?>
            <a href="<?= url() ?>" class="site-logo" aria-label="Expo Cyprus Ana Sayfa">
                <img src="<?= e($cmsLogo ?: asset('img/logo/unifex-logo.png')) ?>"
                     alt="<?= e(setting('site_name', 'Expo Cyprus')) ?> — UNIFEX Fuarcılık"
                     width="160" height="40" loading="eager">
            </a>

            <!-- Desktop Navigation -->
            <nav class="main-nav" aria-label="Ana Navigasyon">
                <ul class="nav-list">
                    <li><a href="<?= url() ?>" class="nav-link"><?= __('nav.home') ?></a></li>

                    <li class="has-dropdown">
                        <button class="nav-link nav-dropdown-trigger" aria-expanded="false" aria-haspopup="true">
                            <?= __('nav.corporate') ?> <span class="chevron" aria-hidden="true">&#8964;</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="<?= url('hakkimizda') ?>"><?= __('nav.about') ?></a></li>
                            <li><a href="<?= url('tarihce') ?>"><?= __('nav.history') ?></a></li>
                            <li><a href="<?= url('ekip') ?>"><?= __('nav.team') ?></a></li>
                            <li><a href="<?= url('misyon-vizyon') ?>"><?= __('nav.mission') ?></a></li>
                            <li><hr style="margin:.25rem 0;border:0;border-top:1px solid var(--border);"></li>
                            <li><a href="<?= url('blog') ?>"><?= __('nav.blog') ?></a></li>
                        </ul>
                    </li>

                    <li class="has-dropdown">
                        <button class="nav-link nav-dropdown-trigger" aria-expanded="false" aria-haspopup="true">
                            <?= __('nav.services') ?> <span class="chevron" aria-hidden="true">&#8964;</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="<?= url('hizmetler/fuar-organizasyonu') ?>"><?= __('nav.service_fair_org') ?></a></li>
                            <li><a href="<?= url('hizmetler/kongre-organizasyonu') ?>"><?= __('nav.service_congress') ?></a></li>
                            <li><a href="<?= url('hizmetler/stand-tasarim-kurulum') ?>"><?= __('nav.service_stand') ?></a></li>
                            <li><a href="<?= url('hizmetler/fuar-katilim-danismanligi') ?>"><?= __('nav.service_consulting') ?></a></li>
                            <li><a href="<?= url('hizmetler/hostes-stand-gorevlisi') ?>"><?= __('nav.service_hostess') ?></a></li>
                            <li><a href="<?= url('hizmetler/pr-tanitim') ?>"><?= __('nav.service_pr') ?></a></li>
                            <li><hr style="margin:.25rem 0;border:0;border-top:1px solid var(--border);"></li>
                            <li><a href="<?= url('oteller') ?>"><?= lang() === 'en' ? 'Hotels' : 'Oteller' ?></a></li>
                            <li><a href="<?= url('malzeme-talebi') ?>"><?= lang() === 'en' ? 'Material Request' : 'Malzeme Talebi' ?></a></li>
                        </ul>
                    </li>

                    <li class="has-dropdown">
                        <button class="nav-link nav-dropdown-trigger" aria-expanded="false" aria-haspopup="true">
                            <?= __('nav.fairs') ?> <span class="chevron" aria-hidden="true">&#8964;</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="<?= url('fuarlarimiz/tuketici-fuari') ?>"><?= __('nav.fair_consumer') ?></a></li>
                            <li><a href="<?= url('fuarlarimiz/av-avcilik-atis-doga-sporlari-fuari') ?>"><?= __('nav.fair_hunting') ?></a></li>
                            <li><a href="<?= url('fuarlarimiz/tarim-hayvancilik-fuari') ?>"><?= __('nav.fair_agriculture') ?></a></li>
                            <li><a href="<?= url('fuarlarimiz/dugun-hazirliklari-fuari') ?>"><?= __('nav.fair_wedding') ?></a></li>
                        </ul>
                    </li>

                    <li><a href="<?= url('stand-katalogu') ?>" class="nav-link"><?= __('nav.catalog') ?></a></li>
                    <li><a href="<?= url('referanslar') ?>" class="nav-link"><?= __('nav.references') ?></a></li>
                    <li><a href="<?= url('iletisim') ?>" class="nav-link"><?= __('nav.contact') ?></a></li>
                </ul>
            </nav>

            <!-- Header Actions -->
            <div class="header-actions">
                <!-- Language Switch -->
                <a href="<?= e($switchUrl) ?>" class="lang-switch" title="<?= $currentLang === 'tr' ? 'Switch to English' : 'Türkçeye Geç' ?>">
                    <?= strtoupper($currentLang === 'tr' ? 'EN' : 'TR') ?>
                </a>

                <!-- Üye Girişi/Panel -->
                <?php if (!empty($_SESSION['member_id'])): ?>
                <a href="<?= url('uye/panel') ?>" class="lang-switch" title="Üye Paneli" style="background:var(--red);color:#fff;padding:.4rem .9rem;border-radius:100px;font-size:.75rem;font-weight:700">
                    <?= lang() === 'en' ? 'MY PANEL' : 'PANELİM' ?>
                </a>
                <?php else: ?>
                <a href="<?= url('uye/giris') ?>" class="lang-switch" title="<?= lang() === 'en' ? 'Member Login' : 'Üye Girişi' ?>">
                    <?= lang() === 'en' ? 'LOGIN' : 'GİRİŞ' ?>
                </a>
                <?php endif; ?>

                <!-- Cart -->
                <?php $cartCount = \App\Core\Cart::count(); ?>
                <a href="<?= url('sepet') ?>" class="header-cart" aria-label="<?= lang() === 'en' ? 'Cart' : 'Sepet' ?>" title="<?= lang() === 'en' ? 'Cart' : 'Sepet' ?>">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
                    <?php if ($cartCount > 0): ?><span class="header-cart-count"><?= $cartCount ?></span><?php endif; ?>
                </a>

                <!-- CTA Button -->
                <?php
                $ctaUrl  = setting('header_cta_url') ?: url('teklif-al');
                $ctaText = lang() === 'en'
                    ? (setting('header_cta_text_en') ?: __('nav.get_quote'))
                    : (setting('header_cta_text_tr') ?: __('nav.get_quote'));
                ?>
                <a href="<?= e($ctaUrl) ?>" class="btn btn-primary btn-sm header-cta">
                    <?= e($ctaText) ?>
                </a>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuBtn" aria-label="Menüyü Aç/Kapat" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay" aria-hidden="true">
    <nav class="mobile-nav">
        <ul>
            <li><a href="<?= url() ?>"><?= __('nav.home') ?></a></li>
            <li><a href="<?= url('hakkimizda') ?>"><?= __('nav.about') ?></a></li>
            <li><a href="<?= url('tarihce') ?>"><?= __('nav.history') ?></a></li>
            <li><a href="<?= url('ekip') ?>"><?= __('nav.team') ?></a></li>
            <li><a href="<?= url('misyon-vizyon') ?>"><?= __('nav.mission') ?></a></li>
            <li><a href="<?= url('blog') ?>"><?= __('nav.blog') ?></a></li>
            <li class="mobile-section-title"><?= __('nav.services') ?></li>
            <li><a href="<?= url('hizmetler/fuar-organizasyonu') ?>"><?= __('nav.service_fair_org') ?></a></li>
            <li><a href="<?= url('hizmetler/kongre-organizasyonu') ?>"><?= __('nav.service_congress') ?></a></li>
            <li><a href="<?= url('hizmetler/stand-tasarim-kurulum') ?>"><?= __('nav.service_stand') ?></a></li>
            <li><a href="<?= url('hizmetler/fuar-katilim-danismanligi') ?>"><?= __('nav.service_consulting') ?></a></li>
            <li><a href="<?= url('hizmetler/hostes-stand-gorevlisi') ?>"><?= __('nav.service_hostess') ?></a></li>
            <li><a href="<?= url('hizmetler/pr-tanitim') ?>"><?= __('nav.service_pr') ?></a></li>
            <li><a href="<?= url('oteller') ?>"><?= lang() === 'en' ? 'Hotels' : 'Oteller' ?></a></li>
            <li><a href="<?= url('malzeme-talebi') ?>"><?= lang() === 'en' ? 'Material Request' : 'Malzeme Talebi' ?></a></li>
            <li class="mobile-section-title"><?= __('nav.fairs') ?></li>
            <li><a href="<?= url('fuarlarimiz/tuketici-fuari') ?>"><?= __('nav.fair_consumer') ?></a></li>
            <li><a href="<?= url('fuarlarimiz/av-avcilik-atis-doga-sporlari-fuari') ?>"><?= __('nav.fair_hunting') ?></a></li>
            <li><a href="<?= url('fuarlarimiz/tarim-hayvancilik-fuari') ?>"><?= __('nav.fair_agriculture') ?></a></li>
            <li><a href="<?= url('fuarlarimiz/dugun-hazirliklari-fuari') ?>"><?= __('nav.fair_wedding') ?></a></li>
            <li class="mobile-section-title"><?= __('nav.other') ?></li>
            <li><a href="<?= url('stand-katalogu') ?>"><?= __('nav.catalog') ?></a></li>
            <li><a href="<?= url('referanslar') ?>"><?= __('nav.references') ?></a></li>
            <li><a href="<?= url('iletisim') ?>"><?= __('nav.contact') ?></a></li>
        </ul>
        <div class="mobile-nav-footer">
            <a href="<?= url('teklif-al') ?>" class="btn btn-primary btn-block"><?= __('nav.get_quote') ?></a>
            <a href="<?= e($switchUrl) ?>" class="btn btn-outline btn-block mt-2"><?= $currentLang === 'tr' ? 'Switch to English' : 'Türkçeye Geç' ?></a>
        </div>
    </nav>
</div>
