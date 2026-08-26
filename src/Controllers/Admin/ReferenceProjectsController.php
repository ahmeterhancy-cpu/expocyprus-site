<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\{MediaFile, ReferenceProject};

class ReferenceProjectsController
{
    public function index(Request $req, array $params = []): void
    {
        ReferenceProject::ensureTable();
        $projects = ReferenceProject::all('featured DESC, sort_order ASC, year DESC, id DESC');
        View::render('admin/references/index', compact('projects'), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        ReferenceProject::ensureTable();
        View::render('admin/references/edit', ['project' => null, 'isNew' => true], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        ReferenceProject::ensureTable();
        $data = $this->formData($req);
        $base = slug($data['title_tr'] ?: ($data['client'] ?: 'proje'));
        $data['slug'] = $base . '-' . substr(uniqid('', true), -6);
        ReferenceProject::create($data);
        Session::flash('success', 'Referans projesi eklendi.');
        View::redirect('/admin/references');
    }

    public function edit(Request $req, array $params = []): void
    {
        ReferenceProject::ensureTable();
        $project = ReferenceProject::find((int) $params['id']);
        if (!$project) View::redirect('/admin/references');
        View::render('admin/references/edit', ['project' => $project, 'isNew' => false], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        ReferenceProject::ensureTable();
        ReferenceProject::update((int) $params['id'], $this->formData($req));
        Session::flash('success', 'Referans projesi güncellendi.');
        View::redirect('/admin/references');
    }

    public function destroy(Request $req, array $params = []): void
    {
        ReferenceProject::delete((int) $params['id']);
        Session::flash('success', 'Referans projesi silindi.');
        View::redirect('/admin/references');
    }

    private function formData(Request $req): array
    {
        // Galeri: textarea'daki mevcut URL'ler
        $gallery = [];
        $galleryRaw = trim((string) $req->post('gallery', ''));
        if ($galleryRaw !== '') {
            foreach (preg_split('/\r\n|\r|\n/', $galleryRaw) as $line) {
                $line = trim($line);
                if ($line !== '') $gallery[] = $line;
            }
        }

        // Galeri: yeni yüklenen dosyalar (mevcutlara eklenir)
        $galleryFiles = $_FILES['gallery_files'] ?? [];
        if (!empty($galleryFiles['name'][0])) {
            foreach ($galleryFiles['tmp_name'] as $i => $tmp) {
                if (($galleryFiles['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) continue;
                $result = MediaFile::upload([
                    'name'     => $galleryFiles['name'][$i],
                    'tmp_name' => $tmp,
                    'error'    => $galleryFiles['error'][$i],
                    'size'     => $galleryFiles['size'][$i],
                    'type'     => $galleryFiles['type'][$i],
                ], 'references');
                if ($result) $gallery[] = $result['url'];
            }
        }
        $gallery = array_values(array_unique($gallery));

        // Kapak görseli: yeni yükleme varsa o, yoksa mevcut URL korunur
        $imageMain = trim((string) $req->post('image_main_current', ''));
        $mainFile  = $req->file('image_main_file');
        if ($mainFile && ($mainFile['error'] ?? 1) === UPLOAD_ERR_OK && !empty($mainFile['name'])) {
            $result = MediaFile::upload($mainFile, 'references');
            if ($result) $imageMain = $result['url'];
        }
        // Kapak boşsa ilk galeri görselini kullan — kart görselsiz kalmasın
        if ($imageMain === '' && $gallery !== []) $imageMain = $gallery[0];

        $year = $req->post('year', '');
        $year = ($year === '' || $year === null) ? null : (int) $year;

        $sqm = $req->post('sqm', '');
        $sqm = ($sqm === '' || $sqm === null) ? null : (int) $sqm;

        $serviceTypes = ReferenceProject::serviceTypes();
        $service = (string) $req->post('service_type', '');
        if (!isset($serviceTypes[$service])) $service = '';

        $standTypes = ReferenceProject::standTypes();
        $stand = (string) $req->post('stand_type', 'custom');
        if (!isset($standTypes[$stand])) $stand = 'custom';

        return [
            'title_tr'       => trim((string) $req->post('title_tr', '')),
            'title_en'       => trim((string) $req->post('title_en', '')),
            'client'         => trim((string) $req->post('client', '')),
            'fair_name'      => trim((string) $req->post('fair_name', '')),
            'location'       => trim((string) $req->post('location', '')),
            'year'           => $year,
            'sqm'            => $sqm,
            'stand_type'     => $stand,
            'service_type'   => $service,
            'summary_tr'     => trim((string) $req->post('summary_tr', '')),
            'summary_en'     => trim((string) $req->post('summary_en', '')),
            'description_tr' => (string) $req->post('description_tr', ''),
            'description_en' => (string) $req->post('description_en', ''),
            'image_main'     => $imageMain,
            'gallery_json'   => json_encode($gallery, JSON_UNESCAPED_UNICODE),
            'featured'       => $req->post('featured') ? 1 : 0,
            'sort_order'     => (int) $req->post('sort_order', 0),
            'status'         => $req->post('status', 'active') === 'inactive' ? 'inactive' : 'active',
        ];
    }
}
