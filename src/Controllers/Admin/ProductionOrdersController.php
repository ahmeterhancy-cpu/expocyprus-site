<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View, DB};
use App\Models\{ProductionOrder, Member, Lead};

class ProductionOrdersController
{
    public function index(Request $req, array $params = []): void
    {
        $page = max(1, (int)$req->get('page', 1));
        $filters = [
            'stage'     => trim((string)$req->get('stage', '')),
            'member_id' => (int)$req->get('member_id', 0),
            'q'         => trim((string)$req->get('q', '')),
        ];
        $result = ProductionOrder::paginateFiltered($page, 25, $filters);
        $stageCounts = ProductionOrder::stageCounts();
        View::render('admin/production-orders/index', array_merge($result, compact('filters','stageCounts')), 'admin');
    }

    public function pipeline(Request $req, array $params = []): void
    {
        ProductionOrder::ensureTables();
        $columns = [];
        foreach (ProductionOrder::STAGES as $key => $cfg) {
            $rows = DB::query("SELECT po.*, m.company_name AS member_company FROM production_orders po LEFT JOIN members m ON m.id = po.member_id WHERE po.current_stage = ? ORDER BY po.updated_at DESC LIMIT 50", [$key]);
            $columns[$key] = ['config' => $cfg, 'orders' => $rows];
        }
        View::render('admin/production-orders/pipeline', compact('columns'), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        ProductionOrder::ensureTables();
        Member::ensureTable();
        $members = DB::query("SELECT id, company_name, contact_name, email FROM members ORDER BY company_name ASC");
        $leadId = (int)$req->get('lead_id', 0);
        $lead = $leadId ? Lead::find($leadId) : null;
        View::render('admin/production-orders/edit', [
            'order' => null, 'isNew' => true, 'members' => $members, 'lead' => $lead
        ], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        ProductionOrder::ensureTables();
        $data = $this->formData($req);
        if ((int)$data['member_id'] === 0 || $data['title'] === '') {
            Session::flash('error', 'Üye ve başlık zorunlu.');
            View::redirect('/admin/production-orders/create');
        }
        $data['order_no']   = ProductionOrder::generateOrderNo();
        $data['progress']   = ProductionOrder::progressForStage($data['current_stage']);
        $data['created_by'] = $_SESSION['admin_id'] ?? null;
        $id = (int)ProductionOrder::create($data);

        // İlk aşama log
        ProductionOrder::logStage($id, $data['current_stage'], 'Sipariş oluşturuldu', $_SESSION['admin_name'] ?? 'Admin', $_SESSION['admin_id'] ?? null);

        // Liste kalemlerini kaydet (Malzeme / Baskı / Üretim)
        $this->saveItemsFromForm($req, $id);

        Session::flash('success', 'Üretim siparişi oluşturuldu.');
        View::redirect('/admin/production-orders/' . $id);
    }

    public function show(Request $req, array $params = []): void
    {
        $order = ProductionOrder::findWithMember((int)$params['id']);
        if (!$order) View::redirect('/admin/production-orders');

        $stagesLog = ProductionOrder::getStagesLog($order['id']);
        $files     = ProductionOrder::getFiles($order['id']);
        $messages  = ProductionOrder::getMessages($order['id']);
        $items     = ProductionOrder::getItems($order['id']);
        $itemStats = ProductionOrder::itemStats($order['id']);

        View::render('admin/production-orders/view', compact('order','stagesLog','files','messages','items','itemStats'), 'admin');
    }

    public function addItem(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $data = [
            'list_type' => trim((string)$req->post('list_type', 'material')),
            'name'      => trim((string)$req->post('name', '')),
            'quantity'  => (float)$req->post('quantity', 1),
            'unit'      => trim((string)$req->post('unit', '')) ?: null,
            'note'      => trim((string)$req->post('note', '')) ?: null,
            'sort_order'=> (int)$req->post('sort_order', 0),
            'is_ready'  => 0,
        ];
        if ($data['name'] === '') {
            Session::flash('error', 'Kalem adı zorunlu.');
        } else {
            ProductionOrder::addItem($id, $data);
            Session::flash('success', 'Liste kalemi eklendi.');
        }
        View::redirect('/admin/production-orders/' . $id);
    }

    public function toggleItem(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $itemId = (int)$params['item_id'];
        $ready = (bool)(int)$req->post('ready', 0);
        ProductionOrder::toggleItemReady($itemId, $ready, $_SESSION['admin_name'] ?? 'Admin');
        if ($req->isAjax()) { View::json(['ok' => true]); return; }
        View::redirect('/admin/production-orders/' . $id);
    }

    public function deleteItem(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        ProductionOrder::deleteItem((int)$params['item_id']);
        Session::flash('success', 'Kalem silindi.');
        View::redirect('/admin/production-orders/' . $id);
    }

    public function edit(Request $req, array $params = []): void
    {
        $order = ProductionOrder::find((int)$params['id']);
        if (!$order) View::redirect('/admin/production-orders');
        Member::ensureTable();
        $members = DB::query("SELECT id, company_name, contact_name, email FROM members ORDER BY company_name ASC");
        View::render('admin/production-orders/edit', [
            'order' => $order, 'isNew' => false, 'members' => $members, 'lead' => null
        ], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $current = ProductionOrder::find($id);
        if (!$current) View::redirect('/admin/production-orders');

        $data = $this->formData($req);
        $data['progress'] = ProductionOrder::progressForStage($data['current_stage']);
        ProductionOrder::update($id, $data);

        if ($current['current_stage'] !== $data['current_stage']) {
            $newLabel = ProductionOrder::STAGES[$data['current_stage']]['label'] ?? $data['current_stage'];
            ProductionOrder::logStage($id, $data['current_stage'], 'Aşama: ' . $newLabel);
        }

        // Liste kalemlerini güncelle (mevcutlar + yeniler)
        $this->saveItemsFromForm($req, $id);

        Session::flash('success', 'Üretim siparişi güncellendi.');
        View::redirect('/admin/production-orders/' . $id);
    }

    /**
     * Form üzerinden gelen items[] dizisini kaydet/güncelle.
     * existing_id varsa update, yoksa insert. Form'da kalan kalemler tutulur, kaldırılanlar (DB'de olup form'da olmayanlar) silinmez (ayrı toggleItem/deleteItem akışı var).
     */
    private function saveItemsFromForm(Request $req, int $orderId): void
    {
        $items = (array)$req->post('items', []);
        $actor = $_SESSION['admin_name'] ?? 'Admin';

        foreach ($items as $listType => $rows) {
            if (!is_array($rows)) continue;
            if (!array_key_exists($listType, ProductionOrder::ITEM_TYPES)) continue;

            foreach ($rows as $idx => $row) {
                $name = trim((string)($row['name'] ?? ''));
                if ($name === '') continue;

                $payload = [
                    'list_type' => $listType,
                    'name'      => $name,
                    'quantity'  => (float)($row['quantity'] ?? 1),
                    'unit'      => trim((string)($row['unit'] ?? '')) ?: null,
                    'note'      => trim((string)($row['note'] ?? '')) ?: null,
                    'sort_order'=> (int)$idx,
                ];
                $isReady = !empty($row['is_ready']);

                if (!empty($row['existing_id'])) {
                    // Update existing item
                    $existingId = (int)$row['existing_id'];
                    \App\Core\DB::update('production_order_items', $payload + [
                        'is_ready' => $isReady ? 1 : 0,
                        'ready_at' => $isReady ? date('Y-m-d H:i:s') : null,
                        'ready_by' => $isReady ? $actor : null,
                    ], ['id' => $existingId]);
                } else {
                    // Insert new
                    $payload['is_ready'] = $isReady ? 1 : 0;
                    if ($isReady) {
                        $payload['ready_at'] = date('Y-m-d H:i:s');
                        $payload['ready_by'] = $actor;
                    }
                    ProductionOrder::addItem($orderId, $payload);
                }
            }
        }
    }

    public function changeStage(Request $req, array $params = []): void
    {
        $id    = (int)$params['id'];
        $stage = trim((string)$req->post('stage', ''));
        $note  = trim((string)$req->post('note', '')) ?: null;
        if (!isset(ProductionOrder::STAGES[$stage])) {
            Session::flash('error', 'Geçersiz aşama.');
            View::redirect('/admin/production-orders/' . $id);
        }
        $progress = ProductionOrder::progressForStage($stage);
        ProductionOrder::update($id, ['current_stage' => $stage, 'progress' => $progress]);
        ProductionOrder::logStage($id, $stage, $note);
        Session::flash('success', 'Aşama güncellendi.');
        View::redirect('/admin/production-orders/' . $id);
    }

    public function destroy(Request $req, array $params = []): void
    {
        ProductionOrder::delete((int)$params['id']);
        Session::flash('success', 'Sipariş silindi.');
        View::redirect('/admin/production-orders');
    }

    public function uploadFile(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $file = $req->file('file');
        $kind = trim((string)$req->post('kind', 'other'));
        $note = trim((string)$req->post('note', '')) ?: null;
        $visibleToMember = (int)(bool)$req->post('visible_to_member', 1);

        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            Session::flash('error', 'Dosya yüklenemedi.');
            View::redirect('/admin/production-orders/' . $id);
        }
        $allowed = ['pdf','doc','docx','xls','xlsx','jpg','jpeg','png','webp','zip','dwg','skp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true) || $file['size'] > 50 * 1024 * 1024) {
            Session::flash('error', 'Geçersiz dosya türü veya boyut (max 50 MB).');
            View::redirect('/admin/production-orders/' . $id);
        }
        $dir = BASE_PATH . '/public/uploads/orders/' . $id;
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $safe = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $name = date('Ymd_His') . '_' . substr(uniqid('', true), -6) . '_' . substr($safe, 0, 40) . '.' . $ext;
        $dest = $dir . '/' . $name;
        if (!@move_uploaded_file($file['tmp_name'], $dest)) {
            Session::flash('error', 'Dosya kaydedilemedi.');
            View::redirect('/admin/production-orders/' . $id);
        }
        $publicPath = '/uploads/orders/' . $id . '/' . $name;
        ProductionOrder::addFile($id, [
            'kind'              => $kind,
            'original'          => $file['name'],
            'path'              => $publicPath,
            'size'              => (int)$file['size'],
            'mime'              => $file['type'] ?? null,
            'note'              => $note,
            'visible_to_member' => $visibleToMember,
            'uploaded_by'       => $_SESSION['admin_id'] ?? null,
        ]);
        Session::flash('success', 'Dosya yüklendi.');
        View::redirect('/admin/production-orders/' . $id);
    }

    public function deleteFile(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        ProductionOrder::deleteFile((int)$params['file_id']);
        Session::flash('success', 'Dosya silindi.');
        View::redirect('/admin/production-orders/' . $id);
    }

    public function sendMessage(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        $body = trim((string)$req->post('body', ''));
        if ($body !== '') {
            ProductionOrder::addMessage(
                $id,
                'admin',
                $_SESSION['admin_id'] ?? null,
                $_SESSION['admin_name'] ?? 'Admin',
                $body
            );
            Session::flash('success', 'Mesaj gönderildi.');
        }
        View::redirect('/admin/production-orders/' . $id);
    }

    private function formData(Request $req): array
    {
        return [
            'member_id'        => (int)$req->post('member_id', 0),
            'lead_id'          => $req->post('lead_id', '') !== '' ? (int)$req->post('lead_id', 0) : null,
            'submission_id'    => $req->post('submission_id', '') !== '' ? (int)$req->post('submission_id', 0) : null,
            'title'            => trim((string)$req->post('title', '')),
            'event_name'       => trim((string)$req->post('event_name', '')) ?: null,
            'event_date'       => trim((string)$req->post('event_date', '')) ?: null,
            'event_location'   => trim((string)$req->post('event_location', '')) ?: null,
            'stand_type'       => trim((string)$req->post('stand_type', '')) ?: null,
            'stand_system'     => trim((string)$req->post('stand_system', '')) ?: null,
            'dimensions'       => trim((string)$req->post('dimensions', '')) ?: null,
            'total_sqm'        => $req->post('total_sqm', '') !== '' ? (float)$req->post('total_sqm', 0) : null,
            'current_stage'    => trim((string)$req->post('current_stage', 'order_received')),
            'total_amount'     => $req->post('total_amount', '') !== '' ? (float)$req->post('total_amount', 0) : null,
            'currency'         => trim((string)$req->post('currency', 'EUR')),
            'paid_amount'      => $req->post('paid_amount', '') !== '' ? (float)$req->post('paid_amount', 0) : 0,
            'expected_delivery'=> trim((string)$req->post('expected_delivery', '')) ?: null,
            'description'      => trim((string)$req->post('description', '')) ?: null,
            'internal_notes'   => trim((string)$req->post('internal_notes', '')) ?: null,
        ];
    }
}
