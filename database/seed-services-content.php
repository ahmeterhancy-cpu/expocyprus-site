<?php
/**
 * Service detail content seeder.
 * Run once: php database/seed-services-content.php
 */
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// Load .env
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    foreach (parse_ini_file($envFile) as $k => $v) {
        putenv("$k=$v");
    }
}
define('BASE_PATH', dirname(__DIR__));

use App\Core\DB;

$services = [
    'fuar-organizasyonu' => [
        'tr' => <<<'HTML'
<p class="lead">22 yıllık tecrübemizle Kıbrıs'ın en köklü fuar organizatörüyüz. Konseptten kapanışa kadar fuarınızın <strong>tüm operasyonel sürecini</strong> tek elden yönetiyoruz.</p>

<h2>Sunduğumuz Hizmet</h2>
<p>Kendi sektörel fuarlarımızı (Tüketici Fuarı, Av & Avcılık, Tarım Hayvancılık, Düğün Hazırlıkları) düzenliyor; aynı zamanda kurumsal müşterilerimiz için <em>özel sektörel fuar</em> ve <em>B2B etkinlik</em> organizasyonları gerçekleştiriyoruz.</p>

<ul>
  <li><strong>Konsept &amp; Strateji:</strong> Sektör analizi, hedef kitle haritalama, fuar formatı belirleme</li>
  <li><strong>Mekan Yönetimi:</strong> KKTC'nin tüm büyük kongre ve fuar merkezleriyle anlaşmalı çalışma</li>
  <li><strong>Stand Satışı:</strong> Katılımcı portföyü, satış kotası, sponsorluk paketleri</li>
  <li><strong>Pazarlama:</strong> Dijital reklam (Meta, Google), basılı medya, dış mekan, davetiye yönetimi</li>
  <li><strong>Operasyon:</strong> Stand kurulumu, teknik altyapı (elektrik, internet, AV), güvenlik, temizlik</li>
  <li><strong>Saha Yönetimi:</strong> Kayıt, akış kontrolü, vakit çizelgesi, koordinasyon merkezi</li>
  <li><strong>Raporlama:</strong> Ziyaretçi analizi, lead listesi, ROI raporu, foto-video arşivi</li>
</ul>

<h2>İş Süreci</h2>
<ol>
  <li><strong>İhtiyaç Analizi (1-2 hafta):</strong> Hedef, bütçe, kapsam belirleme</li>
  <li><strong>Master Plan (3-4 hafta):</strong> Format, mekan, takvim, tema</li>
  <li><strong>Hazırlık (3-6 ay):</strong> Pazarlama, satış, operasyon planı</li>
  <li><strong>Etkinlik (1-5 gün):</strong> Sahada tam koordinasyon</li>
  <li><strong>Pre-Event Raporu (2 hafta):</strong> Detaylı sonuç değerlendirmesi</li>
</ol>

<h2>Neden Expo Cyprus?</h2>
<ul>
  <li>4 sektörel fuarın yıllık operasyonu — pratiğe dökülmüş süreç bilgisi</li>
  <li>50.000+ yıllık ziyaretçi trafiği yönetme deneyimi</li>
  <li>Tüm KKTC fuar merkezleriyle kurumsal anlaşmalar</li>
  <li>İç teknik ekip — taşeron koordinasyon riskini sıfırlar</li>
  <li>Şeffaf bütçeleme — sürpriz maliyet yok</li>
</ul>

<p><em>Düşündüğünüz fuar ne ölçekte olursa olsun — niş bir B2B buluşmasından 5 günlük halka açık bir gösteriye kadar — formatınıza uygun teklif çıkarabiliriz.</em></p>
HTML,
        'en' => <<<'HTML'
<p class="lead">With 22 years of experience, we are Cyprus's most established fair organiser. We manage <strong>the entire operational process</strong> of your fair under one roof, from concept to closing.</p>

<h2>What We Offer</h2>
<p>We organise our own sector fairs (Consumer Fair, Hunting &amp; Outdoor Sports, Agriculture &amp; Livestock, Wedding Preparations) and deliver <em>tailor-made sector fairs</em> and <em>B2B events</em> for corporate clients.</p>

<ul>
  <li><strong>Concept &amp; Strategy:</strong> Sector analysis, audience mapping, fair format definition</li>
  <li><strong>Venue Management:</strong> Partnerships with all major congress and exhibition venues across North Cyprus</li>
  <li><strong>Stand Sales:</strong> Exhibitor portfolio, sales quotas, sponsorship packages</li>
  <li><strong>Marketing:</strong> Digital ads (Meta, Google), print, outdoor, invitation management</li>
  <li><strong>Operations:</strong> Stand build, technical infrastructure (power, internet, AV), security, cleaning</li>
  <li><strong>On-site Management:</strong> Registration, flow control, schedule, coordination hub</li>
  <li><strong>Reporting:</strong> Visitor analytics, lead list, ROI report, photo/video archive</li>
</ul>

<h2>Our Process</h2>
<ol>
  <li><strong>Needs Analysis (1-2 weeks):</strong> Goals, budget, scope</li>
  <li><strong>Master Plan (3-4 weeks):</strong> Format, venue, schedule, theme</li>
  <li><strong>Preparation (3-6 months):</strong> Marketing, sales, operations plan</li>
  <li><strong>Event (1-5 days):</strong> Full on-site coordination</li>
  <li><strong>Post-Event Report (2 weeks):</strong> Detailed evaluation</li>
</ol>

<h2>Why Expo Cyprus?</h2>
<ul>
  <li>Annual operation of 4 sector fairs — proven, practical know-how</li>
  <li>Experience handling 50,000+ annual visitor traffic</li>
  <li>Corporate agreements with every fair venue in North Cyprus</li>
  <li>In-house technical team — eliminates subcontractor risk</li>
  <li>Transparent budgeting — no surprise costs</li>
</ul>

<p><em>Whatever the scale of your fair — from a niche B2B meetup to a 5-day public exhibition — we can tailor a proposal to fit your format.</em></p>
HTML,
    ],

    'kongre-organizasyonu' => [
        'tr' => <<<'HTML'
<p class="lead">Akademik, tıbbi ve kurumsal kongrelerde 10+ uluslararası organizasyon deneyimi. Konuşmacı yönetiminden bilimsel programa, sosyal etkinlikten yayın koordinasyonuna kadar <strong>her detayı biz yönetiyoruz</strong>.</p>

<h2>Kongre Türleri</h2>
<ul>
  <li><strong>Akademik Kongre:</strong> Üniversite konferansları, sempozyumlar, çalıştaylar</li>
  <li><strong>Tıbbi Kongre:</strong> CME akreditasyonlu sunumlar, ilaç firma sponsorluğu, e-poster sistemi</li>
  <li><strong>Kurumsal Kongre:</strong> Yıllık şirket toplantıları, bayi konferansları, ürün lansmanları</li>
  <li><strong>Hibrit Kongre:</strong> Fiziksel + canlı yayın altyapısı, online katılımcı portalı</li>
</ul>

<h2>Sunduğumuz Hizmet</h2>
<ul>
  <li><strong>Bilimsel Komite Desteği:</strong> Çağrılı konuşmacılar, abstract submission sistemi, hakemlik süreci</li>
  <li><strong>Online Kayıt Sistemi:</strong> Erken kayıt indirimi, kategori bazlı ücretlendirme, online ödeme</li>
  <li><strong>Konuşmacı Yönetimi:</strong> Uçuş, transfer, konaklama, honorarium yönetimi</li>
  <li><strong>Mekan ve Teknik:</strong> Salon yapılandırma, simültane çeviri, AV sistemleri, sahne</li>
  <li><strong>Sosyal Program:</strong> Gala yemeği, kültür turları, eş-programları</li>
  <li><strong>Yayın:</strong> Proceedings kitabı, dijital arşiv, video kaydı</li>
  <li><strong>Sertifikalandırma:</strong> Katılım sertifikaları, CME kredilendirmesi</li>
</ul>

<h2>İş Süreci</h2>
<ol>
  <li><strong>Brief &amp; Bilim Komitesi:</strong> Tema, hedef katılımcı sayısı, akademik ortaklar</li>
  <li><strong>Kayıt Sistemi Kurulumu:</strong> 6+ ay öncesinden web sitesi ve kayıt portalı</li>
  <li><strong>Konuşmacı &amp; Sponsor Yönetimi:</strong> 4-5 ay süreçle</li>
  <li><strong>Operasyon:</strong> Bilim sekreteryası, teknik ekip, sahne yönetimi</li>
  <li><strong>Kongre Sonrası:</strong> Yayın, sertifika, anket, raporlama</li>
</ol>

<h2>Neden Expo Cyprus?</h2>
<ul>
  <li>Yakın Doğu Üniversitesi, Doğu Akdeniz Üniversitesi gibi kurumlarla yıllık iş ortaklığı</li>
  <li>500-1500 kişilik kongre formatlarında ölçekli süreç bilgisi</li>
  <li>Çok dilli (TR-EN-RU) bilim sekreteryası</li>
  <li>Hibrit kongre teknik altyapısı (canlı yayın, online katılım, etkileşim)</li>
  <li>KKTC giriş prosedürleri için yurt dışı katılımcılara tam destek</li>
</ul>
HTML,
        'en' => <<<'HTML'
<p class="lead">Over 10 international congress organisations across academic, medical and corporate sectors. From speaker management to scientific programme, from social events to publication coordination — <strong>we handle every detail</strong>.</p>

<h2>Congress Types</h2>
<ul>
  <li><strong>Academic Congress:</strong> University conferences, symposia, workshops</li>
  <li><strong>Medical Congress:</strong> CME-accredited sessions, pharma sponsorship, e-poster system</li>
  <li><strong>Corporate Congress:</strong> Annual company meetings, dealer conferences, product launches</li>
  <li><strong>Hybrid Congress:</strong> Physical + live streaming infrastructure, online attendee portal</li>
</ul>

<h2>What We Offer</h2>
<ul>
  <li><strong>Scientific Committee Support:</strong> Invited speakers, abstract submission system, peer review</li>
  <li><strong>Online Registration:</strong> Early-bird discounts, tiered pricing, online payment</li>
  <li><strong>Speaker Management:</strong> Flights, transfers, accommodation, honorariums</li>
  <li><strong>Venue &amp; Technical:</strong> Hall configuration, simultaneous interpretation, AV systems, stage</li>
  <li><strong>Social Programme:</strong> Gala dinner, cultural tours, accompanying-person programmes</li>
  <li><strong>Publication:</strong> Proceedings book, digital archive, video recordings</li>
  <li><strong>Certification:</strong> Attendance certificates, CME credit</li>
</ul>

<h2>Our Process</h2>
<ol>
  <li><strong>Brief &amp; Scientific Committee:</strong> Theme, target attendance, academic partners</li>
  <li><strong>Registration System Setup:</strong> Website and registration portal 6+ months ahead</li>
  <li><strong>Speaker &amp; Sponsor Management:</strong> 4-5 month engagement cycle</li>
  <li><strong>Operations:</strong> Scientific secretariat, technical team, stage management</li>
  <li><strong>Post-Congress:</strong> Publication, certification, surveys, reporting</li>
</ol>

<h2>Why Expo Cyprus?</h2>
<ul>
  <li>Annual partnerships with institutions like Near East University and Eastern Mediterranean University</li>
  <li>Proven workflow at 500–1500 attendee scale</li>
  <li>Multilingual (TR-EN-RU) scientific secretariat</li>
  <li>Hybrid congress technical infrastructure (live streaming, online participation, interaction)</li>
  <li>Full support for international attendees on North Cyprus entry procedures</li>
</ul>
HTML,
    ],

    'stand-tasarim-kurulum' => [
        'tr' => <<<'HTML'
<p class="lead">İç teknik ekibimizle 100+ stand kurulumu. Markanıza özel <strong>3D tasarımdan üretime, lojistikten saha kurulumuna</strong> tüm aşamaları tek noktadan yönetiyoruz.</p>

<h2>Stand Tipleri</h2>
<ul>
  <li><strong>Hazır Modüler Stand:</strong> Stand kataloğumuzdan seçim — 3×2m, 6×2m, 9×2m, 6×4m ada</li>
  <li><strong>Modüler Sistem (Maxima, Octanorm):</strong> Hızlı kurulum, esnek konfigürasyon</li>
  <li><strong>Özel Yapım Ahşap Stand:</strong> Markaya özel premium tasarım</li>
  <li><strong>Hibrit Stand:</strong> Modüler altyapı + özel detaylar</li>
  <li><strong>İki Katlı Stand:</strong> Yüksek görünürlük, VIP karşılama alanı</li>
</ul>

<h2>Süreç</h2>
<ol>
  <li><strong>Brief Toplantısı:</strong> Marka kimliği, fuar hedefi, ölçü, bütçe</li>
  <li><strong>3D Tasarım (5-10 iş günü):</strong> Photorealistic render, 360° görünüm, revizyonlar</li>
  <li><strong>Onay &amp; Üretim Planı:</strong> Malzeme listesi, üretim takvimi</li>
  <li><strong>Üretim (15-25 gün):</strong> Atölyemizde — ahşap, alüminyum, baskı, grafik</li>
  <li><strong>Lojistik:</strong> KKTC içi nakliye veya yurt dışına gönderim</li>
  <li><strong>Saha Kurulumu:</strong> Fuar açılışından 24-48 saat önce — teknik ekip sahada</li>
  <li><strong>Etkinlik Sırasında:</strong> 7/24 teknik destek</li>
  <li><strong>Demontaj:</strong> Fuar bitiminden hemen sonra söküm + depolama</li>
</ol>

<h2>Sunduğumuz Tasarım Hizmetleri</h2>
<ul>
  <li>3D rendering (Cinema 4D, V-Ray)</li>
  <li>Teknik çizim (AutoCAD)</li>
  <li>Marka grafikleri ve baskı</li>
  <li>Aydınlatma planlaması (LED spot, neon, RGB efekt)</li>
  <li>Mobilya seçimi (vitrin, masa, koltuk, bar)</li>
  <li>AV entegrasyonu (LED ekran, video wall, ses sistemi)</li>
  <li>İnteraktif elementler (touchscreen, AR/VR, dijital broşür)</li>
</ul>

<h2>Üretim Atölyemiz</h2>
<p>Lefkoşa merkezindeki 800 m² atölyemizde tüm üretim aşamaları kontrolümüzde:</p>
<ul>
  <li>Ahşap CNC işleme</li>
  <li>Boya ve cila</li>
  <li>Alüminyum profil kesim</li>
  <li>Geniş format dijital baskı</li>
  <li>Test kurulumu (fuara gitmeden önce)</li>
</ul>

<p><em>Her stand için <strong>fiyat-performans</strong>, <strong>marka uyumu</strong> ve <strong>operasyonel kolaylık</strong> dengesinde en doğru teklifi çıkarıyoruz.</em></p>
HTML,
        'en' => <<<'HTML'
<p class="lead">100+ stand installations with our in-house technical team. From <strong>3D design to production, logistics to on-site build</strong>, we manage every stage from a single point of contact, tailored to your brand.</p>

<h2>Stand Types</h2>
<ul>
  <li><strong>Ready Modular Stand:</strong> Pick from our stand catalogue — 3×2m, 6×2m, 9×2m, 6×4m island</li>
  <li><strong>Modular System (Maxima, Octanorm):</strong> Fast assembly, flexible configuration</li>
  <li><strong>Custom-Built Wooden Stand:</strong> Brand-specific premium design</li>
  <li><strong>Hybrid Stand:</strong> Modular base + custom details</li>
  <li><strong>Two-Storey Stand:</strong> High visibility, VIP reception area</li>
</ul>

<h2>Process</h2>
<ol>
  <li><strong>Brief Meeting:</strong> Brand identity, fair goal, dimensions, budget</li>
  <li><strong>3D Design (5-10 working days):</strong> Photorealistic render, 360° view, revisions</li>
  <li><strong>Approval &amp; Production Plan:</strong> Material list, production schedule</li>
  <li><strong>Production (15-25 days):</strong> In our workshop — wood, aluminium, print, graphics</li>
  <li><strong>Logistics:</strong> Within North Cyprus or international shipping</li>
  <li><strong>On-Site Build:</strong> 24-48 hours before fair opening — technical team on site</li>
  <li><strong>During Event:</strong> 24/7 technical support</li>
  <li><strong>Dismantling:</strong> Immediately after fair — disassembly + storage</li>
</ol>

<h2>Design Services</h2>
<ul>
  <li>3D rendering (Cinema 4D, V-Ray)</li>
  <li>Technical drawing (AutoCAD)</li>
  <li>Brand graphics and print</li>
  <li>Lighting design (LED spot, neon, RGB effect)</li>
  <li>Furniture selection (showcase, table, chair, bar)</li>
  <li>AV integration (LED screen, video wall, sound system)</li>
  <li>Interactive elements (touchscreen, AR/VR, digital brochure)</li>
</ul>

<h2>Our Production Workshop</h2>
<p>Every production stage is under our control in our 800 m² Nicosia workshop:</p>
<ul>
  <li>CNC wood machining</li>
  <li>Paint and finish</li>
  <li>Aluminium profile cutting</li>
  <li>Wide-format digital printing</li>
  <li>Test assembly (before shipping to the fair)</li>
</ul>

<p><em>For every stand we balance <strong>cost-effectiveness</strong>, <strong>brand alignment</strong> and <strong>operational simplicity</strong> in our proposal.</em></p>
HTML,
    ],

    'fuar-katilim-danismanligi' => [
        'tr' => <<<'HTML'
<p class="lead">Fuara hazırlıksız gitmek <strong>yatırım kaybı</strong> demektir. Stratejiden ROI hesabına, hazırlıktan etkinlik sonrası lead takibine — fuarınızı yatırım haline getiriyoruz.</p>

<h2>Hangi Sorunları Çözüyoruz?</h2>
<ul>
  <li>"Hangi fuara katılmalıyım?" — Sektörünüze uygun fuar haritalama</li>
  <li>"Hangi büyüklükte stand alayım?" — Bütçe/hedef analizi</li>
  <li>"Standımda ne sergileyeyim?" — Ürün seçim stratejisi</li>
  <li>"Personeli nasıl eğiteyim?" — Stand görevlisi performans planı</li>
  <li>"ROI nasıl ölçerim?" — Lead skorlama ve dönüş hesabı</li>
</ul>

<h2>Danışmanlık Paketleri</h2>

<h3>1. Stratejik Planlama</h3>
<ul>
  <li>Sektör fuar takvimi (yurt içi + yurt dışı)</li>
  <li>Maliyet-fayda matrisi</li>
  <li>Yıllık fuar takvim önerisi</li>
  <li>Rakip analizi (geçmiş katılımları)</li>
</ul>

<h3>2. Etkinlik Öncesi Hazırlık (4-8 hafta)</h3>
<ul>
  <li>Stand brifi yazımı</li>
  <li>Hedef ziyaretçi profili tanımlama</li>
  <li>Ön-davet kampanyası (existing müşteriler + sektör daveti)</li>
  <li>Demo / sunum hazırlığı</li>
  <li>Stand görevlisi oryantasyonu</li>
  <li>Kontrol listeleri (lojistik, ekipman, personel)</li>
</ul>

<h3>3. Saha Desteği</h3>
<ul>
  <li>İlk gün stand kontrol</li>
  <li>Performans takibi (günlük lead/ziyaretçi)</li>
  <li>Sahada operasyon koordinasyonu</li>
  <li>Sorun çözme (eksik ekipman, personel değişimi)</li>
</ul>

<h3>4. Etkinlik Sonrası Takip</h3>
<ul>
  <li>Lead skorlama ve segmentasyon</li>
  <li>Otomatik teşekkür &amp; takip e-postaları</li>
  <li>30/60/90 günlük dönüş raporu</li>
  <li>ROI hesaplaması (gelir/maliyet)</li>
  <li>Bir sonraki fuar için ders/iyileştirme</li>
</ul>

<h2>Kim İçin?</h2>
<ul>
  <li>İlk kez fuara katılan firmalar</li>
  <li>Sürekli katılım yapan ama dönüşüm alamadığını düşünen markalar</li>
  <li>Yurt dışı fuarlara açılmak isteyen yerli firmalar</li>
  <li>Sektör değişikliği veya yeni ürün lansmanı planlayanlar</li>
</ul>

<h2>Kazandırdıklarımız</h2>
<ul>
  <li>Ortalama %35 daha fazla nitelikli lead</li>
  <li>Fuar sonrası dönüş oranında 2-3 kat iyileşme</li>
  <li>Stand maliyetinde ortalama %15-20 tasarruf (akıllı seçim)</li>
  <li>Personel başına dönüşüm artışı</li>
</ul>
HTML,
        'en' => <<<'HTML'
<p class="lead">Going to a fair unprepared means <strong>wasted investment</strong>. From strategy to ROI calculation, from preparation to post-event lead follow-up — we turn your fair appearance into a measurable investment.</p>

<h2>Problems We Solve</h2>
<ul>
  <li>"Which fair should I attend?" — Sector-relevant fair mapping</li>
  <li>"What stand size should I get?" — Budget/goal analysis</li>
  <li>"What should I exhibit?" — Product selection strategy</li>
  <li>"How do I train my team?" — Stand staff performance plan</li>
  <li>"How do I measure ROI?" — Lead scoring and return calculation</li>
</ul>

<h2>Consulting Packages</h2>

<h3>1. Strategic Planning</h3>
<ul>
  <li>Sector fair calendar (domestic + international)</li>
  <li>Cost-benefit matrix</li>
  <li>Annual fair calendar recommendation</li>
  <li>Competitor analysis (past participations)</li>
</ul>

<h3>2. Pre-Event Preparation (4-8 weeks)</h3>
<ul>
  <li>Stand brief writing</li>
  <li>Target visitor profile definition</li>
  <li>Pre-invitation campaign (existing customers + sector outreach)</li>
  <li>Demo / presentation preparation</li>
  <li>Stand staff orientation</li>
  <li>Checklists (logistics, equipment, personnel)</li>
</ul>

<h3>3. On-Site Support</h3>
<ul>
  <li>Day-one stand inspection</li>
  <li>Performance tracking (daily leads/visitors)</li>
  <li>On-site operations coordination</li>
  <li>Problem solving (missing equipment, staff changes)</li>
</ul>

<h3>4. Post-Event Follow-Up</h3>
<ul>
  <li>Lead scoring and segmentation</li>
  <li>Automated thank-you &amp; follow-up emails</li>
  <li>30/60/90-day return report</li>
  <li>ROI calculation (revenue/cost)</li>
  <li>Lessons / improvements for next fair</li>
</ul>

<h2>Who is this for?</h2>
<ul>
  <li>Companies attending a fair for the first time</li>
  <li>Frequent exhibitors who feel they're not getting conversions</li>
  <li>Local companies planning to enter international fairs</li>
  <li>Companies with sector pivots or new product launches</li>
</ul>

<h2>Outcomes Our Clients See</h2>
<ul>
  <li>~35% more qualified leads on average</li>
  <li>2-3× improvement in post-fair conversion</li>
  <li>15-20% savings in stand cost (through smart selection)</li>
  <li>Higher per-staff conversion rate</li>
</ul>
HTML,
    ],

    'hostes-stand-gorevlisi' => [
        'tr' => <<<'HTML'
<p class="lead">Eğitimli, profesyonel saha kadromuz; karşılamadan ürün demosuna, lead toplamadan VIP eskortluğa kadar <strong>standınızın yüzü</strong> olur.</p>

<h2>Sunduğumuz Personel</h2>

<h3>Hostes</h3>
<ul>
  <li>Karşılama ve yönlendirme</li>
  <li>Broşür dağıtımı</li>
  <li>Genel bilgi sunumu</li>
  <li>Ziyaretçi kayıt (form / dijital)</li>
  <li>Çay/kahve servisi</li>
</ul>

<h3>Stand Görevlisi (Brand Ambassador)</h3>
<ul>
  <li>Ürün/hizmet bilgisi</li>
  <li>Lead toplama ve niteleme</li>
  <li>Demo ve sunum yapma</li>
  <li>Soru-cevap yönetimi</li>
  <li>Müşteri ilişkilerinin başlatılması</li>
</ul>

<h3>MC / Sahne Sunucusu</h3>
<ul>
  <li>Açılış ve kapanış konuşmaları</li>
  <li>Konuşmacı tanıtımı</li>
  <li>Sahne yönetimi</li>
  <li>İnteraktif moderasyon</li>
</ul>

<h3>VIP &amp; Protokol Hostesleri</h3>
<ul>
  <li>Üst düzey misafir karşılama</li>
  <li>Özel transfer ve eskortluk</li>
  <li>Tercüme desteği (TR-EN-RU)</li>
</ul>

<h3>Diğer Saha Kadrosu</h3>
<ul>
  <li>Tercüman (TR-EN-RU-AR-DE)</li>
  <li>Stand teknik destek personeli</li>
  <li>Güvenlik elemanı</li>
  <li>Temizlik ve bakım personeli</li>
</ul>

<h2>Eğitim Süreci</h2>
<p>Tüm personelimiz fuara çıkmadan önce <strong>iki aşamalı eğitim</strong>den geçer:</p>
<ol>
  <li><strong>Genel Eğitim:</strong> Fuar etiği, vücut dili, kıyafet kuralları, müşteri iletişimi</li>
  <li><strong>Marka Brifi:</strong> Müşteri ürün/hizmet bilgisi, sıkça sorulan sorular, hedef kitle, lead niteleme kriterleri</li>
</ol>

<h2>Kadro Profili</h2>
<ul>
  <li>Çoğu üniversite öğrencisi/mezunu — üniversitelerle organize işbirliğimiz var</li>
  <li>Sektör tecrübesi olanlardan oluşan core kadro</li>
  <li>Yabancı dil bilen seçenek (TR-EN minimum, çoğu TR-EN-RU)</li>
  <li>Kurumsal kıyafet, profesyonel görünüm</li>
</ul>

<h2>Süreç</h2>
<ol>
  <li><strong>İhtiyaç Toplantısı:</strong> Personel sayısı, profil, dil, kıyafet</li>
  <li><strong>Aday Sunumu:</strong> 2-3 katı aday CV/foto sunumu</li>
  <li><strong>Müşteri Onayı:</strong> Kısa görüşme veya video</li>
  <li><strong>Marka Brifi:</strong> Etkinlikten 1-3 gün önce</li>
  <li><strong>Etkinlik:</strong> Sahada günlük süpervizyon</li>
  <li><strong>Performans Raporu:</strong> Etkinlik sonrası geri bildirim</li>
</ol>

<h2>Esneklik</h2>
<ul>
  <li>1 günlük → 2 haftalık ihtiyaçlara uyumlu</li>
  <li>Yedek kadro garantisi (hastalık vs durumlarda)</li>
  <li>Vardiyalı çalışma planlaması</li>
  <li>Saatlik veya günlük ücretlendirme</li>
</ul>
HTML,
        'en' => <<<'HTML'
<p class="lead">Trained, professional field staff who become <strong>the face of your stand</strong> — from welcoming guests and product demos to lead capture and VIP escort.</p>

<h2>Our Personnel</h2>

<h3>Hostess</h3>
<ul>
  <li>Welcoming and guidance</li>
  <li>Brochure distribution</li>
  <li>General information</li>
  <li>Visitor registration (form / digital)</li>
  <li>Tea/coffee service</li>
</ul>

<h3>Stand Staff (Brand Ambassador)</h3>
<ul>
  <li>Product/service knowledge</li>
  <li>Lead capture and qualification</li>
  <li>Demo and presentation delivery</li>
  <li>Q&amp;A management</li>
  <li>Initiating customer relationships</li>
</ul>

<h3>MC / Stage Host</h3>
<ul>
  <li>Opening and closing remarks</li>
  <li>Speaker introductions</li>
  <li>Stage management</li>
  <li>Interactive moderation</li>
</ul>

<h3>VIP &amp; Protocol Hostesses</h3>
<ul>
  <li>Senior guest welcoming</li>
  <li>Private transfer and escort</li>
  <li>Translation support (TR-EN-RU)</li>
</ul>

<h3>Other Field Staff</h3>
<ul>
  <li>Interpreters (TR-EN-RU-AR-DE)</li>
  <li>Stand technical support staff</li>
  <li>Security personnel</li>
  <li>Cleaning and maintenance staff</li>
</ul>

<h2>Training Process</h2>
<p>All personnel undergo <strong>two-stage training</strong> before stepping onto a fair floor:</p>
<ol>
  <li><strong>General Training:</strong> Fair etiquette, body language, dress code, customer communication</li>
  <li><strong>Brand Brief:</strong> Client product/service knowledge, FAQs, target audience, lead qualification criteria</li>
</ol>

<h2>Staff Profile</h2>
<ul>
  <li>Many are university students/graduates — we have organised partnerships with universities</li>
  <li>Core team of sector-experienced professionals</li>
  <li>Multilingual options (TR-EN minimum, most TR-EN-RU)</li>
  <li>Corporate attire, professional presentation</li>
</ul>

<h2>Process</h2>
<ol>
  <li><strong>Needs Meeting:</strong> Headcount, profile, language, dress code</li>
  <li><strong>Candidate Presentation:</strong> 2-3× the headcount in CV/photo shortlist</li>
  <li><strong>Client Approval:</strong> Short interview or video</li>
  <li><strong>Brand Brief:</strong> 1-3 days before event</li>
  <li><strong>Event:</strong> Daily on-site supervision</li>
  <li><strong>Performance Report:</strong> Post-event feedback</li>
</ol>

<h2>Flexibility</h2>
<ul>
  <li>1 day → 2 week assignments</li>
  <li>Backup staff guarantee (illness etc.)</li>
  <li>Shift planning</li>
  <li>Hourly or daily billing</li>
</ul>
HTML,
    ],

    'pr-tanitim' => [
        'tr' => <<<'HTML'
<p class="lead">Etkinliğinizin görünürlüğünü <strong>etkinlikten önce, sırasında ve sonrasında</strong> profesyonel iletişim yönetimiyle sağlıyoruz. Basın bülteninden sosyal medyaya, influencer işbirliğinden TV/radyo röportajlarına — tek elden.</p>

<h2>Hizmet Kategorileri</h2>

<h3>1. Basın &amp; Medya İlişkileri</h3>
<ul>
  <li>Basın bülteni yazımı (TR-EN)</li>
  <li>Yerel ve ulusal medya dağıtımı</li>
  <li>Basın daveti ve etkinlik sırasında karşılama</li>
  <li>Röportaj koordinasyonu (TV, radyo, online)</li>
  <li>Yayın takibi ve clipping raporu</li>
</ul>

<h3>2. Sosyal Medya</h3>
<ul>
  <li>Etkinlik öncesi tanıtım kampanyası</li>
  <li>Canlı yayın (Instagram, Facebook, LinkedIn)</li>
  <li>Reels / TikTok kısa video üretimi</li>
  <li>Hashtag stratejisi ve trend yönetimi</li>
  <li>Etkinlik sonrası özet içerikler</li>
</ul>

<h3>3. İçerik Üretimi</h3>
<ul>
  <li>Profesyonel fotoğraf çekimi</li>
  <li>Drone çekimi</li>
  <li>Etkinlik özet videosu (after-movie)</li>
  <li>Konuşmacı/katılımcı röportaj kayıtları</li>
  <li>Grafik ve infografik tasarımı</li>
</ul>

<h3>4. Influencer &amp; KOL İşbirlikleri</h3>
<ul>
  <li>Sektörünüze uygun influencer haritalama</li>
  <li>İçerik brifi ve onay süreci</li>
  <li>Brand ambassador anlaşmaları</li>
  <li>Performans ölçümü (reach, engagement, conversion)</li>
</ul>

<h3>5. Reklam &amp; Görünürlük</h3>
<ul>
  <li>Outdoor reklam (billboard, megapost, raket)</li>
  <li>Dijital reklam (Meta, Google, YouTube)</li>
  <li>Radyo &amp; TV spotu üretim ve yayın</li>
  <li>Sektör yayınlarında advertorial</li>
</ul>

<h2>Süreç</h2>
<ol>
  <li><strong>İletişim Stratejisi (etkinlikten 8-12 hafta önce):</strong> Hedef kitle, mesaj, kanal seçimi, KPI'lar</li>
  <li><strong>İçerik Üretimi (4-6 hafta):</strong> Görsel, video, basın bülteni, sosyal medya planı</li>
  <li><strong>Lansman Kampanyası (3-4 hafta):</strong> Reklam, influencer, basın daveti</li>
  <li><strong>Etkinlik Sırasında:</strong> Canlı yayın, anlık içerik, basın koordinasyonu</li>
  <li><strong>Etkinlik Sonrası:</strong> Özet rapor, after-movie, medya yansımaları</li>
</ol>

<h2>Etkinlik Tipleri</h2>
<ul>
  <li>Sektörel fuarlar</li>
  <li>Kongre ve sempozyumlar</li>
  <li>Ürün lansmanları</li>
  <li>Kurumsal etkinlikler (yıldönümü, ödül, gala)</li>
  <li>Spor ve kültür etkinlikleri</li>
</ul>

<h2>Performans Metrikleri</h2>
<ul>
  <li>Toplam reach (sosyal + medya)</li>
  <li>Engagement rate</li>
  <li>Earned media değeri (PR value)</li>
  <li>Marka anılma sayısı (brand mention)</li>
  <li>Web sitesi trafik artışı</li>
  <li>Etkinlik kayıt/satış dönüşümü</li>
</ul>
HTML,
        'en' => <<<'HTML'
<p class="lead">We deliver event visibility <strong>before, during and after</strong> through professional communications management. From press releases to social media, influencer partnerships to TV/radio interviews — under one roof.</p>

<h2>Service Categories</h2>

<h3>1. Press &amp; Media Relations</h3>
<ul>
  <li>Press release writing (TR-EN)</li>
  <li>Local and national media distribution</li>
  <li>Press invitations and on-site reception</li>
  <li>Interview coordination (TV, radio, online)</li>
  <li>Coverage tracking and clipping report</li>
</ul>

<h3>2. Social Media</h3>
<ul>
  <li>Pre-event awareness campaign</li>
  <li>Live streaming (Instagram, Facebook, LinkedIn)</li>
  <li>Reels / TikTok short-form video production</li>
  <li>Hashtag strategy and trend management</li>
  <li>Post-event recap content</li>
</ul>

<h3>3. Content Production</h3>
<ul>
  <li>Professional photography</li>
  <li>Drone footage</li>
  <li>Event after-movie</li>
  <li>Speaker/attendee interview recordings</li>
  <li>Graphic and infographic design</li>
</ul>

<h3>4. Influencer &amp; KOL Partnerships</h3>
<ul>
  <li>Sector-relevant influencer mapping</li>
  <li>Content brief and approval process</li>
  <li>Brand ambassador deals</li>
  <li>Performance measurement (reach, engagement, conversion)</li>
</ul>

<h3>5. Advertising &amp; Visibility</h3>
<ul>
  <li>Outdoor advertising (billboard, megapost, rakets)</li>
  <li>Digital ads (Meta, Google, YouTube)</li>
  <li>Radio &amp; TV spot production and placement</li>
  <li>Advertorials in industry publications</li>
</ul>

<h2>Process</h2>
<ol>
  <li><strong>Communications Strategy (8-12 weeks before):</strong> Audience, message, channels, KPIs</li>
  <li><strong>Content Production (4-6 weeks):</strong> Visuals, video, press release, social media plan</li>
  <li><strong>Launch Campaign (3-4 weeks):</strong> Ads, influencers, press invitations</li>
  <li><strong>During the Event:</strong> Live coverage, real-time content, press coordination</li>
  <li><strong>Post-Event:</strong> Summary report, after-movie, media coverage</li>
</ol>

<h2>Event Types</h2>
<ul>
  <li>Sector trade fairs</li>
  <li>Congresses and symposia</li>
  <li>Product launches</li>
  <li>Corporate events (anniversaries, awards, galas)</li>
  <li>Sports and culture events</li>
</ul>

<h2>Performance Metrics</h2>
<ul>
  <li>Total reach (social + media)</li>
  <li>Engagement rate</li>
  <li>Earned media value (PR value)</li>
  <li>Brand mention count</li>
  <li>Website traffic uplift</li>
  <li>Event registration/sales conversion</li>
</ul>
HTML,
    ],
];

DB::connect();
$updated = 0;
foreach ($services as $slug => $content) {
    $rows = DB::execute(
        "UPDATE services SET content_tr = ?, content_en = ?, updated_at = NOW() WHERE slug = ?",
        [$content['tr'], $content['en'], $slug]
    );
    if ($rows > 0) {
        $updated++;
        echo "✓ $slug — guncellendi\n";
    } else {
        echo "✗ $slug — bulunamadi\n";
    }
}
echo "\nToplam $updated hizmet guncellendi.\n";
