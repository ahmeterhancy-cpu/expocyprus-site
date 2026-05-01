<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\CatalogCategory;

class CatalogCategoriesController
{
    public function index(Request $req, array $params = []): void
    {
        $items = CatalogCategory::allOrdered();
        View::render('admin/catalog/categories/index', compact('items'), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        View::render('admin/catalog/categories/edit', ['item' => null, 'isNew' => true], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        CatalogCategory::ensureTable();
        $data = $this->formData($req);
        if ($data['cat_key'] === '' || $data['label_tr'] === '') {
            Session::flash('error', 'Anahtar ve TR Etiket zorunlu.');
            View::redirect('/admin/catalog/categories/create');
        }
        if (CatalogCategory::findByKey($data['cat_key'])) {
            Session::flash('error', 'Bu anahtar (key) zaten kullanılıyor.');
            View::redirect('/admin/catalog/categories/create');
        }
        CatalogCategory::create($data);
        Session::flash('success', 'Kategori eklendi.');
        View::redirect('/admin/catalog/categories');
    }

    public function edit(Request $req, array $params = []): void
    {
        $item = CatalogCategory::find((int)$params['id']);
        if (!$item) View::redirect('/admin/catalog/categories');
        View::render('admin/catalog/categories/edit', ['item' => $item, 'isNew' => false], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        $data = $this->formData($req);
        // anahtar değişmesin (referansları bozar) — mevcut anahtarı koru
        $current = CatalogCategory::find((int)$params['id']);
        if ($current) $data['cat_key'] = $current['cat_key'];
        CatalogCategory::update((int)$params['id'], $data);
        Session::flash('success', 'Kategori güncellendi.');
        View::redirect('/admin/catalog/categories');
    }

    public function destroy(Request $req, array $params = []): void
    {
        CatalogCategory::delete((int)$params['id']);
        Session::flash('success', 'Kategori silindi.');
        View::redirect('/admin/catalog/categories');
    }

    private function formData(Request $req): array
    {
        $key = trim((string)$req->post('cat_key', ''));
        $key = preg_replace('/[^a-z0-9\-]/', '', strtolower($key));
        return [
            'cat_key'        => $key,
            'label_tr'       => trim((string)$req->post('label_tr', '')),
            'label_en'       => trim((string)$req->post('label_en', '')),
            'dimensions_tr'  => trim((string)$req->post('dimensions_tr', '')),
            'dimensions_en'  => trim((string)$req->post('dimensions_en', '')),
            'description_tr' => trim((string)$req->post('description_tr', '')),
            'description_en' => trim((string)$req->post('description_en', '')),
            'sort_order'     => (int)$req->post('sort_order', 0),
            'status'         => $req->post('status', 'active'),
        ];
    }
}
