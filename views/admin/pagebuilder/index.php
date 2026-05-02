<?php
$pageTitle = 'Sayfa Yöneticisi';
$pretitle  = 'PHPagebuilder — Block-tabanlı sayfalar';
$headerActions = '<a href="/admin/pagebuilder/new" class="btn btn-primary">+ Yeni Sayfa</a>';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sayfalar</h3>
        <small class="text-muted ms-3">Bu sayfalar PHPagebuilder ile drag-drop düzenlenir.</small>
    </div>
    <?php if (empty($pages)): ?>
    <div class="card-body text-center py-5">
        <i class="ti ti-file-plus" style="font-size:3rem;color:#64748b;display:block;margin-bottom:1rem"></i>
        <p class="text-muted">Henüz sayfa yok.</p>
        <a href="/admin/pagebuilder/new" class="btn btn-primary mt-2">+ İlk Sayfayı Oluştur</a>
    </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Ad</th>
                    <th>TR Başlık & Yol</th>
                    <th>EN Başlık & Yol</th>
                    <th>Layout</th>
                    <th>Güncelleme</th>
                    <th class="text-end">İşlem</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pages as $p): ?>
                <tr>
                    <td><strong><?= e($p['name']) ?></strong> <span class="text-muted small">#<?= $p['id'] ?></span></td>
                    <td>
                        <?php if (!empty($p['translations']['tr'])): ?>
                            <div><?= e($p['translations']['tr']['title']) ?></div>
                            <code class="small text-muted"><?= e($p['translations']['tr']['route']) ?></code>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($p['translations']['en'])): ?>
                            <div><?= e($p['translations']['en']['title']) ?></div>
                            <code class="small text-muted"><?= e($p['translations']['en']['route']) ?></code>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge bg-blue-lt"><?= e($p['layout']) ?></span></td>
                    <td class="text-muted small"><?= date('d.m.Y H:i', strtotime($p['updated_at'])) ?></td>
                    <td class="text-end">
                        <a href="/admin/pagebuilder/edit?action=edit&page=<?= $p['id'] ?>" class="btn btn-sm btn-primary"
                           title="Drag-drop block editör">
                            <i class="ti ti-layout-grid"></i> Builder
                        </a>
                        <a href="/admin/pagebuilder/<?= $p['id'] ?>/settings" class="btn btn-sm btn-outline-secondary" title="Sayfa ayarları">
                            <i class="ti ti-settings"></i>
                        </a>
                        <?php if (!empty($p['translations']['tr']['route'])): ?>
                        <a href="<?= e($p['translations']['tr']['route']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Sayfayı görüntüle">
                            <i class="ti ti-external-link"></i>
                        </a>
                        <?php endif; ?>
                        <form action="/admin/pagebuilder/<?= $p['id'] ?>/delete" method="POST" class="d-inline"
                              onsubmit="return confirm('Bu sayfayı silmek istediğinize emin misiniz?')">
                            <button class="btn btn-sm btn-outline-danger" title="Sil"><i class="ti ti-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
