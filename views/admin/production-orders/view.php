<?php
$pageTitle = $order['order_no'] . ' — ' . $order['title'];
$pretitle  = 'Üretim Sipariş Detay';
$stages = \App\Models\ProductionOrder::STAGES;
$st = $stages[$order['current_stage']] ?? ['label'=>$order['current_stage'],'color'=>'gray'];
$headerActions = '
    <a href="/admin/production-orders/' . $order['id'] . '/edit" class="btn btn-outline-primary me-2"><i class="ti ti-edit me-1"></i>Düzenle</a>
    <a href="/admin/production-orders" class="btn btn-outline-secondary">← Liste</a>
';
$kindLabels = [
    'design' => 'Tasarım', 'render' => '3D Render', 'contract' => 'Sözleşme',
    'invoice' => 'Fatura', 'photo' => 'Fotoğraf', 'production_photo' => 'Üretim Fotoğrafı',
    'site_photo' => 'Saha Fotoğrafı', 'other' => 'Diğer'
];
?>

<!-- Header -->
<div class="card mb-3">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <code class="text-muted"><?= e($order['order_no']) ?></code>
                <h2 class="mb-1"><?= e($order['title']) ?></h2>
                <p class="text-muted mb-0">
                    Firma: <a href="/admin/members/<?= $order['member_id'] ?>"><strong><?= e($order['member_company'] ?? '—') ?></strong></a>
                    · <?= e($order['member_email'] ?? '') ?> · <?= e($order['member_phone'] ?? '—') ?>
                </p>
            </div>
            <div class="col-auto text-end">
                <span class="badge bg-<?= e($st['color']) ?>-lt fs-5"><?= e($st['label']) ?></span>
                <div class="mt-2">
                    <div class="progress" style="width:200px;height:8px"><div class="progress-bar bg-red" style="width:<?= (int)$order['progress'] ?>%"></div></div>
                    <small class="text-muted"><?= (int)$order['progress'] ?>% tamamlandı</small>
                </div>
            </div>
        </div>

        <hr>
        <form method="POST" action="/admin/production-orders/<?= $order['id'] ?>/stage" class="row g-2 align-items-end">
            <div class="col-md-4"><label class="form-label small">Aşamayı Değiştir</label>
                <select name="stage" class="form-select form-select-sm" required>
                    <?php foreach ($stages as $k => $cfg): ?>
                    <option value="<?= e($k) ?>" <?= $order['current_stage'] === $k ? 'selected' : '' ?>><?= e($cfg['label']) ?></option>
                    <?php endforeach; ?>
                </select></div>
            <div class="col-md-6"><label class="form-label small">Not (opsiyonel)</label>
                <input type="text" name="note" class="form-control form-control-sm" placeholder="Aşama değişikliği notu..."></div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100"><i class="ti ti-check me-1"></i>Güncelle</button></div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Order details -->
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Sipariş Bilgileri</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row mb-0">
                            <?php if (!empty($order['event_name'])): ?>
                            <dt class="col-5 text-muted">Etkinlik</dt><dd class="col-7"><?= e($order['event_name']) ?></dd>
                            <?php endif; ?>
                            <?php if (!empty($order['event_date'])): ?>
                            <dt class="col-5 text-muted">Tarih</dt><dd class="col-7"><?= date('d.m.Y', strtotime($order['event_date'])) ?></dd>
                            <?php endif; ?>
                            <?php if (!empty($order['event_location'])): ?>
                            <dt class="col-5 text-muted">Yer</dt><dd class="col-7"><?= e($order['event_location']) ?></dd>
                            <?php endif; ?>
                            <?php if (!empty($order['expected_delivery'])): ?>
                            <dt class="col-5 text-muted">Tahmini Teslim</dt><dd class="col-7"><?= date('d.m.Y', strtotime($order['expected_delivery'])) ?></dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row mb-0">
                            <?php if (!empty($order['stand_type'])): ?>
                            <dt class="col-5 text-muted">Stand Tipi</dt><dd class="col-7"><?= e($order['stand_type']) ?></dd>
                            <?php endif; ?>
                            <?php if (!empty($order['dimensions'])): ?>
                            <dt class="col-5 text-muted">Boyut</dt><dd class="col-7"><?= e($order['dimensions']) ?></dd>
                            <?php endif; ?>
                            <?php if (!empty($order['total_amount'])): ?>
                            <dt class="col-5 text-muted">Toplam</dt><dd class="col-7"><strong><?= e($order['currency']) ?> <?= number_format((float)$order['total_amount'], 2, ',', '.') ?></strong></dd>
                            <dt class="col-5 text-muted">Ödenen</dt><dd class="col-7"><?= e($order['currency']) ?> <?= number_format((float)$order['paid_amount'], 2, ',', '.') ?></dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>
                <?php if (!empty($order['description'])): ?>
                <hr><p style="white-space:pre-wrap"><?= nl2br(e($order['description'])) ?></p>
                <?php endif; ?>
                <?php if (!empty($order['internal_notes'])): ?>
                <div class="alert alert-info mt-2">
                    <strong>İç Notlar:</strong>
                    <p class="mb-0" style="white-space:pre-wrap"><?= nl2br(e($order['internal_notes'])) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Checklists: Malzeme / Baskı / Üretim -->
        <?php
        $itemTypes = \App\Models\ProductionOrder::ITEM_TYPES;
        $itemColors = ['material'=>'blue','print'=>'orange','production_material'=>'green','custom'=>'gray'];
        $itemsByType = [];
        foreach ($items ?? [] as $it) $itemsByType[$it['list_type']][] = $it;
        ?>
        <?php foreach ($itemTypes as $tKey => $tLabel):
            if ($tKey === 'custom') continue; // skip custom for cleaner UI; admins can add via dropdown
            $list = $itemsByType[$tKey] ?? [];
            $stats = $itemStats[$tKey] ?? ['total'=>0,'ready'=>0];
            $pct = $stats['total'] > 0 ? round(($stats['ready'] / $stats['total']) * 100) : 0;
            $color = $itemColors[$tKey] ?? 'gray';
        ?>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ti ti-list-check me-2"></i><?= e($tLabel) ?>
                </h3>
                <div class="card-actions">
                    <span class="text-muted small">
                        <?= $stats['ready'] ?> / <?= $stats['total'] ?>
                    </span>
                    <?php if ($stats['total'] > 0): ?>
                    <span class="badge bg-<?= e($color) ?>-lt ms-2"><?= $pct ?>% hazır</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <?php if ($stats['total'] > 0): ?>
                <div class="progress progress-sm mb-3">
                    <div class="progress-bar bg-<?= e($color) ?>" style="width: <?= $pct ?>%"></div>
                </div>
                <?php endif; ?>

                <?php if (empty($list)): ?>
                <p class="text-muted small mb-3">Henüz kalem yok. Aşağıdan ekleyin.</p>
                <?php else: ?>
                <div class="poi-list mb-3">
                    <?php foreach ($list as $it): ?>
                    <div class="poi-item d-flex align-items-center gap-2 p-2 rounded mb-1" style="background: <?= !empty($it['is_ready']) ? 'rgba(16,185,129,.08)' : 'var(--tblr-bg-surface-secondary, #f5f5f7)' ?>; border: 1px solid <?= !empty($it['is_ready']) ? 'rgba(16,185,129,.3)' : 'transparent' ?>">
                        <form method="POST" action="/admin/production-orders/<?= $order['id'] ?>/item/<?= $it['id'] ?>/toggle" style="margin:0">
                            <input type="hidden" name="ready" value="<?= !empty($it['is_ready']) ? '0' : '1' ?>">
                            <button type="submit" class="btn btn-sm <?= !empty($it['is_ready']) ? 'btn-success' : 'btn-outline-secondary' ?>" style="width:32px;height:32px;padding:0;border-radius:50%;display:flex;align-items:center;justify-content:center" title="<?= !empty($it['is_ready']) ? 'Hazırı geri al' : 'Hazır olarak işaretle' ?>">
                                <?php if (!empty($it['is_ready'])): ?>✓<?php else: ?>○<?php endif; ?>
                            </button>
                        </form>
                        <div class="flex-grow-1" style="<?= !empty($it['is_ready']) ? 'text-decoration:line-through;opacity:.6' : '' ?>">
                            <strong><?= e($it['name']) ?></strong>
                            <span class="badge bg-secondary-lt ms-2"><?= rtrim(rtrim(number_format((float)$it['quantity'], 2, ',', '.'), '0'), ',') ?> <?= e($it['unit'] ?? 'adet') ?></span>
                            <?php if (!empty($it['note'])): ?>
                            <br><small class="text-muted"><?= e($it['note']) ?></small>
                            <?php endif; ?>
                            <?php if (!empty($it['is_ready']) && !empty($it['ready_at'])): ?>
                            <br><small class="text-success">✓ Hazır: <?= date('d.m.Y H:i', strtotime($it['ready_at'])) ?> · <?= e($it['ready_by'] ?? '—') ?></small>
                            <?php endif; ?>
                        </div>
                        <form method="POST" action="/admin/production-orders/<?= $order['id'] ?>/item/<?= $it['id'] ?>/delete" onsubmit="return confirm('Sil?')">
                            <button class="btn btn-sm btn-outline-danger" style="padding:.15rem .4rem"><i class="ti ti-trash"></i></button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Add new item -->
                <form method="POST" action="/admin/production-orders/<?= $order['id'] ?>/item/add" class="row g-2">
                    <input type="hidden" name="list_type" value="<?= e($tKey) ?>">
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Kalem adı (örn: 18mm MDF, Logo Print, vb.)" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" min="0" name="quantity" class="form-control form-control-sm" placeholder="Adet" value="1">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="unit" class="form-control form-control-sm" placeholder="adet/m²/kg/lt">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="note" class="form-control form-control-sm" placeholder="Not">
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-sm btn-primary w-100"><i class="ti ti-plus"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Files -->
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title"><i class="ti ti-files me-2"></i>Dosyalar</h3></div>
            <div class="card-body">
                <form method="POST" action="/admin/production-orders/<?= $order['id'] ?>/upload" enctype="multipart/form-data" class="row g-2 align-items-end mb-3">
                    <div class="col-md-3"><label class="form-label small">Dosya Türü</label>
                        <select name="kind" class="form-select form-select-sm">
                            <?php foreach ($kindLabels as $k => $kl): ?>
                            <option value="<?= e($k) ?>"><?= e($kl) ?></option>
                            <?php endforeach; ?>
                        </select></div>
                    <div class="col-md-4"><label class="form-label small">Dosya</label>
                        <input type="file" name="file" class="form-control form-control-sm" required></div>
                    <div class="col-md-3"><label class="form-label small">Not</label>
                        <input type="text" name="note" class="form-control form-control-sm"></div>
                    <div class="col-md-1"><label class="form-label small">Üyeye Açık</label>
                        <input type="checkbox" name="visible_to_member" value="1" checked class="form-check-input mt-2"></div>
                    <div class="col-md-1"><button class="btn btn-sm btn-primary w-100"><i class="ti ti-upload"></i></button></div>
                </form>

                <?php if (empty($files)): ?>
                <p class="text-muted small mb-0">Henüz dosya yok.</p>
                <?php else: ?>
                <div class="list-group">
                    <?php foreach ($files as $f): ?>
                    <div class="list-group-item d-flex align-items-center gap-3">
                        <i class="ti ti-file-text text-muted" style="font-size:1.5rem"></i>
                        <div class="flex-grow-1">
                            <a href="<?= e($f['path']) ?>" target="_blank"><strong><?= e($f['original']) ?></strong></a>
                            <span class="badge bg-secondary-lt ms-2"><?= e($kindLabels[$f['kind']] ?? $f['kind']) ?></span>
                            <?php if (!empty($f['visible_to_member'])): ?><span class="badge bg-success-lt ms-1">Üye Görür</span><?php endif; ?>
                            <br>
                            <small class="text-muted">
                                <?= number_format((int)$f['size']/1024, 0) ?> KB · <?= date('d.m.Y H:i', strtotime($f['created_at'])) ?>
                                <?php if (!empty($f['note'])): ?> · <em><?= e($f['note']) ?></em><?php endif; ?>
                            </small>
                        </div>
                        <form method="POST" action="/admin/production-orders/<?= $order['id'] ?>/file/<?= $f['id'] ?>/delete" onsubmit="return confirm('Sil?')">
                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Messages -->
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title"><i class="ti ti-messages me-2"></i>Müşteri Mesajları</h3></div>
            <div class="card-body">
                <?php if (empty($messages)): ?>
                <p class="text-muted small">Henüz mesaj yok.</p>
                <?php else: ?>
                <div style="max-height:400px;overflow-y:auto;background:#f5f5f7;padding:1rem;border-radius:8px;display:flex;flex-direction:column;gap:.5rem;margin-bottom:1rem">
                    <?php foreach ($messages as $m): ?>
                    <div style="background:<?= $m['from_role']==='admin'?'#1d1d1f':'#fff' ?>;color:<?= $m['from_role']==='admin'?'#fff':'inherit' ?>;padding:.75rem 1rem;border-radius:12px;align-self:<?= $m['from_role']==='admin'?'flex-end':'flex-start' ?>;max-width:80%">
                        <small style="opacity:.7"><strong><?= e($m['from_name']) ?></strong> · <?= timeAgo($m['created_at']) ?></small>
                        <div style="white-space:pre-wrap;margin-top:.25rem"><?= nl2br(e($m['body'])) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <form method="POST" action="/admin/production-orders/<?= $order['id'] ?>/message" class="d-flex gap-2">
                    <textarea name="body" class="form-control" rows="2" placeholder="Mesaj yaz..." required></textarea>
                    <button class="btn btn-primary" style="white-space:nowrap;align-self:flex-end"><i class="ti ti-send me-1"></i>Gönder</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right: Stage Timeline -->
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title"><i class="ti ti-history me-2"></i>Aşama Geçmişi</h3></div>
            <div class="card-body">
                <?php if (empty($stagesLog)): ?>
                <p class="text-muted small">Henüz aşama kaydı yok.</p>
                <?php else: ?>
                <ul class="timeline list-unstyled" style="margin-left:1rem">
                    <?php foreach (array_reverse($stagesLog) as $log):
                        $sCfg = $stages[$log['stage']] ?? ['label'=>$log['stage'],'color'=>'gray'];
                    ?>
                    <li class="mb-3" style="position:relative;padding-left:1.5rem;border-left:2px solid var(--tblr-border-color);">
                        <span class="position-absolute" style="left:-8px;top:0;width:16px;height:16px;background:#fff;border-radius:50%;border:3px solid var(--tblr-<?= e($sCfg['color']) ?>);"></span>
                        <div>
                            <span class="badge bg-<?= e($sCfg['color']) ?>-lt"><?= e($sCfg['label']) ?></span>
                            <small class="text-muted ms-1"><?= date('d.m.Y H:i', strtotime($log['created_at'])) ?></small>
                        </div>
                        <?php if (!empty($log['note'])): ?>
                        <p class="small mb-0 mt-1" style="white-space:pre-wrap"><?= nl2br(e($log['note'])) ?></p>
                        <?php endif; ?>
                        <small class="text-muted"><?= e($log['actor_name']) ?></small>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="/admin/production-orders/<?= $order['id'] ?>/delete" method="POST"
                      onsubmit="return confirm('Bu siparişi kalıcı olarak silmek istediğinize emin misiniz?')">
                    <button class="btn btn-outline-danger w-100"><i class="ti ti-trash me-1"></i>Siparişi Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>
