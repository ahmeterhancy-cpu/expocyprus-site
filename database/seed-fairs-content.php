<?php
/**
 * Fairs detail content seeder.
 * Run once: php database/seed-fairs-content.php
 *
 * 4 fuarın hero ve içerik alanlarını genel bilgilerle doldurur.
 * UPSERT mantığı: zaten dolu olan alanları KORUR, sadece boş olanları doldurur.
 */
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    foreach (parse_ini_file($envFile) as $k => $v) {
        putenv("$k=$v");
    }
}
define('BASE_PATH', dirname(__DIR__));

use App\Core\DB;

$fairs = [
    // ────────────────────────────────────────────────────────
    'tuketici-fuari' => [
        'icon'           => '🛒',
        'accent_color'   => '#E30613',
        'location'       => 'Lefkoşa, Kuzey Kıbrıs',
        'hero_eyebrow_tr'=> "KKTC'NİN EN BÜYÜK GENEL FUARI",
        'hero_eyebrow_en'=> "NORTHERN CYPRUS'S LARGEST GENERAL FAIR",
        'hero_tagline_tr'=> 'Tüm Sektörler. Tek Çatı Altında.',
        'hero_tagline_en'=> 'All Sectors. Under One Roof.',
        'hero_subline_tr'=> 'Yiyecekten teknolojiye, mobilyadan otomotive — Kıbrıs\'ın en kapsamlı tüketici fuarında binlerce ziyaretçi yüzlerce markayla buluşuyor.',
        'hero_subline_en'=> 'From food to tech, furniture to automotive — thousands of visitors meet hundreds of brands at Cyprus\'s most comprehensive consumer fair.',
        'meta_title_tr'  => 'Tüketici Fuarı | KKTC Genel Tüketici Fuarı',
        'meta_title_en'  => 'Consumer Fair | Northern Cyprus General Trade Fair',
        'meta_desc_tr'   => 'KKTC\'nin en büyük tüketici fuarı. 12+ sektör, 150+ marka, 30.000+ ziyaretçi. Yiyecek, mobilya, teknoloji, otomotiv ve daha fazlası.',
        'meta_desc_en'   => 'Cyprus\'s largest consumer fair. 12+ sectors, 150+ brands, 30.000+ visitors. Food, furniture, tech, automotive and more.',
        'stats_json'     => json_encode([
            'ziyaretci' => '30.000+', 'katilimci' => '150+', 'sektor' => '12+', 'metrekare' => '8.000m²'
        ], JSON_UNESCAPED_UNICODE),
        'content_tr'     => <<<'HTML'
<p class="lead">Tüketici Fuarı, Kuzey Kıbrıs'ın <strong>en kapsamlı çok sektörlü tüketici fuarı</strong>. 22 yıllık deneyimimizle düzenlediğimiz fuar, halkı sektörlerin önde gelen markalarıyla bir araya getiriyor.</p>

<h2>Fuar Hakkında</h2>
<p>Yıllık olarak düzenlenen Tüketici Fuarı, KKTC ekonomisinin nabzını tutan bir buluşma noktası. Yerel ve uluslararası markalar; gıda, mobilya, ev tekstili, beyaz eşya, teknoloji, otomotiv, kozmetik, hediyelik eşya, sağlık, eğitim, turizm ve finans olmak üzere 12 ayrı sektörde ürün ve hizmetlerini sergiliyor.</p>

<h2>Katılımcı Sektörler</h2>
<ul>
  <li><strong>Gıda &amp; İçecek:</strong> Yerel üreticiler, gurme markalar, organik gıda, içecek</li>
  <li><strong>Mobilya &amp; Dekorasyon:</strong> Ev mobilyası, ofis, mutfak, yatak, aydınlatma</li>
  <li><strong>Beyaz Eşya &amp; Elektronik:</strong> Büyük ev aletleri, mutfak teknolojileri, klima</li>
  <li><strong>Teknoloji &amp; Telekomünikasyon:</strong> Akıllı ev, telefon, bilgisayar, internet hizmetleri</li>
  <li><strong>Otomotiv:</strong> Otomobil galerileri, lastik, aksesuar, oto bakım</li>
  <li><strong>Kozmetik &amp; Kişisel Bakım:</strong> Parfüm, cilt bakımı, makyaj, saç ürünleri</li>
  <li><strong>Sağlık &amp; Spor:</strong> Eczane ürünleri, fitness, beslenme, sağlık merkezleri</li>
  <li><strong>Eğitim &amp; Turizm:</strong> Üniversiteler, dil okulları, tatil paketleri, oteller</li>
  <li><strong>Finans &amp; Sigorta:</strong> Bankalar, sigorta, leasing, yatırım</li>
</ul>

<h2>Neden Katılmalısınız?</h2>
<p>Tüketici Fuarı, KKTC'de hedef kitlenize doğrudan ulaşmanın en hızlı yolu. 4 gün boyunca <strong>30.000'i aşkın ziyaretçi</strong> standınızı geziyor; ürününüzü canlı deneyimliyor, soru soruyor, satın alıyor.</p>

<ul>
  <li><strong>Marka Bilinirliği:</strong> Toplu ve odaklı medya görünürlüğü</li>
  <li><strong>Direkt Satış:</strong> Fuar fiyatlandırması ile yoğun kampanya satışı</li>
  <li><strong>Lead Toplama:</strong> Potansiyel müşteri veritabanı oluşturma</li>
  <li><strong>Pazar Araştırması:</strong> Tüketici geri bildirimi, rakip analizi</li>
  <li><strong>Bayi &amp; Distribütör:</strong> KKTC genelinde dağıtım ağı geliştirme</li>
</ul>

<h2>Stand Seçenekleri</h2>
<p>3m² kompakt köşe stand'dan 100m² özel tasarım kurguya kadar — bütçe ve marka konseptinize uygun çözümler sunuyoruz. <a href="/teklif-al">Stand teklifi alın</a> veya <a href="/iletisim">bize ulaşın</a>.</p>
HTML,
        'content_en'     => <<<'HTML'
<p class="lead">The Consumer Fair is Northern Cyprus's <strong>most comprehensive multi-sector consumer fair</strong>. With 22 years of experience, we bring together the public with leading brands across all sectors.</p>

<h2>About the Fair</h2>
<p>Held annually, the Consumer Fair is a gathering point that takes the pulse of Northern Cyprus's economy. Local and international brands exhibit products and services across 12 sectors: food, furniture, home textiles, white goods, technology, automotive, cosmetics, gifts, health, education, tourism and finance.</p>

<h2>Participating Sectors</h2>
<ul>
  <li><strong>Food &amp; Beverage:</strong> Local producers, gourmet brands, organic food, beverages</li>
  <li><strong>Furniture &amp; Decor:</strong> Home, office, kitchen, bedroom, lighting</li>
  <li><strong>White Goods &amp; Electronics:</strong> Major appliances, kitchen tech, climate</li>
  <li><strong>Technology &amp; Telecom:</strong> Smart home, mobile, computing, ISPs</li>
  <li><strong>Automotive:</strong> Auto dealers, tyres, accessories, service</li>
  <li><strong>Cosmetics &amp; Personal Care:</strong> Perfume, skincare, makeup, hair</li>
  <li><strong>Health &amp; Sports:</strong> Pharmacy, fitness, nutrition, clinics</li>
  <li><strong>Education &amp; Tourism:</strong> Universities, language schools, holidays, hotels</li>
  <li><strong>Finance &amp; Insurance:</strong> Banks, insurance, leasing, investment</li>
</ul>

<h2>Why Participate?</h2>
<p>The Consumer Fair is the fastest way to reach your target audience in Northern Cyprus. Over <strong>30,000 visitors</strong> walk the floor across 4 days, experiencing your product first-hand, asking questions, buying.</p>

<ul>
  <li><strong>Brand Awareness:</strong> Concentrated, focused media exposure</li>
  <li><strong>Direct Sales:</strong> Fair pricing drives heavy campaign sales</li>
  <li><strong>Lead Generation:</strong> Build your prospect database</li>
  <li><strong>Market Research:</strong> Consumer feedback and competitor analysis</li>
  <li><strong>Dealer &amp; Distributor:</strong> Expand your distribution network island-wide</li>
</ul>

<h2>Stand Options</h2>
<p>From compact 3m² corner booths to 100m² custom-built showcases — we offer solutions tailored to your budget and brand concept. <a href="/en/teklif-al">Get a stand quote</a> or <a href="/en/iletisim">contact us</a>.</p>
HTML,
    ],

    // ────────────────────────────────────────────────────────
    'av-avcilik-atis-doga-sporlari-fuari' => [
        'icon'           => '🎯',
        'accent_color'   => '#0F4C2E',
        'location'       => 'Lefkoşa, Kuzey Kıbrıs',
        'hero_eyebrow_tr'=> "KIBRIS'IN TEK İHTİSAS FUARI",
        'hero_eyebrow_en'=> "CYPRUS'S ONLY SPECIALIST FAIR",
        'hero_tagline_tr'=> 'Av, Atış ve Doğa Sporlarının Adresi.',
        'hero_tagline_en'=> 'Home of Hunting, Shooting & Outdoor Sports.',
        'hero_subline_tr'=> 'Av tüfeklerinden optik ekipmana, doğa sporlarından kamp malzemelerine — sektörün öncü markaları, profesyonel kadrosu ve binlerce avcı, atıcı ve doğa sporcusu bir araya geliyor.',
        'hero_subline_en'=> 'From shotguns to optics, outdoor sports to camping gear — leading brands, professional teams and thousands of hunters, shooters and outdoor enthusiasts come together.',
        'meta_title_tr'  => 'Av, Avcılık, Atıcılık & Doğa Sporları Fuarı | Kıbrıs',
        'meta_title_en'  => 'Hunting, Shooting & Outdoor Sports Fair | Cyprus',
        'meta_desc_tr'   => 'KKTC\'nin tek av ve doğa sporları ihtisas fuarı. Av tüfekleri, optik, kamp, doğa sporları. 12.000+ ziyaretçi, 60+ marka.',
        'meta_desc_en'   => 'Cyprus\'s only specialist hunting and outdoor fair. Shotguns, optics, camping, outdoor sports. 12,000+ visitors, 60+ brands.',
        'stats_json'     => json_encode([
            'ziyaretci' => '12.000+', 'katilimci' => '60+', 'sektor' => 'Av · Atış · Doğa', 'tecrube' => '10. Yıl'
        ], JSON_UNESCAPED_UNICODE),
        'content_tr'     => <<<'HTML'
<p class="lead">Av, Avcılık, Atıcılık &amp; Doğa Sporları Fuarı, Kıbrıs'taki <strong>tek ihtisas av fuarı</strong>. Sektörün profesyonelleri, ithalatçılar, bayiler ve binlerce tutkulu avcı tek çatı altında buluşuyor.</p>

<h2>Sergilenen Ürün Grupları</h2>
<ul>
  <li><strong>Av Tüfekleri &amp; Tabancalar:</strong> Beretta, Benelli, Browning, Sako, CZ ve daha fazlası</li>
  <li><strong>Mühimmat &amp; Şarjör:</strong> Saçma, kurşun, hassasiyet mühimmatı, reload ekipmanı</li>
  <li><strong>Optik:</strong> Dürbün, nişangah, termal kamera, lazer mesafe ölçer</li>
  <li><strong>Av Giyim &amp; Aksesuar:</strong> Kamuflaj, su geçirmez, sıcak tutucu, çizme</li>
  <li><strong>Av Köpekleri &amp; Eğitim:</strong> Köpek aksesuarları, beslenme, GPS takip</li>
  <li><strong>Doğa Sporları:</strong> Trekking, kamp, tırmanış, oltacılık ekipmanı</li>
  <li><strong>Kasalar &amp; Güvenlik:</strong> Silah dolapları, taşıma çantaları, güvenlik kilitleri</li>
  <li><strong>Drone &amp; Teknoloji:</strong> Av için drone, kamera tuzakları, GPS</li>
</ul>

<h2>Ziyaretçi Profili</h2>
<p>Fuara katılan binlerce ziyaretçinin %85'i aktif av lisansı sahibi. Hedef kitle son derece odaklı: <strong>satın alma niyeti yüksek, marka bağımlılığı düşük</strong>. Ziyaretçi profili — av kulüpleri üyeleri, doğa sporcuları, koleksiyonerler, sportif atıcılar, askeri/güvenlik personeli.</p>

<h2>Etkinlikler</h2>
<ul>
  <li><strong>Canlı Atış Demoları:</strong> Yeni ürünlerin uzman atıcılarla gösterimi</li>
  <li><strong>Av Köpeği Yarışmaları:</strong> Pointer, retriever, spaniel kategorileri</li>
  <li><strong>Optik Test İstasyonları:</strong> Dürbün ve nişangah karşılaştırmaları</li>
  <li><strong>Atölyeler &amp; Söyleşiler:</strong> Av güvenliği, ekosistem, etik avcılık</li>
  <li><strong>Foto Yarışması:</strong> Doğa fotoğrafçılığı kategorilerinde ödüller</li>
</ul>

<h2>Katılımcılara Sunulanlar</h2>
<p>Stand kira, kurulum, teknik altyapı ve tanıtım hizmetlerini A'dan Z'ye yönetiyoruz. Katılımcılarımıza sunduklarımız:</p>
<ul>
  <li>Sektöre özel hedef kitle pazarlaması (av kulüpleri, lisanslı avcı veritabanı)</li>
  <li>Atış demosu için profesyonel atış sahası</li>
  <li>Av köpeği gösterileri için açık alan</li>
  <li>Sektörel basın ve medya partnerleri ile koordineli PR</li>
</ul>

<p><a href="/teklif-al">Stand teklifi alın</a> veya detaylar için <a href="/iletisim">iletişime geçin</a>.</p>
HTML,
        'content_en'     => <<<'HTML'
<p class="lead">The Hunting, Shooting &amp; Outdoor Sports Fair is Cyprus's <strong>only specialist hunting fair</strong>. Industry professionals, importers, dealers and thousands of passionate hunters meet under one roof.</p>

<h2>Product Categories</h2>
<ul>
  <li><strong>Shotguns &amp; Firearms:</strong> Beretta, Benelli, Browning, Sako, CZ and more</li>
  <li><strong>Ammunition &amp; Magazines:</strong> Shot, bullet, precision ammo, reload equipment</li>
  <li><strong>Optics:</strong> Binoculars, scopes, thermal cameras, laser rangefinders</li>
  <li><strong>Hunting Apparel &amp; Accessories:</strong> Camouflage, waterproof, thermal, boots</li>
  <li><strong>Hunting Dogs &amp; Training:</strong> Accessories, nutrition, GPS tracking</li>
  <li><strong>Outdoor Sports:</strong> Trekking, camping, climbing, fishing gear</li>
  <li><strong>Safes &amp; Security:</strong> Gun cabinets, carry cases, security locks</li>
  <li><strong>Drones &amp; Tech:</strong> Hunting drones, trail cameras, GPS</li>
</ul>

<h2>Visitor Profile</h2>
<p>85% of the thousands of visitors hold active hunting licences. The target audience is highly focused: <strong>high purchase intent, low brand loyalty</strong>. Profile includes hunting club members, outdoor athletes, collectors, sport shooters, military and security personnel.</p>

<h2>Events</h2>
<ul>
  <li><strong>Live Shooting Demos:</strong> Expert demonstrations of new products</li>
  <li><strong>Hunting Dog Competitions:</strong> Pointer, retriever, spaniel categories</li>
  <li><strong>Optics Test Stations:</strong> Side-by-side scope and binocular trials</li>
  <li><strong>Workshops &amp; Talks:</strong> Hunting safety, ecosystem, ethical hunting</li>
  <li><strong>Photo Contest:</strong> Awards across nature photography categories</li>
</ul>

<h2>What We Offer Exhibitors</h2>
<p>We manage stand rental, build, technical infrastructure and marketing end-to-end. We provide:</p>
<ul>
  <li>Sector-specific audience marketing (hunting clubs, licenced hunter database)</li>
  <li>Professional shooting range for live demos</li>
  <li>Outdoor area for hunting dog displays</li>
  <li>Coordinated PR with industry press and media partners</li>
</ul>

<p><a href="/en/teklif-al">Get a stand quote</a> or <a href="/en/iletisim">contact us</a> for details.</p>
HTML,
    ],

    // ────────────────────────────────────────────────────────
    'tarim-hayvancilik-fuari' => [
        'icon'           => '🌾',
        'accent_color'   => '#5B8C2A',
        'location'       => 'Lefkoşa, Kuzey Kıbrıs',
        'hero_eyebrow_tr'=> 'KIBRIS TARIMININ KALBİ',
        'hero_eyebrow_en'=> 'THE HEART OF CYPRUS AGRICULTURE',
        'hero_tagline_tr'=> 'Kıbrıs Tarımının Buluşma Noktası.',
        'hero_tagline_en'=> 'The Meeting Point of Cyprus Agriculture.',
        'hero_subline_tr'=> 'Traktör ve sulama sistemlerinden hayvan ırklarına, organik girdilerden tarım teknolojilerine — KKTC tarım ve hayvancılık sektörünün en büyük yıllık etkinliği.',
        'hero_subline_en'=> 'From tractors and irrigation to livestock breeds, organic inputs to agri-tech — Northern Cyprus\'s biggest annual agriculture and livestock event.',
        'meta_title_tr'  => 'Tarım Hayvancılık Fuarı | KKTC Tarım Sektörü Buluşması',
        'meta_title_en'  => 'Agriculture & Livestock Fair | Cyprus Agri Sector Meet',
        'meta_desc_tr'   => 'KKTC\'nin en büyük tarım ve hayvancılık fuarı. Traktör, sulama, gübre, hayvan ırkları, sera, organik tarım. 15.000+ ziyaretçi.',
        'meta_desc_en'   => 'Northern Cyprus\'s largest agri and livestock fair. Tractors, irrigation, fertiliser, livestock, greenhouse, organic. 15,000+ visitors.',
        'stats_json'     => json_encode([
            'ziyaretci' => '15.000+', 'katilimci' => '80+', 'sektor' => 'Tarım & Hayvancılık', 'uretici' => '5.000+ Çiftçi'
        ], JSON_UNESCAPED_UNICODE),
        'content_tr'     => <<<'HTML'
<p class="lead">Tarım Hayvancılık Fuarı, KKTC tarım sektörünün <strong>en büyük yıllık buluşma platformu</strong>. Üretici, ithalatçı, bayi ve çiftçiyi tek çatı altında bir araya getiriyor.</p>

<h2>Fuar Hakkında</h2>
<p>Kuzey Kıbrıs'ın temelini oluşturan tarım ve hayvancılık sektörü, son yıllarda hızlı bir teknolojik dönüşüm geçiriyor. Akıllı sulama, hassas tarım, organik üretim, modern hayvancılık tesisleri — tüm bu yeniliklerin sergilendiği fuar, hem üreticilere hem de çiftçilere yol gösteriyor.</p>

<h2>Sergilenen Sektörler</h2>
<ul>
  <li><strong>Traktör &amp; Tarım Makinaları:</strong> Çekici, biçerdöver, pulluk, ilaçlama, hasat ekipmanı</li>
  <li><strong>Sulama &amp; Damlama:</strong> Hat, vana, pompa, su deposu, otomasyon sistemleri</li>
  <li><strong>Sera Teknolojileri:</strong> Naylon, çelik konstrüksiyon, ısıtma, havalandırma, hidroponik</li>
  <li><strong>Hayvancılık:</strong> Süt sığırı, et sığırı, koyun, keçi ırkları; süt sağım, yemleme</li>
  <li><strong>Yem &amp; Beslenme:</strong> Karma yem, silaj, mineral takviyesi, vitamin</li>
  <li><strong>Tohum &amp; Fide:</strong> Sebze, meyve, hububat tohumları, fidancılık</li>
  <li><strong>Gübre &amp; İlaç:</strong> Organik, kimyasal, biyolojik mücadele ürünleri</li>
  <li><strong>Tarım Teknolojileri:</strong> Drone, IoT sensör, GPS, çiftlik yönetim yazılımı</li>
  <li><strong>Finans &amp; Sigorta:</strong> Tarım kredisi, hasat sigortası, leasing</li>
</ul>

<h2>Ziyaretçi Profili</h2>
<p>Fuara <strong>5.000'den fazla aktif çiftçi</strong>, ziraat mühendisi, kooperatif yetkilisi, hayvancılık işletmesi sahibi katılıyor. KKTC ekonomisinin tarım sektöründeki tüm karar vericileri burada.</p>

<h2>Konferanslar &amp; Atölyeler</h2>
<ul>
  <li>Akıllı sulama ve verim optimizasyonu</li>
  <li>Organik tarım sertifikasyonu ve ihracat</li>
  <li>Hayvancılık tesisi modernizasyonu</li>
  <li>İklim değişikliği ve dayanıklı bitki çeşitleri</li>
  <li>AB hibe programları ve KKTC tarım destekleri</li>
</ul>

<h2>Neden Katılmalısınız?</h2>
<p>KKTC tarım sektöründe ürün veya hizmet sağlıyorsanız, yıllık karar dönemi bu fuardır. Çiftçiler yatırım kararlarını burada alıyor; ithalatçılar bayi ağlarını burada genişletiyor; üreticiler son teknolojiyi burada görüyor.</p>

<p><a href="/teklif-al">Stand teklifi alın</a> veya <a href="/iletisim">bize ulaşın</a>.</p>
HTML,
        'content_en'     => <<<'HTML'
<p class="lead">The Agriculture &amp; Livestock Fair is Northern Cyprus's <strong>largest annual agri-sector gathering</strong>. It brings producers, importers, dealers and farmers together under one roof.</p>

<h2>About the Fair</h2>
<p>Agriculture and livestock — the foundation of Northern Cyprus — are undergoing rapid technological transformation. Smart irrigation, precision farming, organic production, modern livestock facilities — the fair showcases all these innovations and guides both producers and farmers.</p>

<h2>Exhibited Sectors</h2>
<ul>
  <li><strong>Tractors &amp; Farm Machinery:</strong> Tractors, harvesters, ploughs, sprayers</li>
  <li><strong>Irrigation &amp; Drip:</strong> Pipes, valves, pumps, tanks, automation</li>
  <li><strong>Greenhouse Tech:</strong> Plastic, steel structure, heating, ventilation, hydroponics</li>
  <li><strong>Livestock:</strong> Dairy, beef, sheep, goat breeds; milking, feeding</li>
  <li><strong>Feed &amp; Nutrition:</strong> Compound feed, silage, mineral and vitamin supplements</li>
  <li><strong>Seeds &amp; Seedlings:</strong> Vegetable, fruit, grain seeds, nursery</li>
  <li><strong>Fertiliser &amp; Pesticides:</strong> Organic, chemical, biological control</li>
  <li><strong>Agri-Tech:</strong> Drones, IoT sensors, GPS, farm management software</li>
  <li><strong>Finance &amp; Insurance:</strong> Agri-loans, crop insurance, leasing</li>
</ul>

<h2>Visitor Profile</h2>
<p>The fair welcomes over <strong>5,000 active farmers</strong>, agronomists, cooperative officials and livestock owners. All decision-makers in Northern Cyprus's agricultural economy are here.</p>

<h2>Conferences &amp; Workshops</h2>
<ul>
  <li>Smart irrigation and yield optimisation</li>
  <li>Organic certification and export</li>
  <li>Livestock facility modernisation</li>
  <li>Climate change and resilient varieties</li>
  <li>EU grants and Northern Cyprus agri-subsidies</li>
</ul>

<h2>Why Participate?</h2>
<p>If you supply products or services in Northern Cyprus's agricultural sector, this is the annual decision window. Farmers commit investment here; importers expand dealer networks here; producers see the latest tech here.</p>

<p><a href="/en/teklif-al">Get a stand quote</a> or <a href="/en/iletisim">contact us</a>.</p>
HTML,
    ],

    // ────────────────────────────────────────────────────────
    'dugun-hazirliklari-fuari' => [
        'icon'           => '💍',
        'accent_color'   => '#C2185B',
        'location'       => 'Lefkoşa, Kuzey Kıbrıs',
        'hero_eyebrow_tr'=> 'MUTLU SONLARIN BAŞLANGICI',
        'hero_eyebrow_en'=> 'WHERE HAPPILY EVER AFTER BEGINS',
        'hero_tagline_tr'=> 'Hayalinizdeki Düğün, Tek Adımda.',
        'hero_tagline_en'=> 'Your Dream Wedding, in One Step.',
        'hero_subline_tr'=> 'Gelinlik, fotoğraf, mekan, organizasyon, mücevher ve balayı — düğün için ihtiyaç duyabileceğiniz her şey, Kıbrıs\'ın en romantik fuarında.',
        'hero_subline_en'=> 'Wedding dress, photography, venue, organisation, jewellery and honeymoon — everything for your big day at Cyprus\'s most romantic fair.',
        'meta_title_tr'  => 'Evlilik & Düğün Hazırlıkları Fuarı | Kıbrıs Düğün Fuarı',
        'meta_title_en'  => 'Wedding Preparations Fair | Cyprus Wedding Fair',
        'meta_desc_tr'   => 'KKTC düğün hazırlıkları fuarı. Gelinlik, fotoğraf, mekan, mücevher, organizasyon, balayı. Tek noktada tüm düğün ihtiyaçları.',
        'meta_desc_en'   => 'Northern Cyprus wedding preparations fair. Dress, photography, venue, jewellery, organisation, honeymoon. All wedding needs in one place.',
        'stats_json'     => json_encode([
            'ziyaretci' => '10.000+', 'katilimci' => '70+', 'sektor' => 'Wedding · Events', 'kategori' => '15+ Kategori'
        ], JSON_UNESCAPED_UNICODE),
        'content_tr'     => <<<'HTML'
<p class="lead">Evlilik &amp; Düğün Hazırlıkları Fuarı, çiftlerin <strong>düğünleriyle ilgili tüm kararları tek günde verebilecekleri</strong> Kıbrıs'ın en kapsamlı düğün etkinliği.</p>

<h2>Fuar Hakkında</h2>
<p>Düğün hazırlığı stresli ve zaman alıcı bir süreç. Gelinlik mağazaları, fotoğrafçılar, mekanlar, organizasyon firmaları, kuyumcular, çiçekçiler — onlarca farklı tedarikçiyle ayrı ayrı görüşmek yerine, hepsini tek çatı altında karşılaştırma fırsatı sunuyoruz.</p>

<h2>Katılımcı Kategoriler</h2>
<ul>
  <li><strong>Gelinlik &amp; Damatlık:</strong> Tasarımcı butikler, klasik ve modern modeller, kiralama</li>
  <li><strong>Düğün Fotoğrafçılığı:</strong> Foto, video, drone çekim, save-the-date</li>
  <li><strong>Düğün Mekanı:</strong> Oteller, açık hava, tarihi mekanlar, plaj düğünleri</li>
  <li><strong>Organizasyon &amp; Konsept:</strong> Wedding planner, dekorasyon, masa düzeni</li>
  <li><strong>Mücevher &amp; Yüzük:</strong> Söz, alyans, gelin takıları, özel tasarım</li>
  <li><strong>Çiçek &amp; Süsleme:</strong> Gelin buketi, masa süslemeleri, salon dizaynı</li>
  <li><strong>Davetiye &amp; Hediyelik:</strong> Davetiye tasarımı, davetli hediyeleri, nikah şekeri</li>
  <li><strong>Yemek &amp; Pasta:</strong> Catering, davet menüleri, gelinlik pastalar</li>
  <li><strong>Müzik &amp; Eğlence:</strong> Orkestra, DJ, canlı sanatçı, ışık-ses</li>
  <li><strong>Saç &amp; Makyaj:</strong> Gelin makyajı, saç tasarımı, manikür-pedikür</li>
  <li><strong>Balayı:</strong> Tatil paketleri, otel rezervasyon, transfer</li>
  <li><strong>Ev Eşyası:</strong> Beyaz eşya, mobilya, ev tekstili paketleri</li>
</ul>

<h2>Ziyaretçi Profili</h2>
<p>Fuara <strong>5.000'i aşkın çift</strong>, ailesiyle birlikte katılım sağlıyor. Çiftler kararlarını burada alıyor: en yoğun fuarın ardından gelen 4 hafta içinde sektörün satışlarının %40'ı gerçekleşiyor.</p>

<h2>Çiftlere Sunulanlar</h2>
<ul>
  <li><strong>Fuar Özel İndirimleri:</strong> Sadece etkinlik günlerinde geçerli kampanyalar</li>
  <li><strong>Çekiliş &amp; Hediyeler:</strong> Ücretsiz fotoğraf çekimi, balayı paketleri, mücevher</li>
  <li><strong>Mini Defile &amp; Showlar:</strong> Gelinlik defileleri, makyaj demoları</li>
  <li><strong>Wedding Planner Konsültasyonları:</strong> Bütçe planlama, takvim çıkarma</li>
  <li><strong>Doğru Soruları Sorma Rehberi:</strong> Tedarikçi karşılaştırma şablonu</li>
</ul>

<h2>Katılımcı Avantajları</h2>
<p>Düğün sektöründeyseniz, bu fuar yıllık ciroyuzun büyük kısmını yapacağınız etkinlik. Çiftlerin <strong>satın alma kararı verdikleri tek pencere</strong>. Stand kira, kurulum, dekorasyon ve pazarlama hizmetlerimizle yanınızdayız.</p>

<p><a href="/teklif-al">Stand teklifi alın</a> veya <a href="/iletisim">bize ulaşın</a>.</p>
HTML,
        'content_en'     => <<<'HTML'
<p class="lead">The Wedding Preparations Fair is Cyprus's most comprehensive wedding event, where <strong>couples can make every wedding decision in a single day</strong>.</p>

<h2>About the Fair</h2>
<p>Wedding planning is stressful and time-consuming. Instead of meeting dozens of suppliers separately — wedding dress shops, photographers, venues, planners, jewellers, florists — we bring them all under one roof for easy comparison.</p>

<h2>Participating Categories</h2>
<ul>
  <li><strong>Wedding Dresses &amp; Suits:</strong> Designer boutiques, classic and modern, rentals</li>
  <li><strong>Wedding Photography:</strong> Photo, video, drone, save-the-date</li>
  <li><strong>Venues:</strong> Hotels, outdoor, historic, beach weddings</li>
  <li><strong>Organisation &amp; Concept:</strong> Wedding planners, decor, table design</li>
  <li><strong>Jewellery &amp; Rings:</strong> Engagement, wedding bands, bridal sets, custom</li>
  <li><strong>Flowers &amp; Decoration:</strong> Bouquets, centrepieces, hall design</li>
  <li><strong>Invitations &amp; Favours:</strong> Invitation design, guest gifts, wedding favours</li>
  <li><strong>Catering &amp; Cake:</strong> Catering, banquet menus, wedding cakes</li>
  <li><strong>Music &amp; Entertainment:</strong> Orchestra, DJ, live artist, lighting and sound</li>
  <li><strong>Hair &amp; Makeup:</strong> Bridal makeup, hair, manicure-pedicure</li>
  <li><strong>Honeymoon:</strong> Holiday packages, hotel booking, transfer</li>
  <li><strong>Home Goods:</strong> Appliance, furniture, home textile packages</li>
</ul>

<h2>Visitor Profile</h2>
<p>Over <strong>5,000 couples</strong> attend with their families. Couples make decisions here: 40% of the sector's sales happen in the 4 weeks following the busiest fair.</p>

<h2>What We Offer Couples</h2>
<ul>
  <li><strong>Fair-Only Discounts:</strong> Campaigns valid only during event days</li>
  <li><strong>Raffles &amp; Gifts:</strong> Free photo sessions, honeymoon packages, jewellery</li>
  <li><strong>Mini Fashion Shows:</strong> Wedding dress runways, makeup demos</li>
  <li><strong>Wedding Planner Consultations:</strong> Budget and timeline planning</li>
  <li><strong>Smart Question Guide:</strong> Supplier comparison template</li>
</ul>

<h2>Exhibitor Advantages</h2>
<p>If you're in the wedding industry, this fair is where you'll generate a major share of your annual revenue. The <strong>only window where couples actually decide</strong>. We support you with stand rental, build, decoration and marketing.</p>

<p><a href="/en/teklif-al">Get a stand quote</a> or <a href="/en/iletisim">contact us</a>.</p>
HTML,
    ],
];

echo "═══ Fairs Content Seeder ═══\n";

$updated = 0;
foreach ($fairs as $slug => $data) {
    $sql = "UPDATE fairs SET
        icon            = COALESCE(NULLIF(icon,''), ?),
        accent_color    = COALESCE(NULLIF(accent_color,''), ?),
        location        = COALESCE(NULLIF(location,''), ?),
        hero_eyebrow_tr = COALESCE(NULLIF(hero_eyebrow_tr,''), ?),
        hero_eyebrow_en = COALESCE(NULLIF(hero_eyebrow_en,''), ?),
        hero_tagline_tr = COALESCE(NULLIF(hero_tagline_tr,''), ?),
        hero_tagline_en = COALESCE(NULLIF(hero_tagline_en,''), ?),
        hero_subline_tr = COALESCE(NULLIF(hero_subline_tr,''), ?),
        hero_subline_en = COALESCE(NULLIF(hero_subline_en,''), ?),
        content_tr      = COALESCE(NULLIF(content_tr,''), ?),
        content_en      = COALESCE(NULLIF(content_en,''), ?),
        meta_title_tr   = COALESCE(NULLIF(meta_title_tr,''), ?),
        meta_title_en   = COALESCE(NULLIF(meta_title_en,''), ?),
        meta_desc_tr    = COALESCE(NULLIF(meta_desc_tr,''), ?),
        meta_desc_en    = COALESCE(NULLIF(meta_desc_en,''), ?),
        stats_json      = COALESCE(NULLIF(stats_json,''), ?)
        WHERE slug = ?";

    $rows = DB::execute($sql, [
        $data['icon'], $data['accent_color'], $data['location'],
        $data['hero_eyebrow_tr'], $data['hero_eyebrow_en'],
        $data['hero_tagline_tr'], $data['hero_tagline_en'],
        $data['hero_subline_tr'], $data['hero_subline_en'],
        $data['content_tr'], $data['content_en'],
        $data['meta_title_tr'], $data['meta_title_en'],
        $data['meta_desc_tr'], $data['meta_desc_en'],
        $data['stats_json'],
        $slug,
    ]);

    echo ($rows > 0 ? "✓" : "—") . " {$slug}\n";
    if ($rows > 0) $updated++;
}

echo "\n{$updated} fuarın içeriği dolduruldu.\n";
