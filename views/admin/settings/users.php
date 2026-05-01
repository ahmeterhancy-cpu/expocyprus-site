<?php $pageTitle = 'Kullanıcılar'; $pretitle = 'Site Ayarları';
$headerActions = '<a href="/admin/settings" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Ayarlara Dön</a>';
?>
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Admin Kullanıcıları</h3></div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Ad</th>
                            <th>E-posta</th>
                            <th>Rol</th>
                            <th>Son Giriş</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="fw-medium"><?= e($u['name']) ?></td>
                            <td class="text-muted"><?= e($u['email']) ?></td>
                            <td><span class="badge bg-purple-lt"><?= e($u['role']) ?></span></td>
                            <td class="text-muted small"><?= $u['last_login'] ? timeAgo($u['last_login']) : 'Hiç' ?></td>
                            <td>
                                <?php if ($u['id'] !== ($_SESSION['admin_id'] ?? null)): ?>
                                <form action="/admin/settings/users/<?= $u['id'] ?>/delete" method="POST"
                                      onsubmit="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')">
                                    <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                </form>
                                <?php else: ?>
                                <span class="badge bg-green-lt text-success">Siz</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Yeni Kullanıcı Ekle</h3></div>
            <div class="card-body">
                <form action="/admin/settings/users/create" method="POST">
                    <div class="mb-3">
                        <label class="form-label required">Ad Soyad</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">E-posta</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Şifre</label>
                        <input type="password" name="password" class="form-control" minlength="8" required>
                        <div class="form-hint">En az 8 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="role" class="form-select">
                            <option value="admin">Admin (tam yetki)</option>
                            <option value="editor">Editor (içerik)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-user-plus me-1"></i>Kullanıcı Ekle
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
