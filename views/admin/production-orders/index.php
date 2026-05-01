<?php
$pageTitle = 'Üretim Siparişleri';
$pretitle  = 'Üretim Yönetimi';
$headerActions = '
    <a href="/admin/production-orders/pipeline" class="btn btn-outline-secondary me-2"><i class="ti ti-layout-kanban me-1"></i>Pipeline</a>
    <a href="/admin/production-orders/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Sipariş</a>
';
$stages = \App\Models\ProductionOrder::STAGES;
?>

<div class="row row-deck row-cards mb-3">
    <?php foreach ($stages as $key => $cfg):
        if ($key === 'cancelled') continue;
        $count = $stageCounts[$key] ?? 0;
        $isActive = ($filters['stage'] ?? '') === $key;
    ?>
    <div class="col">
        <a href="?stage=<?= e($key) ?>" class="card text-decoration-none <?= $isActive ? 'border-primary' : '' ?>">
            <div class="card-body py-2">
                <div class="d-flex align-items-center">
                    <span class="badge bg-<?= e($cfg['color']) ?>-lt me-2" style="font-size:.65rem"><?= e($cfg['label']) ?></span>
                    <span class="ms-auto h4 mb-0"><?= $count ?></span>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 align-items-center flex-wrap">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Ara: sipariş no, başlık, firma..." value="<?= e($filters['q'] ?? '') ?>" style="max-width:300px">
            <select name="stage" class="form-select form-select-sm" style="width:auto">
                <option value="">Tüm Aşamalar</option>
                <?php foreach ($stages as $k => $cfg): ?>
                <option value="<?= e($k) ?>" <?= ($filters['stage'] ?? '') === $k ? 'selected' : '' ?>><?= e($cfg['label']) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-sm btn-primary">Filtrele</button>
            <span class="ms-auto text-muted small">Toplam: <strong><?= $total ?? 0 ?></strong></span>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-hover">
            <thead>
                <tr><th>Sipariş No</th><th>Başlık</th><th>Firma</th><th>Etkinlik</th><th>Aşama</th><th>İlerleme</th><th>Tutar</th><th>Tarih</th><th class="w-1"></th></tr>
            </thead>
            <tbody>
                <?php foreach ($data ?? [] as $o):
                    $st = $stages[$o['current_stage']] ?? ['label'=>$o['current_stage'],'color'=>'gray'];
                ?>
                <tr>
                    <td><code><?= e($o['order_no']) ?></code></td>
                    <td><strong><?= e($o['title']) ?></strong></td>
                    <td><a href="/admin/members/<?= $o['member_id'] ?>" class="text-decoration-none"><?= e($o['member_company'] ?? '—') ?></a></td>
                    <td class="small text-muted"><?= e($o['event_name'] ?? '—') ?><?php if (!empty($o['event_date'])): ?><br><small><?= date('d.m.Y', strtotime($o['event_date'])) ?></small><?php endif; ?></td>
                    <td><span class="badge bg-<?= e($st['color']) ?>-lt"><?= e($st['label']) ?></span></td>
                    <td>
                        <div class="progress progress-sm" style="width:80px"><div class="progress-bar bg-red" style="width:<?= (int)$o['progress'] ?>%"></div></div>
                        <small><?= (int)$o['progress'] ?>%</small>
                    </td>
                    <td class="small">
                        <?php if (!empty($o['total_amount'])): ?>
                        <strong><?= e($o['currency']) ?> <?= number_format((float)$o['total_amount'], 0, ',', '.') ?></strong>
                        <?php else: ?>—<?php endif; ?>
                    </td>
                    <td class="text-muted small"><?= timeAgo($o['created_at']) ?></td>
                    <td><a href="/admin/production-orders/<?= $o['id'] ?>" class="btn btn-sm">Aç</a></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data)): ?>
                <tr><td colspan="9" class="text-center text-muted py-5">Sipariş bulunamadı.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
