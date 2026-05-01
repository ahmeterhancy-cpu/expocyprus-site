<?php
$pageTitle = 'Sayfa: ' . $page['title_tr'];
$pretitle  = 'CMS — Sayfa Düzenleyici';
$defs = \App\Models\CmsPage::PAGE_DEFINITIONS;
$def = $defs[$page['page_key']] ?? null;
$route = $def['route'] ?? '#';
$headerActions = '
    <a href="' . e($route) . '" target="_blank" class="btn btn-outline-secondary me-2"><i class="ti ti-external-link me-1"></i>Sayfayı Aç</a>
    <a href="/admin/cms" class="btn btn-outline-secondary">← Liste</a>
';
?>

<form action="/admin/cms/<?= e($page['page_key']) ?>/update" method="POST" enctype="multipart/form-data">

    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-basic" type="button">📝 Temel</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button">🎬 Hero</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-body" type="button">📄 İçerik</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-sections" type="button">🧩 Bölümler (JSON)</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button">🔍 SEO</button></li>
    </ul>

    <div class="tab-content">

        <!-- TAB: TEMEL -->
        <div class="tab-pane fade show active" id="tab-basic">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sayfa Bilgileri</h3>
                    <div class="card-actions">
                        <code class="text-muted small"><?= e($page['page_key']) ?></code>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Sayfa Başlığı (TR)</label>
                            <input type="text" name="title_tr" class="form-control" value="<?= e($page['title_tr']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sayfa Başlığı (EN)</label>
                            <input type="text" name="title_en" class="form-control" value="<?= e($page['title_en'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Durum</label>
                            <select name="status" class="form-select">
                                <option value="published" <?= $page['status']==='published'?'selected':'' ?>>Yayında</option>
                                <option value="draft" <?= $page['status']==='draft'?'selected':'' ?>>Taslak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Arama Motoru</label>
                            <div class="form-check form-switch mt-2">
                                <input type="hidden" name="noindex" value="0">
                                <input type="checkbox" class="form-check-input" name="noindex" value="1" id="noindex" <?= !empty($page['noindex']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="noindex">noindex (Google'a gösterme)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB: HERO -->
        <div class="tab-pane fade" id="tab-hero">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Hero Bölümü</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Eyebrow (Üst etiket — TR)</label>
                            <input type="text" name="hero_eyebrow_tr" class="form-control" value="<?= e($page['hero_eyebrow_tr'] ?? '') ?>" placeholder="Örn: SINCE 2004">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Eyebrow (EN)</label>
                            <input type="text" name="hero_eyebrow_en" class="form-control" value="<?= e($page['hero_eyebrow_en'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Başlık (TR)</label>
                            <input type="text" name="hero_title_tr" class="form-control" value="<?= e($page['hero_title_tr'] ?? '') ?>" placeholder="Sayfa kahramanı büyük başlık">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Başlık (EN)</label>
                            <input type="text" name="hero_title_en" class="form-control" value="<?= e($page['hero_title_en'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Alt Başlık (TR)</label>
                            <textarea name="hero_subtitle_tr" class="form-control" rows="2"><?= e($page['hero_subtitle_tr'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Alt Başlık (EN)</label>
                            <textarea name="hero_subtitle_en" class="form-control" rows="2"><?= e($page['hero_subtitle_en'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Hero Görseli</label>
                            <?php if (!empty($page['hero_image'])): ?>
                            <div class="mb-2">
                                <img src="<?= e($page['hero_image']) ?>" style="max-width:300px;height:auto;border-radius:8px">
                                <br><small class="text-muted"><?= e($page['hero_image']) ?></small>
                            </div>
                            <?php endif; ?>
                            <input type="hidden" name="hero_image_current" value="<?= e($page['hero_image'] ?? '') ?>">
                            <input type="file" name="hero_image_file" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                            <small class="text-muted">JPG / PNG / WEBP. 1920×1080 önerilir.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB: İÇERİK -->
        <div class="tab-pane fade" id="tab-body">
            <div class="card">
                <div class="card-header"><h3 class="card-title">İçerik Gövdesi (HTML)</h3></div>
                <div class="card-body">
                    <div class="alert alert-info small">
                        <i class="ti ti-info-circle me-1"></i>
                        HTML kullanabilirsiniz: <code>&lt;h2&gt;</code>, <code>&lt;p&gt;</code>, <code>&lt;ul&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;a&gt;</code>, <code>&lt;img&gt;</code>.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">İçerik (TR)</label>
                        <textarea name="body_tr" class="form-control" rows="14" style="font-family:monospace;font-size:.875rem"><?= e($page['body_tr'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">İçerik (EN)</label>
                        <textarea name="body_en" class="form-control" rows="14" style="font-family:monospace;font-size:.875rem"><?= e($page['body_en'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB: SECTIONS JSON -->
        <div class="tab-pane fade" id="tab-sections">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Bölümler (Yapılandırılmış İçerik)</h3></div>
                <div class="card-body">
                    <div class="alert alert-warning small">
                        <strong>Gelişmiş kullanıcılar için.</strong> JSON dizisi olarak section'ları tanımlayın.
                        Her section: <code>{"type":"text|image|cta|stats|grid", "title":"...", "content":"..."}</code>
                    </div>
                    <textarea name="sections_json" class="form-control" rows="15" style="font-family:monospace;font-size:.8125rem" placeholder='[{"type":"text","title":"Bölüm Başlığı","content":"İçerik..."},{"type":"stats","items":[{"num":"100+","label":"Stand"}]}]'><?= e($page['sections_json'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- TAB: SEO -->
        <div class="tab-pane fade" id="tab-seo">
            <div class="card">
                <div class="card-header"><h3 class="card-title">SEO Meta Bilgileri</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Meta Title (TR)</label>
                            <input type="text" name="meta_title_tr" class="form-control" value="<?= e($page['meta_title_tr'] ?? '') ?>" maxlength="70">
                            <small class="text-muted">İdeal: 50-60 karakter</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Title (EN)</label>
                            <input type="text" name="meta_title_en" class="form-control" value="<?= e($page['meta_title_en'] ?? '') ?>" maxlength="70">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Description (TR)</label>
                            <textarea name="meta_description_tr" class="form-control" rows="2" maxlength="160"><?= e($page['meta_description_tr'] ?? '') ?></textarea>
                            <small class="text-muted">İdeal: 150-160 karakter</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Description (EN)</label>
                            <textarea name="meta_description_en" class="form-control" rows="2" maxlength="160"><?= e($page['meta_description_en'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Anahtar Kelimeler (TR)</label>
                            <input type="text" name="meta_keywords_tr" class="form-control" value="<?= e($page['meta_keywords_tr'] ?? '') ?>" placeholder="virgülle ayır">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Keywords (EN)</label>
                            <input type="text" name="meta_keywords_en" class="form-control" value="<?= e($page['meta_keywords_en'] ?? '') ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">OG (Sosyal Medya) Görseli — 1200×630</label>
                            <?php if (!empty($page['og_image'])): ?>
                            <div class="mb-2"><img src="<?= e($page['og_image']) ?>" style="max-width:200px;border-radius:8px"></div>
                            <?php endif; ?>
                            <input type="hidden" name="og_image_current" value="<?= e($page['og_image'] ?? '') ?>">
                            <input type="file" name="og_image_file" class="form-control" accept=".jpg,.jpeg,.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card mt-3"><div class="card-body d-flex justify-content-between">
        <a href="/admin/cms" class="btn btn-outline-secondary">İptal</a>
        <button class="btn btn-primary px-5"><i class="ti ti-device-floppy me-1"></i>Kaydet</button>
    </div></div>
</form>
