<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View, DB};

/**
 * PHPageBuilder sayfalarını yönetmek için Tabler-tabanlı admin UI.
 * Sayfa CRUD ve route metadata burada; gerçek block düzenleme PHPagebuilder'ın
 * GrapesJS editöründe (/admin/pagebuilder/edit?action=edit&page=N).
 */
class PageBuilderController
{
    public function index(Request $req, array $params = []): void
    {
        try {
            $pages = DB::query("
                SELECT p.id, p.name, p.layout, p.updated_at,
                       tr.locale, tr.title, tr.route
                FROM pb_pages p
                LEFT JOIN pb_page_translations tr ON tr.page_id = p.id
                ORDER BY p.id DESC, tr.locale ASC
            ");
        } catch (\Throwable $e) {
            // pb_* tabloları yoksa setup yapılmamış
            View::render('admin/pagebuilder/setup-required', ['error' => $e->getMessage()], 'admin');
            return;
        }

        // id'ye göre grupla
        $grouped = [];
        foreach ($pages as $p) {
            $id = (int)$p['id'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'id' => $id, 'name' => $p['name'], 'layout' => $p['layout'],
                    'updated_at' => $p['updated_at'], 'translations' => [],
                ];
            }
            if ($p['locale']) {
                $grouped[$id]['translations'][$p['locale']] = [
                    'title' => $p['title'], 'route' => $p['route'],
                ];
            }
        }

        View::render('admin/pagebuilder/index', ['pages' => array_values($grouped)], 'admin');
    }

    public function createForm(Request $req, array $params = []): void
    {
        View::render('admin/pagebuilder/form', ['page' => null], 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        $name      = trim((string)$req->post('name', ''));
        $layout    = trim((string)$req->post('layout', 'master')) ?: 'master';
        $title_tr  = trim((string)$req->post('title_tr', ''));
        $title_en  = trim((string)$req->post('title_en', ''));
        $route_tr  = '/' . ltrim(trim((string)$req->post('route_tr', '')), '/');
        $route_en  = '/' . ltrim(trim((string)$req->post('route_en', '')), '/');
        $meta_title_tr = trim((string)$req->post('meta_title_tr', ''));
        $meta_title_en = trim((string)$req->post('meta_title_en', ''));
        $meta_desc_tr  = trim((string)$req->post('meta_desc_tr', ''));
        $meta_desc_en  = trim((string)$req->post('meta_desc_en', ''));

        if (!$name || !$title_tr || $route_tr === '/') {
            Session::flash('error', 'Sayfa adı, başlık ve TR route zorunlu.');
            View::redirect('/admin/pagebuilder/new');
            return;
        }

        $pageId = (int)DB::insert('pb_pages', [
            'name' => $name, 'layout' => $layout, 'data' => '[]',
        ]);

        DB::insert('pb_page_translations', [
            'page_id' => $pageId, 'locale' => 'tr',
            'title' => $title_tr,
            'meta_title' => $meta_title_tr ?: $title_tr,
            'meta_description' => $meta_desc_tr,
            'route' => $route_tr,
        ]);

        if ($title_en) {
            DB::insert('pb_page_translations', [
                'page_id' => $pageId, 'locale' => 'en',
                'title' => $title_en,
                'meta_title' => $meta_title_en ?: $title_en,
                'meta_description' => $meta_desc_en,
                'route' => $route_en !== '/' ? $route_en : '/en' . $route_tr,
            ]);
        }

        Session::flash('success', "Sayfa oluşturuldu: $name");
        View::redirect('/admin/pagebuilder/edit?action=edit&page=' . $pageId);
    }

    public function editForm(Request $req, array $params = []): void
    {
        $id = (int)($params['id'] ?? 0);
        $page = DB::first("SELECT * FROM pb_pages WHERE id = ?", [$id]);
        if (!$page) { View::redirect('/admin/pagebuilder'); return; }

        $translations = DB::query("SELECT * FROM pb_page_translations WHERE page_id = ?", [$id]);
        $byLocale = [];
        foreach ($translations as $t) $byLocale[$t['locale']] = $t;

        View::render('admin/pagebuilder/form', [
            'page' => $page,
            'translations' => $byLocale,
        ], 'admin');
    }

    public function updateMeta(Request $req, array $params = []): void
    {
        $id = (int)($params['id'] ?? 0);
        $page = DB::first("SELECT * FROM pb_pages WHERE id = ?", [$id]);
        if (!$page) { View::redirect('/admin/pagebuilder'); return; }

        $name   = trim((string)$req->post('name', $page['name']));
        $layout = trim((string)$req->post('layout', $page['layout'])) ?: 'master';
        DB::update('pb_pages', ['name' => $name, 'layout' => $layout], ['id' => $id]);

        foreach (['tr', 'en'] as $loc) {
            $title = trim((string)$req->post("title_$loc", ''));
            $route = '/' . ltrim(trim((string)$req->post("route_$loc", '')), '/');
            $metaTitle = trim((string)$req->post("meta_title_$loc", ''));
            $metaDesc  = trim((string)$req->post("meta_desc_$loc", ''));
            if (!$title) continue;

            $existing = DB::first("SELECT id FROM pb_page_translations WHERE page_id = ? AND locale = ?", [$id, $loc]);
            $data = [
                'title' => $title,
                'meta_title' => $metaTitle ?: $title,
                'meta_description' => $metaDesc,
                'route' => $route,
            ];
            if ($existing) {
                DB::update('pb_page_translations', $data, ['id' => $existing['id']]);
            } else {
                DB::insert('pb_page_translations', array_merge($data, ['page_id' => $id, 'locale' => $loc]));
            }
        }

        Session::flash('success', 'Sayfa ayarları güncellendi.');
        View::redirect('/admin/pagebuilder');
    }

    public function destroy(Request $req, array $params = []): void
    {
        $id = (int)($params['id'] ?? 0);
        DB::execute("DELETE FROM pb_pages WHERE id = ?", [$id]);
        Session::flash('success', 'Sayfa silindi.');
        View::redirect('/admin/pagebuilder');
    }

    /**
     * Mevcut public route'lar için pb_pages stub'ları oluşturur.
     * Aynı route'tan sayfa varsa atlar — idempotent.
     */
    public function seedAll(Request $req, array $params = []): void
    {
        $seedPages = [
            ['name' => 'Hakkımızda',          'tr' => ['Hakkımızda',                    '/hakkimizda',          'Hakkımızda — Unifex Fuarcılık'], 'en' => ['About Us',           '/en/about',          'About Us — Unifex']],
            ['name' => 'Tarihçe',             'tr' => ['Tarihçemiz',                    '/tarihce',             '22 yıllık fuar deneyimi'],       'en' => ['Our History',         '/en/history',        '22 Years of Fair Excellence']],
            ['name' => 'Ekip',                'tr' => ['Ekibimiz',                      '/ekip',                'Ekibimiz — Unifex Fuarcılık'],   'en' => ['Our Team',            '/en/team',           'Our Team']],
            ['name' => 'Misyon ve Vizyon',    'tr' => ['Misyon ve Vizyon',              '/misyon-vizyon',       'Misyon ve Vizyonumuz'],          'en' => ['Mission & Vision',    '/en/mission-vision', 'Our Mission & Vision']],
            ['name' => 'Hizmetler',           'tr' => ['Hizmetlerimiz',                 '/hizmetler',           'Fuar ve Stand Çözümleri'],       'en' => ['Our Services',        '/en/services',       'Fair & Stand Solutions']],
            ['name' => 'Fuarlarımız',         'tr' => ['Fuarlarımız',                   '/fuarlarimiz',         'Yaklaşan ve Geçmiş Fuarlar'],    'en' => ['Our Fairs',           '/en/fairs',          'Upcoming and Past Fairs']],
            ['name' => 'Stand Kataloğu',      'tr' => ['Stand Kataloğu',                '/stand-katalogu',      'Stand Modelleri ve Paketleri'],  'en' => ['Stand Catalogue',     '/en/stand-catalog',  'Stand Models and Packages']],
            ['name' => 'Oteller',             'tr' => ['Anlaşmalı Oteller',             '/oteller',             'Fuar Konaklama Çözümleri'],      'en' => ['Partner Hotels',      '/en/hotels',         'Fair Accommodation Solutions']],
            ['name' => 'Referanslar',         'tr' => ['Referanslarımız',               '/referanslar',         'Çalıştığımız Markalar'],          'en' => ['References',          '/en/references',     'Brands We Work With']],
            ['name' => 'SSS',                 'tr' => ['Sıkça Sorulan Sorular',         '/sss',                 'SSS — Sıkça Sorulan Sorular'],   'en' => ['FAQ',                 '/en/faq',            'Frequently Asked Questions']],
            ['name' => 'İletişim',            'tr' => ['İletişim',                      '/iletisim',            'Bize Ulaşın'],                   'en' => ['Contact',             '/en/contact',        'Get in Touch']],
            ['name' => 'Teklif Al',           'tr' => ['Stand Teklifi',                 '/teklif-al',           'Ücretsiz Stand Teklifi'],        'en' => ['Get Quote',           '/en/get-quote',      'Free Stand Quote']],
            ['name' => 'KVKK',                'tr' => ['KVKK Aydınlatma Metni',         '/kvkk',                'KVKK Aydınlatma Metni'],         'en' => ['KVKK Notice',         '/en/kvkk',           'Personal Data Protection']],
            ['name' => 'Gizlilik Politikası', 'tr' => ['Gizlilik Politikası',           '/gizlilik-politikasi', 'Gizlilik Politikası'],           'en' => ['Privacy Policy',      '/en/privacy-policy', 'Privacy Policy']],
            ['name' => 'Çerez Politikası',    'tr' => ['Çerez Politikası',              '/cerez-politikasi',    'Çerez Politikası'],              'en' => ['Cookie Policy',       '/en/cookie-policy',  'Cookie Policy']],
            ['name' => 'Kullanım Koşulları',  'tr' => ['Kullanım Koşulları',            '/kullanim-kosullari',  'Kullanım Koşulları'],            'en' => ['Terms of Use',        '/en/terms-of-use',   'Terms of Use']],
        ];

        // Mevcut route'ları çek (duplicate engelleme)
        $existing = DB::query("SELECT route FROM pb_page_translations");
        $existingRoutes = array_column($existing, 'route');

        $created = 0;
        $skipped = 0;
        foreach ($seedPages as $sp) {
            // TR ya da EN route zaten varsa atla
            if (in_array($sp['tr'][1], $existingRoutes, true) || in_array($sp['en'][1], $existingRoutes, true)) {
                $skipped++;
                continue;
            }

            try {
                $pageId = (int)DB::insert('pb_pages', [
                    'name'   => $sp['name'],
                    'layout' => 'master',
                    'data'   => '[]',
                ]);

                DB::insert('pb_page_translations', [
                    'page_id'          => $pageId,
                    'locale'           => 'tr',
                    'title'            => $sp['tr'][0],
                    'meta_title'       => $sp['tr'][2],
                    'meta_description' => $sp['tr'][2],
                    'route'            => $sp['tr'][1],
                ]);

                DB::insert('pb_page_translations', [
                    'page_id'          => $pageId,
                    'locale'           => 'en',
                    'title'            => $sp['en'][0],
                    'meta_title'       => $sp['en'][2],
                    'meta_description' => $sp['en'][2],
                    'route'            => $sp['en'][1],
                ]);

                $created++;
            } catch (\Throwable $e) {
                // ignore: route conflict ya da DB hatası — sıradakine geç
            }
        }

        $msg = "Seed tamamlandı: $created sayfa oluşturuldu, $skipped atlandı (zaten vardı).";
        Session::flash('success', $msg);
        View::redirect('/admin/pagebuilder');
    }
}
