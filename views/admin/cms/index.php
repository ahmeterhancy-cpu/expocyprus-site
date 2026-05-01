<?php
$pageTitle = 'Sayfa Düzenleyici';
$pretitle  = 'CMS — İçerik Yönetimi';
$headerActions = '<a href="/admin/cms/settings" class="btn btn-primary"><i class="ti ti-settings me-1"></i>Site Ayarları</a>';
$defs = \App\Models\CmsPage::PAGE_DEFINITIONS;
$groups = \App\Models\CmsPage::PAGE_GROUPS;

$pagesByKey = [];
foreach ($pages as $p) $pagesByKey[$p['page_key']] = $p;

$grouped = [];
foreach ($defs as $key => $def) {
    $g = $def['group'] ?? 'other';
    if (!isset($pagesByKey[$key])) continue;
    $grouped[$g][] = ['key' => $key, 'def' => $def, 'page' => $pagesByKey[$key]];
}

// Stats
$total = count($pages);
$withSeo = 0; $withHero = 0; $draft = 0;
foreach ($pages as $p) {
    if (!empty($p['meta_title_tr']) || !empty($p['meta_description_tr'])) $withSeo++;
    if (!empty($p['hero_title_tr']) || !empty($p['hero_image'])) $withHero++;
    if (($p['status'] ?? '') === 'draft') $draft++;
}
?>

<!-- Stats Strip -->
<div class="cms-stats">
    <div class="cms-stat">
        <div class="cms-stat-num"><?= $total ?></div>
        <div class="cms-stat-label">Toplam Sayfa</div>
    </div>
    <div class="cms-stat cms-stat-green">
        <div class="cms-stat-num"><?= $withSeo ?></div>
        <div class="cms-stat-label">SEO Dolu</div>
    </div>
    <div class="cms-stat cms-stat-blue">
        <div class="cms-stat-num"><?= $withHero ?></div>
        <div class="cms-stat-label">Hero Özelleştirilmiş</div>
    </div>
    <div class="cms-stat cms-stat-orange">
        <div class="cms-stat-num"><?= $draft ?></div>
        <div class="cms-stat-label">Taslak</div>
    </div>
</div>

<!-- Search + View toggle -->
<div class="cms-toolbar">
    <div class="cms-search">
        <i class="ti ti-search"></i>
        <input type="text" id="cmsSearch" placeholder="Sayfa ara..." autocomplete="off">
    </div>
    <div class="cms-view-toggle">
        <button class="cms-view-btn active" data-view="grid" title="Grid"><i class="ti ti-layout-grid"></i></button>
        <button class="cms-view-btn" data-view="list" title="Liste"><i class="ti ti-list"></i></button>
    </div>
</div>

<?php
// Eğer controller değişkenleri aktarmadıysa, fallback olarak burada DB'den çek
if (!isset($services)) {
    try { $services = \App\Core\DB::query("SELECT id, slug, title_tr, title_en, image, status, updated_at FROM services ORDER BY sort_order ASC, id ASC"); }
    catch (\Throwable $e) { $services = []; }
}
if (!isset($fairs)) {
    try { $fairs = \App\Core\DB::query("SELECT id, slug, name_tr, name_en, image_hero AS image, status, updated_at FROM fairs ORDER BY sort_order ASC, id ASC"); }
    catch (\Throwable $e) { $fairs = []; }
}
if (!isset($blogPosts)) {
    try { $blogPosts = \App\Core\DB::query("SELECT id, slug, title, image, status, updated_at, lang FROM blog_posts ORDER BY published_at DESC LIMIT 50"); }
    catch (\Throwable $e) { $blogPosts = []; }
}

// Build dynamic groups (services, fairs, blog) — bu içerikler kendi tablolarından gelir
$dynamicGroups = [
    'service_pages' => [
        'cfg'   => ['label' => 'Hizmet Detay Sayfaları', 'icon' => '🛠️', 'color' => 'cyan'],
        'items' => array_map(function($s) {
            return [
                'title_tr' => $s['title_tr'] ?? '',
                'title_en' => $s['title_en'] ?? '',
                'key'      => $s['slug'] ?? ('service-' . $s['id']),
                'route'    => '/hizmetler/' . ($s['slug'] ?? ''),
                'edit_url' => '/admin/services/' . $s['id'] . '/edit',
                'image'    => $s['image'] ?? '',
                'status'   => $s['status'] ?? 'active',
                'updated'  => $s['updated_at'] ?? '',
            ];
        }, $services ?? []),
    ],
    'fair_pages' => [
        'cfg'   => ['label' => 'Fuar Detay Sayfaları', 'icon' => '🎪', 'color' => 'orange'],
        'items' => array_map(function($f) {
            return [
                'title_tr' => $f['name_tr'] ?? '',
                'title_en' => $f['name_en'] ?? '',
                'key'      => $f['slug'] ?? ('fair-' . $f['id']),
                'route'    => '/fuarlarimiz/' . ($f['slug'] ?? ''),
                'edit_url' => '/admin/fairs/' . $f['id'] . '/edit',
                'image'    => $f['image'] ?? '',
                'status'   => $f['status'] ?? 'active',
                'updated'  => $f['updated_at'] ?? '',
            ];
        }, $fairs ?? []),
    ],
    'blog_posts' => [
        'cfg'   => ['label' => 'Blog Yazıları', 'icon' => '📝', 'color' => 'purple'],
        'items' => array_map(function($b) {
            return [
                'title_tr' => $b['title'] ?? '',
                'title_en' => '',
                'key'      => $b['slug'] ?? ('blog-' . $b['id']),
                'route'    => '/blog/' . ($b['slug'] ?? ''),
                'edit_url' => '/admin/blog/' . $b['id'] . '/edit',
                'image'    => $b['image'] ?? '',
                'status'   => $b['status'] ?? 'draft',
                'updated'  => $b['updated_at'] ?? '',
            ];
        }, $blogPosts ?? []),
    ],
];
?>

<div class="cms-board" data-view="grid">
<?php foreach ($groups as $gKey => $gCfg):
    if (empty($grouped[$gKey])) continue;
?>
<section class="cms-group" data-group="<?= e($gKey) ?>">
    <header class="cms-group-head">
        <span class="cms-group-icon" data-color="<?= e($gCfg['color']) ?>"><?= $gCfg['icon'] ?></span>
        <h3 class="cms-group-title"><?= e($gCfg['label']) ?></h3>
        <span class="cms-group-count"><?= count($grouped[$gKey]) ?></span>
    </header>

    <div class="cms-grid">
        <?php foreach ($grouped[$gKey] as $item):
            $p = $item['page'];
            $def = $item['def'];
            $route = $def['route'] ?? '#';
            $hasSeo = !empty($p['meta_title_tr']) || !empty($p['meta_description_tr']);
            $hasHero = !empty($p['hero_title_tr']) || !empty($p['hero_image']);
            $isDraft = ($p['status'] ?? 'published') === 'draft';
            $isNoindex = (int)($p['noindex'] ?? 0) === 1;
        ?>
        <a href="/admin/cms/<?= e($p['page_key']) ?>" class="cms-card" data-search="<?= e(strtolower($p['title_tr'] . ' ' . $p['page_key'] . ' ' . ($p['title_en'] ?? ''))) ?>">
            <?php if (!empty($p['hero_image'])): ?>
            <div class="cms-card-thumb" style="background-image:url('<?= e($p['hero_image']) ?>')"></div>
            <?php endif; ?>

            <div class="cms-card-body">
                <div class="cms-card-head">
                    <h4 class="cms-card-title"><?= e($p['title_tr']) ?></h4>
                    <span class="cms-card-arrow" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                    </span>
                </div>
                <code class="cms-card-key"><?= e($p['page_key']) ?></code>
                <div class="cms-card-route"><?= e($route) ?></div>

                <div class="cms-card-meta">
                    <span class="cms-dot <?= $hasSeo ? 'cms-dot-on' : '' ?>" title="<?= $hasSeo ? 'SEO doldu' : 'SEO eksik' ?>">
                        <i class="ti ti-search"></i> SEO
                    </span>
                    <span class="cms-dot <?= $hasHero ? 'cms-dot-on' : '' ?>" title="<?= $hasHero ? 'Hero özelleştirilmiş' : 'Hero standart' ?>">
                        <i class="ti ti-photo"></i> Hero
                    </span>
                    <?php if ($isDraft): ?>
                    <span class="cms-dot cms-dot-warn" title="Taslak">
                        <i class="ti ti-pencil"></i> Taslak
                    </span>
                    <?php endif; ?>
                    <?php if ($isNoindex): ?>
                    <span class="cms-dot cms-dot-warn" title="noindex">
                        <i class="ti ti-eye-off"></i>
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="cms-card-actions">
                <button type="button" class="cms-card-action" onclick="event.preventDefault();event.stopPropagation();location.href='/admin/cms/<?= e($p['page_key']) ?>/builder'" title="Block Builder ile düzenle">
                    <i class="ti ti-layout-board"></i>
                </button>
                <button type="button" class="cms-card-action" onclick="event.preventDefault();event.stopPropagation();window.open('<?= e($route) ?>','_blank')" title="Sayfayı aç">
                    <i class="ti ti-external-link"></i>
                </button>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endforeach; ?>

<!-- ═══ DİNAMİK ALT SAYFALAR (services / fairs / blog) ═══ -->
<?php foreach ($dynamicGroups as $dKey => $dGrp):
    if (empty($dGrp['items'])) continue;
    $dCfg = $dGrp['cfg'];
?>
<section class="cms-group" data-group="<?= e($dKey) ?>">
    <header class="cms-group-head">
        <span class="cms-group-icon" data-color="<?= e($dCfg['color']) ?>"><?= $dCfg['icon'] ?></span>
        <h3 class="cms-group-title"><?= e($dCfg['label']) ?></h3>
        <span class="cms-group-count"><?= count($dGrp['items']) ?></span>
        <span class="cms-group-hint">Bu sayfalar kendi modüllerinden yönetilir</span>
    </header>

    <div class="cms-grid">
        <?php foreach ($dGrp['items'] as $item):
            $title = $item['title_tr'] ?: ($item['title_en'] ?: $item['key']);
            $isDraft = in_array(($item['status'] ?? ''), ['draft', 'inactive'], true);
        ?>
        <a href="<?= e($item['edit_url']) ?>" class="cms-card cms-card--dynamic" data-search="<?= e(strtolower($title . ' ' . $item['key'])) ?>">
            <?php if (!empty($item['image'])): ?>
            <div class="cms-card-thumb" style="background-image:url('<?= e($item['image']) ?>')"></div>
            <?php endif; ?>

            <div class="cms-card-body">
                <div class="cms-card-head">
                    <h4 class="cms-card-title"><?= e($title) ?></h4>
                    <span class="cms-card-arrow" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                    </span>
                </div>
                <code class="cms-card-key"><?= e($item['key']) ?></code>
                <div class="cms-card-route"><?= e($item['route']) ?></div>

                <div class="cms-card-meta">
                    <?php if ($isDraft): ?>
                    <span class="cms-dot cms-dot-warn"><i class="ti ti-pencil"></i> <?= e($item['status']) ?></span>
                    <?php else: ?>
                    <span class="cms-dot cms-dot-on"><i class="ti ti-check"></i> Aktif</span>
                    <?php endif; ?>
                    <?php if (!empty($item['updated'])): ?>
                    <span class="cms-dot"><i class="ti ti-clock"></i> <?= timeAgo($item['updated']) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <button type="button" class="cms-card-preview" onclick="event.preventDefault();event.stopPropagation();window.open('<?= e($item['route']) ?>','_blank')" title="Sayfayı aç">
                <i class="ti ti-external-link"></i>
            </button>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endforeach; ?>
</div>

<div class="cms-empty" id="cmsEmpty" style="display:none">
    <i class="ti ti-search-off" style="font-size:2.5rem;opacity:.3"></i>
    <p>Aradığınız kriterlere uygun sayfa bulunamadı.</p>
</div>

<style>
/* ═══ CMS PAGE EDITOR — CLEAN UI ═══ */
:root {
    --cms-card-bg: var(--tblr-bg-surface, #fff);
    --cms-card-border: var(--tblr-border-color, #e5e7eb);
    --cms-text: var(--tblr-body-color, #1d1d1f);
    --cms-text-mute: var(--tblr-secondary, #6b7280);
    --cms-accent: #E30613;
}

/* Stats */
.cms-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .875rem;
    margin-bottom: 1.5rem;
}
.cms-stat {
    background: var(--cms-card-bg);
    border: 1px solid var(--cms-card-border);
    border-radius: 14px;
    padding: 1.125rem 1.25rem;
    transition: transform .25s, box-shadow .25s;
}
.cms-stat:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.05); }
.cms-stat-num {
    font-size: 1.875rem; font-weight: 700;
    line-height: 1; color: var(--cms-text);
    letter-spacing: -.02em;
}
.cms-stat-label {
    font-size: .8125rem; color: var(--cms-text-mute);
    margin-top: .35rem; font-weight: 500;
}
.cms-stat-green  .cms-stat-num { color: #10b981; }
.cms-stat-blue   .cms-stat-num { color: #0066cc; }
.cms-stat-orange .cms-stat-num { color: #f59e0b; }

/* Toolbar */
.cms-toolbar {
    display: flex; align-items: center; gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.cms-search {
    flex: 1; max-width: 420px;
    position: relative;
}
.cms-search i {
    position: absolute; left: 1rem; top: 50%;
    transform: translateY(-50%); color: var(--cms-text-mute);
    pointer-events: none; font-size: 1.1rem;
}
.cms-search input {
    width: 100%; padding: .75rem 1rem .75rem 2.75rem;
    border: 1px solid var(--cms-card-border); border-radius: 100px;
    background: var(--cms-card-bg); color: var(--cms-text);
    font-size: .9375rem;
    transition: all .2s;
}
.cms-search input:focus {
    outline: 0; border-color: var(--cms-accent);
    box-shadow: 0 0 0 4px rgba(227,6,19,.1);
}
.cms-view-toggle {
    display: flex; gap: .25rem;
    background: var(--cms-card-bg);
    border: 1px solid var(--cms-card-border);
    border-radius: 10px; padding: .25rem;
}
.cms-view-btn {
    background: transparent; border: 0;
    padding: .5rem .75rem; border-radius: 7px;
    color: var(--cms-text-mute); cursor: pointer;
    transition: all .15s; line-height: 1;
}
.cms-view-btn:hover { color: var(--cms-text); }
.cms-view-btn.active { background: var(--cms-accent); color: #fff; }

/* Group */
.cms-group {
    margin-bottom: 2.5rem;
}
.cms-group-head {
    display: flex; align-items: center; gap: .75rem;
    margin-bottom: 1rem;
    padding-bottom: .75rem;
    border-bottom: 1px solid var(--cms-card-border);
}
.cms-group-icon {
    width: 32px; height: 32px;
    border-radius: 10px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    background: rgba(0,102,204,.1);
}
.cms-group-icon[data-color="green"]  { background: rgba(16,185,129,.1); }
.cms-group-icon[data-color="orange"] { background: rgba(245,158,11,.1); }
.cms-group-icon[data-color="cyan"]   { background: rgba(6,182,212,.1); }
.cms-group-icon[data-color="gray"]   { background: rgba(107,114,128,.1); }
.cms-group-title {
    font-size: 1.0625rem; font-weight: 600;
    margin: 0; color: var(--cms-text);
    letter-spacing: -.01em;
}
.cms-group-count {
    background: var(--cms-card-bg);
    border: 1px solid var(--cms-card-border);
    color: var(--cms-text-mute);
    padding: .15rem .55rem; border-radius: 100px;
    font-size: .75rem; font-weight: 600;
}
.cms-group-hint {
    margin-left: auto;
    font-size: .75rem;
    color: var(--cms-text-mute);
    font-style: italic;
}
.cms-card--dynamic { border-style: dashed; }
.cms-card--dynamic:hover { border-style: solid; }

/* Grid */
.cms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: .875rem;
}

/* Card */
.cms-card {
    position: relative;
    display: flex; flex-direction: column;
    background: var(--cms-card-bg);
    border: 1px solid var(--cms-card-border);
    border-radius: 14px;
    overflow: hidden;
    text-decoration: none; color: inherit;
    transition: all .25s cubic-bezier(.2,.7,.2,1);
}
.cms-card:hover {
    transform: translateY(-3px);
    border-color: var(--cms-accent);
    box-shadow: 0 12px 30px rgba(0,0,0,.08);
    color: inherit;
}
.cms-card-thumb {
    height: 100px;
    background-size: cover;
    background-position: center;
    background-color: var(--cms-card-border);
    border-bottom: 1px solid var(--cms-card-border);
}
.cms-card-body {
    padding: 1rem 1.125rem;
    flex: 1;
    display: flex; flex-direction: column;
}
.cms-card-head {
    display: flex; align-items: center; justify-content: space-between;
    gap: .5rem; margin-bottom: .35rem;
}
.cms-card-title {
    font-size: .9375rem; font-weight: 600;
    color: var(--cms-text); margin: 0;
    letter-spacing: -.005em;
}
.cms-card-arrow {
    color: var(--cms-text-mute);
    transition: transform .2s, color .2s;
    flex-shrink: 0;
}
.cms-card:hover .cms-card-arrow {
    color: var(--cms-accent);
    transform: translateX(3px);
}
.cms-card-key {
    font-size: .6875rem;
    color: var(--cms-text-mute);
    font-family: 'JetBrains Mono', ui-monospace, monospace;
    letter-spacing: .02em;
    background: transparent;
    padding: 0;
    display: block;
    margin-bottom: .15rem;
}
.cms-card-route {
    font-size: .75rem;
    color: var(--cms-text-mute);
    margin-bottom: .85rem;
    font-family: 'JetBrains Mono', ui-monospace, monospace;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.cms-card-meta {
    display: flex; gap: .375rem;
    margin-top: auto;
    flex-wrap: wrap;
}
.cms-dot {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .25rem .55rem;
    border-radius: 6px;
    background: rgba(107,114,128,.08);
    color: var(--cms-text-mute);
    font-size: .6875rem; font-weight: 500;
    line-height: 1;
}
.cms-dot i { font-size: .75rem; }
.cms-dot-on {
    background: rgba(16,185,129,.12);
    color: #059669;
}
.cms-dot-warn {
    background: rgba(245,158,11,.12);
    color: #d97706;
}

.cms-card-preview {
    position: absolute; top: .65rem; right: .65rem;
    width: 28px; height: 28px;
    border-radius: 8px;
    background: rgba(0,0,0,.6);
    color: #fff; border: 0;
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; opacity: 0;
    transition: opacity .2s, background .2s;
    backdrop-filter: blur(10px);
}
.cms-card:hover .cms-card-preview { opacity: 1; }
.cms-card-preview:hover { background: var(--cms-accent); }
.cms-card-actions {
    position: absolute; top: .65rem; right: .65rem;
    display: flex; gap: .375rem;
    opacity: 0; transition: opacity .2s;
}
.cms-card:hover .cms-card-actions { opacity: 1; }
.cms-card-action {
    width: 28px; height: 28px; border-radius: 8px;
    background: rgba(0,0,0,.7); color: #fff; border: 0;
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .2s;
    backdrop-filter: blur(10px);
}
.cms-card-action:hover { background: var(--cms-accent); }

/* Empty */
.cms-empty {
    text-align: center; padding: 4rem 2rem;
    color: var(--cms-text-mute);
}
.cms-empty p { margin: 1rem 0 0; font-size: .9375rem; }

/* List view */
.cms-board[data-view="list"] .cms-grid {
    grid-template-columns: 1fr;
    gap: .375rem;
}
.cms-board[data-view="list"] .cms-card {
    flex-direction: row;
    align-items: center;
    border-radius: 10px;
}
.cms-board[data-view="list"] .cms-card-thumb {
    width: 80px; height: 60px;
    border-bottom: 0; border-right: 1px solid var(--cms-card-border);
    flex-shrink: 0;
}
.cms-board[data-view="list"] .cms-card-body {
    flex-direction: row;
    align-items: center;
    gap: 1.5rem;
    padding: .75rem 1.125rem;
    width: 100%;
}
.cms-board[data-view="list"] .cms-card-head {
    flex: 1; margin: 0;
}
.cms-board[data-view="list"] .cms-card-key,
.cms-board[data-view="list"] .cms-card-route {
    margin: 0;
    flex-shrink: 0;
}
.cms-board[data-view="list"] .cms-card-meta {
    margin: 0;
    flex-shrink: 0;
}

/* Mobile */
@media (max-width: 768px) {
    .cms-stats { grid-template-columns: repeat(2, 1fr); }
    .cms-toolbar { flex-direction: column; align-items: stretch; }
    .cms-search { max-width: 100%; }
    .cms-view-toggle { align-self: flex-start; }
    .cms-grid { grid-template-columns: 1fr 1fr; }
    .cms-board[data-view="list"] .cms-card-body { flex-wrap: wrap; gap: .5rem; }
    .cms-board[data-view="list"] .cms-card-route { display: none; }
}
@media (max-width: 480px) {
    .cms-grid { grid-template-columns: 1fr; }
}
</style>

<script>
(function() {
    // Search filter
    const search = document.getElementById('cmsSearch');
    const cards  = document.querySelectorAll('.cms-card');
    const groups = document.querySelectorAll('.cms-group');
    const empty  = document.getElementById('cmsEmpty');

    function applyFilter(q) {
        q = q.toLowerCase().trim();
        let visibleTotal = 0;
        groups.forEach(g => {
            let groupVisible = 0;
            g.querySelectorAll('.cms-card').forEach(card => {
                const term = card.dataset.search || '';
                const show = !q || term.indexOf(q) !== -1;
                card.style.display = show ? '' : 'none';
                if (show) { groupVisible++; visibleTotal++; }
            });
            g.style.display = groupVisible > 0 ? '' : 'none';
        });
        empty.style.display = visibleTotal === 0 ? '' : 'none';
    }
    if (search) {
        search.addEventListener('input', e => applyFilter(e.target.value));
    }

    // View toggle
    const board = document.querySelector('.cms-board');
    const buttons = document.querySelectorAll('.cms-view-btn');
    const savedView = localStorage.getItem('cms_view') || 'grid';
    if (board && savedView) {
        board.setAttribute('data-view', savedView);
        buttons.forEach(b => b.classList.toggle('active', b.dataset.view === savedView));
    }
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const v = btn.dataset.view;
            board.setAttribute('data-view', v);
            buttons.forEach(b => b.classList.toggle('active', b === btn));
            localStorage.setItem('cms_view', v);
        });
    });
})();
</script>
