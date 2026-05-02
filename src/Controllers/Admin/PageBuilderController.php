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
        $pages = DB::query("
            SELECT p.id, p.name, p.layout, p.updated_at,
                   tr.locale, tr.title, tr.route
            FROM pb_pages p
            LEFT JOIN pb_page_translations tr ON tr.page_id = p.id
            ORDER BY p.id DESC, tr.locale ASC
        ");

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
}
