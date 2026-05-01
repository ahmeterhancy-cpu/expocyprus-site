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
