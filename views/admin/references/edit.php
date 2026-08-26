<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Referans Projesi' : 'Referans Projesi Düzenle';
$pretitle  = 'Referans Projeler';
$action    = ($isNew ?? true) ? '/admin/references/store' : '/admin/references/' . ($project['id'] ?? 0) . '/update';
$p         = $project ?? [];
$headerActions = '<a href="/admin/references" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Geri Dön</a>';

$services   = \App\Models\ReferenceProject::serviceTypes();
$standTypes = \App\Models\ReferenceProject::standTypes();
$gallery    = \App\Models\ReferenceProject::gallery($p);
$galleryText = implode("\n", $gallery);
?>

<form action="<?= e($action) ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-temel" type="button">📋 Proje Bilgileri</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-metin" type="button">📝 Metinler</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-medya" type="button">🖼️ Fotoğraflar</button></li>
    </ul>

    <div class="tab-content">

        <!-- ─── PROJE BİLGİLERİ ─────────────────────────────── -->
        <div class="tab-pane fade show active" id="tab-temel">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Proje Bilgileri</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Proje Adı <span class="badge bg-secondary">TR</span></label>
                            <input type="text" name="title_tr" class="form-control" required
                                   value="<?= e($p['title_tr'] ?? '') ?>"
                                   placeholder="Örn. Near East University Kariyer Fuarı Standı">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Project Title <span class="badge bg-secondary">EN</span></label>
                            <input type="text" name="title_en" class="form-control"
                                   value="<?= e($p['title_en'] ?? '') ?>">
                            <div class="form-hint">Boş bırakılırsa İngilizce sayfada Türkçe adı gösterilir.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Müşteri / Kurum</label>
                            <input type="text" name="client" class="form-control"
                                   value="<?= e($p['client'] ?? '') ?>" placeholder="Örn. KKTC Ticaret Odası">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fuar / Etkinlik Adı</label>
                            <input type="text" name="fair_name" class="form-control"
                                   value="<?= e($p['fair_name'] ?? '') ?>" placeholder="Örn. Kıbrıs Tarım ve Hayvancılık Fuarı">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Konum</label>
                            <input type="text" name="location" class="form-control"
                                   value="<?= e($p['location'] ?? '') ?>" placeholder="Örn. Lefkoşa, KKTC">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Yıl</label>
                            <input type="number" name="year" class="form-control" min="1990" max="2100"
                                   value="<?= e((string) ($p['year'] ?? '')) ?>" placeholder="2025">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Alan (m²)</label>
                            <input type="number" name="sqm" class="form-control" min="0"
                                   value="<?= e((string) ($p['sqm'] ?? '')) ?>" placeholder="24">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hizmet Türü</label>
                            <select name="service_type" class="form-select">
                                <option value="">— Seçilmedi —</option>
                                <?php foreach ($services as $k => $lbl): ?>
                                <option value="<?= e($k) ?>" <?= ($p['service_type'] ?? '') === $k ? 'selected' : '' ?>>
                                    <?= e($lbl['tr']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-hint">Referanslar sayfasındaki filtre bu alana göre çalışır.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stand Tipi</label>
                            <select name="stand_type" class="form-select">
                                <?php foreach ($standTypes as $k => $lbl): ?>
                                <option value="<?= e($k) ?>" <?= ($p['stand_type'] ?? 'custom') === $k ? 'selected' : '' ?>>
                                    <?= e($lbl['tr']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sıralama</label>
                            <input type="number" name="sort_order" class="form-control"
                                   value="<?= (int) ($p['sort_order'] ?? 0) ?>">
                            <div class="form-hint">Küçük sayı önce gelir.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="active"   <?= ($p['status'] ?? 'active') === 'active'   ? 'selected' : '' ?>>Yayında</option>
                                <option value="inactive" <?= ($p['status'] ?? '')       === 'inactive' ? 'selected' : '' ?>>Taslak (sitede görünmez)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Öne Çıkar</label>
                            <label class="form-check form-switch mt-2">
                                <input type="checkbox" name="featured" value="1" class="form-check-input"
                                       <?= !empty($p['featured']) ? 'checked' : '' ?>>
                                <span class="form-check-label">Listenin başında göster</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ─── METİNLER ────────────────────────────────────── -->
        <div class="tab-pane fade" id="tab-metin">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Metinler</h3></div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <strong>Kısa özet</strong> kartta görünür (1–2 cümle).
                        <strong>Detaylı anlatım</strong> ise projenin kendi sayfasında.
                        Boş bırakılan alanlar sitede hiç basılmaz.
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kısa Özet <span class="badge bg-secondary">TR</span></label>
                            <textarea name="summary_tr" class="form-control" rows="3" maxlength="400"
                                      placeholder="24 m² özel yapım ada stand, iki katlı toplantı alanı ile."><?= e($p['summary_tr'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Short Summary <span class="badge bg-secondary">EN</span></label>
                            <textarea name="summary_en" class="form-control" rows="3" maxlength="400"><?= e($p['summary_en'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Detaylı Anlatım <span class="badge bg-secondary">TR</span></label>
                            <textarea name="description_tr" class="form-control" rows="10"><?= e($p['description_tr'] ?? '') ?></textarea>
                            <div class="form-hint">Her boş satır yeni paragraf olur.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Description <span class="badge bg-secondary">EN</span></label>
                            <textarea name="description_en" class="form-control" rows="10"><?= e($p['description_en'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ─── FOTOĞRAFLAR ─────────────────────────────────── -->
        <div class="tab-pane fade" id="tab-medya">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Fotoğraflar</h3></div>
                <div class="card-body">

                    <div class="mb-4">
                        <label class="form-label">Kapak Görseli</label>
                        <?php if (!empty($p['image_main'])): ?>
                        <div class="d-flex gap-3 align-items-start mb-2">
                            <img src="<?= e($p['image_main']) ?>" alt=""
                                 style="max-width:200px;height:auto;border-radius:8px;border:1px solid var(--tblr-border-color);">
                            <div>
                                <div class="text-muted small mb-1">Mevcut kapak</div>
                                <code class="small text-muted"><?= e($p['image_main']) ?></code>
                            </div>
                        </div>
                        <?php endif; ?>
                        <input type="hidden" name="image_main_current" value="<?= e($p['image_main'] ?? '') ?>">
                        <input type="file" name="image_main_file" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-hint">
                            4:3 oran önerilir. Yeni dosya seçilmezse mevcut korunur.
                            Kapak boş bırakılırsa galerideki ilk fotoğraf kapak olur.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Proje Galerisi</label>
                        <?php if ($gallery): ?>
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <?php foreach ($gallery as $g): ?>
                            <img src="<?= e($g) ?>" alt=""
                                 style="width:90px;height:67px;object-fit:cover;border-radius:6px;border:1px solid var(--tblr-border-color);">
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <input type="file" name="gallery_files[]" class="form-control mb-2" multiple accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-hint mb-2">Çoklu seçim yapabilirsiniz; yeni fotoğraflar mevcut galeriye eklenir.</div>
                        <label class="form-label mt-2">Mevcut galeri (satır sil → fotoğraf listeden kaldırılır)</label>
                        <textarea name="gallery" class="form-control" rows="<?= $gallery ? 5 : 2 ?>"
                                  placeholder="<?= $gallery ? '' : '(henüz fotoğraf yok)' ?>"><?= e($galleryText) ?></textarea>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="card mt-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="/admin/references" class="btn btn-outline-secondary">İptal</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="ti ti-device-floppy me-1"></i>
                <?= ($isNew ?? true) ? 'Projeyi Ekle' : 'Değişiklikleri Kaydet' ?>
            </button>
        </div>
    </div>
</form>
