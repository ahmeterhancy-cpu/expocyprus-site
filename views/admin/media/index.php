<?php $pageTitle = 'Medya Kütüphanesi'; $pretitle = 'Sistem'; ?>

<!-- Upload Zone -->
<div class="card mb-4">
    <div class="card-body">
        <div id="uploadZone" class="upload-zone">
            <div class="upload-zone-inner">
                <i class="ti ti-cloud-upload" style="font-size:2.5rem;color:#64748b;display:block;margin-bottom:.5rem"></i>
                <p class="mb-1 fw-medium">Dosyaları buraya sürükleyin veya</p>
                <label class="btn btn-primary btn-sm mt-1" for="fileInput">Dosya Seç</label>
                <input type="file" id="fileInput" multiple accept="image/*,.pdf,.svg" style="display:none">
                <p class="text-muted small mt-2">JPG, PNG, WebP, SVG, GIF, PDF — maks. 10 MB</p>
            </div>
        </div>
        <div id="uploadProgress" class="mt-3" style="display:none">
            <div class="progress">
                <div class="progress-bar bg-primary progress-bar-animated progress-bar-striped" id="progressBar" style="width:0%"></div>
            </div>
            <p class="text-muted small mt-1" id="uploadStatus">Yükleniyor...</p>
        </div>
    </div>
</div>

<!-- Media Grid -->
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title me-auto">Medya Dosyaları (<?= $total ?? 0 ?>)</h3>
        <div class="btn-group" role="group">
            <button class="btn btn-sm btn-outline-secondary active" id="viewGrid"><i class="ti ti-layout-grid"></i></button>
            <button class="btn btn-sm btn-outline-secondary" id="viewList"><i class="ti ti-list"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3" id="mediaGrid">
            <?php foreach ($data ?? [] as $file):
                $isImage = str_starts_with($file['type'] ?? '', 'image/');
            ?>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="media-item card h-100">
                    <div class="media-thumb" style="height:120px;background:#1e293b;display:flex;align-items:center;justify-content:center;overflow:hidden;border-radius:6px 6px 0 0">
                        <?php if ($isImage): ?>
                            <img src="<?= e($file['path']) ?>" alt="<?= e($file['original']) ?>"
                                 style="width:100%;height:100%;object-fit:cover" loading="lazy"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            <div style="display:none;align-items:center;justify-content:center;width:100%;height:100%;color:#64748b"><i class="ti ti-photo-off" style="font-size:2rem"></i></div>
                        <?php else: ?>
                            <i class="ti ti-file-text" style="font-size:2.5rem;color:#64748b"></i>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-2">
                        <p class="small mb-1 text-truncate" title="<?= e($file['original']) ?>"><?= e($file['original']) ?></p>
                        <p class="text-muted" style="font-size:.7rem"><?= number_format($file['size'] / 1024, 1) ?> KB</p>
                    </div>
                    <div class="card-footer p-2 d-flex gap-1">
                        <button class="btn btn-sm btn-outline-secondary flex-fill copy-url" data-url="<?= e($file['path']) ?>" title="URL Kopyala">
                            <i class="ti ti-copy"></i>
                        </button>
                        <form action="/admin/media/<?= $file['id'] ?>/delete" method="POST" class="flex-fill"
                              onsubmit="return confirm('Bu dosyayı silmek istediğinizden emin misiniz?')">
                            <button class="btn btn-sm btn-outline-danger w-100"><i class="ti ti-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (empty($data)): ?>
            <div class="col-12 text-center py-5 text-muted">
                <i class="ti ti-photo" style="font-size:3rem;opacity:.2;display:block;margin-bottom:1rem"></i>
                Henüz dosya yüklenmemiş
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pagination -->
    <?php if (($last_page ?? 1) > 1): ?>
    <div class="card-footer d-flex justify-content-end">
        <ul class="pagination mb-0">
            <?php for ($i = 1; $i <= ($last_page ?? 1); $i++): ?>
            <li class="page-item <?= $i === ($page ?? 1) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>

<style>
.upload-zone { border: 2px dashed #334155; border-radius: 12px; padding: 2rem; text-align: center; cursor: pointer; transition: all .2s; }
.upload-zone.drag-over { border-color: #E30613; background: rgba(227,6,19,.05); }
.upload-zone-inner { pointer-events: none; }
.media-item { border: 1px solid rgba(255,255,255,.06); transition: border-color .2s; }
.media-item:hover { border-color: rgba(227,6,19,.4); }
</style>

<script>
const zone = document.getElementById('uploadZone');
const input = document.getElementById('fileInput');
const progress = document.getElementById('uploadProgress');
const bar = document.getElementById('progressBar');
const status = document.getElementById('uploadStatus');

zone.addEventListener('click', () => input.click());
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.classList.remove('drag-over');
    uploadFiles(e.dataTransfer.files);
});
input.addEventListener('change', () => uploadFiles(input.files));

function uploadFiles(files) {
    Array.from(files).forEach(file => {
        const form = new FormData();
        form.append('file', file);
        form.append('folder', 'images');

        progress.style.display = 'block';
        status.textContent = `${file.name} yükleniyor...`;

        fetch('/admin/media/upload', { method: 'POST', body: form })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    bar.style.width = '100%';
                    status.textContent = '✓ Yüklendi: ' + file.name;
                    setTimeout(() => location.reload(), 800);
                } else {
                    status.textContent = '✗ Hata: ' + (data.message || 'Bilinmeyen hata');
                }
            })
            .catch(() => { status.textContent = '✗ Yükleme başarısız'; });
    });
}

document.querySelectorAll('.copy-url').forEach(btn => {
    btn.addEventListener('click', () => {
        navigator.clipboard.writeText(btn.dataset.url).then(() => {
            btn.innerHTML = '<i class="ti ti-check"></i>';
            setTimeout(() => btn.innerHTML = '<i class="ti ti-copy"></i>', 1500);
        });
    });
});
</script>
