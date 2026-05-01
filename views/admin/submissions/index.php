<?php
$pageTitle = 'Başvurular';
$pretitle  = 'Form Yönetimi';
$headerActions = '<a href="/admin/submissions/export?type=' . e($type ?? '') . '" class="btn btn-outline-secondary"><i class="ti ti-download me-1"></i>CSV İndir</a>';

$formTypeLabels = [
    'contact'           => 'İletişim Formu',
    'stand_inquiry'     => 'Stand Talep Formu',
    'quote_request'     => 'Stand Teklifi (Detaylı)',
    'material_request'  => 'Malzeme Talebi',
];
?>

<!-- Filtreler -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 align-items-center flex-wrap">
            <label class="form-label mb-0">Form Tipi:</label>
            <select name="type" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">Tüm Formlar</option>
                <?php foreach ($types as $t):
                    $tLabel = $formTypeLabels[$t['form_type']] ?? $t['form_type'];
                ?>
                <option value="<?= e($t['form_type']) ?>" <?= ($type ?? '') === $t['form_type'] ? 'selected' : '' ?>>
                    <?= e($tLabel) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <?php if ($type ?? false): ?>
            <a href="/admin/submissions" class="btn btn-sm btn-outline-secondary">Filtreyi Temizle</a>
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
                    <th>Form Tipi</th>
                    <th>Ad / E-posta</th>
                    <th>Sayfa Kaynağı</th>
                    <th>Tarih</th>
                    <th>Durum</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data ?? [] as $sub):
                    $d = json_decode($sub['data_json'] ?? '{}', true) ?: [];
                    $name  = $d['name'] ?? $d['ad_soyad'] ?? $d['isim'] ?? '—';
                    $email = $d['email'] ?? '—';
                ?>
                <tr class="<?= !$sub['is_read'] ? 'fw-semibold' : '' ?>">
                    <td class="text-muted small"><?= $sub['id'] ?></td>
                    <td><span class="badge bg-blue-lt"><?= e($formTypeLabels[$sub['form_type']] ?? $sub['form_type']) ?></span></td>
                    <td>
                        <div><?= e($name) ?></div>
                        <small class="text-muted"><?= e($email) ?></small>
                    </td>
                    <td class="text-muted small"><?= e($sub['source_page'] ?? '—') ?></td>
                    <td class="text-muted small"><?= timeAgo($sub['created_at']) ?></td>
                    <td>
                        <?= !$sub['is_read']
                            ? '<span class="badge bg-danger-lt text-danger">Yeni</span>'
                            : '<span class="badge bg-success-lt text-success">Okundu</span>' ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/submissions/<?= $sub['id'] ?>" class="btn btn-sm">Gör</a>
                            <form action="/admin/submissions/<?= $sub['id'] ?>/delete" method="POST"
                                  onsubmit="return confirm('Bu başvuruyu silmek istediğinizden emin misiniz?')">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data)): ?>
                <tr><td colspan="7" class="text-center text-muted py-5">
                    <i class="ti ti-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Başvuru bulunamadı
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (($last_page ?? 1) > 1): ?>
    <div class="card-footer d-flex justify-content-end">
        <ul class="pagination mb-0">
            <?php for ($i = 1; $i <= ($last_page ?? 1); $i++): ?>
            <li class="page-item <?= $i === ($page ?? 1) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&type=<?= e($type ?? '') ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
