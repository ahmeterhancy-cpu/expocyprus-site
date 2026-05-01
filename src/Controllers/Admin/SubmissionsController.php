<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{DB, Request, Session, View};
use App\Models\FormSubmission;

class SubmissionsController
{
    public function index(Request $req, array $params = []): void
    {
        $type    = $req->get('type', '');
        $page    = max(1, (int)$req->get('page', 1));
        $where   = $type ? "form_type = ?" : '';
        $wParams = $type ? [$type] : [];

        $result = FormSubmission::paginate($page, 20, $where, $wParams);
        $types  = DB::query("SELECT DISTINCT form_type FROM form_submissions ORDER BY form_type");

        View::render('admin/submissions/index', array_merge($result, compact('type', 'types')), 'admin');
    }

    public function view(Request $req, array $params = []): void
    {
        $submission = FormSubmission::find((int)$params['id']);
        if (!$submission) View::redirect('/admin/submissions');

        FormSubmission::markRead((int)$params['id']);
        $submission['data'] = json_decode($submission['data_json'] ?? '{}', true) ?: [];

        View::render('admin/submissions/view', compact('submission'), 'admin');
    }

    public function destroy(Request $req, array $params = []): void
    {
        FormSubmission::delete((int)$params['id']);
        Session::flash('success', 'Başvuru silindi.');
        View::redirect('/admin/submissions');
    }

    public function export(Request $req, array $params = []): void
    {
        $type = $req->get('type', '');
        $rows = $type
            ? DB::query("SELECT * FROM form_submissions WHERE form_type = ? ORDER BY created_at DESC", [$type])
            : DB::query("SELECT * FROM form_submissions ORDER BY created_at DESC");

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="basvu_' . date('YmdHis') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));  // UTF-8 BOM

        if (!empty($rows)) {
            $first = $rows[0];
            fputcsv($out, array_keys($first));
            foreach ($rows as $row) fputcsv($out, $row);
        }
        fclose($out);
        exit;
    }
}
