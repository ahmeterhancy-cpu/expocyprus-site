<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View, DB};
use App\Models\{Lead, FormSubmission, AdminUser, MediaFile};

class LeadsController
{
    /** List with filters + pipeline summary */
    public function index(Request $req, array $params = []): void
    {
        $page = max(1, (int)$req->get('page', 1));
        $filters = [
            'status'      => trim((string)$req->get('status', '')),
            'temperature' => trim((string)$req->get('temperature', '')),
            'source'      => trim((string)$req->get('source', '')),
            'q'           => trim((string)$req->get('q', '')),
        ];
        $result = Lead::paginateFiltered($page, 25, $filters);
        $statusCounts = Lead::statusCounts();
        View::render('admin/leads/index', array_merge(
            $result,
            ['filters' => $filters, 'statusCounts' => $statusCounts]
        ), 'admin');
    }

    /** Kanban / Pipeline view */
    public function pipeline(Request $req, array $params = []): void
    {
        Lead::ensureTables();
        $columns = [];
        foreach (Lead::STATUSES as $key => $cfg) {
            $columns[$key] = [
                'config' => $cfg,
                'leads'  => DB::query(
                    "SELECT * FROM leads WHERE status = ? ORDER BY updated_at DESC LIMIT 50",
                    [$key]
                ),
            ];
        }
        View::render('admin/leads/pipeline', compact('columns'), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        View::render('admin/leads/edit', ['lead' => null, 'isNew' => true], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        Lead::ensureTables();
        $data = $this->formData($req);
        if ($data['name'] === '') {
            Session::flash('error', 'Ad zorunlu.');
            View::redirect('/admin/leads/create');
        }
        $id = (int)Lead::create($data);
        Lead::addActivity($id, 'created', 'Lead manuel oluşturuldu');

        // Teklif dosyası yüklendiyse kaydet
        $this->saveProposalFile($req, $id);

        Session::flash('success', 'Lead eklendi.');
        View::redirect('/admin/leads/' . $id);
    }

    public function show(Request $req, array $params = []): void
    {
        Lead::ensureTables();
        $lead = Lead::find((int)$params['id']);
        if (!$lead) View::redirect('/admin/leads');

        $activities = Lead::getActivities((int)$params['id']);
        $files      = Lead::getFiles((int)$params['id']);

        // Linked form submission (if any)
        $submission = null;
        if (!empty($lead['submission_id'])) {
            $submission = FormSubmission::find((int)$lead['submission_id']);
            if ($submission) {
                $submission['data'] = json_decode($submission['data_json'] ?? '{}', true) ?: [];
            }
        }

        View::render('admin/leads/view', compact('lead','activities','files','submission'), 'admin');
    }

    public function edit(Request $req, array $params = []): void
    {
        $lead = Lead::find((int)$params['id']);
        if (!$lead) View::redirect('/admin/leads');
        View::render('admin/leads/edit', ['lead' => $lead, 'isNew' => false], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $current = Lead::find($id);
        if (!$current) View::redirect('/admin/leads');

        $data = $this->formData($req);
        Lead::update($id, $data);

        // Status change activity
        if (($current['status'] ?? '') !== ($data['status'] ?? '')) {
            $statuses = Lead::STATUSES;
            $oldLabel = $statuses[$current['status']]['label'] ?? $current['status'];
            $newLabel = $statuses[$data['status']]['label']    ?? $data['status'];
            Lead::addActivity($id, 'status_change', "Durum değişti: $oldLabel → $newLabel");
        }

        // Teklif dosyası yüklendiyse ekle
        $this->saveProposalFile($req, $id);

        Session::flash('success', 'Lead güncellendi.');
        View::redirect('/admin/leads/' . $id);
    }

    /** Inline proposal file upload (used in store/update form) */
    private function saveProposalFile(Request $req, int $leadId): void
    {
        $file = $req->file('proposal_file');
        if (!$file || empty($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return;
        }
        $allowed = ['pdf','doc','docx','jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true) || $file['size'] > 25 * 1024 * 1024) {
            Session::flash('error', 'Teklif dosyası geçersiz (PDF/DOC/Görsel, max 25 MB).');
            return;
        }
        $dir = BASE_PATH . '/public/uploads/leads/' . $leadId;
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $safe = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $name = date('Ymd_His') . '_' . substr(uniqid('', true), -6) . '_' . substr($safe, 0, 40) . '.' . $ext;
        $dest = $dir . '/' . $name;
        if (!@move_uploaded_file($file['tmp_name'], $dest)) {
            Session::flash('error', 'Teklif dosyası kaydedilemedi.');
            return;
        }
        $publicPath = '/uploads/leads/' . $leadId . '/' . $name;
        $note = trim((string)$req->post('proposal_file_note', '')) ?: null;
        Lead::addFile($leadId, [
            'kind'        => 'proposal',
            'original'    => $file['name'],
            'path'        => $publicPath,
            'size'        => (int)$file['size'],
            'mime'        => $file['type'] ?? null,
            'note'        => $note,
            'uploaded_by' => $_SESSION['admin_id'] ?? null,
        ]);
        Lead::addActivity($leadId, 'file_upload', 'Teklif dosyası yüklendi: ' . $file['name'], $note, ['kind' => 'proposal', 'path' => $publicPath]);
        Lead::update($leadId, ['proposal_sent_at' => date('Y-m-d H:i:s')]);
    }

    public function destroy(Request $req, array $params = []): void
    {
        Lead::delete((int)$params['id']);
        Session::flash('success', 'Lead silindi.');
        View::redirect('/admin/leads');
    }

    /** Add note as activity */
    public function addNote(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $body = trim((string)$req->post('body', ''));
        if ($body !== '') {
            Lead::addActivity($id, 'note', null, $body);
            Lead::update($id, ['last_contacted_at' => date('Y-m-d H:i:s')]);
            Session::flash('success', 'Not eklendi.');
        }
        View::redirect('/admin/leads/' . $id);
    }

    /** Update status quickly */
    public function changeStatus(Request $req, array $params = []): void
    {
        $id     = (int)$params['id'];
        $status = trim((string)$req->post('status', ''));
        if (isset(Lead::STATUSES[$status])) {
            $current = Lead::find($id);
            if ($current && $current['status'] !== $status) {
                Lead::update($id, ['status' => $status]);
                $oldLabel = Lead::STATUSES[$current['status']]['label'] ?? $current['status'];
                $newLabel = Lead::STATUSES[$status]['label'];
                Lead::addActivity($id, 'status_change', "Durum değişti: $oldLabel → $newLabel");
            }
        }
        if ($req->isAjax()) { View::json(['ok' => true]); return; }
        View::redirect('/admin/leads/' . $id);
    }

    /** Upload file (proposal, contract, brief, photo, etc.) */
    public function uploadFile(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        Lead::ensureTables();
        $file = $req->file('file');
        $kind = trim((string)$req->post('kind', 'other'));
        $note = trim((string)$req->post('note', ''));

        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            Session::flash('error', 'Dosya yüklenemedi.');
            View::redirect('/admin/leads/' . $id);
        }

        $allowed = ['pdf','doc','docx','xls','xlsx','jpg','jpeg','png','webp','zip'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true) || $file['size'] > 25 * 1024 * 1024) {
            Session::flash('error', 'Geçersiz dosya tipi veya boyut (max 25 MB).');
            View::redirect('/admin/leads/' . $id);
        }

        $dir  = BASE_PATH . '/public/uploads/leads/' . $id;
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $safe = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $name = date('Ymd_His') . '_' . substr(uniqid('', true), -6) . '_' . substr($safe, 0, 40) . '.' . $ext;
        $dest = $dir . '/' . $name;

        if (!@move_uploaded_file($file['tmp_name'], $dest)) {
            Session::flash('error', 'Dosya kaydedilemedi.');
            View::redirect('/admin/leads/' . $id);
        }

        $publicPath = '/uploads/leads/' . $id . '/' . $name;
        Lead::addFile($id, [
            'kind'        => $kind,
            'original'    => $file['name'],
            'path'        => $publicPath,
            'size'        => (int)$file['size'],
            'mime'        => $file['type'] ?? null,
            'note'        => $note ?: null,
            'uploaded_by' => $_SESSION['admin_id'] ?? null,
        ]);
        Lead::addActivity($id, 'file_upload', "Dosya yüklendi: " . $file['name'], $note ?: null, ['kind' => $kind, 'path' => $publicPath]);

        // If proposal — auto-set proposal_sent_at
        if ($kind === 'proposal') {
            Lead::update($id, ['proposal_sent_at' => date('Y-m-d H:i:s')]);
        }

        Session::flash('success', 'Dosya yüklendi.');
        View::redirect('/admin/leads/' . $id);
    }

    public function deleteFile(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        Lead::deleteFile((int)$params['file_id']);
        Lead::addActivity($id, 'file_delete', 'Dosya silindi');
        Session::flash('success', 'Dosya silindi.');
        View::redirect('/admin/leads/' . $id);
    }

    /** Convert a form_submission to a lead */
    public function convertFromSubmission(Request $req, array $params = []): void
    {
        $sid = (int)$params['id'];
        $sub = FormSubmission::find($sid);
        if (!$sub) {
            Session::flash('error', 'Başvuru bulunamadı.');
            View::redirect('/admin/submissions');
        }

        // Already converted?
        Lead::ensureTables();
        $existing = DB::first("SELECT id FROM leads WHERE submission_id = ?", [$sid]);
        if ($existing) {
            Session::flash('success', 'Bu başvuru zaten Lead olarak kayıtlı.');
            View::redirect('/admin/leads/' . $existing['id']);
        }

        $leadId = Lead::fromSubmission($sub);
        Session::flash('success', 'Başvuru Lead\'e dönüştürüldü.');
        View::redirect('/admin/leads/' . $leadId);
    }

    private function formData(Request $req): array
    {
        $tags = trim((string)$req->post('tags', ''));
        $tagsArr = array_values(array_filter(array_map('trim', explode(',', $tags))));

        return [
            'name'             => trim((string)$req->post('name', '')),
            'company'          => trim((string)$req->post('company', '')) ?: null,
            'email'            => trim((string)$req->post('email', '')) ?: null,
            'phone'            => trim((string)$req->post('phone', '')) ?: null,
            'status'           => $req->post('status', 'new'),
            'temperature'      => $req->post('temperature', 'warm'),
            'score'            => max(0, min(100, (int)$req->post('score', 50))),
            'source'           => $req->post('source', 'manual'),
            'event_name'       => trim((string)$req->post('event_name', '')) ?: null,
            'event_date'       => trim((string)$req->post('event_date', '')) ?: null,
            'event_location'   => trim((string)$req->post('event_location', '')) ?: null,
            'expected_value'   => $req->post('expected_value', '') !== '' ? (float)$req->post('expected_value', 0) : null,
            'currency'         => $req->post('currency', 'EUR'),
            'has_order'        => (int)(bool)$req->post('has_order', 0),
            'order_ref'        => trim((string)$req->post('order_ref', '')) ?: null,
            'proposal_amount'  => $req->post('proposal_amount', '') !== '' ? (float)$req->post('proposal_amount', 0) : null,
            'next_action'      => trim((string)$req->post('next_action', '')) ?: null,
            'next_action_date' => trim((string)$req->post('next_action_date', '')) ?: null,
            'assigned_to'      => $req->post('assigned_to', '') !== '' ? (int)$req->post('assigned_to', 0) : null,
            'tags_json'        => $tagsArr ? json_encode($tagsArr, JSON_UNESCAPED_UNICODE) : null,
            'notes'            => trim((string)$req->post('notes', '')) ?: null,
        ];
    }
}
