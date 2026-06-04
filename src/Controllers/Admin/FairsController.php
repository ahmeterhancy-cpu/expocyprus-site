<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\Fair;

class FairsController
{
    public function index(Request $req, array $params = []): void
    {
        $fairs = Fair::all('sort_order ASC');
        View::render('admin/fairs/index', compact('fairs'), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        View::render('admin/fairs/edit', ['fair' => null, 'isNew' => true], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        Fair::create($this->formData($req));
        Session::flash('success', 'Fuar eklendi.');
        View::redirect('/admin/fairs');
    }

    public function edit(Request $req, array $params = []): void
    {
        $fair = Fair::find((int)$params['id']);
        if (!$fair) View::redirect('/admin/fairs');
        View::render('admin/fairs/edit', ['fair' => $fair, 'isNew' => false], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        Fair::update((int)$params['id'], $this->formData($req));
        Session::flash('success', 'Fuar güncellendi.');
        View::redirect('/admin/fairs');
    }

    public function destroy(Request $req, array $params = []): void
    {
        Fair::delete((int)$params['id']);
        Session::flash('success', 'Fuar silindi.');
        View::redirect('/admin/fairs');
    }

    /**
     * One-shot: KKTC Av Avcılık Balıkçılık Doğa Sporları Fuarı'nın
     * tüm bilgilerini günceller (poster eklendiğinde 2-4 Ekim 2026 etkinliği için).
     * Idempotent — birden fazla çalıştırılabilir.
     */
    public function seedAvFair(Request $req, array $params = []): void
    {
        // Genişletilmiş kolonların var olduğundan emin ol (hero_eyebrow_tr vb.)
        Fair::ensureExtended();

        $slug = 'av-avcilik-atis-doga-sporlari-fuari';
        $fair = Fair::findBySlug($slug);

        if (!$fair) {
            Session::flash('error', "Fuar bulunamadı: $slug");
            View::redirect('/admin/fairs');
            return;
        }

        $contentTr = <<<HTML
<h2>Doğanın Tutkusunu Keşfet!</h2>

<p><strong>KKTC'nin en kapsamlı doğa fuarı 2–4 Ekim 2026 tarihleri arasında Eski Ercan Havalimanı'nda!</strong></p>

<p>Av, atıcılık, balıkçılık, doğa sporları ve kamp malzemeleri sektörünün önde gelen markaları, son ürünleri ve yenilikleriyle bir araya geliyor. Profesyoneller, hobiciler ve doğa tutkunları için kaçırılmayacak bir buluşma.</p>

<h3>📅 Fuar Tarihleri</h3>
<ul>
  <li><strong>Açılış:</strong> 2 Ekim 2026, Cuma</li>
  <li><strong>Kapanış:</strong> 4 Ekim 2026, Pazar</li>
</ul>

<h3>🕒 Ziyaret Saatleri</h3>
<ul>
  <li><strong>2 Ekim Cuma:</strong> 18:00 – 22:00</li>
  <li><strong>3 Ekim Cumartesi:</strong> 10:00 – 22:00</li>
  <li><strong>4 Ekim Pazar:</strong> 10:00 – 22:00</li>
</ul>

<h3>📍 Fuar Alanı</h3>
<p>Eski Ercan Havalimanı, KKTC</p>

<h3>🤝 Destekleyen Kurumlar</h3>
<ul>
  <li>KKTC Başbakanlık</li>
  <li>KKTC İç İşleri Bakanlığı</li>
  <li>KKTC Avcılık Federasyonu</li>
</ul>

<h3>📞 Detaylı Bilgi ve İletişim</h3>
<p>
  <strong>Telefon:</strong> <a href="tel:+905488303000">0548 830 30 00</a> &nbsp;·&nbsp;
  <a href="tel:+905338225052">0533 822 50 52</a><br>
  <strong>Web:</strong> <a href="https://www.expocyprus.com">www.expocyprus.com</a>
</p>

<p><em>Cyprus Expo 26 by UNIFEX Fuarcılık organizasyonudur.</em></p>
HTML;

        $contentEn = <<<HTML
<h2>Discover Nature's Passion!</h2>

<p><strong>TRNC's most comprehensive outdoor fair, October 2–4, 2026 at the Old Ercan Airport!</strong></p>

<p>Leading brands and innovations from the hunting, shooting, fishing, outdoor sports and camping equipment industry come together. An unmissable event for professionals, hobbyists and nature lovers.</p>

<h3>📅 Fair Dates</h3>
<ul>
  <li><strong>Opening:</strong> Friday, October 2, 2026</li>
  <li><strong>Closing:</strong> Sunday, October 4, 2026</li>
</ul>

<h3>🕒 Visiting Hours</h3>
<ul>
  <li><strong>Friday, Oct 2:</strong> 6:00 PM – 10:00 PM</li>
  <li><strong>Saturday, Oct 3:</strong> 10:00 AM – 10:00 PM</li>
  <li><strong>Sunday, Oct 4:</strong> 10:00 AM – 10:00 PM</li>
</ul>

<h3>📍 Venue</h3>
<p>Old Ercan Airport, TRNC</p>

<h3>🤝 Supported By</h3>
<ul>
  <li>TRNC Prime Ministry</li>
  <li>TRNC Ministry of Interior</li>
  <li>TRNC Hunting Federation</li>
</ul>

<h3>📞 Contact</h3>
<p>
  <strong>Phone:</strong> <a href="tel:+905488303000">+90 548 830 30 00</a> &nbsp;·&nbsp;
  <a href="tel:+905338225052">+90 533 822 50 52</a><br>
  <strong>Web:</strong> <a href="https://www.expocyprus.com">www.expocyprus.com</a>
</p>

<p><em>Cyprus Expo 26 by UNIFEX Fuarcılık event.</em></p>
HTML;

        $data = [
            'name_tr'       => 'KKTC Av, Avcılık, Balıkçılık, Doğa Sporları ve Kamp Malzemeleri Fuarı',
            'name_en'       => 'TRNC Hunting, Shooting, Fishing, Outdoor Sports and Camping Equipment Fair',
            'summary_tr'    => "Doğanın Tutkusunu Keşfet! KKTC'nin en kapsamlı av, avcılık, balıkçılık, doğa sporları ve kamp malzemeleri fuarı. 2-4 Ekim 2026 tarihleri arasında Eski Ercan Havalimanı Fuar Alanı'nda. Açık havada doğanın tutkusunu yaşamak isteyenler ve sektör profesyonelleri için kaçırılmayacak bir buluşma.",
            'summary_en'    => "Discover Nature's Passion! The most comprehensive hunting, shooting, fishing, outdoor sports and camping equipment fair in TRNC. October 2-4, 2026 at the Old Ercan Airport Fair Ground. A must-attend gathering for outdoor enthusiasts and industry professionals.",
            'content_tr'    => $contentTr,
            'content_en'    => $contentEn,
            'next_date'     => '2026-10-02',
            'end_date'      => '2026-10-04',
            'location'      => 'Eski Ercan Havalimanı, KKTC',
            'image_hero'    => '/uploads/fairs/av-fuari-2026-poster.jpg',
            'status'        => 'active',
            'meta_title_tr' => 'KKTC Av Avcılık Balıkçılık Doğa Fuarı 2026 | Cyprus Expo',
            'meta_title_en' => 'TRNC Hunting Fishing Outdoor Fair 2026 | Cyprus Expo',
            'meta_desc_tr'  => "2-4 Ekim 2026 Eski Ercan Havalimanı'nda KKTC'nin en kapsamlı av, avcılık, balıkçılık ve doğa sporları fuarı. Ücretsiz giriş, 3 gün boyunca açık.",
            'meta_desc_en'  => "October 2-4, 2026 at Old Ercan Airport — TRNC's most comprehensive hunting, fishing and outdoor fair. Free entry, 3 days open.",
            // Eski hero alanlarını temizle — view'deki tarih-bazlı eyebrow ('2–4 EKİM 2026') kullanılsın
            'hero_eyebrow_tr'  => null,
            'hero_eyebrow_en'  => null,
            'hero_tagline_tr'  => null,
            'hero_tagline_en'  => null,
            'hero_subline_tr'  => null,
            'hero_subline_en'  => null,
        ];

        Fair::update((int)$fair['id'], $data);

        Session::flash('success', "✓ Fuar güncellendi: '{$data['name_tr']}'. Posteri /uploads/fairs/av-fuari-2026-poster.jpg yoluna yüklemeyi unutmayın (cPanel File Manager veya admin/media).");
        View::redirect('/admin/fairs');
    }

    private function formData(Request $req): array
    {
        return [
            'slug'        => slug($req->post('name_tr', '')),
            'name_tr'     => trim($req->post('name_tr', '')),
            'name_en'     => trim($req->post('name_en', '')),
            'summary_tr'  => trim($req->post('summary_tr', '')),
            'summary_en'  => trim($req->post('summary_en', '')),
            'content_tr'  => $req->post('content_tr', ''),
            'content_en'  => $req->post('content_en', ''),
            'next_date'   => $req->post('next_date', null) ?: null,
            'end_date'    => $req->post('end_date', null) ?: null,
            'location'    => trim($req->post('location', '')),
            'image_hero'  => trim($req->post('image_hero', '')),
            'sort_order'  => (int)$req->post('sort_order', 0),
            'status'      => $req->post('status', 'active'),
            'meta_title_tr' => trim($req->post('meta_title_tr', '')),
            'meta_title_en' => trim($req->post('meta_title_en', '')),
            'meta_desc_tr'  => trim($req->post('meta_desc_tr', '')),
            'meta_desc_en'  => trim($req->post('meta_desc_en', '')),
        ];
    }
}
