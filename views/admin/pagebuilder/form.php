<?php
$isEdit = !empty($page);
$pageTitle = $isEdit ? 'Sayfa Ayarları' : 'Yeni Sayfa';
$pretitle  = $isEdit ? 'PHPagebuilder — ' . e($page['name']) : 'PHPagebuilder — Yeni';
$action = $isEdit ? '/admin/pagebuilder/' . $page['id'] . '/settings' : '/admin/pagebuilder/new';
$tr = $translations['tr'] ?? [];
$en = $translations['en'] ?? [];
?>

<form action="<?= $action ?>" method="POST">
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Genel</h3></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Sayfa Adı (admin için)</label>
                    <input type="text" name="name" class="form-control" required
                           value="<?= e($page['name'] ?? '') ?>" placeholder="Hakkımızda">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Layout</label>
                    <select name="layout" class="form-select">
                        <option value="master" <?= ($page['layout'] ?? 'master') === 'master' ? 'selected' : '' ?>>Master (varsayılan)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Türkçe</h3></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Başlık</label>
                    <input type="text" name="title_tr" class="form-control" required value="<?= e($tr['title'] ?? '') ?>" placeholder="Hakkımızda">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Yol (Route)</label>
                    <input type="text" name="route_tr" class="form-control" required value="<?= e($tr['route'] ?? '') ?>" placeholder="/hakkimizda">
                </div>
                <div class="col-md-6">
                    <label class="form-label">SEO Title (opsiyonel)</label>
                    <input type="text" name="meta_title_tr" class="form-control" value="<?= e($tr['meta_title'] ?? '') ?>" maxlength="80">
                </div>
                <div class="col-md-6">
                    <label class="form-label">SEO Description (opsiyonel)</label>
                    <input type="text" name="meta_desc_tr" class="form-control" value="<?= e($tr['meta_description'] ?? '') ?>" maxlength="180">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">English (opsiyonel)</h3></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title_en" class="form-control" value="<?= e($en['title'] ?? '') ?>" placeholder="About">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Route</label>
                    <input type="text" name="route_en" class="form-control" value="<?= e($en['route'] ?? '') ?>" placeholder="/en/about">
                </div>
                <div class="col-md-6">
                    <label class="form-label">SEO Title</label>
                    <input type="text" name="meta_title_en" class="form-control" value="<?= e($en['meta_title'] ?? '') ?>" maxlength="80">
                </div>
                <div class="col-md-6">
                    <label class="form-label">SEO Description</label>
                    <input type="text" name="meta_desc_en" class="form-control" value="<?= e($en['meta_description'] ?? '') ?>" maxlength="180">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <a href="/admin/pagebuilder" class="btn btn-outline-secondary">İptal</a>
        <button class="btn btn-primary"><?= $isEdit ? 'Kaydet' : 'Oluştur ve Builder\'a Git' ?></button>
    </div>
</form>
