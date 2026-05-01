<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Stand Kategorisi' : 'Kategoriyi Düzenle';
$pretitle  = 'Stand Kategorileri';
$action    = ($isNew ?? true) ? '/admin/catalog/categories/store' : '/admin/catalog/categories/' . ($item['id'] ?? 0) . '/update';
$it        = $item ?? [];
$headerActions = '<a href="/admin/catalog/categories" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Geri Dön</a>';
?>

<form action="<?= e($action) ?>" method="POST">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Kategori Bilgileri</h3></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Anahtar (key)</label>
                    <?php if ($isNew ?? true): ?>
                    <input type="text" name="cat_key" class="form-control"
                           value="<?= e($it['cat_key'] ?? '') ?>" placeholder="örn: dort-birim" required maxlength="50"
                           pattern="[a-z0-9\-]+">
                    <div class="form-hint">Sadece küçük harf, rakam ve tire (-). Kayıt sonrası değiştirilemez.</div>
                    <?php else: ?>
                    <input type="text" class="form-control" value="<?= e($it['cat_key'] ?? '') ?>" disabled>
                    <div class="form-hint text-warning">Anahtar değiştirilemez (mevcut stand modelleri bu anahtarla bağlı).</div>
                    <?php endif; ?>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Sıra</label>
                    <input type="number" name="sort_order" class="form-control"
                           value="<?= (int)($it['sort_order'] ?? 0) ?>" min="0" step="10">
                    <div class="form-hint">Küçük sayı önce görünür</div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Durum</label>
                    <select name="status" class="form-select">
                        <option value="active"   <?= ($it['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Aktif</option>
                        <option value="inactive" <?= ($it['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Pasif</option>
                    </select>
                </div>

                <div class="col-md-12"><hr></div>

                <div class="col-md-6 mb-3">
                    <label class="form-label required">Etiket (Türkçe)</label>
                    <input type="text" name="label_tr" class="form-control"
                           value="<?= e($it['label_tr'] ?? '') ?>" placeholder="Örn: Dört Birim" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Etiket (İngilizce)</label>
                    <input type="text" name="label_en" class="form-control"
                           value="<?= e($it['label_en'] ?? '') ?>" placeholder="e.g. Quad Unit">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ölçü (Türkçe)</label>
                    <input type="text" name="dimensions_tr" class="form-control"
                           value="<?= e($it['dimensions_tr'] ?? '') ?>" placeholder="12m × 2m">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ölçü (İngilizce)</label>
                    <input type="text" name="dimensions_en" class="form-control"
                           value="<?= e($it['dimensions_en'] ?? '') ?>" placeholder="12m × 2m">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Açıklama (Türkçe)</label>
                    <textarea name="description_tr" class="form-control" rows="3"
                              placeholder="Bu kategorideki standların kısa açıklaması..."><?= e($it['description_tr'] ?? '') ?></textarea>
                    <div class="form-hint">Stand kataloğu sayfasında kategori başlığı altında gösterilir.</div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Description (English)</label>
                    <textarea name="description_en" class="form-control" rows="3"><?= e($it['description_en'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="/admin/catalog/categories" class="btn btn-outline-secondary">İptal</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="ti ti-device-floppy me-1"></i>
                <?= ($isNew ?? true) ? 'Kategoriyi Ekle' : 'Değişiklikleri Kaydet' ?>
            </button>
        </div>
    </div>
</form>
