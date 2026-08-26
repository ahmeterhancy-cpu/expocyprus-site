<?php $pageTitle = 'Referans Projeler'; $pretitle = 'İçerik Yönetimi'; ?>
<?php
$headerActions = '<a href="/admin/references/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Proje</a>';
$services = \App\Models\ReferenceProject::serviceTypes();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tüm Projeler (<?= count($projects) ?>)</h3>
        <div class="card-actions text-muted small">
            Sıralama: önce ⭐ öne çıkanlar, sonra sıra no, sonra yıl (yeniden eskiye)
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th style="width:60px">Görsel</th>
                    <th>Proje</th>
                    <th>Müşteri</th>
                    <th>Fuar / Etkinlik</th>
                    <th style="width:70px">Yıl</th>
                    <th style="width:70px">m²</th>
                    <th>Hizmet</th>
                    <th style="width:80px">Sıra</th>
                    <th>Durum</th>
                    <th class="w-1">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $p):
                    $gallery = \App\Models\ReferenceProject::gallery($p);
                ?>
                <tr>
                    <td>
                        <?php if (!empty($p['image_main'])): ?>
                            <img src="<?= e($p['image_main']) ?>" alt=""
                                 style="width:50px;height:50px;object-fit:cover;border-radius:4px">
                        <?php else: ?>
                            <div style="width:50px;height:50px;background:#2e3440;border-radius:4px;display:flex;align-items:center;justify-content:center">
                                <i class="ti ti-photo-off" style="color:#6c7a89"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="fw-medium">
                        <?php if (!empty($p['featured'])): ?><span title="Öne çıkan">⭐</span> <?php endif; ?>
                        <?= e($p['title_tr'] ?: '—') ?>
                        <?php if ($gallery): ?>
                            <span class="text-muted small d-block"><i class="ti ti-photo"></i> <?= count($gallery) ?> görsel</span>
                        <?php endif; ?>
                    </td>
                    <td><?= e($p['client'] ?: '—') ?></td>
                    <td class="text-muted small"><?= e($p['fair_name'] ?: '—') ?></td>
                    <td><?= $p['year'] ? (int) $p['year'] : '—' ?></td>
                    <td><?= $p['sqm'] ? (int) $p['sqm'] : '—' ?></td>
                    <td>
                        <?php $s = $p['service_type'] ?? ''; ?>
                        <?php if ($s !== '' && isset($services[$s])): ?>
                            <span class="badge bg-blue-lt"><?= e($services[$s]['tr']) ?></span>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted"><?= (int) ($p['sort_order'] ?? 0) ?></td>
                    <td>
                        <?php if (($p['status'] ?? '') === 'active'): ?>
                            <span class="badge bg-success-lt text-success">Yayında</span>
                        <?php else: ?>
                            <span class="badge bg-warning-lt text-warning">Taslak</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/references/<?= $p['id'] ?>/edit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-edit"></i> Düzenle
                            </a>
                            <form action="/admin/references/<?= $p['id'] ?>/delete" method="POST" class="d-inline"
                                  onsubmit="return confirm('Bu projeyi silmek istediğinizden emin misiniz?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($projects)): ?>
                <tr><td colspan="10" class="text-center text-muted py-5">
                    <i class="ti ti-building-arch" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Henüz referans projesi eklenmemiş — Referanslar sayfasındaki proje bölümü boş görünür.<br>
                    <a href="/admin/references/create">İlk projeyi ekle →</a>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
