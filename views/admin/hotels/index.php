<?php $pageTitle = 'Oteller'; $pretitle = 'İçerik Yönetimi'; ?>
<?php
$headerActions = '<a href="/admin/hotels/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Otel</a>';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tüm Oteller (<?= count($hotels) ?>)</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th style="width:60px">Görsel</th>
                    <th>Otel Adı</th>
                    <th>Bölge</th>
                    <th style="width:110px">Yıldız</th>
                    <th>Konum</th>
                    <th style="width:80px">Sıralama</th>
                    <th>Durum</th>
                    <th class="w-1">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hotels as $h): ?>
                <tr>
                    <td>
                        <?php if (!empty($h['image_main'])): ?>
                            <img src="<?= e($h['image_main']) ?>" alt=""
                                 style="width:50px;height:50px;object-fit:cover;border-radius:4px">
                        <?php else: ?>
                            <div style="width:50px;height:50px;background:#2e3440;border-radius:4px;display:flex;align-items:center;justify-content:center">
                                <i class="ti ti-building" style="color:#FFD700"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="fw-medium"><?= e($h['name'] ?? '—') ?></td>
                    <td><span class="badge bg-blue-lt"><?= e($h['region'] ?? '—') ?></span></td>
                    <td>
                        <span style="color:#FFD700;letter-spacing:.05em"><?= str_repeat('★', (int)($h['stars'] ?? 5)) ?></span>
                    </td>
                    <td class="text-muted small"><?= e($h['location'] ?? '—') ?></td>
                    <td class="text-muted"><?= (int)($h['sort_order'] ?? 0) ?></td>
                    <td>
                        <?php if (($h['status'] ?? '') === 'active'): ?>
                            <span class="badge bg-success-lt text-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-warning-lt text-warning">Pasif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/hotels/<?= $h['id'] ?>/edit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-edit"></i> Düzenle
                            </a>
                            <form action="/admin/hotels/<?= $h['id'] ?>/delete" method="POST" class="d-inline"
                                  onsubmit="return confirm('Bu oteli silmek istediğinizden emin misiniz?')">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($hotels)): ?>
                <tr><td colspan="8" class="text-center text-muted py-5">
                    <i class="ti ti-building" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Henüz otel eklenmemiş. <a href="/admin/hotels/create">İlk oteli ekle →</a>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
