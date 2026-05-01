<?php
$pageTitle = 'Leads (CRM)';
$pretitle  = 'Müşteri / Aday Yönetimi';
$headerActions = '
    <a href="/admin/leads/pipeline" class="btn btn-outline-secondary me-2"><i class="ti ti-layout-kanban me-1"></i>Pipeline</a>
    <a href="/admin/leads/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Lead</a>
';
?>

<!-- Status Pipeline Bar -->
<div class="row row-deck row-cards mb-3">
    <?php foreach (\App\Models\Lead::STATUSES as $key => $cfg):
        $count = $statusCounts[$key] ?? 0;
        $isActive = ($filters['status'] ?? '') === $key;
    ?>
    <div class="col-md col-sm-6">
        <a href="?status=<?= e($key) ?>" class="card text-decoration-none <?= $isActive ? 'border-primary' : '' ?>" style="<?= $isActive ? 'border-width:2px' : '' ?>">
            <div class="card-body py-2">
                <div class="d-flex align-items-center">
                    <span class="badge bg-<?= e($cfg['color']) ?>-lt me-2" style="font-size:.65rem"><?= e($cfg['label']) ?></span>
                    <span class="ms-auto h3 mb-0"><?= $count ?></span>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 align-items-center flex-wrap">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Ara: ad, firma, e-posta, telefon..."
                   value="<?= e($filters['q'] ?? '') ?>" style="max-width:280px">
            <select name="status" class="form-select form-select-sm" style="width:auto">
                <option value="">Tüm Durumlar</option>
                <?php foreach (\App\Models\Lead::STATUSES as $k => $cfg): ?>
                <option value="<?= e($k) ?>" <?= ($filters['status'] ?? '') === $k ? 'selected' : '' ?>><?= e($cfg['label']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="temperature" class="form-select form-select-sm" style="width:auto">
                <option value="">Tüm Sıcaklıklar</option>
                <?php foreach (\App\Models\Lead::TEMPERATURES as $k => $cfg): ?>
                <option value="<?= e($k) ?>" <?= ($filters['temperature'] ?? '') === $k ? 'selected' : '' ?>><?= e($cfg['icon']) ?> <?= e($cfg['label']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="source" class="form-select form-select-sm" style="width:auto">
                <option value="">Tüm Kaynaklar</option>
                <?php foreach (\App\Models\Lead::SOURCES as $k => $label): ?>
                <option value="<?= e($k) ?>" <?= ($filters['source'] ?? '') === $k ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Filtrele</button>
            <?php if (array_filter($filters)): ?>
            <a href="/admin/leads" class="btn btn-sm btn-outline-secondary">Temizle</a>
            <?php endif; ?>
            <span class="ms-auto text-muted small">Toplam: <strong><?= $total ?? 0 ?></strong></span>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ad / Firma</th>
                    <th>İletişim</th>
                    <th>Etkinlik</th>
                    <th>Durum</th>
                    <th>Sıcak</th>
                    <th>Skor</th>
                    <th>Sipariş</th>
                    <th>Bütçe</th>
                    <th>Tarih</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data ?? [] as $l):
                    $st = \App\Models\Lead::STATUSES[$l['status']] ?? ['label' => $l['status'], 'color' => 'secondary'];
                    $tp = \App\Models\Lead::TEMPERATURES[$l['temperature']] ?? ['label' => $l['temperature'], 'color' => 'gray', 'icon' => '•'];
                ?>
                <tr>
                    <td class="text-muted small"><?= $l['id'] ?></td>
                    <td>
                        <div><strong><?= e($l['name']) ?></strong></div>
                        <?php if (!empty($l['company'])): ?>
                        <small class="text-muted"><?= e($l['company']) ?></small>
                        <?php endif; ?>
                    </td>
                    <td class="small">
                        <?php if (!empty($l['email'])): ?><div><?= e($l['email']) ?></div><?php endif; ?>
                        <?php if (!empty($l['phone'])): ?><div class="text-muted"><?= e($l['phone']) ?></div><?php endif; ?>
                    </td>
                    <td class="small text-muted">
                        <?php if (!empty($l['event_name'])): ?>
                        <div><?= e($l['event_name']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($l['event_date'])): ?>
                        <small><?= e(date('d.m.Y', strtotime($l['event_date']))) ?></small>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge bg-<?= e($st['color']) ?>-lt"><?= e($st['label']) ?></span></td>
                    <td><span title="<?= e($tp['label']) ?>"><?= $tp['icon'] ?? '•' ?></span></td>
                    <td>
                        <div class="progress progress-sm" style="width:50px">
                            <div class="progress-bar bg-<?= ($l['score'] ?? 0) >= 70 ? 'green' : (($l['score'] ?? 0) >= 40 ? 'yellow' : 'red') ?>" style="width:<?= (int)$l['score'] ?>%"></div>
                        </div>
                        <small class="text-muted"><?= (int)$l['score'] ?></small>
                    </td>
                    <td>
                        <?php if ((int)$l['has_order'] === 1): ?>
                            <span class="badge bg-success-lt">✓ Var</span>
                        <?php else: ?>
                            <span class="text-muted small">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="small">
                        <?php if (!empty($l['expected_value'])): ?>
                        <strong><?= e($l['currency'] ?? '€') ?> <?= number_format((float)$l['expected_value'], 0, ',', '.') ?></strong>
                        <?php else: ?>
                        <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted small"><?= timeAgo($l['created_at']) ?></td>
                    <td>
                        <a href="/admin/leads/<?= $l['id'] ?>" class="btn btn-sm">Aç</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data)): ?>
                <tr><td colspan="11" class="text-center text-muted py-5">
                    <i class="ti ti-users" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Lead bulunamadı. <a href="/admin/leads/create">Yeni lead ekle</a> veya <a href="/admin/submissions">başvuru</a>'lardan dönüştür.
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (($last_page ?? 1) > 1): ?>
    <div class="card-footer d-flex justify-content-end">
        <ul class="pagination mb-0">
            <?php
            $qs = $_GET; unset($qs['page']);
            $qsStr = http_build_query($qs);
            for ($i = 1; $i <= ($last_page ?? 1); $i++): ?>
            <li class="page-item <?= $i === ($page ?? 1) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&<?= e($qsStr) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
