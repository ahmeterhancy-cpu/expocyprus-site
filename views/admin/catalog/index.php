<?php
$pageTitle = 'Stand Kataloğu';
$pretitle  = 'Hazır Stand Modelleri';
$headerActions = '
    <a href="/admin/catalog/categories" class="btn btn-outline-secondary me-2"><i class="ti ti-tags me-1"></i>Kategoriler</a>
    <a href="/admin/catalog/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Stand Modeli</a>
';

$colorPalette = ['blue', 'green', 'orange', 'red', 'purple', 'cyan', 'yellow', 'pink'];
$catLabels = [];
$ci = 0;
foreach (\App\Models\CatalogCategory::allOrdered() as $c) {
    $catLabels[$c['cat_key']] = [
        'label' => $c['label_tr'] ?? $c['cat_key'],
        'dim'   => $c['dimensions_tr'] ?? '',
        'color' => $colorPalette[$ci++ % count($colorPalette)],
    ];
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tüm Stand Modelleri (<?= count($items) ?>)</h3>
        <div class="card-options">
            <span class="text-muted small">Fiyat boş bırakılırsa kart "Fiyat Talep Et" butonu gösterir</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th class="w-1">Görsel</th>
                    <th>Model No</th>
                    <th>Ad (TR)</th>
                    <th>Kategori</th>
                    <th>Ölçü</th>
                    <th>Fiyat</th>
                    <th>Durum</th>
                    <th class="w-1">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i):
                    $cat = $catLabels[$i['size_category']] ?? ['label' => $i['size_category'] ?? '—', 'dim' => '', 'color' => 'secondary'];
                    $symbol = ['EUR'=>'€','USD'=>'$','GBP'=>'£','TRY'=>'₺'][$i['currency'] ?? 'EUR'] ?? '€';
                ?>
                <tr>
                    <td>
                        <?php if (!empty($i['image_main'])): ?>
                            <img src="<?= e($i['image_main']) ?>" alt="" style="width:60px;height:45px;object-fit:cover;border-radius:6px;">
                        <?php else: ?>
                            <div style="width:60px;height:45px;background:rgba(255,255,255,.05);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:.7rem;color:#666"><?= e($i['model_no'] ?? '–') ?></div>
                        <?php endif; ?>
                    </td>
                    <td><code class="badge bg-secondary-lt"><?= e($i['model_no'] ?? '—') ?></code></td>
                    <td>
                        <div class="fw-medium"><?= e($i['name_tr'] ?? '—') ?></div>
                        <?php if (!empty($i['name_en'])): ?>
                        <small class="text-muted"><?= e($i['name_en']) ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge bg-<?= e($cat['color']) ?>-lt"><?= e($cat['label']) ?></span>
                    </td>
                    <td class="text-muted"><?= e($i['dimensions'] ?? $cat['dim']) ?></td>
                    <td>
                        <?php if (!empty($i['price']) && (float)$i['price'] > 0): ?>
                            <strong><?= $symbol ?> <?= number_format((float)$i['price'], 0, ',', '.') ?></strong>
                        <?php else: ?>
                            <span class="badge bg-warning-lt text-warning">Fiyat Talep</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (($i['status'] ?? '') === 'active'): ?>
                            <span class="badge bg-success-lt text-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-warning-lt text-warning">Pasif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/catalog/<?= $i['id'] ?>/edit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="/admin/catalog/<?= $i['id'] ?>/delete" method="POST" class="d-inline" onsubmit="return confirm('Bu modeli silmek istediğinizden emin misiniz?')">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($items)): ?>
                <tr><td colspan="8" class="text-center text-muted py-5">
                    <i class="ti ti-layout-grid" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Henüz stand modeli eklenmemiş. <a href="/admin/catalog/create">İlk modeli ekle →</a>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
