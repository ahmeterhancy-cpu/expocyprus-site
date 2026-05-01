<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View, DB};
use App\Models\CrewApplication;

class CrewController
{
    public function index(Request $req, array $params = []): void
    {
        $page = max(1, (int)$req->get('page', 1));
        $filters = [
            'position'   => trim((string)$req->get('position', '')),
            'gender'     => trim((string)$req->get('gender', '')),
            'status'     => trim((string)$req->get('status', '')),
            'regions'    => trim((string)$req->get('regions', '')),
            'min_height' => trim((string)$req->get('min_height', '')),
            'max_height' => trim((string)$req->get('max_height', '')),
            'min_age'    => trim((string)$req->get('min_age', '')),
            'max_age'    => trim((string)$req->get('max_age', '')),
            'language'   => trim((string)$req->get('language', '')),
            'q'          => trim((string)$req->get('q', '')),
        ];
        $result = CrewApplication::paginateFiltered($page, 25, $filters);
        $statusCounts = CrewApplication::statusCounts();
        View::render('admin/crew/index', array_merge($result, compact('filters','statusCounts')), 'admin');
    }

    public function view(Request $req, array $params = []): void
    {
        CrewApplication::ensureTable();
        $app = CrewApplication::find((int)$params['id']);
        if (!$app) View::redirect('/admin/crew');
        View::render('admin/crew/view', compact('app'), 'admin');
    }

    public function updateStatus(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $status = trim((string)$req->post('status', ''));
        if (isset(CrewApplication::STATUSES[$status])) {
            CrewApplication::update($id, ['status' => $status]);
            Session::flash('success', 'Durum güncellendi.');
        }
        View::redirect('/admin/crew/' . $id);
    }

    public function addNote(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $note = trim((string)$req->post('admin_notes', ''));
        CrewApplication::update($id, ['admin_notes' => $note]);
        Session::flash('success', 'Not güncellendi.');
        View::redirect('/admin/crew/' . $id);
    }

    public function destroy(Request $req, array $params = []): void
    {
        CrewApplication::delete((int)$params['id']);
        Session::flash('success', 'Başvuru silindi.');
        View::redirect('/admin/crew');
    }

    public function export(Request $req, array $params = []): void
    {
        CrewApplication::ensureTable();
        $rows = DB::query("SELECT * FROM crew_applications ORDER BY created_at DESC");
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="crew_' . date('YmdHis') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));
        if (!empty($rows)) {
            fputcsv($out, array_keys($rows[0]));
            foreach ($rows as $row) fputcsv($out, $row);
        }
        fclose($out);
        exit;
    }
}
