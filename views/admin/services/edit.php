<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Hizmet Ekle' : 'Hizmet Düzenle';
$pretitle  = 'Hizmetler';
$action    = ($isNew ?? true) ? '/admin/services/store' : '/admin/services/' . ($service['id'] ?? 0) . '/update';
$s         = $service ?? [];
$headerActions = '<a href="/admin/services" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Geri Dön</a>';
?>

<form action="<?= e($action) ?>" method="POST" enctype="multipart/form-data">

    <!-- Language Tabs -->
    <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
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
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-apple" type="button">🎬 Apple Stil</button>
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
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label required">Başlık (TR)</label>
                            <input type="text" name="title_tr" class="form-control"
                                   value="<?= e($s['title_tr'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">İkon (URL veya emoji)</label>
                            <input type="text" name="icon" class="form-control"
                                   value="<?= e($s['icon'] ?? '') ?>" placeholder="🎪 veya /assets/img/icon.svg">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Özet (TR) <small class="text-muted">— Kart ve liste görünümlerinde</small></label>
                        <textarea name="summary_tr" class="form-control" rows="3" required><?= e($s['summary_tr'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">İçerik (TR) <small class="text-muted">— Detay sayfasında</small></label>
                        <textarea name="content_tr" id="editor_tr" class="form-control quill-editor" rows="15"><?= htmlspecialchars($s['content_tr'] ?? '') ?></textarea>
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
                        <label class="form-label required">Title (EN)</label>
                        <input type="text" name="title_en" class="form-control"
                               value="<?= e($s['title_en'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Summary (EN)</label>
                        <textarea name="summary_en" class="form-control" rows="3" required><?= e($s['summary_en'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content (EN)</label>
                        <textarea name="content_en" id="editor_en" class="form-control quill-editor" rows="15"><?= htmlspecialchars($s['content_en'] ?? '') ?></textarea>
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
                                   value="<?= e($s['meta_title_tr'] ?? '') ?>">
                            <div class="form-hint">Önerilen: max 60 karakter</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Başlık (EN)</label>
                            <input type="text" name="meta_title_en" class="form-control" maxlength="60"
                                   value="<?= e($s['meta_title_en'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Açıklama (TR)</label>
                            <textarea name="meta_desc_tr" class="form-control" rows="3" maxlength="160"><?= e($s['meta_desc_tr'] ?? '') ?></textarea>
                            <div class="form-hint">Önerilen: max 160 karakter</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Açıklama (EN)</label>
                            <textarea name="meta_desc_en" class="form-control" rows="3" maxlength="160"><?= e($s['meta_desc_en'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Apple-Stil Tab -->
        <div class="tab-pane fade" id="tab-apple" role="tabpanel">
            <?php
            $stats = [];
            if (!empty($s['stats_json'])) {
                $dec = json_decode((string)$s['stats_json'], true);
                if (is_array($dec)) $stats = $dec;
            }
            // Pad to 4 rows for editing
            while (count($stats) < 4) $stats[] = ['num' => '', 'tr' => '', 'en' => ''];
            ?>

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">🎯 Hero — Üst etiket & Tagline</h3></div>
                <div class="card-body">
                    <div class="alert alert-info small mb-3">
                        <i class="ti ti-info-circle me-1"></i>
                        Bu alanlar hizmet detay sayfasının üstündeki büyük başlıkta görünür.
                        Frontend'deki Apple-tarzı görüntü için kullanılır.
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Hero Eyebrow (TR)</label>
                            <input type="text" name="hero_eyebrow_tr" class="form-control"
                                   value="<?= e($s['hero_eyebrow_tr'] ?? '') ?>"
                                   placeholder="FUAR ORGANİZASYONU" maxlength="50">
                            <small class="text-muted">Hero üstündeki küçük etiket. BÜYÜK HARF önerilir.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Eyebrow (EN)</label>
                            <input type="text" name="hero_eyebrow_en" class="form-control"
                                   value="<?= e($s['hero_eyebrow_en'] ?? '') ?>"
                                   placeholder="FAIR ORGANISATION" maxlength="50">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Hero Tagline (TR)</label>
                            <input type="text" name="hero_tagline_tr" class="form-control"
                                   value="<?= e($s['hero_tagline_tr'] ?? '') ?>"
                                   placeholder="Konseptten kapanışa." maxlength="80">
                            <small class="text-muted">Hero büyük başlığı. Kısa ve etkili.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Tagline (EN)</label>
                            <input type="text" name="hero_tagline_en" class="form-control"
                                   value="<?= e($s['hero_tagline_en'] ?? '') ?>"
                                   placeholder="From concept to close." maxlength="80">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Hero Subline (TR)</label>
                            <textarea name="hero_subline_tr" class="form-control" rows="2"
                                      placeholder="Tek bir partner. Tüm operasyon. 22 yılın özgüveniyle."><?= e($s['hero_subline_tr'] ?? '') ?></textarea>
                            <small class="text-muted">Tagline altında 1-2 satır açıklama.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Subline (EN)</label>
                            <textarea name="hero_subline_en" class="form-control" rows="2"
                                      placeholder="One partner. The full operation."><?= e($s['hero_subline_en'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">🎨 Renk & Görseller</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Vurgu Rengi</label>
                            <input type="color" name="accent_color" class="form-control form-control-color w-100"
                                   value="<?= e($s['accent_color'] ?? '#E30613') ?>" style="height:46px">
                            <small class="text-muted">Hero, butonlar, vurgular</small>
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Showcase / Parallax Görseli URL</label>
                            <input type="text" name="showcase_image" class="form-control"
                                   value="<?= e($s['showcase_image'] ?? '') ?>"
                                   placeholder="/assets/images/...">
                            <small class="text-muted">İçeriğin ortasında tam genişlik parallax görseli</small>
                            <?php if (!empty($s['showcase_image'])): ?>
                            <div class="mt-2"><img src="<?= e($s['showcase_image']) ?>" style="max-height:120px;border-radius:8px"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">📊 Stats — 4 Büyük İstatistik</h3>
                    <div class="card-actions">
                        <span class="text-muted small">Hero altındaki sayılar</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-2 mb-2 text-muted small fw-bold">
                        <div class="col-md-3">Sayı</div>
                        <div class="col-md-4">Etiket (TR)</div>
                        <div class="col-md-4">Etiket (EN)</div>
                        <div class="col-md-1"></div>
                    </div>
                    <?php foreach ($stats as $i => $st): ?>
                    <div class="row g-2 mb-2 align-items-center">
                        <div class="col-md-3">
                            <input type="text" name="stat_num[]" class="form-control" value="<?= e($st['num'] ?? '') ?>" placeholder="22+">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="stat_label_tr[]" class="form-control" value="<?= e($st['tr'] ?? '') ?>" placeholder="Yıllık Tecrübe">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="stat_label_en[]" class="form-control" value="<?= e($st['en'] ?? '') ?>" placeholder="Years Experience">
                        </div>
                        <div class="col-md-1 text-center text-muted small"><?= $i + 1 ?></div>
                    </div>
                    <?php endforeach; ?>
                    <small class="text-muted">Boş satırlar yayınlanmaz. Ekstra stat eklemek için boş satırları doldurun.</small>
                </div>
            </div>

            <div class="alert alert-warning small">
                <strong>💡 Önizleme:</strong>
                Bu bölümleri doldurduktan sonra kaydedip sayfayı görmek için:
                <a href="/hizmetler/<?= e($s['slug'] ?? '') ?>" target="_blank" class="ms-1"><strong>/hizmetler/<?= e($s['slug'] ?? '') ?></strong> →</a>
            </div>
        </div>

        <!-- Settings Tab -->
        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Ayarlar</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kapak Görseli URL</label>
                            <input type="text" name="image" class="form-control"
                                   value="<?= e($s['image'] ?? '') ?>" placeholder="/uploads/images/...">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sıralama</label>
                            <input type="number" name="sort_order" class="form-control"
                                   value="<?= (int)($s['sort_order'] ?? 0) ?>" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="active"   <?= ($s['status'] ?? '') === 'active'  ? 'selected' : '' ?>>Aktif</option>
                                <option value="inactive" <?= ($s['status'] ?? '') === 'inactive'? 'selected' : '' ?>>Pasif</option>
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
            <a href="/admin/services" class="btn btn-outline-secondary">İptal</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="ti ti-device-floppy me-1"></i>
                <?= ($isNew ?? true) ? 'Hizmeti Ekle' : 'Değişiklikleri Kaydet' ?>
            </button>
        </div>
    </div>

</form>
