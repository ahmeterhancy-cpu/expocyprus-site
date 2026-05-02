<?php
$pageTitle = 'Builder: ' . ($page['title_tr'] ?? '');
$pretitle  = 'Sayfa Oluşturucu (Block-tabanlı)';
$defs = \App\Models\CmsPage::PAGE_DEFINITIONS;
$def = $defs[$page['page_key']] ?? null;
$route = $def['route'] ?? '#';
$headerActions = '
    <a href="' . e($route) . '" target="_blank" class="btn btn-outline-secondary me-2"><i class="ti ti-external-link me-1"></i>Sayfayı Aç</a>
    <a href="/admin/cms/' . e($page['page_key']) . '" class="btn btn-outline-secondary me-2"><i class="ti ti-list-details me-1"></i>Klasik Düzenleyici</a>
    <a href="/admin/cms" class="btn btn-outline-secondary">← CMS</a>
';
?>

<div class="bld-shell">
    <!-- LEFT: Block Library -->
    <aside class="bld-library" aria-label="Block Library">
        <div class="bld-lib-head">
            <h3>Bloklar</h3>
            <small>Sürükle-bırak ile sayfaya ekle</small>
        </div>
        <div class="bld-lib-list">
            <?php foreach ($blockTypes as $type => $cfg): ?>
            <div class="bld-lib-item" draggable="true" data-block-type="<?= e($type) ?>">
                <span class="bld-lib-icon"><?= $cfg['icon'] ?></span>
                <span class="bld-lib-meta">
                    <strong><?= e($cfg['label']) ?></strong>
                    <small><?= e($cfg['desc']) ?></small>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </aside>

    <!-- CENTER: Canvas -->
    <main class="bld-canvas-wrap">
        <div class="bld-canvas-head">
            <div class="bld-page-info">
                <h2><?= e($page['title_tr']) ?></h2>
                <code><?= e($page['page_key']) ?> · <?= e($route) ?></code>
            </div>
            <div class="bld-actions">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="bldClearAll" title="Tüm blokları sil">
                    <i class="ti ti-trash"></i>
                </button>
                <span class="bld-save-status" id="bldStatus"></span>
                <button type="button" class="btn btn-primary" id="bldSave">
                    <i class="ti ti-device-floppy me-1"></i>Kaydet
                </button>
            </div>
        </div>

        <?php if (!empty($isSeeded)): ?>
        <div class="bld-seed-notice">
            <div class="bld-seed-text">
                <strong>📦 Hazır içerikle yüklendi</strong>
                Sayfanın mevcut içerikleri otomatik bloklara çevrildi. Düzenleyebilir, silebilir ya da yeni bloklar ekleyebilirsin. <strong>Kaydedince</strong> kalıcı olur.
            </div>
        </div>
        <?php endif; ?>

        <div class="bld-canvas" id="bldCanvas">
            <div class="bld-empty" id="bldEmpty" <?= !empty($blocks) ? 'style="display:none"' : '' ?>>
                <div class="bld-empty-icon">⊕</div>
                <h3>Sayfa boş</h3>
                <p>Soldaki bloklardan birini sürükleyip buraya bırakın</p>
            </div>
        </div>
    </main>

    <!-- RIGHT: Block Editor -->
    <aside class="bld-editor" id="bldEditor" aria-label="Block Editor">
        <div class="bld-editor-empty">
            <div class="bld-editor-empty-icon">✎</div>
            <p>Düzenlemek için bir blok seçin</p>
        </div>
    </aside>
</div>

<style>
/* ═══════════════════════════════════════════════════════════════
   PAGE BUILDER — Elementor tarzı 3 panel
═══════════════════════════════════════════════════════════════ */
.page-wrapper > .container-xl, .page-wrapper > .container-fluid { max-width: 100% !important; padding: 0 !important; }
.bld-shell {
    display: grid;
    grid-template-columns: 280px 1fr 360px;
    height: calc(100vh - 80px);
    background: var(--tblr-bg-surface-secondary, #f5f5f7);
    overflow: hidden;
    margin: -1.5rem -1rem 0;
}

/* ── LIBRARY (sol) ── */
.bld-library {
    background: var(--tblr-bg-surface, #fff);
    border-right: 1px solid var(--tblr-border-color, #e5e7eb);
    overflow-y: auto;
    display: flex; flex-direction: column;
}
.bld-lib-head {
    padding: 1.25rem 1.25rem .75rem;
    border-bottom: 1px solid var(--tblr-border-color);
    flex-shrink: 0;
}
.bld-lib-head h3 { margin: 0; font-size: .875rem; font-weight: 700; letter-spacing: .03em; text-transform: uppercase; color: var(--tblr-secondary); }
.bld-lib-head small { color: var(--tblr-secondary); font-size: .75rem; }
.bld-lib-list { padding: .75rem; display: flex; flex-direction: column; gap: .35rem; }
.bld-lib-item {
    display: flex; align-items: center; gap: .75rem;
    padding: .65rem .75rem;
    background: var(--tblr-bg-surface-secondary, #f5f5f7);
    border: 1px solid transparent;
    border-radius: 10px;
    cursor: grab;
    transition: all .15s;
    user-select: none;
}
.bld-lib-item:hover {
    background: #fff;
    border-color: #E30613;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,.06);
}
.bld-lib-item:active { cursor: grabbing; }
.bld-lib-item.dragging { opacity: .4; }
.bld-lib-icon {
    width: 36px; height: 36px;
    display: inline-flex; align-items: center; justify-content: center;
    background: rgba(227,6,19,.08);
    color: #E30613; border-radius: 8px;
    font-size: 1.25rem; flex-shrink: 0;
}
.bld-lib-meta { display: flex; flex-direction: column; gap: .125rem; min-width: 0; }
.bld-lib-meta strong { font-size: .8125rem; color: var(--tblr-body-color); font-weight: 600; }
.bld-lib-meta small { font-size: .6875rem; color: var(--tblr-secondary); line-height: 1.2; }

/* ── CANVAS (orta) ── */
.bld-canvas-wrap { display: flex; flex-direction: column; min-width: 0; }
.bld-canvas-head {
    padding: 1rem 1.5rem;
    background: var(--tblr-bg-surface, #fff);
    border-bottom: 1px solid var(--tblr-border-color);
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.bld-page-info h2 { margin: 0; font-size: 1rem; font-weight: 600; color: var(--tblr-body-color); }
.bld-page-info code { font-size: .75rem; color: var(--tblr-secondary); }
.bld-actions { display: flex; gap: .5rem; align-items: center; }
.bld-save-status { font-size: .8125rem; color: var(--tblr-secondary); }
.bld-save-status.saving { color: #f59e0b; }
.bld-save-status.saved { color: #10b981; }
.bld-save-status.error { color: #ef4444; }

.bld-seed-notice {
    background: linear-gradient(90deg, rgba(16,185,129,.08), rgba(16,185,129,.02));
    border-bottom: 1px solid rgba(16,185,129,.2);
    padding: .75rem 1.5rem;
    color: #065f46;
    font-size: .8125rem;
    flex-shrink: 0;
}
.bld-seed-text strong { display: inline-block; margin-right: .5rem; color: #047857; }

.bld-canvas {
    flex: 1; overflow-y: auto;
    padding: 2rem;
    background: linear-gradient(135deg, #f5f5f7 25%, transparent 25%, transparent 75%, #f5f5f7 75%),
                linear-gradient(135deg, #f5f5f7 25%, #fff 25%, #fff 75%, #f5f5f7 75%);
    background-size: 20px 20px;
    background-position: 0 0, 10px 10px;
    background-color: #fafafa;
}

.bld-empty {
    text-align: center; padding: 4rem 2rem;
    border: 2px dashed var(--tblr-border-color, #e5e7eb);
    border-radius: 18px;
    color: var(--tblr-secondary);
    background: rgba(255,255,255,.7);
    transition: all .25s;
}
.bld-empty.over { border-color: #E30613; background: #fff5f5; color: #E30613; }
.bld-empty-icon { font-size: 4rem; opacity: .3; margin-bottom: 1rem; line-height: 1; }
.bld-empty h3 { margin: 0 0 .5rem; font-size: 1.25rem; font-weight: 600; }
.bld-empty p { margin: 0; font-size: .875rem; }

/* Block on canvas */
.bld-block {
    position: relative;
    background: #fff;
    border: 2px solid transparent;
    border-radius: 12px;
    margin-bottom: 1rem;
    overflow: hidden;
    transition: all .2s;
}
.bld-block:hover { border-color: rgba(227,6,19,.4); box-shadow: 0 4px 16px rgba(0,0,0,.08); }
.bld-block.selected { border-color: #E30613; box-shadow: 0 8px 24px rgba(227,6,19,.15); }
.bld-block.drag-over { box-shadow: 0 0 0 3px #E30613, 0 4px 12px rgba(227,6,19,.2); }
.bld-block-toolbar {
    position: absolute; top: 8px; right: 8px;
    display: flex; gap: 4px;
    z-index: 10;
    opacity: 0; transition: opacity .2s;
}
.bld-block:hover .bld-block-toolbar,
.bld-block.selected .bld-block-toolbar { opacity: 1; }
.bld-tb-btn {
    width: 28px; height: 28px;
    background: rgba(0,0,0,.85); color: #fff;
    border: 0; border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .15s;
    backdrop-filter: blur(10px);
}
.bld-tb-btn:hover { background: #E30613; }
.bld-tb-btn.bld-tb-handle { cursor: grab; }
.bld-tb-btn.bld-tb-handle:active { cursor: grabbing; }
.bld-block-label {
    position: absolute; top: 8px; left: 8px;
    background: rgba(0,0,0,.85); color: #fff;
    padding: 4px 10px; border-radius: 6px;
    font-size: .7rem; font-weight: 600; letter-spacing: .03em;
    text-transform: uppercase; z-index: 10;
    backdrop-filter: blur(10px);
    opacity: 0; transition: opacity .2s;
}
.bld-block:hover .bld-block-label,
.bld-block.selected .bld-block-label { opacity: 1; }

.bld-block-preview {
    pointer-events: none;
    width: 100%;
    height: 220px; /* JS dinamik olarak günceller */
    min-height: 120px;
    max-height: 640px;
    overflow: hidden;
    background: #fff;
    position: relative;
    transition: height .2s ease;
}
.bld-block-preview iframe {
    position: absolute; top: 0; left: 0;
    width: 1280px; height: 720px;
    border: 0; pointer-events: none;
    background: #fff;
    transform-origin: 0 0;
    /* transform: scale() JS ile set ediliyor */
}

/* ── EDITOR (sağ) ── */
.bld-editor {
    background: var(--tblr-bg-surface, #fff);
    border-left: 1px solid var(--tblr-border-color, #e5e7eb);
    overflow-y: auto;
    display: flex; flex-direction: column;
}
.bld-editor-empty {
    padding: 4rem 2rem; text-align: center;
    color: var(--tblr-secondary);
}
.bld-editor-empty-icon { font-size: 3rem; opacity: .3; margin-bottom: 1rem; }
.bld-editor-empty p { font-size: .8125rem; }

.bld-edit-head {
    padding: 1.25rem 1.25rem .75rem;
    border-bottom: 1px solid var(--tblr-border-color);
    flex-shrink: 0;
}
.bld-edit-head h3 {
    margin: 0; font-size: .875rem; font-weight: 700;
    letter-spacing: .03em; text-transform: uppercase;
    color: var(--tblr-secondary);
}
.bld-edit-title {
    margin: .35rem 0 0; font-size: 1rem; font-weight: 600;
    color: var(--tblr-body-color); display: flex; align-items: center; gap: .5rem;
}
.bld-edit-form { padding: 1.25rem; flex: 1; }
.bld-edit-form .bld-field { margin-bottom: 1.125rem; }
.bld-edit-form label {
    display: block; font-size: .75rem; font-weight: 600;
    color: var(--tblr-secondary); margin-bottom: .35rem;
    text-transform: uppercase; letter-spacing: .03em;
}
.bld-edit-form input[type="text"],
.bld-edit-form input[type="url"],
.bld-edit-form select,
.bld-edit-form textarea {
    width: 100%; padding: .55rem .75rem;
    border: 1px solid var(--tblr-border-color, #d1d5db);
    border-radius: 8px;
    background: #fff; color: var(--tblr-body-color);
    font-size: .875rem; font-family: inherit;
    transition: all .15s;
}
.bld-edit-form input:focus, .bld-edit-form select:focus, .bld-edit-form textarea:focus {
    outline: 0; border-color: #E30613;
    box-shadow: 0 0 0 3px rgba(227,6,19,.08);
}
.bld-edit-form textarea { resize: vertical; min-height: 70px; font-family: 'JetBrains Mono', monospace; font-size: .8125rem; }
.bld-edit-form input[type="color"] {
    width: 56px; height: 38px; padding: 2px;
    border: 1px solid var(--tblr-border-color); border-radius: 8px;
    flex-shrink: 0;
}
.bld-color-input { display: flex; align-items: center; gap: .35rem; }
.bld-color-input input[type="text"] {
    flex: 1 0 auto; font-family: 'JetBrains Mono', monospace; font-size: .8125rem;
}
.bld-color-clear {
    width: 28px; height: 28px; border: 1px solid var(--tblr-border-color);
    border-radius: 6px; background: transparent; color: var(--tblr-secondary);
    cursor: pointer; font-size: 1.125rem; line-height: 1;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.bld-color-clear:hover { background: rgba(227,6,19,.08); color: #E30613; border-color: #E30613; }
.bld-edit-form .bld-checkbox { display: flex; align-items: center; gap: .5rem; }
.bld-edit-form .bld-checkbox input { width: 18px; height: 18px; }
.bld-edit-form .bld-checkbox label { margin: 0; text-transform: none; letter-spacing: 0; font-size: .875rem; color: var(--tblr-body-color); font-weight: 500; }
.bld-image-input { display: flex; gap: .5rem; }
.bld-image-input input { flex: 1; }
.bld-image-input button {
    background: var(--tblr-bg-surface-secondary); color: var(--tblr-body-color);
    border: 1px solid var(--tblr-border-color);
    padding: 0 .75rem; border-radius: 8px;
    cursor: pointer; font-size: .85rem;
}

/* Mobile */
@media (max-width: 1200px) {
    .bld-shell { grid-template-columns: 220px 1fr 320px; }
}
@media (max-width: 992px) {
    .bld-shell {
        grid-template-columns: 1fr;
        height: auto;
    }
    .bld-library, .bld-editor {
        max-height: 280px;
        border-right: 0; border-left: 0;
        border-bottom: 1px solid var(--tblr-border-color);
    }
}
</style>

<script>
(function() {
    const BLOCK_TYPES = <?= json_encode(\App\Core\BlockRenderer::BLOCK_TYPES, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    const PAGE_KEY = '<?= e($page['page_key']) ?>';
    let blocks = <?= json_encode($blocks, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    let selectedIdx = null;

    const canvas = document.getElementById('bldCanvas');
    const empty  = document.getElementById('bldEmpty');
    const editor = document.getElementById('bldEditor');
    const status = document.getElementById('bldStatus');

    /* ─── DRAG & DROP from Library ─── */
    let draggedType = null;
    document.querySelectorAll('.bld-lib-item').forEach(item => {
        item.addEventListener('dragstart', e => {
            draggedType = item.dataset.blockType;
            item.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'copy';
        });
        item.addEventListener('dragend', () => item.classList.remove('dragging'));
    });

    canvas.addEventListener('dragover', e => {
        e.preventDefault();
        e.dataTransfer.dropEffect = draggedType ? 'copy' : 'move';
        if (empty) empty.classList.add('over');
    });
    canvas.addEventListener('dragleave', () => { if (empty) empty.classList.remove('over'); });
    canvas.addEventListener('drop', e => {
        e.preventDefault();
        if (empty) empty.classList.remove('over');
        if (draggedType) {
            const cfg = BLOCK_TYPES[draggedType];
            const data = {};
            for (const [k, f] of Object.entries(cfg.fields || {})) {
                if (f.default !== undefined) data[k] = f.default;
            }
            blocks.push({ type: draggedType, data });
            draggedType = null;
            renderCanvas();
            selectBlock(blocks.length - 1);
            markDirty();
        }
    });

    /* ─── RENDER CANVAS ─── */
    function renderCanvas() {
        // Remove all blocks but keep empty state
        canvas.querySelectorAll('.bld-block').forEach(n => n.remove());
        if (blocks.length === 0) {
            empty.style.display = '';
            return;
        }
        empty.style.display = 'none';

        blocks.forEach((b, idx) => {
            const cfg = BLOCK_TYPES[b.type] || { label: b.type, icon: '?' };
            const el = document.createElement('div');
            el.className = 'bld-block' + (selectedIdx === idx ? ' selected' : '');
            el.dataset.idx = idx;
            el.innerHTML = `
                <div class="bld-block-label">${cfg.icon} ${cfg.label}</div>
                <div class="bld-block-toolbar">
                    <button type="button" class="bld-tb-btn bld-tb-handle" title="Sürükle" draggable="true"><i class="ti ti-grip-vertical"></i></button>
                    <button type="button" class="bld-tb-btn bld-tb-up" title="Yukarı taşı"><i class="ti ti-chevron-up"></i></button>
                    <button type="button" class="bld-tb-btn bld-tb-down" title="Aşağı taşı"><i class="ti ti-chevron-down"></i></button>
                    <button type="button" class="bld-tb-btn bld-tb-dup" title="Çoğalt"><i class="ti ti-copy"></i></button>
                    <button type="button" class="bld-tb-btn bld-tb-del" title="Sil"><i class="ti ti-trash"></i></button>
                </div>
                <div class="bld-block-preview" id="bld-preview-${idx}">
                    <iframe srcdoc="<!DOCTYPE html><html><head><meta charset='utf-8'><link rel='stylesheet' href='/assets/css/main.css?v=10'><link rel='stylesheet' href='/assets/css/blocks.css?v=1'><style>body{margin:0;padding:0}</style></head><body><div style='padding:2rem;color:#86868b;text-align:center;font-family:Inter,sans-serif'>Yükleniyor...</div></body></html>"></iframe>
                </div>
            `;

            // Click to select
            el.addEventListener('click', e => {
                if (e.target.closest('.bld-tb-btn')) return;
                selectBlock(idx);
            });

            // Toolbar buttons
            el.querySelector('.bld-tb-up').addEventListener('click', e => { e.stopPropagation(); moveBlock(idx, -1); });
            el.querySelector('.bld-tb-down').addEventListener('click', e => { e.stopPropagation(); moveBlock(idx, 1); });
            el.querySelector('.bld-tb-dup').addEventListener('click', e => { e.stopPropagation(); duplicateBlock(idx); });
            el.querySelector('.bld-tb-del').addEventListener('click', e => {
                e.stopPropagation();
                if (confirm('Bu bloğu silmek istediğinize emin misiniz?')) deleteBlock(idx);
            });

            // Drag-drop reorder via handle
            const handle = el.querySelector('.bld-tb-handle');
            handle.addEventListener('dragstart', e => {
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/idx', String(idx));
                el.classList.add('dragging');
            });
            handle.addEventListener('dragend', () => el.classList.remove('dragging'));
            el.addEventListener('dragover', e => {
                if (draggedType) return; // library drag handled by canvas
                e.preventDefault();
                el.classList.add('drag-over');
            });
            el.addEventListener('dragleave', () => el.classList.remove('drag-over'));
            el.addEventListener('drop', e => {
                el.classList.remove('drag-over');
                const fromIdx = parseInt(e.dataTransfer.getData('text/idx'), 10);
                if (isNaN(fromIdx) || fromIdx === idx) return;
                e.preventDefault();
                e.stopPropagation();
                const moved = blocks.splice(fromIdx, 1)[0];
                const toIdx = fromIdx < idx ? idx : idx;
                blocks.splice(toIdx, 0, moved);
                renderCanvas();
                markDirty();
            });

            canvas.appendChild(el);

            // Lazy-render preview
            requestAnimationFrame(() => renderBlockPreview(idx, b));
        });

        // Tüm preview'leri ölçekle (yeniden çizimden sonra)
        requestAnimationFrame(scaleAllPreviews);
    }

    /* ─── PREVIEW SCALE + DİNAMİK YÜKSEKLİK ─── */
    function fitPreview(wrap) {
        const iframe = wrap.querySelector('iframe');
        if (!iframe) return;
        const w = wrap.clientWidth;
        if (w <= 0) return;
        const scale = w / 1280;
        iframe.style.transform = `scale(${scale})`;

        // İçerik yüksekliğine göre container'ı boyutlandır
        try {
            const doc = iframe.contentDocument || iframe.contentWindow?.document;
            if (doc && doc.body) {
                const contentH = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight);
                if (contentH > 0) {
                    const scaledH = Math.max(120, Math.min(640, contentH * scale));
                    wrap.style.height = scaledH + 'px';
                }
            }
        } catch (e) { /* cross-origin guard */ }
    }
    // Geriye dönük uyumluluk
    function scalePreview(wrap) { fitPreview(wrap); }

    function scaleAllPreviews() {
        document.querySelectorAll('.bld-block-preview').forEach(fitPreview);
    }
    if ('ResizeObserver' in window) {
        const ro = new ResizeObserver(scaleAllPreviews);
        ro.observe(canvas);
    }
    window.addEventListener('resize', scaleAllPreviews);

    /* ─── RENDER A SINGLE BLOCK PREVIEW ─── */
    async function renderBlockPreview(idx, block) {
        try {
            const fd = new FormData();
            fd.append('type', block.type);
            for (const [k, v] of Object.entries(block.data || {})) {
                fd.append('data[' + k + ']', v ?? '');
            }
            const res = await fetch('/admin/cms/builder/preview', { method: 'POST', body: fd });
            const json = await res.json();
            if (!json.ok) return;
            const el = document.querySelector('#bld-preview-' + idx + ' iframe');
            if (!el) return;
            // Listener'ı srcdoc'TAN ÖNCE ekle, yoksa hızlı yüklenmede tetiklenmez
            el.addEventListener('load', () => {
                fitPreview(el.parentElement);
                // Resim yüklenmesi için bir tur daha
                setTimeout(() => fitPreview(el.parentElement), 300);
                setTimeout(() => fitPreview(el.parentElement), 800);
            }, { once: true });
            const doc = `<!DOCTYPE html><html><head><meta charset="utf-8"><link rel="stylesheet" href="/assets/css/main.css?v=10"><link rel="stylesheet" href="/assets/css/blocks.css?v=1"><style>body{margin:0;padding:0;font-family:Inter,sans-serif}</style></head><body>${json.html}</body></html>`;
            el.srcdoc = doc;
        } catch (err) { console.error(err); }
    }

    /* ─── BLOCK ACTIONS ─── */
    function selectBlock(idx) {
        selectedIdx = idx;
        document.querySelectorAll('.bld-block').forEach(el => el.classList.toggle('selected', parseInt(el.dataset.idx) === idx));
        renderEditor();
    }
    function moveBlock(idx, delta) {
        const newIdx = idx + delta;
        if (newIdx < 0 || newIdx >= blocks.length) return;
        [blocks[idx], blocks[newIdx]] = [blocks[newIdx], blocks[idx]];
        if (selectedIdx === idx) selectedIdx = newIdx;
        else if (selectedIdx === newIdx) selectedIdx = idx;
        renderCanvas();
        markDirty();
    }
    function duplicateBlock(idx) {
        const copy = JSON.parse(JSON.stringify(blocks[idx]));
        blocks.splice(idx + 1, 0, copy);
        renderCanvas();
        selectBlock(idx + 1);
        markDirty();
    }
    function deleteBlock(idx) {
        blocks.splice(idx, 1);
        if (selectedIdx === idx) selectedIdx = null;
        renderCanvas();
        renderEditor();
        markDirty();
    }

    /* ─── EDITOR (sağ panel) ─── */
    function renderEditor() {
        if (selectedIdx === null || !blocks[selectedIdx]) {
            editor.innerHTML = `
                <div class="bld-editor-empty">
                    <div class="bld-editor-empty-icon">✎</div>
                    <p>Düzenlemek için bir blok seçin</p>
                </div>
            `;
            return;
        }
        const block = blocks[selectedIdx];
        const cfg = BLOCK_TYPES[block.type] || { fields: {} };

        let html = `
            <div class="bld-edit-head">
                <h3>BLOK AYARLARI</h3>
                <p class="bld-edit-title">${cfg.icon || ''} ${cfg.label || block.type}</p>
            </div>
            <div class="bld-edit-form">
        `;

        for (const [key, field] of Object.entries(cfg.fields)) {
            const val = block.data[key] ?? field.default ?? '';
            html += `<div class="bld-field">`;
            html += `<label>${escapeHtml(field.label)}</label>`;

            switch (field.type) {
                case 'textarea':
                    html += `<textarea data-field="${key}" rows="3" placeholder="${escapeHtml(field.placeholder || '')}">${escapeHtml(val)}</textarea>`;
                    break;
                case 'richtext':
                    html += `<textarea data-field="${key}" rows="6" placeholder="HTML: &lt;p&gt;Metin&lt;/p&gt;">${escapeHtml(val)}</textarea>`;
                    break;
                case 'select':
                    html += `<select data-field="${key}">`;
                    for (const [optV, optL] of Object.entries(field.options || {})) {
                        html += `<option value="${escapeHtml(optV)}" ${optV == val ? 'selected' : ''}>${escapeHtml(optL)}</option>`;
                    }
                    html += `</select>`;
                    break;
                case 'color':
                    const colorVal = val || field.default || '';
                    html += `<div class="bld-color-input">`;
                    html += `<input type="color" data-field="${key}" value="${escapeHtml(colorVal || '#000000')}">`;
                    html += `<input type="text" data-field-mirror="${key}" value="${escapeHtml(colorVal)}" placeholder="boş = varsayılan" style="margin-left:.5rem;width:120px">`;
                    html += `<button type="button" class="bld-color-clear" data-field-clear="${key}" title="Temizle">×</button>`;
                    html += `</div>`;
                    break;
                case 'checkbox':
                    html += `<div class="bld-checkbox"><input type="checkbox" data-field="${key}" id="cb-${key}" ${val ? 'checked' : ''}><label for="cb-${key}">Aktif</label></div>`;
                    break;
                case 'image':
                    html += `<div class="bld-image-input">
                        <input type="text" data-field="${key}" value="${escapeHtml(val)}" placeholder="/uploads/... veya URL">
                    </div>`;
                    if (val) html += `<img src="${escapeHtml(val)}" style="max-width:100%;margin-top:.5rem;border-radius:8px">`;
                    break;
                default:
                    html += `<input type="text" data-field="${key}" value="${escapeHtml(val)}" placeholder="${escapeHtml(field.placeholder || '')}">`;
            }
            html += `</div>`;
        }
        html += `</div>`;
        editor.innerHTML = html;

        // Attach change handlers (debounced for text)
        let debounce;
        editor.querySelectorAll('[data-field]').forEach(input => {
            input.addEventListener('input', () => {
                const k = input.dataset.field;
                let v;
                if (input.type === 'checkbox') v = input.checked ? '1' : '';
                else v = input.value;
                blocks[selectedIdx].data[k] = v;
                // Color picker'da text mirror'ı senkronize et
                if (input.type === 'color') {
                    const mirror = editor.querySelector(`[data-field-mirror="${k}"]`);
                    if (mirror) mirror.value = v;
                }
                markDirty();
                clearTimeout(debounce);
                debounce = setTimeout(() => renderBlockPreview(selectedIdx, blocks[selectedIdx]), 250);
            });
        });

        // Color text mirror — kullanıcı hex elle yazdığında color picker'ı güncelle
        editor.querySelectorAll('[data-field-mirror]').forEach(input => {
            input.addEventListener('input', () => {
                const k = input.dataset.fieldMirror;
                const v = input.value.trim();
                blocks[selectedIdx].data[k] = v;
                if (/^#[0-9a-f]{3,8}$/i.test(v)) {
                    const picker = editor.querySelector(`input[type="color"][data-field="${k}"]`);
                    if (picker) picker.value = v.length === 4
                        ? '#' + v.slice(1).split('').map(c => c+c).join('')
                        : v.slice(0, 7);
                }
                markDirty();
                clearTimeout(debounce);
                debounce = setTimeout(() => renderBlockPreview(selectedIdx, blocks[selectedIdx]), 250);
            });
        });

        // Color clear butonu
        editor.querySelectorAll('[data-field-clear]').forEach(btn => {
            btn.addEventListener('click', () => {
                const k = btn.dataset.fieldClear;
                blocks[selectedIdx].data[k] = '';
                const picker = editor.querySelector(`input[type="color"][data-field="${k}"]`);
                const mirror = editor.querySelector(`[data-field-mirror="${k}"]`);
                if (picker) picker.value = '#000000';
                if (mirror) mirror.value = '';
                markDirty();
                renderBlockPreview(selectedIdx, blocks[selectedIdx]);
            });
        });
    }

    function escapeHtml(s) { return String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }

    /* ─── SAVE ─── */
    let dirty = false;
    function markDirty() {
        dirty = true;
        status.textContent = '● Değişiklik var';
        status.className = 'bld-save-status';
    }

    document.getElementById('bldSave').addEventListener('click', save);
    document.getElementById('bldClearAll').addEventListener('click', () => {
        if (!confirm('Tüm blokları silmek istediğinize emin misiniz?')) return;
        blocks = [];
        selectedIdx = null;
        renderCanvas();
        renderEditor();
        markDirty();
    });

    async function save() {
        status.textContent = 'Kaydediliyor...';
        status.className = 'bld-save-status saving';
        try {
            const fd = new FormData();
            fd.append('blocks_json', JSON.stringify(blocks));
            const res = await fetch('/admin/cms/' + PAGE_KEY + '/builder/save', { method: 'POST', body: fd });
            const json = await res.json();
            if (json.ok) {
                status.textContent = '✓ Kaydedildi (' + json.count + ' blok)';
                status.className = 'bld-save-status saved';
                dirty = false;
                setTimeout(() => { if (!dirty) status.textContent = ''; }, 3000);
            } else {
                throw new Error(json.error || 'Kayıt hatası');
            }
        } catch (err) {
            status.textContent = '✗ Hata: ' + err.message;
            status.className = 'bld-save-status error';
        }
    }

    // Ctrl+S to save
    document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') { e.preventDefault(); save(); }
    });

    // Beforeunload warning
    window.addEventListener('beforeunload', e => {
        if (dirty) { e.preventDefault(); return e.returnValue = 'Kaydedilmemiş değişiklikler var!'; }
    });

    // Initial render
    renderCanvas();
})();
</script>
