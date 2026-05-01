<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Üretim Siparişi' : 'Siparişi Düzenle';
$pretitle  = 'Üretim';
$action    = ($isNew ?? true) ? '/admin/production-orders/store' : '/admin/production-orders/' . ($order['id'] ?? 0) . '/update';
$o = $order ?? [];
$stages = \App\Models\ProductionOrder::STAGES;
$selectedMember = (int)($o['member_id'] ?? $_GET['member_id'] ?? 0);

// Pre-fill from lead if present
if (!empty($lead) && empty($o)) {
    $o = [
        'event_name'     => $lead['event_name'] ?? null,
        'event_date'     => $lead['event_date'] ?? null,
        'event_location' => $lead['event_location'] ?? null,
        'lead_id'        => $lead['id'],
        'title'          => $lead['event_name'] ?? '—',
    ];
}
$headerActions = '<a href="/admin/production-orders" class="btn btn-outline-secondary">← Liste</a>';
?>

<form action="<?= e($action) ?>" method="POST">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Temel Bilgiler</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-label required">Üye / Firma</label>
                            <select name="member_id" class="form-select" required>
                                <option value="">— Üye Seçin —</option>
                                <?php foreach ($members as $mb): ?>
                                <option value="<?= $mb['id'] ?>" <?= $selectedMember === (int)$mb['id'] ? 'selected' : '' ?>><?= e($mb['company_name']) ?> — <?= e($mb['contact_name']) ?> (<?= e($mb['email']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Önce <a href="/admin/members/create">yeni üye</a> oluşturmanız gerekir.</small>
                        </div>
                        <div class="col-md-12"><label class="form-label required">Sipariş Başlığı</label>
                            <input type="text" name="title" class="form-control" value="<?= e($o['title'] ?? '') ?>" required placeholder="Örn: Saray Hotel Stand Tasarım & Kurulum"></div>

                        <div class="col-md-6"><label class="form-label">Etkinlik Adı</label>
                            <input type="text" name="event_name" class="form-control" value="<?= e($o['event_name'] ?? '') ?>"></div>
                        <div class="col-md-3"><label class="form-label">Etkinlik Tarihi</label>
                            <input type="date" name="event_date" class="form-control" value="<?= e($o['event_date'] ?? '') ?>"></div>
                        <div class="col-md-3"><label class="form-label">Etkinlik Yeri</label>
                            <input type="text" name="event_location" class="form-control" value="<?= e($o['event_location'] ?? '') ?>"></div>

                        <div class="col-md-3"><label class="form-label">Stand Tipi</label>
                            <input type="text" name="stand_type" class="form-control" value="<?= e($o['stand_type'] ?? '') ?>"></div>
                        <div class="col-md-3"><label class="form-label">Sistem</label>
                            <input type="text" name="stand_system" class="form-control" value="<?= e($o['stand_system'] ?? '') ?>"></div>
                        <div class="col-md-3"><label class="form-label">Boyutlar</label>
                            <input type="text" name="dimensions" class="form-control" value="<?= e($o['dimensions'] ?? '') ?>" placeholder="6m × 4m"></div>
                        <div class="col-md-3"><label class="form-label">Toplam (m²)</label>
                            <input type="number" step="0.01" name="total_sqm" class="form-control" value="<?= e($o['total_sqm'] ?? '') ?>"></div>

                        <div class="col-md-12"><label class="form-label">Açıklama (üye görür)</label>
                            <textarea name="description" rows="4" class="form-control"><?= e($o['description'] ?? '') ?></textarea></div>
                        <div class="col-md-12"><label class="form-label">İç Notlar (sadece admin)</label>
                            <textarea name="internal_notes" rows="3" class="form-control"><?= e($o['internal_notes'] ?? '') ?></textarea></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Aşama & İlerleme</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Şu anki Aşama</label>
                        <select name="current_stage" class="form-select">
                            <?php foreach ($stages as $k => $cfg): ?>
                            <option value="<?= e($k) ?>" <?= ($o['current_stage'] ?? 'order_received') === $k ? 'selected' : '' ?>><?= e($cfg['label']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahmini Teslim Tarihi</label>
                        <input type="date" name="expected_delivery" class="form-control" value="<?= e($o['expected_delivery'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Tutar</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8"><label class="form-label">Toplam Tutar</label>
                            <input type="number" step="0.01" name="total_amount" class="form-control" value="<?= e($o['total_amount'] ?? '') ?>"></div>
                        <div class="col-md-4"><label class="form-label">Para Birimi</label>
                            <select name="currency" class="form-select">
                                <?php foreach (['EUR'=>'EUR','TRY'=>'TRY','USD'=>'USD','GBP'=>'GBP'] as $c => $cl): ?>
                                <option value="<?= $c ?>" <?= ($o['currency'] ?? 'EUR') === $c ? 'selected' : '' ?>><?= $cl ?></option>
                                <?php endforeach; ?>
                            </select></div>
                        <div class="col-md-12"><label class="form-label">Ödenen Tutar</label>
                            <input type="number" step="0.01" name="paid_amount" class="form-control" value="<?= e($o['paid_amount'] ?? '0') ?>"></div>
                    </div>
                </div>
            </div>

            <?php if (!empty($lead)): ?>
            <input type="hidden" name="lead_id" value="<?= $lead['id'] ?>">
            <div class="card mb-3 border-info">
                <div class="card-body small">
                    <i class="ti ti-link"></i> Bu sipariş <a href="/admin/leads/<?= $lead['id'] ?>" target="_blank">Lead #<?= $lead['id'] ?></a> ile ilişkilendiriliyor.
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════
         MALZEME / BASKI / ÜRETİM LİSTELERİ (yeni siparişlerde de eklenebilir)
    ═══════════════════════════════════════════════════════════════ -->
    <?php
    $listTypes = [
        'material'            => ['label' => 'Malzeme Listesi',          'color' => 'blue',   'icon' => 'ti-box'],
        'print'               => ['label' => 'Baskı Listesi',            'color' => 'orange', 'icon' => 'ti-printer'],
        'production_material' => ['label' => 'Malzeme Üretim Listesi',   'color' => 'green',  'icon' => 'ti-tools'],
    ];

    // Mevcut sipariş ise items'ı çekelim
    $existingItems = [];
    if (!($isNew ?? true) && !empty($order['id'])) {
        $existingItems = \App\Models\ProductionOrder::getItems((int)$order['id']);
    }
    $itemsByType = [];
    foreach ($existingItems as $it) $itemsByType[$it['list_type']][] = $it;
    ?>

    <div class="row">
        <?php foreach ($listTypes as $tKey => $tCfg):
            $existing = $itemsByType[$tKey] ?? [];
        ?>
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti <?= e($tCfg['icon']) ?> me-2"></i><?= e($tCfg['label']) ?>
                    </h3>
                    <div class="card-actions">
                        <button type="button" class="btn btn-sm btn-<?= e($tCfg['color']) ?>-lt poi-add-row" data-list-type="<?= e($tKey) ?>">
                            <i class="ti ti-plus me-1"></i>Satır Ekle
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="poi-rows" data-list-type="<?= e($tKey) ?>">
                        <!-- Header -->
                        <div class="row g-2 mb-2 text-muted small fw-bold">
                            <div class="col-md-1 text-center">Hazır</div>
                            <div class="col-md-4">Kalem Adı</div>
                            <div class="col-md-2">Adet</div>
                            <div class="col-md-2">Birim</div>
                            <div class="col-md-2">Not</div>
                            <div class="col-md-1"></div>
                        </div>

                        <?php foreach ($existing as $idx => $it): ?>
                        <div class="row g-2 mb-2 align-items-center poi-row" data-existing-id="<?= (int)$it['id'] ?>">
                            <div class="col-md-1 text-center">
                                <input type="hidden" name="items[<?= e($tKey) ?>][<?= $idx ?>][existing_id]" value="<?= (int)$it['id'] ?>">
                                <input type="checkbox" class="form-check-input" name="items[<?= e($tKey) ?>][<?= $idx ?>][is_ready]" value="1" <?= !empty($it['is_ready']) ? 'checked' : '' ?> title="Hazır işaretle">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="items[<?= e($tKey) ?>][<?= $idx ?>][name]" class="form-control form-control-sm" value="<?= e($it['name']) ?>" placeholder="Kalem adı">
                            </div>
                            <div class="col-md-2">
                                <input type="number" step="0.01" min="0" name="items[<?= e($tKey) ?>][<?= $idx ?>][quantity]" class="form-control form-control-sm" value="<?= e($it['quantity']) ?>">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="items[<?= e($tKey) ?>][<?= $idx ?>][unit]" class="form-control form-control-sm" value="<?= e($it['unit'] ?? '') ?>" placeholder="adet/m²/kg">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="items[<?= e($tKey) ?>][<?= $idx ?>][note]" class="form-control form-control-sm" value="<?= e($it['note'] ?? '') ?>" placeholder="Not">
                            </div>
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger poi-remove-row"><i class="ti ti-x"></i></button>
                            </div>
                            <?php if (!empty($it['is_ready']) && !empty($it['ready_at'])): ?>
                            <div class="col-12">
                                <small class="text-success">✓ Hazır: <?= date('d.m.Y H:i', strtotime($it['ready_at'])) ?> · <?= e($it['ready_by'] ?? '—') ?></small>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (empty($existing)): ?>
                    <p class="text-muted small mb-0 poi-empty">Henüz kalem yok. <strong>"Satır Ekle"</strong> ile başlayın.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Hidden template -->
    <template id="poi-row-template">
        <div class="row g-2 mb-2 align-items-center poi-row">
            <div class="col-md-1 text-center">
                <input type="checkbox" class="form-check-input" data-name-suffix="[is_ready]" value="1" title="Hazır işaretle">
            </div>
            <div class="col-md-4">
                <input type="text" data-name-suffix="[name]" class="form-control form-control-sm" placeholder="Kalem adı" required>
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" min="0" data-name-suffix="[quantity]" class="form-control form-control-sm" value="1">
            </div>
            <div class="col-md-2">
                <input type="text" data-name-suffix="[unit]" class="form-control form-control-sm" placeholder="adet/m²/kg">
            </div>
            <div class="col-md-2">
                <input type="text" data-name-suffix="[note]" class="form-control form-control-sm" placeholder="Not">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-sm btn-outline-danger poi-remove-row"><i class="ti ti-x"></i></button>
            </div>
        </div>
    </template>

    <div class="card mt-3"><div class="card-body d-flex justify-content-between">
        <a href="/admin/production-orders" class="btn btn-outline-secondary">İptal</a>
        <button class="btn btn-primary px-5"><?= ($isNew ?? true) ? 'Sipariş Oluştur' : 'Kaydet' ?></button>
    </div></div>
</form>

<script>
(function() {
    const counters = {};
    document.querySelectorAll('.poi-rows').forEach(c => {
        const type = c.dataset.listType;
        // Find max existing index
        let max = -1;
        c.querySelectorAll('.poi-row').forEach(r => {
            const inputs = r.querySelectorAll('input[name*="[' + type + ']"]');
            inputs.forEach(i => {
                const m = i.name.match(/\[(\d+)\]/);
                if (m) max = Math.max(max, parseInt(m[1], 10));
            });
        });
        counters[type] = max + 1;
    });

    document.querySelectorAll('.poi-add-row').forEach(btn => {
        btn.addEventListener('click', () => {
            const type = btn.dataset.listType;
            const container = document.querySelector('.poi-rows[data-list-type="' + type + '"]');
            const tpl = document.getElementById('poi-row-template').content.cloneNode(true);
            const idx = counters[type]++;

            tpl.querySelectorAll('[data-name-suffix]').forEach(el => {
                const suffix = el.dataset.nameSuffix;
                el.name = 'items[' + type + '][' + idx + ']' + suffix;
                el.removeAttribute('data-name-suffix');
            });
            container.appendChild(tpl);

            // Hide empty placeholder
            const empty = container.parentElement.querySelector('.poi-empty');
            if (empty) empty.style.display = 'none';
        });
    });

    document.addEventListener('click', (e) => {
        if (e.target.closest('.poi-remove-row')) {
            const row = e.target.closest('.poi-row');
            if (!row) return;
            // If it's an existing item, mark for deletion via hidden flag
            const existingId = row.dataset.existingId;
            if (existingId) {
                if (!confirm('Bu kalem silinecek. Emin misiniz?')) return;
            }
            row.remove();
        }
    });
})();
</script>
