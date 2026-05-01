<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\{CatalogItem, MediaFile};

class CatalogController
{
    public function index(Request $req, array $params = []): void
    {
        $items = CatalogItem::all('FIELD(size_category, "bir-birim", "iki-birim", "uc-birim", "ada"), model_no ASC');
        View::render('admin/catalog/index', compact('items'), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        View::render('admin/catalog/edit', ['item' => null, 'isNew' => true], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        $data = $this->formData($req);
        $modelNo = $data['model_no'] ?: 'item';
        $data['slug'] = slug($modelNo . '-' . ($data['name_tr'] ?: 'stand'));
        CatalogItem::create($data);
        Session::flash('success', 'Katalog öğesi eklendi.');
        View::redirect('/admin/catalog');
    }

    public function edit(Request $req, array $params = []): void
    {
        $item = CatalogItem::find((int)$params['id']);
        if (!$item) View::redirect('/admin/catalog');
        View::render('admin/catalog/edit', ['item' => $item, 'isNew' => false], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        CatalogItem::update((int)$params['id'], $this->formData($req));
        Session::flash('success', 'Katalog öğesi güncellendi.');
        View::redirect('/admin/catalog');
    }

    public function destroy(Request $req, array $params = []): void
    {
        CatalogItem::delete((int)$params['id']);
        Session::flash('success', 'Katalog öğesi silindi.');
        View::redirect('/admin/catalog');
    }

    private function formData(Request $req): array
    {
        // Features: each line = one feature
        $featuresRaw = trim((string)$req->post('features', ''));
        $features = [];
        if ($featuresRaw !== '') {
            foreach (preg_split('/\r\n|\r|\n/', $featuresRaw) as $line) {
                $line = trim($line);
                if ($line !== '') $features[] = $line;
            }
        }

        // Gallery: existing URLs from textarea
        $galleryRaw = trim((string)$req->post('gallery', ''));
        $gallery = [];
        if ($galleryRaw !== '') {
            foreach (preg_split('/\r\n|\r|\n/', $galleryRaw) as $line) {
                $line = trim($line);
                if ($line !== '') $gallery[] = $line;
            }
        }

        // Gallery: new file uploads (append to existing)
        $galleryFiles = $_FILES['gallery_files'] ?? [];
        if (!empty($galleryFiles['name'][0])) {
            foreach ($galleryFiles['tmp_name'] as $i => $tmp) {
                if ($galleryFiles['error'][$i] === UPLOAD_ERR_OK) {
                    $file = [
                        'name'     => $galleryFiles['name'][$i],
                        'tmp_name' => $tmp,
                        'error'    => $galleryFiles['error'][$i],
                        'size'     => $galleryFiles['size'][$i],
                        'type'     => $galleryFiles['type'][$i],
                    ];
                    $result = MediaFile::upload($file, 'catalog');
                    if ($result) $gallery[] = $result['url'];
                }
            }
        }

        // Main image: uploaded file takes priority, otherwise keep current URL
        $imageMain = trim($req->post('image_main_current', ''));
        $mainFile  = $req->file('image_main_file');
        if ($mainFile && $mainFile['error'] === UPLOAD_ERR_OK && !empty($mainFile['name'])) {
            $result = MediaFile::upload($mainFile, 'catalog');
            if ($result) $imageMain = $result['url'];
        }

        $price = $req->post('price', '');
        $price = ($price === '' || $price === null) ? null : (float)$price;

        return [
            'model_no'       => strtoupper(trim($req->post('model_no', ''))),
            'name_tr'        => trim($req->post('name_tr', '')),
            'name_en'        => trim($req->post('name_en', '')),
            'size_category'  => $req->post('size_category', 'bir-birim'),
            'dimensions'     => trim($req->post('dimensions', '')),
            'price'          => $price,
            'currency'       => $req->post('currency', 'EUR'),
            'features_json'  => json_encode($features, JSON_UNESCAPED_UNICODE),
            'description'    => trim($req->post('description', '')),
            'description_en' => trim($req->post('description_en', '')),
            'image_main'     => $imageMain,
            'gallery_json'   => $gallery ? json_encode(array_values($gallery), JSON_UNESCAPED_UNICODE) : null,
            'status'         => $req->post('status', 'active'),
        ];
    }
}
