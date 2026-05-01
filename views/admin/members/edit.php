<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Üye' : 'Üyeyi Düzenle';
$pretitle  = 'Üyelik';
$action    = ($isNew ?? true) ? '/admin/members/store' : '/admin/members/' . ($member['id'] ?? 0) . '/update';
$m = $member ?? [];
$headerActions = '<a href="/admin/members" class="btn btn-outline-secondary">← Geri</a>';
?>

<form action="<?= e($action) ?>" method="POST">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Firma Bilgileri</h3></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label required">Firma Adı</label>
                    <input type="text" name="company_name" class="form-control" value="<?= e($m['company_name'] ?? '') ?>" required></div>
                <div class="col-md-6"><label class="form-label required">Yetkili Adı</label>
                    <input type="text" name="contact_name" class="form-control" value="<?= e($m['contact_name'] ?? '') ?>" required></div>
                <div class="col-md-6"><label class="form-label required">E-posta</label>
                    <input type="email" name="email" class="form-control" value="<?= e($m['email'] ?? '') ?>" required <?= empty($isNew) ? 'readonly' : '' ?>></div>
                <div class="col-md-6"><label class="form-label">Telefon</label>
                    <input type="tel" name="phone" class="form-control" value="<?= e($m['phone'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">Vergi No</label>
                    <input type="text" name="tax_no" class="form-control" value="<?= e($m['tax_no'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">Şehir</label>
                    <input type="text" name="city" class="form-control" value="<?= e($m['city'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">Ülke</label>
                    <input type="text" name="country" class="form-control" value="<?= e($m['country'] ?? 'KKTC') ?>"></div>
                <div class="col-md-12"><label class="form-label">Adres</label>
                    <textarea name="address" class="form-control" rows="2"><?= e($m['address'] ?? '') ?></textarea></div>
                <div class="col-md-6"><label class="form-label">Web Sitesi</label>
                    <input type="url" name="website" class="form-control" value="<?= e($m['website'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Durum</label>
                    <select name="status" class="form-select">
                        <?php foreach (\App\Models\Member::STATUSES as $k => $cfg): ?>
                        <option value="<?= e($k) ?>" <?= ($m['status'] ?? 'pending') === $k ? 'selected' : '' ?>><?= e($cfg['label']) ?></option>
                        <?php endforeach; ?>
                    </select></div>
                <div class="col-md-3"><label class="form-label"><?= ($isNew ?? true) ? 'Şifre *' : 'Yeni Şifre' ?></label>
                    <input type="password" name="password" class="form-control" minlength="8" <?= ($isNew ?? true) ? 'required' : '' ?>>
                    <?php if (empty($isNew)): ?><small class="text-muted">Boş bırakılırsa değişmez</small><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3"><div class="card-body d-flex justify-content-between">
        <a href="/admin/members" class="btn btn-outline-secondary">İptal</a>
        <button class="btn btn-primary px-5"><?= ($isNew ?? true) ? 'Ekle' : 'Kaydet' ?></button>
    </div></div>
</form>
