<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Otel Ekle' : 'Otel Düzenle';
$pretitle  = 'Oteller';
$action    = ($isNew ?? true) ? '/admin/hotels/store' : '/admin/hotels/' . ($hotel['id'] ?? 0) . '/update';
$h         = $hotel ?? [];
$headerActions = '<a href="/admin/hotels" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Geri Dön</a>';

// Decode features and gallery for textarea display
$featuresText = '';
if (!empty($h['features_json'])) {
    $arr = json_decode((string)$h['features_json'], true);
    if (is_array($arr)) $featuresText = implode("\n", $arr);
}
$galleryText = '';
if (!empty($h['gallery_json'])) {
    $arr = json_decode((string)$h['gallery_json'], true);
    if (is_array($arr)) $galleryText = implode("\n", $arr);
}

// Decode event types
$selectedEventTypes = [];
if (!empty($h['event_types_json'])) {
    $arr = json_decode((string)$h['event_types_json'], true);
    if (is_array($arr)) $selectedEventTypes = $arr;
}
$availableEventTypes = ['Kongre', 'Konferans', 'Toplantı', 'Düğün', 'Seminer', 'Lansman', 'Workshop', 'Galeri'];

$regions = ['Girne', 'Mağusa', 'Lefkoşa', 'Bafra', 'İskele'];
?>

<form action="<?= e($action) ?>" method="POST">

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="hotelTabs" role="tablist">
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
                <div class="card-header"><h3 class="card-title">Türkçe İçerik & Temel Bilgiler</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label required">Otel Adı</label>
                            <input type="text" name="name" class="form-control"
                                   value="<?= e($h['name'] ?? '') ?>" required placeholder="Örn: Cratos Premium Hotel & Casino">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">Yıldız</label>
                            <select name="stars" class="form-select" required>
                                <?php for ($i=5; $i>=1; $i--): ?>
                                    <option value="<?= $i ?>" <?= ((int)($h['stars'] ?? 5) === $i) ? 'selected' : '' ?>><?= str_repeat('★', $i) ?> (<?= $i ?>)</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Bölge</label>
                            <select name="region" class="form-select" required>
                                <option value="">— Bölge Seçin —</option>
                                <?php foreach ($regions as $r): ?>
                                    <option value="<?= e($r) ?>" <?= ($h['region'] ?? '') === $r ? 'selected' : '' ?>><?= e($r) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konum (Detay)</label>
                            <input type="text" name="location" class="form-control"
                                   value="<?= e($h['location'] ?? '') ?>" placeholder="Örn: Çatalköy, Girne, KKTC">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Özet (TR)</label>
                        <textarea name="summary_tr" class="form-control" rows="3" placeholder="Kısa otel özeti (kart üzerinde gösterilir)"><?= e($h['summary_tr'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Detaylı Açıklama (TR)</label>
                        <textarea name="description_tr" id="editor_hotel_tr" class="form-control quill-editor" rows="15"><?= htmlspecialchars($h['description_tr'] ?? '') ?></textarea>
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
                        <label class="form-label">Summary (EN)</label>
                        <textarea name="summary_en" class="form-control" rows="3" placeholder="Short hotel summary (shown on card)"><?= e($h['summary_en'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Detailed Description (EN)</label>
                        <textarea name="description_en" id="editor_hotel_en" class="form-control quill-editor" rows="15"><?= htmlspecialchars($h['description_en'] ?? '') ?></textarea>
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
                            <input type="text" name="meta_title_tr" class="form-control" maxlength="80"
                                   value="<?= e($h['meta_title_tr'] ?? '') ?>">
                            <div class="form-hint">Önerilen: max 60 karakter</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Title (EN)</label>
                            <input type="text" name="meta_title_en" class="form-control" maxlength="80"
                                   value="<?= e($h['meta_title_en'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Açıklama (TR)</label>
                            <textarea name="meta_desc_tr" class="form-control" rows="3" maxlength="180"><?= e($h['meta_desc_tr'] ?? '') ?></textarea>
                            <div class="form-hint">Önerilen: max 160 karakter</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Description (EN)</label>
                            <textarea name="meta_desc_en" class="form-control" rows="3" maxlength="180"><?= e($h['meta_desc_en'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Tab -->
        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Otel Ayarları</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Kapak Görseli URL</label>
                            <input type="text" name="image_main" class="form-control"
                                   value="<?= e($h['image_main'] ?? '') ?>" placeholder="/uploads/images/...">
                            <?php if (!empty($h['image_main'])): ?>
                            <div class="mt-2">
                                <img src="<?= e($h['image_main']) ?>" alt="" class="img-thumbnail" style="max-height:140px">
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Web Sitesi (URL)</label>
                            <input type="url" name="website_url" class="form-control"
                                   value="<?= e($h['website_url'] ?? '') ?>" placeholder="https://...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefon</label>
                            <input type="text" name="phone" class="form-control"
                                   value="<?= e($h['phone'] ?? '') ?>" placeholder="+90 392 ...">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Oda Sayısı</label>
                            <input type="number" name="rooms" class="form-control" min="0"
                                   value="<?= !empty($h['rooms']) ? (int)$h['rooms'] : '' ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Toplantı Salon Sayısı</label>
                            <input type="number" name="meeting_rooms" class="form-control" min="0" max="50"
                                   value="<?= !empty($h['meeting_rooms']) ? (int)$h['meeting_rooms'] : '' ?>"
                                   placeholder="Örn: 11">
                            <div class="form-hint">Otelde mevcut toplantı/balo salonu adedi</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Sıralama</label>
                            <input type="number" name="sort_order" class="form-control"
                                   value="<?= (int)($h['sort_order'] ?? 0) ?>" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="active"   <?= ($h['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Aktif</option>
                                <option value="inactive" <?= ($h['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Pasif</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Etkinlik Tipleri</label>
                            <div class="d-flex flex-wrap gap-3 p-3" style="background:rgba(255,255,255,.03); border:1px solid var(--tblr-border-color); border-radius:6px;">
                                <?php foreach ($availableEventTypes as $et): ?>
                                <label class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="checkbox" name="event_types[]" value="<?= e($et) ?>"
                                           <?= in_array($et, $selectedEventTypes, true) ? 'checked' : '' ?>>
                                    <span class="form-check-label"><?= e($et) ?></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-hint">Otelin ev sahipliği yapabileceği etkinlik türleri (kartta rozet olarak gösterilir)</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Özellikler</label>
                            <textarea name="features" class="form-control" rows="6" placeholder="Spa
Plaj
Casino
Kongre Salonu"><?= e($featuresText) ?></textarea>
                            <div class="form-hint">Her satıra bir özellik: Spa, Plaj, Casino...</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Galeri (URL Listesi)</label>
                            <textarea name="gallery" class="form-control" rows="6" placeholder="https://example.com/img1.jpg
https://example.com/img2.jpg"><?= e($galleryText) ?></textarea>
                            <div class="form-hint">Her satıra bir URL</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Submit Bar -->
    <div class="card mt-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="/admin/hotels" class="btn btn-outline-secondary">İptal</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="ti ti-device-floppy me-1"></i>
                <?= ($isNew ?? true) ? 'Oteli Ekle' : 'Değişiklikleri Kaydet' ?>
            </button>
        </div>
    </div>

</form>

