<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Stand Modeli Ekle' : 'Stand Modeli Düzenle';
$pretitle  = 'Stand Kataloğu';
$action    = ($isNew ?? true) ? '/admin/catalog/store' : '/admin/catalog/' . ($item['id'] ?? 0) . '/update';
$it        = $item ?? [];
$headerActions = '<a href="/admin/catalog" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Geri Dön</a>';

// Decode features and gallery
$featuresText = '';
if (!empty($it['features_json'])) {
    $arr = json_decode((string)$it['features_json'], true);
    if (is_array($arr)) $featuresText = implode("\n", $arr);
}
$galleryText = '';
if (!empty($it['gallery_json'])) {
    $arr = json_decode((string)$it['gallery_json'], true);
    if (is_array($arr)) $galleryText = implode("\n", $arr);
}

$categories  = \App\Models\CatalogCategory::keyLabelMap();
$dimDefaults = \App\Models\CatalogCategory::keyDimMap();
?>

<form action="<?= e($action) ?>" method="POST" enctype="multipart/form-data">

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-temel" type="button">📋 Temel Bilgiler</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-aciklama" type="button">📝 Açıklama</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-medya" type="button">🖼️ Medya</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-ozellik" type="button">✨ Özellikler</button></li>
    </ul>

    <div class="tab-content">

        <!-- TEMEL BİLGİLER -->
        <div class="tab-pane fade show active" id="tab-temel">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Temel Bilgiler</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label required">Model No</label>
                            <input type="text" name="model_no" class="form-control text-uppercase"
                                   value="<?= e($it['model_no'] ?? '') ?>" placeholder="Örn: BB-01" required maxlength="20">
                            <div class="form-hint">Benzersiz kod (BB-01, IB-02, AD-04 vb.)</div>
                        </div>
                        <div class="col-md-9 mb-3">
                            <label class="form-label required">Ad (Türkçe)</label>
                            <input type="text" name="name_tr" class="form-control"
                                   value="<?= e($it['name_tr'] ?? '') ?>" placeholder="Örn: Modern Beyaz Stand" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Ad (İngilizce)</label>
                            <input type="text" name="name_en" class="form-control"
                                   value="<?= e($it['name_en'] ?? '') ?>" placeholder="e.g. Modern White Stand">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label required d-flex justify-content-between align-items-center">
                                <span>Kategori</span>
                                <a href="/admin/catalog/categories" class="text-muted small" target="_blank" title="Kategorileri yönet">
                                    <i class="ti ti-settings"></i> yönet
                                </a>
                            </label>
                            <select name="size_category" id="size_category" class="form-select" onchange="autoFillDim()">
                                <?php
                                $currentCat = $it['size_category'] ?? '';
                                $hasCurrent = $currentCat && isset($categories[$currentCat]);
                                if ($currentCat && !$hasCurrent):
                                ?>
                                <option value="<?= e($currentCat) ?>" data-dim="<?= e($it['dimensions'] ?? '') ?>" selected>
                                    <?= e($currentCat) ?> (pasif/silinmiş kategori)
                                </option>
                                <?php endif; ?>
                                <?php foreach ($categories as $key => $label): ?>
                                <option value="<?= e($key) ?>" data-dim="<?= e($dimDefaults[$key] ?? '') ?>"
                                    <?= $currentCat === $key ? 'selected' : '' ?>>
                                    <?= e($label) ?>
                                </option>
                                <?php endforeach; ?>
                                <?php if (empty($categories)): ?>
                                <option value="" disabled>(Kategori yok — önce kategori ekleyin)</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Ölçü Etiketi</label>
                            <input type="text" name="dimensions" id="dimensions" class="form-control"
                                   value="<?= e($it['dimensions'] ?? '') ?>" placeholder="3m × 2m">
                            <div class="form-hint">Karta gösterilen ölçü metni (otomatik doldurulur)</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="active"   <?= ($it['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Aktif</option>
                                <option value="inactive" <?= ($it['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Pasif</option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-2"><hr></div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Fiyat
                                <span class="text-muted small">(boş bırakılırsa "Fiyat Talep Et" gösterilir)</span>
                            </label>
                            <input type="number" step="0.01" min="0" name="price" class="form-control"
                                   value="<?= !empty($it['price']) ? e($it['price']) : '' ?>" placeholder="1850.00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Para Birimi</label>
                            <select name="currency" class="form-select">
                                <?php foreach (['EUR'=>'EUR (€)','TRY'=>'TRY (₺)','USD'=>'USD ($)','GBP'=>'GBP (£)'] as $c => $cl): ?>
                                <option value="<?= $c ?>" <?= ($it['currency'] ?? 'EUR') === $c ? 'selected' : '' ?>><?= $cl ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AÇIKLAMA -->
        <div class="tab-pane fade" id="tab-aciklama">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Açıklama</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Açıklama (Türkçe)</label>
                        <textarea name="description" class="form-control" rows="6"
                                  placeholder="Tek cephe açık, kompakt 3×2m stand. Beyaz minimal estetiği..."><?= htmlspecialchars($it['description'] ?? '') ?></textarea>
                        <div class="form-hint">Tamamı katalog kartında görünür.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description_en" class="form-control" rows="6"
                                  placeholder="Single-side open compact 3×2m stand..."><?= htmlspecialchars($it['description_en'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- MEDYA -->
        <div class="tab-pane fade" id="tab-medya">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Görseller</h3></div>
                <div class="card-body">
                    <!-- ANA GÖRSEL -->
                    <div class="mb-4">
                        <label class="form-label">Ana Görsel</label>
                        <?php if (!empty($it['image_main'])): ?>
                        <div class="mb-2 d-flex align-items-start gap-3">
                            <img src="<?= e($it['image_main']) ?>" alt=""
                                 style="max-width:200px;height:auto;border-radius:8px;border:1px solid var(--tblr-border-color);">
                            <div>
                                <div class="text-muted small mb-1">Mevcut görsel</div>
                                <code class="small text-muted"><?= e($it['image_main']) ?></code>
                            </div>
                        </div>
                        <?php endif; ?>
                        <input type="hidden" name="image_main_current" value="<?= e($it['image_main'] ?? '') ?>">
                        <input type="file" name="image_main_file" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-hint">4:3 oran önerilir. Yeni dosya seçilmezse mevcut görsel korunur.</div>
                    </div>

                    <!-- GALERİ -->
                    <div class="mb-3">
                        <label class="form-label">Galeri Görselleri</label>
                        <?php
                        $galleryUrls = [];
                        if (!empty($it['gallery_json'])) {
                            $dec = json_decode((string)$it['gallery_json'], true);
                            if (is_array($dec)) $galleryUrls = $dec;
                        }
                        ?>
                        <?php if (!empty($galleryUrls)): ?>
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <?php foreach ($galleryUrls as $gu): ?>
                            <img src="<?= e($gu) ?>" alt=""
                                 style="width:90px;height:67px;object-fit:cover;border-radius:6px;border:1px solid var(--tblr-border-color);">
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <input type="file" name="gallery_files[]" class="form-control mb-2" multiple accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-hint mb-2">Yeni görseller mevcut galeriye eklenir (çoklu seçim yapılabilir).</div>
                        <?php if (!empty($galleryUrls)): ?>
                        <label class="form-label mt-2">Mevcut galeriyi düzenle (satır sil → görsel kaldırılır)</label>
                        <textarea name="gallery" class="form-control" rows="4"><?= e($galleryText) ?></textarea>
                        <?php else: ?>
                        <textarea name="gallery" class="form-control" rows="2" placeholder="(henüz görsel yok)"></textarea>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ÖZELLİKLER -->
        <div class="tab-pane fade" id="tab-ozellik">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Özellikler (Karttaki ✓ liste)</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Özellikler</label>
                        <textarea name="features" class="form-control" rows="10" placeholder="Tek cephe açık
Beyaz minimal
LED aydınlatma
Karşılama desk
Logo paneli
Halı zemin"><?= e($featuresText) ?></textarea>
                        <div class="form-hint">Her satıra bir özellik. Tümü karta yansıtılır (✓ ile).</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Bar -->
    <div class="card mt-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="/admin/catalog" class="btn btn-outline-secondary">İptal</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="ti ti-device-floppy me-1"></i>
                <?= ($isNew ?? true) ? 'Modeli Ekle' : 'Değişiklikleri Kaydet' ?>
            </button>
        </div>
    </div>
</form>

<script>
function autoFillDim() {
    const sel = document.getElementById('size_category');
    const dim = document.getElementById('dimensions');
    if (sel && dim && (!dim.value || dim.dataset.autofill === '1')) {
        const opt = sel.options[sel.selectedIndex];
        dim.value = opt.dataset.dim || '';
        dim.dataset.autofill = '1';
    }
}
</script>
