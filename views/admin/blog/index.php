<?php $pageTitle = 'Blog Yazıları'; $pretitle = 'İçerik Yönetimi'; ?>
<?php
$headerActions = '<a href="/admin/blog/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Yazı</a>';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tüm Blog Yazıları (<?= count($posts) ?>)</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Dil</th>
                    <th>Kategori</th>
                    <th>Durum</th>
                    <th>Yayın Tarihi</th>
                    <th class="w-1">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $p): ?>
                <tr>
                    <td class="fw-medium"><?= e($p['title']) ?></td>
                    <td>
                        <?php if (($p['lang'] ?? 'tr') === 'tr'): ?>
                            <span class="badge bg-blue-lt">TR</span>
                        <?php else: ?>
                            <span class="badge bg-cyan-lt">EN</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted"><?= e($p['category'] ?? '—') ?></td>
                    <td>
                        <?php if (($p['status'] ?? '') === 'published'): ?>
                            <span class="badge bg-success-lt text-success">Yayında</span>
                        <?php else: ?>
                            <span class="badge bg-warning-lt text-warning">Taslak</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-muted small">
                        <?= $p['published_at'] ? date('d.m.Y', strtotime($p['published_at'])) : '—' ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/blog/<?= $p['id'] ?>/edit" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-edit"></i> Düzenle
                            </a>
                            <form action="/admin/blog/<?= $p['id'] ?>/delete" method="POST" class="d-inline"
                                  onsubmit="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($posts)): ?>
                <tr><td colspan="6" class="text-center text-muted py-5">
                    <i class="ti ti-news" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Henüz blog yazısı eklenmemiş. <a href="/admin/blog/create">İlk yazıyı ekle →</a>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
