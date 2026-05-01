<?php
$pageTitle = 'Stand Kategorileri';
$pretitle  = 'Stand Kataloğu';
$headerActions = '<a href="/admin/catalog/categories/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Kategori</a>';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tüm Kategoriler (<?= count($items) ?>)</h3>
        <div class="card-options">
            <span class="text-muted small">Sıra numarasına göre listelenir. Anahtar (key), kataloğa kayıtlı stand modellerini bağladığı için değiştirilemez.</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th class="w-1">Sıra</th>
                    <th>Anahtar (key)</th>
                    <th>Etiket (TR)</th>
                    <th>Etiket (EN)</th>
                    <th>Ölçü</th>
                    <th>Durum</th>
                    <th class="w-1">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($items)): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">Henüz kategori eklenmemiş.</td></tr>
                <?php endif; ?>
                <?php foreach ($items as $c): ?>
                <tr>
                    <td><span class="badge bg-secondary"><?= (int)$c['sort_order'] ?></span></td>
                    <td><code><?= e($c['cat_key']) ?></code></td>
                    <td><strong><?= e($c['label_tr']) ?></strong></td>
                    <td class="text-muted"><?= e($c['label_en'] ?? '—') ?></td>
                    <td class="text-muted"><?= e($c['dimensions_tr'] ?? '—') ?></td>
                    <td>
                        <?php if (($c['status'] ?? '') === 'active'): ?>
                            <span class="badge bg-success-lt">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-lt">Pasif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-list flex-nowrap">
                            <a href="/admin/catalog/categories/<?= (int)$c['id'] ?>/edit" class="btn btn-sm btn-outline-primary">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form method="POST" action="/admin/catalog/categories/<?= (int)$c['id'] ?>/delete"
                                  onsubmit="return confirm('Bu kategoriyi silmek istediğinize emin misiniz? Mevcut stand modelleri bu kategoride kalacaktır.');" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
