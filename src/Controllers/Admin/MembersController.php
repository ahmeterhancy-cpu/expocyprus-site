<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\{Member, ProductionOrder};

class MembersController
{
    public function index(Request $req, array $params = []): void
    {
        $page = max(1, (int)$req->get('page', 1));
        $filters = [
            'status' => trim((string)$req->get('status', '')),
            'q'      => trim((string)$req->get('q', '')),
        ];
        $result = Member::paginateFiltered($page, 25, $filters);
        $statusCounts = Member::statusCounts();
        View::render('admin/members/index', array_merge($result, compact('filters','statusCounts')), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        View::render('admin/members/edit', ['member' => null, 'isNew' => true], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        Member::ensureTable();
        $data = $this->formData($req);
        $pass = (string)$req->post('password', '');
        if ($data['company_name'] === '' || $data['contact_name'] === '' || $data['email'] === '' || $pass === '') {
            Session::flash('error', 'Firma adı, yetkili, e-posta ve şifre zorunlu.');
            View::redirect('/admin/members/create');
        }
        if (Member::findByEmail($data['email'])) {
            Session::flash('error', 'Bu e-posta zaten kayıtlı.');
            View::redirect('/admin/members/create');
        }
        $data['password'] = $pass;
        Member::register($data);
        Session::flash('success', 'Üye eklendi.');
        View::redirect('/admin/members');
    }

    public function show(Request $req, array $params = []): void
    {
        $member = Member::find((int)$params['id']);
        if (!$member) View::redirect('/admin/members');
        $orders = ProductionOrder::forMember((int)$params['id']);
        View::render('admin/members/view', compact('member','orders'), 'admin');
    }

    public function edit(Request $req, array $params = []): void
    {
        $member = Member::find((int)$params['id']);
        if (!$member) View::redirect('/admin/members');
        View::render('admin/members/edit', ['member' => $member, 'isNew' => false], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $data = $this->formData($req);
        $newPass = (string)$req->post('password', '');
        if ($newPass !== '') {
            if (strlen($newPass) < 8) {
                Session::flash('error', 'Şifre en az 8 karakter olmalı.');
                View::redirect('/admin/members/' . $id . '/edit');
            }
            $data['password_hash'] = password_hash($newPass, PASSWORD_BCRYPT);
        }
        Member::update($id, $data);
        Session::flash('success', 'Üye güncellendi.');
        View::redirect('/admin/members/' . $id);
    }

    public function destroy(Request $req, array $params = []): void
    {
        Member::delete((int)$params['id']);
        Session::flash('success', 'Üye silindi.');
        View::redirect('/admin/members');
    }

    public function approve(Request $req, array $params = []): void
    {
        Member::update((int)$params['id'], ['status' => 'active']);
        Session::flash('success', 'Üye onaylandı.');
        View::redirect('/admin/members/' . $params['id']);
    }

    private function formData(Request $req): array
    {
        return [
            'company_name' => trim((string)$req->post('company_name', '')),
            'contact_name' => trim((string)$req->post('contact_name', '')),
            'email'        => strtolower(trim((string)$req->post('email', ''))),
            'phone'        => trim((string)$req->post('phone', '')) ?: null,
            'tax_no'       => trim((string)$req->post('tax_no', '')) ?: null,
            'address'      => trim((string)$req->post('address', '')) ?: null,
            'city'         => trim((string)$req->post('city', '')) ?: null,
            'country'      => trim((string)$req->post('country', 'KKTC')),
            'website'      => trim((string)$req->post('website', '')) ?: null,
            'status'       => trim((string)$req->post('status', 'pending')),
        ];
    }
}
