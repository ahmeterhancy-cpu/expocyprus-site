<!DOCTYPE html>
<html lang="tr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($pageTitle ?? 'Yönetim Paneli') ?> — Expo Cyprus Admin</title>
    <link rel="icon" type="image/svg+xml" href="/assets/img/logo/unifex-mark-only.svg">

    <!-- Tabler CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <!-- Quill WYSIWYG Editor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
    <!-- Custom Admin Overrides -->
    <style>
        :root {
            --unifex-red:   #E30613;
            --unifex-black: #0A0A0A;
        }
        .navbar-brand-image { height: 32px; }
        .sidebar-brand      { padding: 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,.08); }
        .nav-link.active, .nav-link:hover { color: var(--unifex-red) !important; }
        .btn-primary  { background: var(--unifex-red); border-color: var(--unifex-red); }
        .btn-primary:hover { background: #c0050f; border-color: #c0050f; }
        .badge-red    { background: var(--unifex-red); }
        .card-stats .card-body { padding: 1.25rem; }
        .stat-icon    { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .stat-icon.red { background: rgba(227,6,19,.15); color: var(--unifex-red); }
        .stat-icon.blue{ background: rgba(59,130,246,.15); color: #3b82f6; }
        .stat-icon.green{background: rgba(34,197,94,.15);  color: #22c55e; }
        .stat-icon.orange{background:rgba(249,115,22,.15); color: #f97316; }
        .toast-wrap   { position: fixed; top: 1rem; right: 1rem; z-index: 9999; }
        .admin-flash  { margin-bottom: 1rem; }
        /* Quill editor dark theme tweaks */
        .quill-wrap { background: var(--tblr-card-bg, #1a2230); border-radius: 8px; overflow: hidden; }
        .quill-wrap .ql-toolbar { background: rgba(255,255,255,.03); border: 0; border-bottom: 1px solid rgba(255,255,255,.08); }
        .quill-wrap .ql-container { border: 0; min-height: 240px; font-size: .9375rem; }
        .quill-wrap .ql-editor { min-height: 240px; color: #e6edf3; }
        .quill-wrap .ql-editor.ql-blank::before { color: rgba(255,255,255,.35); font-style: normal; }
        .quill-wrap .ql-toolbar .ql-stroke { stroke: rgba(255,255,255,.7); }
        .quill-wrap .ql-toolbar .ql-fill { fill: rgba(255,255,255,.7); }
        .quill-wrap .ql-toolbar .ql-picker-label { color: rgba(255,255,255,.7); }
        .quill-wrap .ql-toolbar button:hover .ql-stroke,
        .quill-wrap .ql-toolbar button.ql-active .ql-stroke { stroke: var(--unifex-red); }
        .quill-wrap .ql-toolbar button:hover .ql-fill,
        .quill-wrap .ql-toolbar button.ql-active .ql-fill { fill: var(--unifex-red); }
        .quill-wrap .ql-picker-options { background: #2c3849; color: #fff; }
        .quill-wrap .ql-snow a { color: var(--unifex-red); }
        textarea.quill-editor { display: none; }
    </style>
</head>
<body class="antialiased">
<div class="wrapper">

    <!-- ─── SIDEBAR ─────────────────────────────────── -->
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <!-- Brand -->
            <div class="sidebar-brand">
                <a href="/admin" class="navbar-brand">
                    <img src="/assets/img/logo/unifex-logo-beyaz.svg" alt="Expo Cyprus Admin" class="navbar-brand-image">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="navbar-nav pt-lg-3">

                    <!-- Genel -->
                    <li class="nav-item">
                        <span class="nav-link-title text-muted px-3 pb-1 small text-uppercase fw-bold" style="font-size:.7rem;letter-spacing:.08em">GENEL</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin') && !str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/') ? 'active' : '' ?>" href="/admin">
                            <span class="nav-link-icon"><i class="ti ti-dashboard"></i></span>
                            <span class="nav-link-title">Dashboard</span>
                        </a>
                    </li>

                    <!-- İçerik -->
                    <li class="nav-item mt-2">
                        <span class="nav-link-title text-muted px-3 pb-1 small text-uppercase fw-bold" style="font-size:.7rem;letter-spacing:.08em">İÇERİK</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/services') ? 'active' : '' ?>" href="/admin/services">
                            <span class="nav-link-icon"><i class="ti ti-tools"></i></span>
                            <span class="nav-link-title">Hizmetler</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/fairs') ? 'active' : '' ?>" href="/admin/fairs">
                            <span class="nav-link-icon"><i class="ti ti-calendar-event"></i></span>
                            <span class="nav-link-title">Fuarlar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/hotels') ? 'active' : '' ?>" href="/admin/hotels">
                            <span class="nav-link-icon"><i class="ti ti-building"></i></span>
                            <span class="nav-link-title">Oteller</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/catalog') && !str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/catalog/categories')) ? 'active' : '' ?>" href="/admin/catalog">
                            <span class="nav-link-icon"><i class="ti ti-layout-grid"></i></span>
                            <span class="nav-link-title">Stand Kataloğu</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/catalog/categories') ? 'active' : '' ?>" href="/admin/catalog/categories">
                            <span class="nav-link-icon"><i class="ti ti-tags"></i></span>
                            <span class="nav-link-title">Stand Kategorileri</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/blog') ? 'active' : '' ?>" href="/admin/blog">
                            <span class="nav-link-icon"><i class="ti ti-news"></i></span>
                            <span class="nav-link-title">Blog</span>
                        </a>
                    </li>

                    <!-- CMS -->
                    <li class="nav-item mt-2">
                        <span class="nav-link-title text-muted px-3 pb-1 small text-uppercase fw-bold" style="font-size:.7rem;letter-spacing:.08em">İÇERİK YÖNETİMİ</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/cms') && !str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/cms/settings')) ? 'active' : '' ?>" href="/admin/cms">
                            <span class="nav-link-icon"><i class="ti ti-edit-circle"></i></span>
                            <span class="nav-link-title">Sayfa Düzenleyici</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/cms/settings') ? 'active' : '' ?>" href="/admin/cms/settings">
                            <span class="nav-link-icon"><i class="ti ti-settings-cog"></i></span>
                            <span class="nav-link-title">Site Ayarları</span>
                        </a>
                    </li>

                    <!-- CRM -->
                    <li class="nav-item mt-2">
                        <span class="nav-link-title text-muted px-3 pb-1 small text-uppercase fw-bold" style="font-size:.7rem;letter-spacing:.08em">CRM</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/leads') ? 'active' : '' ?>" href="/admin/leads">
                            <span class="nav-link-icon"><i class="ti ti-target-arrow"></i></span>
                            <span class="nav-link-title">Leads</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/crew') ? 'active' : '' ?>" href="/admin/crew">
                            <span class="nav-link-icon"><i class="ti ti-users-group"></i></span>
                            <span class="nav-link-title">Unifex Crew</span>
                        </a>
                    </li>

                    <!-- Üyelik & Üretim -->
                    <li class="nav-item mt-2">
                        <span class="nav-link-title text-muted px-3 pb-1 small text-uppercase fw-bold" style="font-size:.7rem;letter-spacing:.08em">ÜYELİK & ÜRETİM</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/members') ? 'active' : '' ?>" href="/admin/members">
                            <span class="nav-link-icon"><i class="ti ti-building-store"></i></span>
                            <span class="nav-link-title">Firma Üyeleri</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/production-orders') ? 'active' : '' ?>" href="/admin/production-orders">
                            <span class="nav-link-icon"><i class="ti ti-package"></i></span>
                            <span class="nav-link-title">Üretim Siparişleri</span>
                        </a>
                    </li>

                    <!-- Formlar -->
                    <li class="nav-item mt-2">
                        <span class="nav-link-title text-muted px-3 pb-1 small text-uppercase fw-bold" style="font-size:.7rem;letter-spacing:.08em">FORMLAR</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/submissions') ? 'active' : '' ?>" href="/admin/submissions">
                            <span class="nav-link-icon"><i class="ti ti-mail"></i></span>
                            <span class="nav-link-title">Başvurular
                                <?php if (($unreadCount ?? 0) > 0): ?>
                                <span class="badge badge-sm badge-red ms-auto"><?= $unreadCount ?></span>
                                <?php endif; ?>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/orders') ? 'active' : '' ?>" href="/admin/orders">
                            <span class="nav-link-icon"><i class="ti ti-shopping-cart"></i></span>
                            <span class="nav-link-title">Siparişler</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (($_GET['type'] ?? '') === 'stand_inquiry') ? 'active' : '' ?>" href="/admin/submissions?type=stand_inquiry">
                            <span class="nav-link-icon"><i class="ti ti-tag"></i></span>
                            <span class="nav-link-title">Katalog Talepleri</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (($_GET['type'] ?? '') === 'material_request') ? 'active' : '' ?>" href="/admin/submissions?type=material_request">
                            <span class="nav-link-icon"><i class="ti ti-package"></i></span>
                            <span class="nav-link-title">Malzeme Talepleri</span>
                        </a>
                    </li>

                    <!-- Sistem -->
                    <li class="nav-item mt-2">
                        <span class="nav-link-title text-muted px-3 pb-1 small text-uppercase fw-bold" style="font-size:.7rem;letter-spacing:.08em">SİSTEM</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/media') ? 'active' : '' ?>" href="/admin/media">
                            <span class="nav-link-icon"><i class="ti ti-photo"></i></span>
                            <span class="nav-link-title">Medya Kütüphanesi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/settings') ? 'active' : '' ?>" href="/admin/settings">
                            <span class="nav-link-icon"><i class="ti ti-settings"></i></span>
                            <span class="nav-link-title">Site Ayarları</span>
                        </a>
                    </li>

                    <!-- Spacer -->
                    <li class="nav-item" style="margin-top:auto;padding-bottom:1rem">
                        <hr class="my-3">
                        <?php $adminUser = adminUser(); ?>
                        <div class="px-3 py-2 d-flex align-items-center gap-2 mb-2">
                            <div class="avatar avatar-sm" style="background:var(--unifex-red);color:#fff;display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:50%;font-weight:600;font-size:.8rem">
                                <?= strtoupper(substr($adminUser['name'] ?? 'A', 0, 1)) ?>
                            </div>
                            <div>
                                <div style="font-size:.85rem;font-weight:600;color:#fff"><?= e($adminUser['name'] ?? 'Admin') ?></div>
                                <div style="font-size:.75rem;color:#8b95a1"><?= e($adminUser['role'] ?? 'admin') ?></div>
                            </div>
                        </div>
                        <a class="nav-link text-danger" href="/admin/logout">
                            <span class="nav-link-icon"><i class="ti ti-logout"></i></span>
                            <span class="nav-link-title">Çıkış Yap</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- ─── MAIN CONTENT ────────────────────────────── -->
    <div class="page-wrapper">
        <!-- Top Bar -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle"><?= e($pretitle ?? 'Expo Cyprus Yönetim') ?></div>
                        <h2 class="page-title"><?= e($pageTitle ?? 'Dashboard') ?></h2>
                    </div>
                    <?php if ($headerActions ?? false): ?>
                    <div class="col-auto ms-auto d-print-none">
                        <?= $headerActions ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <div class="container-xl pt-3">
            <?php $flashSuccess = \App\Core\Session::getFlash('success'); $flashError = \App\Core\Session::getFlash('error'); ?>
            <?php if ($flashSuccess): ?>
            <div class="alert alert-success alert-dismissible admin-flash" role="alert">
                <i class="ti ti-check me-2"></i><?= e($flashSuccess) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            <?php if ($flashError): ?>
            <div class="alert alert-danger alert-dismissible admin-flash" role="alert">
                <i class="ti ti-alert-triangle me-2"></i><?= e($flashError) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
        </div>

        <!-- Page Content -->
        <div class="page-body">
            <div class="container-xl">
                <?= $content ?>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl text-center">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col">
                        <p class="text-muted mb-0">
                            © <?= date('Y') ?> Expo Cyprus Admin Panel — Unifex Fuarcılık Organizasyon Ltd.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Tabler JS + Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<!-- Quill WYSIWYG Editor -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
// Auto-initialize Quill on every <textarea class="quill-editor">
document.addEventListener('DOMContentLoaded', function () {
    const TOOLBAR = [
        [{ header: [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ color: [] }, { background: [] }],
        [{ list: 'ordered' }, { list: 'bullet' }],
        [{ align: [] }],
        ['blockquote', 'code-block'],
        ['link', 'image'],
        ['clean']
    ];

    const editors = [];
    document.querySelectorAll('textarea.quill-editor').forEach(function (textarea) {
        // Wrapper div
        const wrap = document.createElement('div');
        wrap.className = 'quill-wrap';
        const editorDiv = document.createElement('div');
        editorDiv.innerHTML = textarea.value;
        wrap.appendChild(editorDiv);
        textarea.parentNode.insertBefore(wrap, textarea);

        const quill = new Quill(editorDiv, {
            theme: 'snow',
            placeholder: textarea.getAttribute('placeholder') || 'İçerik yazın...',
            modules: { toolbar: TOOLBAR }
        });

        editors.push({ quill: quill, textarea: textarea });
    });

    // Sync HTML back to textareas on form submit
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            editors.forEach(function (pair) {
                if (form.contains(pair.textarea)) {
                    const html = pair.quill.root.innerHTML;
                    pair.textarea.value = (html === '<p><br></p>') ? '' : html;
                }
            });
        });
    });
});
</script>

<?php if ($extraScripts ?? false): echo $extraScripts; endif; ?>
</body>
</html>
