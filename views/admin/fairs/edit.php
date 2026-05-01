<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Fuar Ekle' : 'Fuar Düzenle';
$pretitle  = 'Fuarlar';
$action    = ($isNew ?? true) ? '/admin/fairs/store' : '/admin/fairs/' . ($fair['id'] ?? 0) . '/update';
$f         = $fair ?? [];
$headerActions = '<a href="/admin/fairs" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Geri Dön</a>';
?>

<form action="<?= e($action) ?>" method="POST">

    <!-- Language Tabs -->
    <ul class="nav nav-tabs mb-4" id="fairTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-tr" type="button">🇹🇷 Türkçe</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-en" type="button">🇬🇧 English</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button"><i class="ti ti-search me-1"></i>SEO</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-settings" type="button"><i class="ti ti-adjustments me-1"></i>Ayarlar</button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- TR Tab -->
        <div class="tab-pane fade show active" id="tab-tr" role="tabpanel">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Türkçe İçerik</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label required">Fuar Adı (TR)</label>
                        <input type="text" name="name_tr" class="form-control"
                               value="<?= e($f['name_tr'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Özet (TR)</label>
                        <textarea name="summary_tr" class="form-control" rows="3"><?= e($f['summary_tr'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">İçerik (TR)</label>
                        <textarea name="content_tr" id="editor_fair_tr" class="form-control quill-editor" rows="15"><?= htmlspecialchars($f['content_tr'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- EN Tab -->
        <div class="tab-pane fade" id="tab-en" role="tabpanel">
            <div class="card">
                <div class="card-header"><h3 class="card-title">English Content</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label required">Fair Name (EN)</label>
                        <input type="text" name="name_en" class="form-control"
                               value="<?= e($f['name_en'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Summary (EN)</label>
                        <textarea name="summary_en" class="form-control" rows="3"><?= e($f['summary_en'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content (EN)</label>
                        <textarea name="content_en" id="editor_fair_en" class="form-control quill-editor" rows="15"><?= htmlspecialchars($f['content_en'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Tab -->
        <div class="tab-pane fade" id="tab-seo" role="tabpanel">
            <div class="card">
                <div class="card-header"><h3 class="card-title">SEO Ayarları</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Başlık (TR)</label>
                            <input type="text" name="meta_title_tr" class="form-control" maxlength="60"
                                   value="<?= e($f['meta_title_tr'] ?? '') ?>">
                            <div class="form-hint">Önerilen: max 60 karakter</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Başlık (EN)</label>
                            <input type="text" name="meta_title_en" class="form-control" maxlength="60"
                                   value="<?= e($f['meta_title_en'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Açıklama (TR)</label>
                            <textarea name="meta_desc_tr" class="form-control" rows="3" maxlength="160"><?= e($f['meta_desc_tr'] ?? '') ?></textarea>
                            <div class="form-hint">Önerilen: max 160 karakter</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Açıklama (EN)</label>
                            <textarea name="meta_desc_en" class="form-control" rows="3" maxlength="160"><?= e($f['meta_desc_en'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Tab -->
        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Fuar Ayarları</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Başlangıç Tarihi</label>
                            <input type="date" name="next_date" class="form-control"
                                   value="<?= e($f['next_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bitiş Tarihi</label>
                            <input type="date" name="end_date" class="form-control"
                                   value="<?= e($f['end_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Konum</label>
                            <input type="text" name="location" class="form-control"
                                   value="<?= e($f['location'] ?? '') ?>" placeholder="Lefkoşa, Kıbrıs">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sıralama</label>
                            <input type="number" name="sort_order" class="form-control"
                                   value="<?= (int)($f['sort_order'] ?? 0) ?>" min="0">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Kapak Görseli URL (Hero)</label>
                            <input type="text" name="image_hero" class="form-control"
                                   value="<?= e($f['image_hero'] ?? '') ?>" placeholder="/uploads/images/...">
                            <?php if (!empty($f['image_hero'])): ?>
                            <div class="mt-2">
                                <img src="<?= e($f['image_hero']) ?>" alt="" class="img-thumbnail" style="max-height:120px">
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="active"   <?= ($f['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Aktif</option>
                                <option value="inactive" <?= ($f['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Pasif</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Submit Bar -->
    <div class="card mt-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="/admin/fairs" class="btn btn-outline-secondary">İptal</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="ti ti-device-floppy me-1"></i>
                <?= ($isNew ?? true) ? 'Fuarı Ekle' : 'Değişiklikleri Kaydet' ?>
            </button>
        </div>
    </div>

</form>

