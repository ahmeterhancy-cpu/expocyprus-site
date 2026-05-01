<?php
/**
 * SEO Meta Auto-Fill — 15 sayfanın tamamına yüksek kaliteli SEO doldurur.
 * Run: "C:/laragon/bin/php/php-8.3.30-Win32-vs16-x64/php.exe" database/seed-cms-seo.php
 */
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
foreach (parse_ini_file(__DIR__ . '/../.env') as $k => $v) putenv("$k=$v");
define('BASE_PATH', dirname(__DIR__));

use App\Core\DB;
use App\Models\CmsPage;

DB::connect();
CmsPage::ensureTable();

/**
 * Per sayfa SEO bütünleyici — title (50-60ch), description (150-160ch), keywords.
 */
$seo = [
    'home' => [
        'title_tr' => 'Anasayfa',
        'meta_title_tr' => 'Expo Cyprus — Kıbrıs Fuar, Kongre & Stand Organizasyonu | UNIFEX',
        'meta_title_en' => 'Expo Cyprus — Trade Fair, Congress & Stand Organisation in Cyprus',
        'meta_description_tr' => 'Kıbrıs\'ın 22 yıllık fuar uzmanı. Fuar, kongre, stand tasarım, hostes ve PR hizmetleri tek çatı altında. 100+ stand kurulumu, 4 yıllık fuar.',
        'meta_description_en' => 'Cyprus\'s 22-year fair expert. Fair, congress, stand design, hostess and PR — all under one roof. 100+ stand installations, 4 annual trade fairs.',
        'meta_keywords_tr' => 'fuar organizasyonu Kıbrıs, kongre KKTC, stand tasarım, UNIFEX Fuarcılık, Expo Cyprus, Lefkoşa fuar, etkinlik organizasyonu',
        'meta_keywords_en' => 'fair organisation Cyprus, congress Cyprus, stand design, UNIFEX, Expo Cyprus, Nicosia exhibition, event organisation',
        'hero_eyebrow_tr' => '2004\'TEN BERİ',
        'hero_eyebrow_en' => 'SINCE 2004',
        'hero_title_tr' => 'Kıbrıs\'ın fuar standardı.',
        'hero_title_en' => 'The fair standard of Cyprus.',
        'hero_subtitle_tr' => '22 yıllık tecrübe. 4 sektörel fuar. 100+ stand kurulumu. Tek çatı altında.',
        'hero_subtitle_en' => '22 years of experience. 4 sector fairs. 100+ stand installations. Under one roof.',
    ],
    'about' => [
        'title_tr' => 'Hakkımızda',
        'meta_title_tr' => 'Hakkımızda | Kıbrıs\'ta 22 Yıllık Fuarcılık Tecrübesi | Expo Cyprus',
        'meta_title_en' => 'About Us | 22 Years of Fair Excellence in Cyprus | Expo Cyprus',
        'meta_description_tr' => 'Expo Cyprus, 2004\'te UNIFEX Fuarcılık altında kuruldu. KKTC\'nin lider fuar organizatörü. 4 fuar, 100+ stand, 10+ kongre.',
        'meta_description_en' => 'Expo Cyprus, founded in 2004 under UNIFEX Fuarcılık. North Cyprus\'s leading fair organiser. 4 fairs, 100+ stands, 10+ congresses.',
        'meta_keywords_tr' => 'Expo Cyprus hakkında, UNIFEX Fuarcılık, Kıbrıs fuar şirketi, Lefkoşa kongre',
        'meta_keywords_en' => 'about Expo Cyprus, UNIFEX, Cyprus fair company, Nicosia congress',
        'hero_eyebrow_tr' => 'HAKKIMIZDA',
        'hero_eyebrow_en' => 'ABOUT US',
        'hero_title_tr' => '22 yıl. Kıbrıs fuar sektörü. Bizim eserimiz.',
        'hero_title_en' => '22 years. Cyprus exhibition industry. Built by us.',
    ],
    'history' => [
        'title_tr' => 'Tarihçe',
        'meta_title_tr' => 'Tarihçemiz | Expo Cyprus 2004-2026 Yolculuğu',
        'meta_title_en' => 'Our History | Expo Cyprus 2004-2026 Journey',
        'meta_description_tr' => '2004\'ten bu yana Kıbrıs fuar sektörünün dönüm noktaları. Kuruluştan bugüne 22 yıllık başarı hikayemiz.',
        'meta_description_en' => 'Milestones in Cyprus exhibition industry since 2004. Our 22-year success story from founding to today.',
        'meta_keywords_tr' => 'Expo Cyprus tarihçe, UNIFEX kuruluş, Kıbrıs fuar geçmişi, 2004 fuar',
        'meta_keywords_en' => 'Expo Cyprus history, UNIFEX founding, Cyprus fair timeline, 2004',
    ],
    'team' => [
        'title_tr' => 'Ekibimiz',
        'meta_title_tr' => 'Ekibimiz | Profesyonel Fuar Organizasyon Kadrosu | Expo Cyprus',
        'meta_title_en' => 'Our Team | Professional Fair Organisation Staff | Expo Cyprus',
        'meta_description_tr' => 'Expo Cyprus\'un arkasındaki deneyimli kadro. Fuar yönetimi, stand tasarım, operasyon ve PR uzmanları.',
        'meta_description_en' => 'The experienced team behind Expo Cyprus. Fair management, stand design, operations and PR specialists.',
        'meta_keywords_tr' => 'Expo Cyprus ekip, fuar uzmanı, stand tasarımcı, kongre yöneticisi',
        'meta_keywords_en' => 'Expo Cyprus team, fair expert, stand designer, congress manager',
    ],
    'mission' => [
        'title_tr' => 'Misyon & Vizyon',
        'meta_title_tr' => 'Misyon & Vizyon | Değerlerimiz ve Hedeflerimiz | Expo Cyprus',
        'meta_title_en' => 'Mission & Vision | Our Values and Goals | Expo Cyprus',
        'meta_description_tr' => 'Expo Cyprus\'un misyonu, vizyonu ve değerleri. Kıbrıs\'ı dünya standartlarında fuar merkezine taşıyan ilkelerimiz.',
        'meta_description_en' => 'Expo Cyprus\'s mission, vision and values. Principles that take Cyprus to world-class fair hub.',
        'meta_keywords_tr' => 'Expo Cyprus misyon, vizyon, değerler, fuar standardı',
        'meta_keywords_en' => 'Expo Cyprus mission, vision, values, fair standards',
    ],
    'services' => [
        'title_tr' => 'Hizmetler',
        'meta_title_tr' => 'Hizmetler | Fuar, Kongre, Stand & PR | Expo Cyprus Kıbrıs',
        'meta_title_en' => 'Services | Fair, Congress, Stand & PR in Cyprus | Expo Cyprus',
        'meta_description_tr' => '6 uzman hizmet: fuar organizasyonu, kongre yönetimi, stand tasarım, fuar danışmanlığı, hostes kadrosu, PR. Tek çatı altında.',
        'meta_description_en' => '6 expert services: fair organisation, congress management, stand design, exhibitor consulting, hostess staff, PR. Under one roof.',
        'meta_keywords_tr' => 'fuar organizasyonu, kongre organizasyonu, stand tasarım, fuar danışmanlığı, hostes hizmeti, PR Kıbrıs',
        'meta_keywords_en' => 'fair organisation, congress organisation, stand design, exhibitor consulting, hostess services, PR Cyprus',
        'hero_eyebrow_tr' => 'HİZMETLERİMİZ',
        'hero_eyebrow_en' => 'OUR SERVICES',
        'hero_title_tr' => 'Altı hizmet. Tek sorumluluk.',
        'hero_title_en' => 'Six services. One responsibility.',
    ],
    'fairs' => [
        'title_tr' => 'Fuarlar',
        'meta_title_tr' => 'Kıbrıs\'ta Fuarlar | 4 Sektörel Yıllık Fuar | Expo Cyprus',
        'meta_title_en' => 'Trade Fairs in Cyprus | 4 Annual Sector Fairs | Expo Cyprus',
        'meta_description_tr' => 'Kıbrıs\'ın 4 sektörel fuarı: Tüketici, Av & Doğa Sporları, Tarım Hayvancılık, Düğün. Yıllık 50.000+ ziyaretçi.',
        'meta_description_en' => '4 sector fairs in Cyprus: Consumer, Hunting & Outdoor Sports, Agriculture & Livestock, Wedding. 50,000+ annual visitors.',
        'meta_keywords_tr' => 'Kıbrıs fuarı, KKTC fuar takvimi, tüketici fuarı, av fuarı, tarım fuarı, düğün fuarı',
        'meta_keywords_en' => 'Cyprus fair, North Cyprus fair calendar, consumer fair, hunting fair, agriculture fair, wedding fair',
        'hero_eyebrow_tr' => 'KENDİ FUARLARIMIZ',
        'hero_eyebrow_en' => 'OUR FAIRS',
        'hero_title_tr' => 'Dört Fuar. Bir Öncü. Kıbrıs.',
        'hero_title_en' => 'Four Fairs. One Leader. Cyprus.',
    ],
    'catalog' => [
        'title_tr' => 'Stand Kataloğu',
        'meta_title_tr' => 'Stand Kataloğu | Hazır Tasarım Stand Modelleri | Expo Cyprus',
        'meta_title_en' => 'Stand Catalogue | Ready-to-Order Booth Designs | Expo Cyprus',
        'meta_description_tr' => 'Hazır stand modelleri: 3×2m, 6×2m, 9×2m, 6×4m ada. Üretimden sahaya kuruluma tüm süreç bizden.',
        'meta_description_en' => 'Ready stand models: 3×2m, 6×2m, 9×2m, 6×4m island. From production to on-site setup — all from us.',
        'meta_keywords_tr' => 'stand kataloğu, hazır stand, modüler stand, stand modeli, fuar standı Kıbrıs',
        'meta_keywords_en' => 'stand catalogue, ready stands, modular stand, exhibition booth Cyprus',
    ],
    'references' => [
        'title_tr' => 'Projeler',
        'meta_title_tr' => 'Projeler / Referanslar | 100+ Tamamlanan Proje | Expo Cyprus',
        'meta_title_en' => 'Projects / References | 100+ Completed Projects | Expo Cyprus',
        'meta_description_tr' => 'Expo Cyprus\'a güvenen kurumlar ve markalar. 100+ stand kurulumu, 22 yıl güven.',
        'meta_description_en' => 'Brands and institutions that trusted Expo Cyprus. 100+ stand installations, 22 years of trust.',
        'meta_keywords_tr' => 'Expo Cyprus referansları, projeler, müşteri portföyü',
        'meta_keywords_en' => 'Expo Cyprus references, projects, client portfolio',
    ],
    'contact' => [
        'title_tr' => 'İletişim',
        'meta_title_tr' => 'İletişim | Lefkoşa Fuar Organizasyon Şirketi | Expo Cyprus',
        'meta_title_en' => 'Contact | Nicosia Fair Organisation Company | Expo Cyprus',
        'meta_description_tr' => 'Expo Cyprus ekibiyle iletişime geçin. Fuar, kongre ve stand soruları için 24 saatte dönüş garantisi.',
        'meta_description_en' => 'Contact the Expo Cyprus team. 24-hour response guarantee for fair, congress and stand enquiries.',
        'meta_keywords_tr' => 'Expo Cyprus iletişim, fuar firması telefon, Lefkoşa fuar adresi',
        'meta_keywords_en' => 'Expo Cyprus contact, fair company phone, Nicosia exhibition address',
    ],
    'faq' => [
        'title_tr' => 'SSS',
        'meta_title_tr' => 'Sıkça Sorulan Sorular | Fuar & Stand Hakkında | Expo Cyprus',
        'meta_title_en' => 'FAQ | About Fairs & Stands | Expo Cyprus',
        'meta_description_tr' => 'Fuar katılımı, stand maliyetleri, kongre organizasyonu hakkında en sık sorulan soruların yanıtları.',
        'meta_description_en' => 'Answers to most asked questions about fair participation, stand costs, congress organisation.',
        'meta_keywords_tr' => 'fuar SSS, stand maliyeti, fuar katılımı, kongre soruları',
        'meta_keywords_en' => 'fair FAQ, stand cost, fair participation, congress questions',
    ],
    'kvkk' => [
        'title_tr' => 'KVKK Aydınlatma Metni',
        'meta_title_tr' => 'KVKK Aydınlatma Metni | Kişisel Veri Politikası | Expo Cyprus',
        'meta_title_en' => 'KVKK Notice | Personal Data Policy | Expo Cyprus',
        'meta_description_tr' => 'Expo Cyprus KVKK aydınlatma metni. Kişisel verilerinizin işlenme amaçları, hukuki dayanakları ve haklarınız.',
        'meta_description_en' => 'Expo Cyprus KVKK notice. Personal data processing purposes, legal basis and your rights.',
    ],
    'privacy' => [
        'title_tr' => 'Gizlilik Politikası',
        'meta_title_tr' => 'Gizlilik Politikası | Veri Güvenliği | Expo Cyprus',
        'meta_title_en' => 'Privacy Policy | Data Security | Expo Cyprus',
        'meta_description_tr' => 'Expo Cyprus gizlilik politikası. Topladığımız bilgiler, kullanım amaçları, veri güvenliği ve haklarınız.',
        'meta_description_en' => 'Expo Cyprus privacy policy. Information we collect, usage purposes, data security and your rights.',
    ],
    'cookies' => [
        'title_tr' => 'Çerez Politikası',
        'meta_title_tr' => 'Çerez Politikası | Cookie Kullanımı | Expo Cyprus',
        'meta_title_en' => 'Cookie Policy | Expo Cyprus',
        'meta_description_tr' => 'Expo Cyprus çerez politikası. Kullandığımız çerezler, kategorileri ve nasıl yöneteceğiniz.',
        'meta_description_en' => 'Expo Cyprus cookie policy. Cookies we use, categories and how to manage them.',
    ],
    'terms' => [
        'title_tr' => 'Kullanım Koşulları',
        'meta_title_tr' => 'Kullanım Koşulları | Site Şartları | Expo Cyprus',
        'meta_title_en' => 'Terms of Use | Site Conditions | Expo Cyprus',
        'meta_description_tr' => 'Expo Cyprus web sitesi kullanım koşulları. Site kullanımı, fikri mülkiyet, sorumluluk sınırlamaları.',
        'meta_description_en' => 'Expo Cyprus terms of use. Site usage, intellectual property, liability limitations.',
    ],

    // ─── Hizmet & Ürün ek sayfaları ─────────────────
    'hotels' => [
        'title_tr' => 'Oteller',
        'meta_title_tr' => 'Oteller | Kıbrıs Konferans & Etkinlik Otelleri | Expo Cyprus',
        'meta_title_en' => 'Hotels | Cyprus Conference & Event Hotels | Expo Cyprus',
        'meta_description_tr' => 'KKTC\'nin en iyi konferans, kongre ve etkinlik otelleri. Toplu rezervasyon ve transfer hizmeti.',
        'meta_description_en' => 'North Cyprus\'s top conference, congress and event hotels. Group reservations and transfer services.',
        'meta_keywords_tr' => 'Kıbrıs otelleri, kongre oteli, konferans oteli, KKTC otel rezervasyon',
        'meta_keywords_en' => 'Cyprus hotels, congress hotel, conference hotel, North Cyprus hotel reservation',
        'hero_eyebrow_tr' => 'KONGRE OTELLERİ',
        'hero_eyebrow_en' => 'CONGRESS HOTELS',
        'hero_title_tr' => 'KKTC\'nin en iyi etkinlik mekanları.',
        'hero_title_en' => 'North Cyprus\'s top event venues.',
    ],
    'blog' => [
        'title_tr' => 'Blog',
        'meta_title_tr' => 'Blog | Fuar & Stand Sektör Yazıları | Expo Cyprus',
        'meta_title_en' => 'Blog | Fair & Stand Industry Articles | Expo Cyprus',
        'meta_description_tr' => 'Fuar, kongre ve stand tasarım sektöründen uzman görüşler, sektör haberleri ve katılımcı rehberleri.',
        'meta_description_en' => 'Expert insights, industry news and exhibitor guides from fair, congress and stand design industry.',
        'meta_keywords_tr' => 'fuar blog, stand tasarım yazıları, kongre sektör haberleri, fuar rehberi',
        'meta_keywords_en' => 'fair blog, stand design articles, congress industry news, exhibitor guide',
    ],
    // ─── Form sayfaları ──────────────────────────────
    'quote' => [
        'title_tr' => 'Stand Teklif Formu',
        'meta_title_tr' => 'Stand Teklifi Al | Detaylı Stand Brifi Formu | Expo Cyprus',
        'meta_title_en' => 'Get Stand Quote | Detailed Stand Brief Form | Expo Cyprus',
        'meta_description_tr' => 'Detaylı stand teklifi formu — fuar bilgileri, ölçüler, sistem, özellikler ve bütçe. 24 saat içinde dönüş.',
        'meta_description_en' => 'Detailed stand quote form — fair info, dimensions, system, features and budget. Response within 24 hours.',
        'meta_keywords_tr' => 'stand teklifi, fuar standı fiyat, stand brifi formu',
        'meta_keywords_en' => 'stand quote, exhibition booth price, stand brief form',
    ],
    'inquiry' => [
        'title_tr' => 'Stand Talep Formu',
        'meta_title_tr' => 'Stand Talep Formu | Hızlı Stand Sorgulama | Expo Cyprus',
        'meta_title_en' => 'Stand Inquiry Form | Quick Stand Enquiry | Expo Cyprus',
        'meta_description_tr' => 'Hızlı stand talep formu. Modeli seç, bilgilerini paylaş, biz arayalım.',
        'meta_description_en' => 'Quick stand inquiry form. Pick a model, share your details, we\'ll call.',
    ],
    'material_request' => [
        'title_tr' => 'Malzeme Talebi',
        'meta_title_tr' => 'Malzeme Talebi | Mobilya & Ekipman Sipariş | Expo Cyprus',
        'meta_title_en' => 'Material Request | Furniture & Equipment Order | Expo Cyprus',
        'meta_description_tr' => 'Stand mobilyası ve AV ekipmanı için hızlı talep formu: masa, sandalye, LED TV, modüler LED wall.',
        'meta_description_en' => 'Quick request form for stand furniture and AV equipment: tables, chairs, LED TVs, modular LED walls.',
        'meta_keywords_tr' => 'stand mobilya, fuar masa sandalye, LED TV kiralama Kıbrıs, LED wall',
        'meta_keywords_en' => 'stand furniture, fair table chair, LED TV rental Cyprus, LED wall',
    ],
    'crew' => [
        'title_tr' => 'Unifex Crew Başvurusu',
        'meta_title_tr' => 'Unifex Crew Başvuru Formu | Hostes & Saha Kadrosu | Expo Cyprus',
        'meta_title_en' => 'Unifex Crew Application | Hostess & Field Staff | Expo Cyprus',
        'meta_description_tr' => 'Hostes, MC, model, fotoğrafçı — Unifex Crew\'a başvur. KKTC\'nin lider etkinlik kadrosu ağına katıl.',
        'meta_description_en' => 'Hostess, MC, model, photographer — apply to Unifex Crew. Join North Cyprus\'s leading event staff network.',
        'meta_keywords_tr' => 'hostes başvuru, fuar görevlisi iş, model başvuru Kıbrıs, MC iş',
        'meta_keywords_en' => 'hostess application, fair staff job, model application Cyprus',
    ],
    // ─── Yardımcı sayfalar ──────────────────────────
    'cart' => [
        'title_tr' => 'Sepet',
        'meta_title_tr' => 'Sepetim | Stand Sipariş Sepeti | Expo Cyprus',
        'meta_title_en' => 'My Cart | Stand Order Cart | Expo Cyprus',
        'meta_description_tr' => 'Sepetinizdeki stand modellerini görüntüleyin, miktar değiştirin ve siparişi tamamlayın.',
        'meta_description_en' => 'View your stand models in cart, change quantities and complete order.',
    ],
    'checkout' => [
        'title_tr' => 'Ödeme',
        'meta_title_tr' => 'Ödeme | Sipariş Tamamla | Expo Cyprus',
        'meta_title_en' => 'Checkout | Complete Order | Expo Cyprus',
        'meta_description_tr' => 'Güvenli ödeme ile siparişinizi tamamlayın. Kredi kartı ve havale seçenekleri.',
        'meta_description_en' => 'Complete your order with secure payment. Credit card and bank transfer options.',
    ],
    'not_found' => [
        'title_tr' => '404 — Sayfa Bulunamadı',
        'meta_title_tr' => '404 Sayfa Bulunamadı | Expo Cyprus',
        'meta_title_en' => '404 Not Found | Expo Cyprus',
        'meta_description_tr' => 'Aradığınız sayfa bulunamadı. Anasayfaya dönün veya iletişime geçin.',
        'meta_description_en' => 'The page you\'re looking for was not found. Return home or contact us.',
    ],
];

$updated = 0;
foreach ($seo as $key => $fields) {
    $rows = DB::execute(
        "UPDATE cms_pages SET
            title_tr = COALESCE(NULLIF(title_tr, ''), ?),
            meta_title_tr = ?,
            meta_title_en = ?,
            meta_description_tr = ?,
            meta_description_en = ?,
            meta_keywords_tr = ?,
            meta_keywords_en = ?,
            hero_eyebrow_tr = COALESCE(NULLIF(hero_eyebrow_tr, ''), ?),
            hero_eyebrow_en = COALESCE(NULLIF(hero_eyebrow_en, ''), ?),
            hero_title_tr = COALESCE(NULLIF(hero_title_tr, ''), ?),
            hero_title_en = COALESCE(NULLIF(hero_title_en, ''), ?),
            hero_subtitle_tr = COALESCE(NULLIF(hero_subtitle_tr, ''), ?),
            hero_subtitle_en = COALESCE(NULLIF(hero_subtitle_en, ''), ?),
            updated_at = NOW()
         WHERE page_key = ?",
        [
            $fields['title_tr']                ?? null,
            $fields['meta_title_tr']           ?? null,
            $fields['meta_title_en']           ?? null,
            $fields['meta_description_tr']     ?? null,
            $fields['meta_description_en']     ?? null,
            $fields['meta_keywords_tr']        ?? null,
            $fields['meta_keywords_en']        ?? null,
            $fields['hero_eyebrow_tr']         ?? null,
            $fields['hero_eyebrow_en']         ?? null,
            $fields['hero_title_tr']           ?? null,
            $fields['hero_title_en']           ?? null,
            $fields['hero_subtitle_tr']        ?? null,
            $fields['hero_subtitle_en']        ?? null,
            $key,
        ]
    );
    echo ($rows > 0 ? "✓" : "✗") . " {$key}\n";
    if ($rows > 0) $updated++;
}

// Default site settings (only if empty)
$defaultSettings = [
    'site_name'              => 'Expo Cyprus',
    'site_tagline_tr'        => '22 yıllık fuar tecrübesi. Tek çatı altında.',
    'site_tagline_en'        => '22 years of fair excellence. Under one roof.',
    'company_address'        => 'Lefkoşa, Kuzey Kıbrıs',
    'company_phone'          => '+90 548 ... ....',
    'company_email'          => 'info@expocyprus.com',
    'company_hours'          => 'Pzt-Cum 09:00-18:00',
    'header_cta_text_tr'     => 'Stand Teklifi Al',
    'header_cta_text_en'     => 'Get Stand Quote',
    'header_cta_url'         => '/teklif-al',
    'footer_about_tr'        => '2004 yılından bu yana Kuzey Kıbrıs\'ta devlet tarafından resmi yetki belgesine sahip tek fuar organizasyon ve kongre şirketi olarak faaliyet göstermekteyiz. Kendi sektörel fuarlarımızı düzenlemenin yanı sıra, katılımcılarımıza stand tasarım ve kurulumundan hostes ve PR hizmetlerine kadar tüm süreçleri A\'dan Z\'ye tek noktadan sunmaktayız.',
    'footer_about_en'        => 'Since 2004, we have been operating as the only fair organisation and congress company in Northern Cyprus officially licensed by the state. In addition to organising our own sectoral fairs, we provide every process — from stand design and installation to hostess and PR services — to our participants under one roof, from A to Z.',
    'footer_copyright'       => '© 2004–' . date('Y') . ' Expo Cyprus — UNIFEX Fuarcılık. Tüm hakları saklıdır.',
    'seo_default_keywords'   => 'Expo Cyprus, UNIFEX Fuarcılık, Kıbrıs fuar, KKTC fuar, kongre Kıbrıs, stand tasarım',
];

foreach ($defaultSettings as $k => $v) {
    $exists = DB::first("SELECT setting_value FROM cms_settings WHERE setting_key = ?", [$k]);
    if (!$exists || empty($exists['setting_value'])) {
        CmsPage::setSetting($k, $v, str_starts_with($k, 'header_') ? 'header' : (str_starts_with($k, 'footer_') ? 'footer' : (str_starts_with($k, 'seo_') ? 'seo' : 'general')));
        echo "  + setting {$k}\n";
    }
}

echo "\n{$updated} sayfanın SEO meta'sı dolduruldu.\n";
