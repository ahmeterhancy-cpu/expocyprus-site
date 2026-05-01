<?php
declare(strict_types=1);

namespace App\Core;

use App\Models\CmsPage;

/**
 * Mevcut sayfaların içeriklerini otomatik block'lara dönüştürür.
 * Kullanıcı builder'ı ilk açtığında boş canvas yerine bu hazır blockları görür.
 */
class BlockSeeder
{
    /** Verilen page_key için varsayılan blokları üret */
    public static function defaultsFor(string $pageKey): array
    {
        $cms = CmsPage::content($pageKey);

        // Önce sayfa-özel seed'leri dene
        $method = 'seed_' . str_replace('-', '_', $pageKey);
        if (method_exists(self::class, $method)) {
            return call_user_func([self::class, $method], $cms);
        }

        // Generic fallback: hero + heading + text varsa
        return self::seed_generic($cms);
    }

    private static function seed_generic(array $cms): array
    {
        $blocks = [];
        if (!empty($cms['hero_title_tr']) || !empty($cms['hero_image'])) {
            $blocks[] = ['type' => 'hero', 'data' => [
                'eyebrow_tr' => $cms['hero_eyebrow_tr'] ?? '',
                'eyebrow_en' => $cms['hero_eyebrow_en'] ?? '',
                'title_tr'   => $cms['hero_title_tr']   ?? $cms['title_tr']   ?? '',
                'title_en'   => $cms['hero_title_en']   ?? $cms['title_en']   ?? '',
                'subtitle_tr'=> $cms['hero_subtitle_tr']?? '',
                'subtitle_en'=> $cms['hero_subtitle_en']?? '',
                'image'      => $cms['hero_image']      ?? '',
                'accent'     => '#E30613',
            ]];
        }
        if (!empty($cms['body_tr']) || !empty($cms['body_en'])) {
            $blocks[] = ['type' => 'text', 'data' => [
                'body_tr' => $cms['body_tr'] ?? '',
                'body_en' => $cms['body_en'] ?? '',
            ]];
        }
        return $blocks;
    }

    /* ─── HOME ─── */
    private static function seed_home(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => '2004\'TEN BERİ', 'eyebrow_en' => 'SINCE 2004',
                'title_tr' => 'Kıbrıs\'ın fuar standardı.',
                'title_en' => 'The fair standard of Cyprus.',
                'subtitle_tr' => '22 yıllık tecrübe. 4 sektörel fuar. 100+ stand kurulumu. Tek çatı altında.',
                'subtitle_en' => '22 years. 4 sector fairs. 100+ stand installations. Under one roof.',
                'image' => '/assets/images/hero-hall.png',
                'cta_text_tr' => 'Stand Teklifi Al', 'cta_text_en' => 'Get Stand Quote',
                'cta_url' => '/teklif-al', 'accent' => '#E30613',
            ]],
            ['type' => 'stats', 'data' => [
                'theme' => 'dark',
                'stat1_num' => '22+',  'stat1_tr' => 'Yıllık Tecrübe',  'stat1_en' => 'Years',
                'stat2_num' => '4',    'stat2_tr' => 'Sektörel Fuar',   'stat2_en' => 'Sector Fairs',
                'stat3_num' => '100+', 'stat3_tr' => 'Stand Kurulumu',  'stat3_en' => 'Stands Built',
                'stat4_num' => '50K+', 'stat4_tr' => 'Yıllık Ziyaretçi','stat4_en' => 'Annual Visitors',
            ]],
            ['type' => 'heading', 'data' => [
                'eyebrow_tr' => 'HİZMETLERİMİZ', 'eyebrow_en' => 'OUR SERVICES',
                'title_tr' => 'Tek çatı altında, 6 uzmanlık alanı.',
                'title_en' => 'Six specialties. Under one roof.',
                'align' => 'center', 'size' => 'lg',
            ]],
            ['type' => 'features', 'data' => [
                'columns' => '3',
                'feat1_icon' => '🎪', 'feat1_title_tr' => 'Fuar Organizasyonu', 'feat1_title_en' => 'Fair Organisation',
                'feat1_desc_tr' => 'Konseptten kapanışa A\'dan Z\'ye fuar yönetimi.',
                'feat1_desc_en' => 'A to Z fair management — from concept to close.',
                'feat2_icon' => '🎙️', 'feat2_title_tr' => 'Kongre Organizasyonu', 'feat2_title_en' => 'Congress',
                'feat2_desc_tr' => 'Akademik, tıbbi, kurumsal kongre operasyonu.',
                'feat2_desc_en' => 'Academic, medical, corporate congress operations.',
                'feat3_icon' => '🏗️', 'feat3_title_tr' => 'Stand Tasarım & Kurulum', 'feat3_title_en' => 'Stand Design & Build',
                'feat3_desc_tr' => '3D tasarımdan saha kurulumuna — kendi atölyemizde.',
                'feat3_desc_en' => 'From 3D design to on-site build — in our workshop.',
                'feat4_icon' => '🧭', 'feat4_title_tr' => 'Fuar Danışmanlığı', 'feat4_title_en' => 'Exhibitor Consulting',
                'feat4_desc_tr' => 'Stratejiden ROI raporuna fuarı yatırıma çeviriyoruz.',
                'feat4_desc_en' => 'From strategy to ROI — turning fair into investment.',
            ]],
            ['type' => 'showcase', 'data' => [
                'image' => '/assets/images/hero-hall.png',
                'title_tr' => 'Detayla işlenmiş. Disiplinle teslim edilmiş.',
                'title_en' => 'Crafted with detail. Delivered with discipline.',
            ]],
            ['type' => 'cta', 'data' => [
                'theme' => 'gradient',
                'title_tr' => 'Bir sonraki fuarınızı birlikte planlayalım.',
                'title_en' => 'Let\'s plan your next fair together.',
                'subtitle_tr' => '24 saatte dönüş. Özel teklif. Bağlayıcılık yok.',
                'subtitle_en' => '24-hour response. Custom quote. No commitment.',
                'btn1_text_tr' => 'Teklif İste', 'btn1_text_en' => 'Get a Quote', 'btn1_url' => '/teklif-al',
                'btn2_text_tr' => 'İletişime Geç', 'btn2_text_en' => 'Contact us', 'btn2_url' => '/iletisim',
            ]],
        ];
    }

    /* ─── ABOUT ─── */
    private static function seed_about(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => '2004\'TEN BERİ', 'eyebrow_en' => 'SINCE 2004',
                'title_tr' => '22 yıl. Kıbrıs fuar sektörü.',
                'title_en' => '22 years. Cyprus exhibition industry.',
                'subtitle_tr' => 'Bir avuç profesyonelin tutkuyla başlattığı yolculuk, bugün adanın en güvenilir fuar organizatörü.',
                'subtitle_en' => 'What started as a passion project is today the island\'s most trusted fair organiser.',
                'image' => '/assets/images/about-team.png',
                'accent' => '#E30613',
            ]],
            ['type' => 'heading', 'data' => [
                'eyebrow_tr' => 'HİKAYEMİZ', 'eyebrow_en' => 'OUR STORY',
                'title_tr' => '2004\'te UNIFEX Fuarcılık altında kuruldu.',
                'title_en' => 'Founded in 2004 under UNIFEX Fuarcılık.',
                'align' => 'left', 'size' => 'lg',
            ]],
            ['type' => 'image_text', 'data' => [
                'image' => '/assets/images/hero-hall.png',
                'title_tr' => 'Kıbrıs\'ın fuar altyapısını biz inşa ettik.',
                'title_en' => 'We built Cyprus\'s exhibition infrastructure.',
                'body_tr' => '<p>Tek bir inançla yola çıktık: Kıbrıs, dünya standartlarında fuar altyapısını hak ediyor. Bir avuç profesyonelin tutkuyla başlattığı bu yolculuk, bugün adanın en güvenilir fuar ve kongre organizatörüne dönüştü.</p><p>Bugün <strong>4 periyodik ticaret fuarı</strong> düzenliyor, yıllık <strong>100+ stand kurulumu</strong> yapıyor ve <strong>10+ uluslararası kongre</strong> gerçekleştiriyoruz.</p>',
                'body_en' => '<p>We started with one belief: Cyprus deserves world-class exhibition infrastructure. Today we run <strong>4 recurring trade fairs</strong>, build <strong>100+ stand installations</strong> annually, and host <strong>10+ international congresses</strong>.</p>',
                'layout' => 'left', 'tilt' => '1',
            ]],
            ['type' => 'stats', 'data' => [
                'theme' => 'dark',
                'stat1_num' => '22+',  'stat1_tr' => 'Yıllık Tecrübe',     'stat1_en' => 'Years Experience',
                'stat2_num' => '4',    'stat2_tr' => 'Yıllık Fuar',         'stat2_en' => 'Annual Fairs',
                'stat3_num' => '100+', 'stat3_tr' => 'Stand Kurulumu',     'stat3_en' => 'Stand Builds',
                'stat4_num' => '10+',  'stat4_tr' => 'Uluslararası Kongre', 'stat4_en' => 'Int\'l Congresses',
            ]],
            ['type' => 'heading', 'data' => [
                'eyebrow_tr' => 'NEYİ TEMSİL EDİYORUZ', 'eyebrow_en' => 'WHAT WE STAND FOR',
                'title_tr' => 'Üç değer. Her proje.',
                'title_en' => 'Three values. Every project.',
                'align' => 'left', 'size' => 'lg',
            ]],
            ['type' => 'features', 'data' => [
                'columns' => '3',
                'feat1_icon' => '01', 'feat1_title_tr' => 'Disiplin', 'feat1_title_en' => 'Discipline',
                'feat1_desc_tr' => 'Her detay takipte, her teslim tarihi tutturulur. Üretim bir zanaattir.',
                'feat1_desc_en' => 'Every detail tracked, every deadline kept. Production is a craft.',
                'feat2_icon' => '02', 'feat2_title_tr' => 'Özen', 'feat2_title_en' => 'Care',
                'feat2_desc_tr' => 'Küçük bir KOBİ ve çok uluslu bir marka aynı özeni hak eder.',
                'feat2_desc_en' => 'A small SME and a multinational receive the same level of attention.',
                'feat3_icon' => '03', 'feat3_title_tr' => 'Yerellik', 'feat3_title_en' => 'Locality',
                'feat3_desc_tr' => 'Kıbrıs uzmanlığı. Yerel lojistik, yerel ilişkiler, yerel bilgi.',
                'feat3_desc_en' => 'Cyprus expertise. Local logistics, relationships, knowledge.',
            ]],
            ['type' => 'cta', 'data' => [
                'theme' => 'light',
                'title_tr' => 'Sıradaki bölümü birlikte yazalım.',
                'title_en' => 'Let\'s build the next chapter together.',
                'btn1_text_tr' => 'Projeyi Başlat', 'btn1_text_en' => 'Start a project', 'btn1_url' => '/teklif-al',
                'btn2_text_tr' => 'İletişime Geç', 'btn2_text_en' => 'Contact us', 'btn2_url' => '/iletisim',
            ]],
        ];
    }

    /* ─── HISTORY ─── */
    private static function seed_history(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => 'TARİHÇEMİZ', 'eyebrow_en' => 'OUR HISTORY',
                'title_tr' => 'Yirmi yıllık dönüm noktaları.',
                'title_en' => 'Two decades of milestones.',
                'subtitle_tr' => '2004\'te bir vizyon. Bugün KKTC\'nin fuar standardı.',
                'subtitle_en' => 'A vision in 2004. Today, the fair standard of Cyprus.',
                'image' => '/assets/images/about-team.png',
                'accent' => '#E30613',
            ]],
            ['type' => 'features', 'data' => [
                'columns' => '3',
                'feat1_icon' => '2004', 'feat1_title_tr' => 'Lefkoşa\'da Kuruluş', 'feat1_title_en' => 'Founded in Nicosia',
                'feat1_desc_tr' => 'Unifex Fuarcılık kuruldu. İlk Tüketici Fuarı düzenlendi.',
                'feat1_desc_en' => 'Unifex Fuarcılık founded. First Consumer Fair launched.',
                'feat2_icon' => '2008', 'feat2_title_tr' => 'İlk İhtisas Fuarı', 'feat2_title_en' => 'First Specialty Fair',
                'feat2_desc_tr' => 'Av & Doğa Sporları — KKTC\'nin ilk ihtisas fuarı.',
                'feat2_desc_en' => 'Hunting & Outdoor Sports — Cyprus\'s first specialty fair.',
                'feat3_icon' => '2012', 'feat3_title_tr' => 'Tarım Fuarı', 'feat3_title_en' => 'Agriculture Fair',
                'feat3_desc_tr' => 'Tarım Hayvancılık Fuarı eklendi. 30.000+ ziyaretçi.',
                'feat3_desc_en' => 'Agriculture & Livestock added. 30,000+ visitors.',
                'feat4_icon' => '2016', 'feat4_title_tr' => '100. Stand', 'feat4_title_en' => '100th Stand',
                'feat4_desc_tr' => 'Özel yapım stand kurulumu kilometre taşı.',
                'feat4_desc_en' => 'Custom stand installation milestone.',
            ]],
            ['type' => 'features', 'data' => [
                'columns' => '3',
                'feat1_icon' => '2020', 'feat1_title_tr' => 'Hibrit Dönem', 'feat1_title_en' => 'Hybrid Era',
                'feat1_desc_tr' => 'Canlı yayın + dijital altyapı.',
                'feat1_desc_en' => 'Live streaming + digital infrastructure.',
                'feat2_icon' => '2022', 'feat2_title_tr' => 'Expo Cyprus', 'feat2_title_en' => 'Expo Cyprus Brand',
                'feat2_desc_tr' => 'Marka yenileme. 50.000+ yıllık ziyaretçi.',
                'feat2_desc_en' => 'Rebrand. 50,000+ annual visitors.',
                'feat3_icon' => '2026', 'feat3_title_tr' => 'Bugün', 'feat3_title_en' => 'Today',
                'feat3_desc_tr' => 'Kıbrıs\'ın lider fuar organizatörü.',
                'feat3_desc_en' => 'Cyprus\'s leading fair organiser.',
            ]],
            ['type' => 'cta', 'data' => [
                'theme' => 'gradient',
                'title_tr' => 'Yolculuğun bir parçası olun.',
                'title_en' => 'Be part of the journey.',
                'btn1_text_tr' => 'İletişime Geç', 'btn1_text_en' => 'Contact us', 'btn1_url' => '/iletisim',
            ]],
        ];
    }

    /* ─── MISSION ─── */
    private static function seed_mission(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => 'MİSYON & VİZYON', 'eyebrow_en' => 'MISSION & VISION',
                'title_tr' => 'Aldığımız her kararın pusulası.',
                'title_en' => 'The compass for every decision.',
                'image' => '/assets/images/hero-hall.png',
                'accent' => '#E30613',
            ]],
            ['type' => 'features', 'data' => [
                'columns' => '2',
                'feat1_icon' => '🎯', 'feat1_title_tr' => 'Misyonumuz', 'feat1_title_en' => 'Our Mission',
                'feat1_desc_tr' => 'Kıbrıs\'ta fuar ve etkinlik organizasyonunda standartları yükselten, katılımcılarına ölçülebilir değer üreten, sektörünü ileriye taşıyan çözümler sunmak.',
                'feat1_desc_en' => 'To deliver fair and event organisation that raises the standard, generates measurable value, and moves the industry forward.',
                'feat2_icon' => '👁️', 'feat2_title_tr' => 'Vizyonumuz', 'feat2_title_en' => 'Our Vision',
                'feat2_desc_tr' => 'Kıbrıs\'ı dünya standartlarında bir fuar ve kongre merkezine dönüştürmek; Doğu Akdeniz\'in sektör buluşma noktası olmak.',
                'feat2_desc_en' => 'Transform Cyprus into a world-class fair and congress hub; become the Eastern Mediterranean\'s industry meeting point.',
            ]],
            ['type' => 'heading', 'data' => [
                'eyebrow_tr' => 'DEĞERLERİMİZ', 'eyebrow_en' => 'OUR VALUES',
                'title_tr' => 'Üç ilke. Her proje.',
                'title_en' => 'Three principles. Every project.',
                'align' => 'center', 'size' => 'lg',
            ]],
            ['type' => 'features', 'data' => [
                'columns' => '3',
                'feat1_icon' => '⚡', 'feat1_title_tr' => 'Disiplin', 'feat1_title_en' => 'Discipline',
                'feat1_desc_tr' => 'Her detay takipte, her teslim tarihi tutturulur.',
                'feat1_desc_en' => 'Every detail tracked, every deadline kept.',
                'feat2_icon' => '💎', 'feat2_title_tr' => 'Özen', 'feat2_title_en' => 'Care',
                'feat2_desc_tr' => 'Küçük bir KOBİ ve çok uluslu marka aynı özeni hak eder.',
                'feat2_desc_en' => 'A small SME and a multinational receive the same level of attention.',
                'feat3_icon' => '🌍', 'feat3_title_tr' => 'Yerellik', 'feat3_title_en' => 'Locality',
                'feat3_desc_tr' => 'Kıbrıs uzmanlığı. Yerel lojistik, yerel ilişkiler.',
                'feat3_desc_en' => 'Cyprus expertise. Local logistics, local relationships.',
            ]],
        ];
    }

    /* ─── TEAM ─── */
    private static function seed_team(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => 'EKİBİMİZ', 'eyebrow_en' => 'OUR TEAM',
                'title_tr' => 'Profesyonel kadro. Kıbrıs uzmanlığı.',
                'title_en' => 'Professional staff. Cyprus expertise.',
                'subtitle_tr' => 'Deneyim, tutku ve detaya verilen önem.',
                'subtitle_en' => 'Experience, passion, attention to detail.',
                'image' => '/assets/images/about-team.png',
            ]],
            ['type' => 'text', 'data' => [
                'body_tr' => '<p>Expo Cyprus\'un arkasındaki kadro, yıllarca süren saha tecrübesi ve farklı disiplinlerden gelen uzmanlık alanlarıyla bir araya geldi. Fuar yönetimi, stand tasarımı, operasyon ve PR uzmanları aynı çatı altında.</p>',
                'body_en' => '<p>The team behind Expo Cyprus combines years of field experience with diverse disciplines. Fair management, stand design, operations and PR specialists — all under one roof.</p>',
            ]],
            ['type' => 'cta', 'data' => [
                'theme' => 'light',
                'title_tr' => 'Ekibimizle tanışmak ister misin?',
                'title_en' => 'Want to meet the team?',
                'btn1_text_tr' => 'İletişim', 'btn1_text_en' => 'Contact', 'btn1_url' => '/iletisim',
                'btn2_text_tr' => 'Crew\'a Katıl', 'btn2_text_en' => 'Join Our Crew', 'btn2_url' => '/unifex-crew',
            ]],
        ];
    }

    /* ─── SERVICES (liste sayfası) ─── */
    private static function seed_services(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => 'HİZMETLERİMİZ', 'eyebrow_en' => 'OUR SERVICES',
                'title_tr' => 'Altı hizmet. Tek sorumluluk.',
                'title_en' => 'Six services. One responsibility.',
                'subtitle_tr' => 'Fuar organizasyonundan PR\'a — her şey ekibimiz tarafından tasarlanır, üretilir ve teslim edilir.',
                'subtitle_en' => 'Everything from fair organisation to PR — designed, built and delivered by our team.',
                'image' => '/assets/images/hero-hall.png',
            ]],
            ['type' => 'features', 'data' => [
                'columns' => '3',
                'feat1_icon' => '🎪', 'feat1_title_tr' => 'Fuar Organizasyonu', 'feat1_title_en' => 'Fair Organisation',
                'feat1_desc_tr' => 'Konseptten kapanışa A\'dan Z\'ye fuar yönetimi.',
                'feat1_desc_en' => 'A to Z fair management — from concept to close.',
                'feat2_icon' => '🎙️', 'feat2_title_tr' => 'Kongre Organizasyonu', 'feat2_title_en' => 'Congress',
                'feat2_desc_tr' => 'Akademik, tıbbi, kurumsal kongre operasyonu.',
                'feat2_desc_en' => 'Academic, medical, corporate congress operations.',
                'feat3_icon' => '🏗️', 'feat3_title_tr' => 'Stand Tasarım & Kurulum', 'feat3_title_en' => 'Stand Design & Build',
                'feat3_desc_tr' => '3D tasarımdan saha kurulumuna kendi atölyemizde.',
                'feat3_desc_en' => 'From 3D design to on-site build — in our workshop.',
                'feat4_icon' => '🧭', 'feat4_title_tr' => 'Fuar Danışmanlığı', 'feat4_title_en' => 'Exhibitor Consulting',
                'feat4_desc_tr' => 'Stratejiden ROI raporuna fuarı yatırıma çeviriyoruz.',
                'feat4_desc_en' => 'From strategy to ROI report.',
            ]],
        ];
    }

    /* ─── FAIRS ─── */
    private static function seed_fairs(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => 'KENDİ FUARLARIMIZ', 'eyebrow_en' => 'OUR FAIRS',
                'title_tr' => 'Dört Fuar. Bir Öncü. Kıbrıs.',
                'title_en' => 'Four Fairs. One Leader. Cyprus.',
                'subtitle_tr' => 'Binlerce ziyaretçiyi yüzlerce katılımcıyla buluşturan yıllık ticaret fuarları.',
                'subtitle_en' => 'Annual trade fairs that bring thousands of visitors with hundreds of exhibitors.',
                'image' => '/assets/images/hero-hall.png',
            ]],
            ['type' => 'features', 'data' => [
                'columns' => '2',
                'feat1_icon' => '🛍️', 'feat1_title_tr' => 'Tüketici Fuarı', 'feat1_title_en' => 'Consumer Fair',
                'feat1_desc_tr' => 'Tüm sektörler tek çatı altında. Yıllık 15.000+ ziyaretçi.',
                'feat1_desc_en' => 'All sectors under one roof. 15,000+ annual visitors.',
                'feat2_icon' => '🎯', 'feat2_title_tr' => 'Av & Doğa Sporları', 'feat2_title_en' => 'Hunting & Outdoor',
                'feat2_desc_tr' => 'KKTC\'nin ilk ihtisas fuarı. Av, atış, doğa sporları.',
                'feat2_desc_en' => 'Cyprus\'s first specialty fair.',
                'feat3_icon' => '🌾', 'feat3_title_tr' => 'Tarım Hayvancılık', 'feat3_title_en' => 'Agriculture & Livestock',
                'feat3_desc_tr' => 'Tarım teknolojisi, hayvancılık, gıda işleme.',
                'feat3_desc_en' => 'Agritech, livestock, food processing.',
                'feat4_icon' => '💍', 'feat4_title_tr' => 'Düğün Hazırlıkları', 'feat4_title_en' => 'Wedding Preparations',
                'feat4_desc_tr' => 'Mekan, gelinlik, fotoğraf, balayı — düğün için her şey.',
                'feat4_desc_en' => 'Venues, dresses, photo, honeymoon.',
            ]],
            ['type' => 'quote', 'data' => [
                'theme' => 'dark',
                'quote_tr' => 'Biz fuarları sadece düzenlemiyoruz. Onları inşa ediyoruz.',
                'quote_en' => 'We don\'t just host fairs. We build them.',
                'author' => 'Expo Cyprus',
            ]],
        ];
    }

    /* ─── CONTACT ─── */
    private static function seed_contact(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => 'İLETİŞİM', 'eyebrow_en' => 'CONTACT',
                'title_tr' => 'Bize ulaşın.',
                'title_en' => 'Get in touch.',
                'subtitle_tr' => '24 saat içinde yanıt veriyoruz. Projenizi bize anlatın.',
                'subtitle_en' => 'We respond within 24 hours. Tell us about your project.',
                'image' => '/assets/images/hero-hall.png',
            ]],
            ['type' => 'features', 'data' => [
                'columns' => '3',
                'feat1_icon' => '📍', 'feat1_title_tr' => 'Adres', 'feat1_title_en' => 'Address',
                'feat1_desc_tr' => 'Lefkoşa, Kuzey Kıbrıs',
                'feat1_desc_en' => 'Nicosia, Northern Cyprus',
                'feat2_icon' => '📞', 'feat2_title_tr' => 'Telefon', 'feat2_title_en' => 'Phone',
                'feat2_desc_tr' => '+90 548 ... ....',
                'feat2_desc_en' => '+90 548 ... ....',
                'feat3_icon' => '✉️', 'feat3_title_tr' => 'E-posta', 'feat3_title_en' => 'Email',
                'feat3_desc_tr' => 'info@expocyprus.com',
                'feat3_desc_en' => 'info@expocyprus.com',
            ]],
        ];
    }

    /* ─── FAQ ─── */
    private static function seed_faq(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => 'SSS', 'eyebrow_en' => 'FAQ',
                'title_tr' => 'Sıkça sorulan sorular.',
                'title_en' => 'Frequently asked questions.',
                'subtitle_tr' => 'İletişime geçmeden önce sormak istediğiniz her şey.',
                'subtitle_en' => 'Everything you wanted to ask before getting in touch.',
                'image' => '/assets/images/hero-hall.png',
            ]],
            ['type' => 'text', 'data' => [
                'body_tr' => '<h2>Fuar katılımı için ne kadar erken planlama yapmalıyım?</h2><p>En az 3-6 ay önce. Stand tasarımı, kurulum ve pazarlama için sağlıklı süre.</p><h2>Stand maliyeti nasıl hesaplanır?</h2><p>m² × tasarım tipi × ek hizmetler. Modüler 350-500 €/m², özel yapım 600-1200 €/m² aralığında.</p><h2>Yurt dışından katılım yapanlara hangi destekler veriyorsunuz?</h2><p>Konaklama, transfer, yerel iletişim ve KKTC giriş prosedürleri için tam destek.</p><h2>Hostes / sahne ekibi sağlıyor musunuz?</h2><p>Evet, eğitimli kadromuz var: stand görevlisi, dil bilen hostes, MC, sahne yönetimi.</p>',
                'body_en' => '<h2>How early should I plan?</h2><p>At least 3-6 months in advance.</p><h2>How is stand cost calculated?</h2><p>m² × design type × additional services. Modular: 350-500 €/m²; custom: 600-1200 €/m².</p>',
            ]],
            ['type' => 'cta', 'data' => [
                'theme' => 'light',
                'title_tr' => 'Cevabını bulamadın mı?',
                'title_en' => 'Couldn\'t find your answer?',
                'btn1_text_tr' => 'Bize Sor', 'btn1_text_en' => 'Ask Us', 'btn1_url' => '/iletisim',
            ]],
        ];
    }

    /* ─── REFERENCES ─── */
    private static function seed_references(array $cms): array
    {
        return [
            ['type' => 'hero', 'data' => [
                'eyebrow_tr' => 'PROJELER', 'eyebrow_en' => 'PROJECTS',
                'title_tr' => '100+ kurulum. 22 yıl güven.',
                'title_en' => '100+ installations. 22 years of trust.',
                'subtitle_tr' => 'Uzun vadeli müşterilerimizden bir seçki.',
                'subtitle_en' => 'A selection from our long-term clients.',
                'image' => '/assets/images/hero-hall.png',
            ]],
        ];
    }
}
