<?php
$pageTitle = 'Üretim Pipeline';
$pretitle  = 'Üretim';
$headerActions = '
    <a href="/admin/production-orders" class="btn btn-outline-secondary me-2"><i class="ti ti-list me-1"></i>Liste</a>
    <a href="/admin/production-orders/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Sipariş</a>
';
?>

<div style="display:flex; gap:1rem; overflow-x:auto; padding-bottom:1rem">
    <?php foreach ($columns as $key => $col):
        $cfg = $col['config'];
        $count = count($col['orders']);
    ?>
    <div style="flex:0 0 280px; min-width:280px">
        <div class="card">
            <div class="card-header py-2 d-flex justify-content-between align-items-center">
                <span class="badge bg-<?= e($cfg['color']) ?>-lt"><?= e($cfg['label']) ?></span>
                <small class="text-muted"><?= $count ?></small>
            </div>
            <div class="card-body p-2" style="max-height:80vh;overflow-y:auto">
                <?php if (empty($col['orders'])): ?>
                <p class="text-muted small text-center py-2 mb-0">Boş</p>
                <?php else: foreach ($col['orders'] as $o): ?>
                <a href="/admin/production-orders/<?= $o['id'] ?>" class="d-block mb-2 p-3 rounded text-decoration-none" style="background:var(--tblr-bg-surface-secondary);border:1px solid var(--tblr-border-color);color:inherit">
                    <code class="text-muted small d-block mb-1"><?= e($o['order_no']) ?></code>
                    <strong><?= e($o['title']) ?></strong>
                    <?php if (!empty($o['member_company'])): ?>
                    <div class="small text-muted"><?= e($o['member_company']) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($o['event_name'])): ?>
                    <div class="small mt-1">📅 <?= e($o['event_name']) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($o['total_amount'])): ?>
                    <div class="small text-success mt-1"><strong><?= e($o['currency']) ?> <?= number_format((float)$o['total_amount'], 0, ',', '.') ?></strong></div>
                    <?php endif; ?>
                    <div class="progress mt-2" style="height:4px"><div class="progress-bar bg-red" style="width:<?= (int)$o['progress'] ?>%"></div></div>
                </a>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
