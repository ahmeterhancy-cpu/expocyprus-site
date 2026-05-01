<?php
$pageTitle = 'Firma Üyeleri';
$pretitle  = 'Üyelik Yönetimi';
$headerActions = '<a href="/admin/members/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Üye</a>';
?>

<div class="row row-deck row-cards mb-3">
    <?php foreach (\App\Models\Member::STATUSES as $key => $cfg):
        $count = $statusCounts[$key] ?? 0;
        $isActive = ($filters['status'] ?? '') === $key;
    ?>
    <div class="col-md col-sm-6">
        <a href="?status=<?= e($key) ?>" class="card text-decoration-none <?= $isActive ? 'border-primary' : '' ?>" style="<?= $isActive ? 'border-width:2px' : '' ?>">
            <div class="card-body py-2">
                <div class="d-flex align-items-center">
                    <span class="badge bg-<?= e($cfg['color']) ?>-lt me-2"><?= e($cfg['label']) ?></span>
                    <span class="ms-auto h3 mb-0"><?= $count ?></span>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 align-items-center flex-wrap">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Ara..." value="<?= e($filters['q'] ?? '') ?>" style="max-width:280px">
            <select name="status" class="form-select form-select-sm" style="width:auto">
                <option value="">Tüm Durumlar</option>
                <?php foreach (\App\Models\Member::STATUSES as $k => $cfg): ?>
                <option value="<?= e($k) ?>" <?= ($filters['status'] ?? '') === $k ? 'selected' : '' ?>><?= e($cfg['label']) ?></option>
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
                <tr><th>#</th><th>Firma</th><th>Yetkili</th><th>İletişim</th><th>Durum</th><th>Son Giriş</th><th>Tarih</th><th class="w-1"></th></tr>
            </thead>
            <tbody>
                <?php foreach ($data ?? [] as $m):
                    $st = \App\Models\Member::STATUSES[$m['status']] ?? ['label'=>$m['status'],'color'=>'gray'];
                ?>
                <tr>
                    <td class="text-muted small"><?= $m['id'] ?></td>
                    <td><strong><?= e($m['company_name']) ?></strong><br><small class="text-muted"><?= e($m['city'] ?? '') ?></small></td>
                    <td><?= e($m['contact_name']) ?></td>
                    <td class="small"><?= e($m['email']) ?><br><span class="text-muted"><?= e($m['phone'] ?? '—') ?></span></td>
                    <td><span class="badge bg-<?= e($st['color']) ?>-lt"><?= e($st['label']) ?></span></td>
                    <td class="text-muted small"><?= !empty($m['last_login_at']) ? timeAgo($m['last_login_at']) : '—' ?></td>
                    <td class="text-muted small"><?= timeAgo($m['created_at']) ?></td>
                    <td><a href="/admin/members/<?= $m['id'] ?>" class="btn btn-sm">Aç</a></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data)): ?>
                <tr><td colspan="8" class="text-center text-muted py-5">Üye bulunamadı.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
