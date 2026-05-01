<?php $pageTitle = 'Hizmetler'; $pretitle = 'İçerik Yönetimi'; ?>
<?php
$headerActions = '<a href="/admin/services/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Hizmet</a>';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tüm Hizmetler (<?= count($services) ?>)</h3>
        <div class="card-options">
            <span class="text-muted small">Sıralamayı sürükle-bırak ile değiştirebilirsiniz</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th style="width:40px">Sıra</th>
                    <th>Başlık TR</th>
                    <th>Başlık EN</th>
                    <th>Slug</th>
                    <th>Durum</th>
                    <th class="w-1">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $s): ?>
                <tr>
                    <td class="text-muted"><?= (int)$s['sort_order'] ?></td>
                    <td class="fw-medium"><?= e($s['title_tr']) ?></td>
                    <td class="text-muted"><?= e($s['title_en']) ?></td>
                    <td><code><?= e($s['slug']) ?></code></td>
                    <td>
                        <?php if ($s['status'] === 'active'): ?>
                            <span class="badge bg-success-lt text-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-warning-lt text-warning">Pasif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/services/<?= $s['id'] ?>/edit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-edit"></i> Düzenle
                            </a>
                            <form action="/admin/services/<?= $s['id'] ?>/delete" method="POST" class="d-inline" onsubmit="return confirm('Bu hizmeti silmek istediğinizden emin misiniz?')">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($services)): ?>
                <tr><td colspan="6" class="text-center text-muted py-5">
                    <i class="ti ti-tools" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Henüz hizmet eklenmemiş. <a href="/admin/services/create">İlk hizmeti ekle →</a>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
