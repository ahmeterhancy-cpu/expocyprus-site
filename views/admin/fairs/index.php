<?php $pageTitle = 'Fuarlar'; $pretitle = 'İçerik Yönetimi'; ?>
<?php
$headerActions = '<a href="/admin/fairs/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Fuar</a>';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tüm Fuarlar (<?= count($fairs) ?>)</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th style="width:60px">Görsel</th>
                    <th>Fuar Adı (TR)</th>
                    <th>Fuar Adı (EN)</th>
                    <th>Sonraki Tarih</th>
                    <th>Konum</th>
                    <th>Durum</th>
                    <th class="w-1">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fairs as $f): ?>
                <tr>
                    <td>
                        <?php if (!empty($f['image_hero'])): ?>
                            <img src="<?= e($f['image_hero']) ?>" alt=""
                                 style="width:50px;height:50px;object-fit:cover;border-radius:4px">
                        <?php else: ?>
                            <div style="width:50px;height:50px;background:#2e3440;border-radius:4px;display:flex;align-items:center;justify-content:center">
                                <i class="ti ti-building-community text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="fw-medium"><?= e($f['name_tr'] ?? '—') ?></td>
                    <td class="text-muted"><?= e($f['name_en'] ?? '—') ?></td>
                    <td class="text-muted small">
                        <?= !empty($f['next_date']) ? date('d.m.Y', strtotime($f['next_date'])) : '—' ?>
                    </td>
                    <td class="text-muted"><?= e($f['location'] ?? '—') ?></td>
                    <td>
                        <?php if (($f['status'] ?? '') === 'active'): ?>
                            <span class="badge bg-success-lt text-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-warning-lt text-warning">Pasif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/fairs/<?= $f['id'] ?>/edit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-edit"></i> Düzenle
                            </a>
                            <form action="/admin/fairs/<?= $f['id'] ?>/delete" method="POST" class="d-inline"
                                  onsubmit="return confirm('Bu fuarı silmek istediğinizden emin misiniz?')">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($fairs)): ?>
                <tr><td colspan="7" class="text-center text-muted py-5">
                    <i class="ti ti-building-community" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Henüz fuar eklenmemiş. <a href="/admin/fairs/create">İlk fuarı ekle →</a>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
