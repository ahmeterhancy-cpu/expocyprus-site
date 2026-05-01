<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Blog Yazısı Ekle' : 'Blog Yazısı Düzenle';
$pretitle  = 'Blog';
$action    = ($isNew ?? true) ? '/admin/blog/store' : '/admin/blog/' . ($post['id'] ?? 0) . '/update';
$p         = $post ?? [];
$headerActions = '<a href="/admin/blog" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Geri Dön</a>';
?>

<form action="<?= e($action) ?>" method="POST" enctype="multipart/form-data">

    <div class="row">

        <!-- Main Content Column -->
        <div class="col-lg-8">

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">İçerik</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label required">Başlık</label>
                        <input type="text" name="title" class="form-control"
                               value="<?= e($p['title'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Özet <small class="text-muted">— Liste ve kart görünümünde</small></label>
                        <textarea name="excerpt" class="form-control" rows="3"><?= e($p['excerpt'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">İçerik</label>
                        <textarea name="content" id="editor_blog" class="form-control quill-editor" rows="20"><?= htmlspecialchars($p['content'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SEO Card -->
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title"><i class="ti ti-search me-1"></i>SEO</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Meta Başlık</label>
                        <input type="text" name="meta_title" class="form-control" maxlength="60"
                               value="<?= e($p['meta_title'] ?? '') ?>">
                        <div class="form-hint">Önerilen: max 60 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Açıklama</label>
                        <textarea name="meta_desc" class="form-control" rows="3" maxlength="160"><?= e($p['meta_desc'] ?? '') ?></textarea>
                        <div class="form-hint">Önerilen: max 160 karakter</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Yayın Ayarları</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Dil</label>
                        <select name="lang" class="form-select">
                            <option value="tr" <?= ($p['lang'] ?? 'tr') === 'tr' ? 'selected' : '' ?>>Türkçe (TR)</option>
                            <option value="en" <?= ($p['lang'] ?? '') === 'en' ? 'selected' : '' ?>>English (EN)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durum</label>
                        <select name="status" class="form-select">
                            <option value="draft"     <?= ($p['status'] ?? 'draft') === 'draft'     ? 'selected' : '' ?>>Taslak</option>
                            <option value="published" <?= ($p['status'] ?? '') === 'published' ? 'selected' : '' ?>>Yayında</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Yayın Tarihi</label>
                        <input type="datetime-local" name="published_at" class="form-control"
                               value="<?= e(isset($p['published_at']) && $p['published_at'] ? date('Y-m-d\TH:i', strtotime($p['published_at'])) : '') ?>">
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Yazı Detayları</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Yazar</label>
                        <input type="text" name="author" class="form-control"
                               value="<?= e($p['author'] ?? 'Expo Cyprus') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" class="form-control"
                               value="<?= e($p['category'] ?? '') ?>" placeholder="Haberler, Etkinlikler, vb.">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Etiketler <small class="text-muted">(virgülle ayrın)</small></label>
                        <input type="text" name="tags" class="form-control"
                               value="<?= e($p['tags'] ?? '') ?>" placeholder="fuar, sergi, etkinlik">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kapak Görseli</label>
                        <?php if (!empty($p['image'])): ?>
                        <div class="mb-2">
                            <img src="<?= e($p['image']) ?>" alt="" class="img-thumbnail" style="max-height:120px">
                            <div class="form-hint mt-1">Mevcut görsel — yeni dosya seçilirse değiştirilir</div>
                        </div>
                        <?php endif; ?>
                        <input type="hidden" name="image_current" value="<?= e($p['image'] ?? '') ?>">
                        <input type="file" name="image_file" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-hint">Yeni dosya seçilmezse mevcut görsel korunur.</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Submit Bar -->
    <div class="card mt-1">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="/admin/blog" class="btn btn-outline-secondary">İptal</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="ti ti-device-floppy me-1"></i>
                <?= ($isNew ?? true) ? 'Yazıyı Ekle' : 'Değişiklikleri Kaydet' ?>
            </button>
        </div>
    </div>

</form>

