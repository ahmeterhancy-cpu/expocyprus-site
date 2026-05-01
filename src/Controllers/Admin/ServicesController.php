<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\Service;

class ServicesController
{
    public function index(Request $req, array $params = []): void
    {
        $services = Service::all('sort_order ASC');
        View::render('admin/services/index', compact('services'), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        View::render('admin/services/edit', ['service' => null, 'isNew' => true], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        $data = $this->validate($req);
        if (!$data) { View::redirect('/admin/services/create'); }

        Service::create($data);
        Session::flash('success', 'Hizmet başarıyla eklendi.');
        View::redirect('/admin/services');
    }

    public function edit(Request $req, array $params = []): void
    {
        Service::ensureExtended();
        $service = Service::find((int)$params['id']);
        if (!$service) { View::redirect('/admin/services'); }
        View::render('admin/services/edit', ['service' => $service, 'isNew' => false], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        $data = $this->validate($req);
        if (!$data) { View::redirect('/admin/services/' . $params['id'] . '/edit'); }

        Service::update((int)$params['id'], $data);
        Session::flash('success', 'Hizmet güncellendi.');
        View::redirect('/admin/services');
    }

    public function destroy(Request $req, array $params = []): void
    {
        Service::delete((int)$params['id']);
        Session::flash('success', 'Hizmet silindi.');
        View::redirect('/admin/services');
    }

    private function validate(Request $req): array|false
    {
        Service::ensureExtended();

        // Stats: 4 satır halinde gönderiliyor (stat_num[], stat_label_tr[], stat_label_en[])
        $statNums   = (array)$req->post('stat_num', []);
        $statLblTr  = (array)$req->post('stat_label_tr', []);
        $statLblEn  = (array)$req->post('stat_label_en', []);
        $stats = [];
        for ($i = 0; $i < count($statNums); $i++) {
            $num = trim((string)($statNums[$i] ?? ''));
            $tr  = trim((string)($statLblTr[$i] ?? ''));
            if ($num === '' && $tr === '') continue;
            $stats[] = [
                'num'   => $num,
                'tr'    => $tr,
                'en'    => trim((string)($statLblEn[$i] ?? '')),
            ];
        }

        return [
            'slug'             => slug($req->post('title_tr', '')),
            'title_tr'         => trim($req->post('title_tr', '')),
            'title_en'         => trim($req->post('title_en', '')),
            'summary_tr'       => trim($req->post('summary_tr', '')),
            'summary_en'       => trim($req->post('summary_en', '')),
            'content_tr'       => $req->post('content_tr', ''),
            'content_en'       => $req->post('content_en', ''),
            'icon'             => trim($req->post('icon', '')),
            'image'            => trim($req->post('image', '')),
            'sort_order'       => (int)$req->post('sort_order', 0),
            'status'           => $req->post('status', 'active'),
            'meta_title_tr'    => trim($req->post('meta_title_tr', '')),
            'meta_title_en'    => trim($req->post('meta_title_en', '')),
            'meta_desc_tr'     => trim($req->post('meta_desc_tr', '')),
            'meta_desc_en'     => trim($req->post('meta_desc_en', '')),
            // Apple-style alanlar
            'hero_eyebrow_tr'  => trim($req->post('hero_eyebrow_tr', '')) ?: null,
            'hero_eyebrow_en'  => trim($req->post('hero_eyebrow_en', '')) ?: null,
            'hero_tagline_tr'  => trim($req->post('hero_tagline_tr', '')) ?: null,
            'hero_tagline_en'  => trim($req->post('hero_tagline_en', '')) ?: null,
            'hero_subline_tr'  => trim($req->post('hero_subline_tr', '')) ?: null,
            'hero_subline_en'  => trim($req->post('hero_subline_en', '')) ?: null,
            'accent_color'     => trim($req->post('accent_color', '#E30613')),
            'showcase_image'   => trim($req->post('showcase_image', '')) ?: null,
            'stats_json'       => $stats ? json_encode($stats, JSON_UNESCAPED_UNICODE) : null,
        ];
    }
}
