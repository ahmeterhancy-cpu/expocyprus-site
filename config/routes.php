<?php
declare(strict_types=1);

use App\Controllers\{HomeController, PublicController, MemberAuthController, MemberPortalController, SeoController};
use App\Controllers\Admin\{
    AuthController, DashboardController, ServicesController,
    FairsController, BlogController, CatalogController, CatalogCategoriesController,
    HotelsController as HotelsAdminController,
    OrdersController,
    SubmissionsController, MediaController, SettingsController,
    LeadsController, CrewController,
    MembersController, ProductionOrdersController,
    CmsPagesController, CmsBuilderController
};
use App\Middleware\{AuthMiddleware, MemberAuthMiddleware};

$r = app()->router;

// ─── PUBLIC ROUTES ───────────────────────────────────────────────────────────

// Anasayfa TR + EN
$r->get('/',     [HomeController::class, 'index']);
$r->get('/en',   [HomeController::class, 'index']);
$r->get('/en/',  [HomeController::class, 'index']);

// Hakkımızda
$r->get('/hakkimizda',     [PublicController::class, 'about']);
$r->get('/en/hakkimizda',  [PublicController::class, 'about']);
$r->get('/en/about',       [PublicController::class, 'about']);

// Hizmetler
$r->get('/hizmetler',              [PublicController::class, 'services']);
$r->get('/en/hizmetler',           [PublicController::class, 'services']);
$r->get('/en/services',            [PublicController::class, 'services']);
$r->get('/hizmetler/:slug',        [PublicController::class, 'serviceDetail']);
$r->get('/en/hizmetler/:slug',     [PublicController::class, 'serviceDetail']);
$r->get('/en/services/:slug',      [PublicController::class, 'serviceDetail']);

// Fuarlarımız
$r->get('/fuarlarimiz',            [PublicController::class, 'fairs']);
$r->get('/en/fuarlarimiz',         [PublicController::class, 'fairs']);
$r->get('/en/fairs',               [PublicController::class, 'fairs']);
$r->get('/fuarlarimiz/:slug',      [PublicController::class, 'fairDetail']);
$r->get('/en/fuarlarimiz/:slug',   [PublicController::class, 'fairDetail']);
$r->get('/en/fairs/:slug',         [PublicController::class, 'fairDetail']);

// Stand Kataloğu
$r->get('/stand-katalogu',         [PublicController::class, 'catalog']);
$r->get('/en/stand-katalogu',      [PublicController::class, 'catalog']);
$r->get('/en/stand-catalog',       [PublicController::class, 'catalog']);

// Oteller
$r->get('/oteller',                [PublicController::class, 'hotels']);
$r->get('/en/oteller',             [PublicController::class, 'hotels']);
$r->get('/en/hotels',              [PublicController::class, 'hotels']);
$r->get('/oteller/:slug',          [PublicController::class, 'hotelDetail']);
$r->get('/en/oteller/:slug',       [PublicController::class, 'hotelDetail']);
$r->get('/en/hotels/:slug',        [PublicController::class, 'hotelDetail']);

// Kurumsal alt sayfaları
$r->get('/tarihce',                [PublicController::class, 'history']);
$r->get('/en/tarihce',             [PublicController::class, 'history']);
$r->get('/en/history',             [PublicController::class, 'history']);
$r->get('/ekip',                   [PublicController::class, 'team']);
$r->get('/en/ekip',                [PublicController::class, 'team']);
$r->get('/en/team',                [PublicController::class, 'team']);
$r->get('/misyon-vizyon',          [PublicController::class, 'mission']);
$r->get('/en/misyon-vizyon',       [PublicController::class, 'mission']);
$r->get('/en/mission-vision',      [PublicController::class, 'mission']);

// Referanslar & SSS
$r->get('/referanslar',            [PublicController::class, 'references']);
$r->get('/en/referanslar',         [PublicController::class, 'references']);
$r->get('/en/references',          [PublicController::class, 'references']);
$r->get('/sss',                    [PublicController::class, 'faq']);
$r->get('/en/sss',                 [PublicController::class, 'faq']);
$r->get('/en/faq',                 [PublicController::class, 'faq']);

// Yasal sayfalar
$r->get('/kvkk',                       [PublicController::class, 'kvkk']);
$r->get('/en/kvkk',                    [PublicController::class, 'kvkk']);
$r->get('/gizlilik-politikasi',        [PublicController::class, 'privacy']);
$r->get('/en/gizlilik-politikasi',     [PublicController::class, 'privacy']);
$r->get('/en/privacy-policy',          [PublicController::class, 'privacy']);
$r->get('/cerez-politikasi',           [PublicController::class, 'cookies']);
$r->get('/en/cerez-politikasi',        [PublicController::class, 'cookies']);
$r->get('/en/cookie-policy',           [PublicController::class, 'cookies']);
$r->get('/kullanim-kosullari',         [PublicController::class, 'terms']);
$r->get('/en/kullanim-kosullari',      [PublicController::class, 'terms']);
$r->get('/en/terms-of-use',            [PublicController::class, 'terms']);

// Blog
$r->get('/blog',                   [PublicController::class, 'blog']);
$r->get('/en/blog',                [PublicController::class, 'blog']);
$r->get('/blog/:slug',             [PublicController::class, 'blogDetail']);
$r->get('/en/blog/:slug',          [PublicController::class, 'blogDetail']);

// İletişim
$r->get('/iletisim',               [PublicController::class, 'contact']);
$r->post('/iletisim',              [PublicController::class, 'contactPost']);
$r->get('/en/iletisim',            [PublicController::class, 'contact']);
$r->post('/en/iletisim',           [PublicController::class, 'contactPost']);
$r->get('/en/contact',             [PublicController::class, 'contact']);
$r->post('/en/contact',            [PublicController::class, 'contactPost']);

// Teklif Al
$r->get('/teklif-al',              [PublicController::class, 'quote']);
$r->post('/teklif-al',             [PublicController::class, 'quotePost']);
$r->get('/en/teklif-al',           [PublicController::class, 'quote']);
$r->post('/en/teklif-al',          [PublicController::class, 'quotePost']);
$r->get('/en/get-quote',           [PublicController::class, 'quote']);
$r->post('/en/get-quote',          [PublicController::class, 'quotePost']);

// Sepet & Sipariş
$r->get('/sepet',                  [PublicController::class, 'cart']);
$r->get('/en/sepet',               [PublicController::class, 'cart']);
$r->get('/en/cart',                [PublicController::class, 'cart']);
$r->post('/sepete-ekle',           [PublicController::class, 'cartAdd']);
$r->post('/sepet/guncelle',        [PublicController::class, 'cartUpdate']);
$r->post('/sepet/sil',             [PublicController::class, 'cartRemove']);
$r->post('/sepet/temizle',         [PublicController::class, 'cartClear']);

$r->get('/odeme',                  [PublicController::class, 'checkout']);
$r->get('/en/odeme',               [PublicController::class, 'checkout']);
$r->get('/en/checkout',            [PublicController::class, 'checkout']);
$r->post('/odeme/tamamla',         [PublicController::class, 'checkoutPost']);
$r->get('/siparis/:order_no',      [PublicController::class, 'orderSuccess']);
$r->get('/en/siparis/:order_no',   [PublicController::class, 'orderSuccess']);

// Fiyatsız Talep
$r->get('/talep-formu',            [PublicController::class, 'inquiry']);
$r->post('/talep-formu',           [PublicController::class, 'inquiryPost']);
$r->get('/en/talep-formu',         [PublicController::class, 'inquiry']);
$r->get('/en/inquiry',             [PublicController::class, 'inquiry']);
$r->post('/en/inquiry',            [PublicController::class, 'inquiryPost']);

// Malzeme Talebi (sadece mobilya / ekipman)
$r->get('/malzeme-talebi',         [PublicController::class, 'materialRequest']);
$r->post('/malzeme-talebi',        [PublicController::class, 'materialRequestPost']);
$r->get('/en/material-request',    [PublicController::class, 'materialRequest']);
$r->post('/en/material-request',   [PublicController::class, 'materialRequestPost']);

// SEO — robots.txt + sitemap.xml
$r->get('/robots.txt',             [SeoController::class, 'robots']);
$r->get('/sitemap.xml',            [SeoController::class, 'sitemap']);

// Unifex Crew (Hostes / Saha kadrosu başvuru formu)
$r->get('/unifex-crew',            [PublicController::class, 'crewForm']);
$r->post('/unifex-crew',           [PublicController::class, 'crewSubmit']);
$r->get('/en/unifex-crew',         [PublicController::class, 'crewForm']);
$r->post('/en/unifex-crew',        [PublicController::class, 'crewSubmit']);

// ─── ÜYE / FİRMA PORTAL ──────────────────────────────────────────────────────
$r->get('/uye/giris',              [MemberAuthController::class, 'loginForm']);
$r->post('/uye/giris',             [MemberAuthController::class, 'login']);
$r->get('/uye/kayit',              [MemberAuthController::class, 'registerForm']);
$r->post('/uye/kayit',             [MemberAuthController::class, 'register']);
$r->get('/uye/cikis',              [MemberAuthController::class, 'logout']);

// Üye paneli (login gerektirir)
$r->group('/uye', [MemberAuthMiddleware::class], function ($r) {
    $r->get('/panel',              [MemberPortalController::class, 'dashboard']);
    $r->get('/siparisler',         [MemberPortalController::class, 'orders']);
    $r->get('/siparis/:id',        [MemberPortalController::class, 'orderDetail']);
    $r->post('/siparis/:id/mesaj', [MemberPortalController::class, 'sendMessage']);
    $r->get('/profil',             [MemberPortalController::class, 'profile']);
    $r->post('/profil',            [MemberPortalController::class, 'profileUpdate']);
});

// ─── ADMIN AUTH ──────────────────────────────────────────────────────────────

$r->get('/admin/login',  [AuthController::class, 'loginForm']);
$r->post('/admin/login', [AuthController::class, 'login']);
$r->get('/admin/logout', [AuthController::class, 'logout']);

// ─── ADMIN PROTECTED ─────────────────────────────────────────────────────────

$r->group('/admin', [AuthMiddleware::class], function($r) {
    // Dashboard
    $r->get('',        [DashboardController::class, 'index']);
    $r->get('/',       [DashboardController::class, 'index']);

    // Services
    $r->get('/services',               [ServicesController::class, 'index']);
    $r->get('/services/create',        [ServicesController::class, 'create']);
    $r->post('/services/store',        [ServicesController::class, 'store']);
    $r->get('/services/:id/edit',      [ServicesController::class, 'edit']);
    $r->post('/services/:id/update',   [ServicesController::class, 'update']);
    $r->post('/services/:id/delete',   [ServicesController::class, 'destroy']);

    // Fairs
    $r->get('/fairs',                  [FairsController::class, 'index']);
    $r->get('/fairs/create',           [FairsController::class, 'create']);
    $r->post('/fairs/store',           [FairsController::class, 'store']);
    $r->get('/fairs/:id/edit',         [FairsController::class, 'edit']);
    $r->post('/fairs/:id/update',      [FairsController::class, 'update']);
    $r->post('/fairs/:id/delete',      [FairsController::class, 'destroy']);

    // Hotels
    $r->get('/hotels',                 [HotelsAdminController::class, 'index']);
    $r->get('/hotels/create',          [HotelsAdminController::class, 'create']);
    $r->post('/hotels/store',          [HotelsAdminController::class, 'store']);
    $r->get('/hotels/:id/edit',        [HotelsAdminController::class, 'edit']);
    $r->post('/hotels/:id/update',     [HotelsAdminController::class, 'update']);
    $r->post('/hotels/:id/delete',     [HotelsAdminController::class, 'destroy']);

    // Blog
    $r->get('/blog',                   [BlogController::class, 'index']);
    $r->get('/blog/create',            [BlogController::class, 'create']);
    $r->post('/blog/store',            [BlogController::class, 'store']);
    $r->get('/blog/:id/edit',          [BlogController::class, 'edit']);
    $r->post('/blog/:id/update',       [BlogController::class, 'update']);
    $r->post('/blog/:id/delete',       [BlogController::class, 'destroy']);

    // Catalog
    $r->get('/catalog',                [CatalogController::class, 'index']);
    $r->get('/catalog/create',         [CatalogController::class, 'create']);
    $r->post('/catalog/store',         [CatalogController::class, 'store']);
    $r->get('/catalog/:id/edit',       [CatalogController::class, 'edit']);
    $r->post('/catalog/:id/update',    [CatalogController::class, 'update']);
    $r->post('/catalog/:id/delete',    [CatalogController::class, 'destroy']);

    // Catalog Categories (kategorileri yönet)
    $r->get('/catalog/categories',                  [CatalogCategoriesController::class, 'index']);
    $r->get('/catalog/categories/create',           [CatalogCategoriesController::class, 'create']);
    $r->post('/catalog/categories/store',           [CatalogCategoriesController::class, 'store']);
    $r->get('/catalog/categories/:id/edit',         [CatalogCategoriesController::class, 'edit']);
    $r->post('/catalog/categories/:id/update',      [CatalogCategoriesController::class, 'update']);
    $r->post('/catalog/categories/:id/delete',      [CatalogCategoriesController::class, 'destroy']);

    // Orders
    $r->get('/orders',                 [OrdersController::class, 'index']);
    $r->get('/orders/:id',             [OrdersController::class, 'view']);
    $r->post('/orders/:id/status',     [OrdersController::class, 'updateStatus']);
    $r->post('/orders/:id/delete',     [OrdersController::class, 'destroy']);

    // Submissions
    $r->get('/submissions',            [SubmissionsController::class, 'index']);
    $r->get('/submissions/:id',        [SubmissionsController::class, 'view']);
    $r->post('/submissions/:id/delete',[SubmissionsController::class, 'destroy']);
    $r->get('/submissions/export',     [SubmissionsController::class, 'export']);
    $r->post('/submissions/:id/to-lead',[LeadsController::class, 'convertFromSubmission']);

    // Leads (CRM)
    $r->get('/leads',                  [LeadsController::class, 'index']);
    $r->get('/leads/pipeline',         [LeadsController::class, 'pipeline']);
    $r->get('/leads/create',           [LeadsController::class, 'create']);
    $r->post('/leads/store',           [LeadsController::class, 'store']);
    $r->get('/leads/:id',              [LeadsController::class, 'show']);
    $r->get('/leads/:id/edit',         [LeadsController::class, 'edit']);
    $r->post('/leads/:id/update',      [LeadsController::class, 'update']);
    $r->post('/leads/:id/delete',      [LeadsController::class, 'destroy']);
    $r->post('/leads/:id/note',        [LeadsController::class, 'addNote']);
    $r->post('/leads/:id/status',      [LeadsController::class, 'changeStatus']);
    $r->post('/leads/:id/upload',      [LeadsController::class, 'uploadFile']);
    $r->post('/leads/:id/file/:file_id/delete', [LeadsController::class, 'deleteFile']);

    // Unifex Crew (başvuru kayıtları)
    $r->get('/crew',                   [CrewController::class, 'index']);
    $r->get('/crew/:id',               [CrewController::class, 'view']);
    $r->post('/crew/:id/status',       [CrewController::class, 'updateStatus']);
    $r->post('/crew/:id/note',         [CrewController::class, 'addNote']);
    $r->post('/crew/:id/delete',       [CrewController::class, 'destroy']);
    $r->get('/crew/export',            [CrewController::class, 'export']);

    // Members (Firma Üyeleri)
    $r->get('/members',                [MembersController::class, 'index']);
    $r->get('/members/create',         [MembersController::class, 'create']);
    $r->post('/members/store',         [MembersController::class, 'store']);
    $r->get('/members/:id',            [MembersController::class, 'show']);
    $r->get('/members/:id/edit',       [MembersController::class, 'edit']);
    $r->post('/members/:id/update',    [MembersController::class, 'update']);
    $r->post('/members/:id/approve',   [MembersController::class, 'approve']);
    $r->post('/members/:id/delete',    [MembersController::class, 'destroy']);

    // Production Orders (Üretim Siparişleri)
    $r->get('/production-orders',                    [ProductionOrdersController::class, 'index']);
    $r->get('/production-orders/pipeline',           [ProductionOrdersController::class, 'pipeline']);
    $r->get('/production-orders/create',             [ProductionOrdersController::class, 'create']);
    $r->post('/production-orders/store',             [ProductionOrdersController::class, 'store']);
    $r->get('/production-orders/:id',                [ProductionOrdersController::class, 'show']);
    $r->get('/production-orders/:id/edit',           [ProductionOrdersController::class, 'edit']);
    $r->post('/production-orders/:id/update',        [ProductionOrdersController::class, 'update']);
    $r->post('/production-orders/:id/stage',         [ProductionOrdersController::class, 'changeStage']);
    $r->post('/production-orders/:id/upload',        [ProductionOrdersController::class, 'uploadFile']);
    $r->post('/production-orders/:id/file/:file_id/delete', [ProductionOrdersController::class, 'deleteFile']);
    $r->post('/production-orders/:id/message',       [ProductionOrdersController::class, 'sendMessage']);
    $r->post('/production-orders/:id/item/add',      [ProductionOrdersController::class, 'addItem']);
    $r->post('/production-orders/:id/item/:item_id/toggle', [ProductionOrdersController::class, 'toggleItem']);
    $r->post('/production-orders/:id/item/:item_id/delete', [ProductionOrdersController::class, 'deleteItem']);
    $r->post('/production-orders/:id/delete',        [ProductionOrdersController::class, 'destroy']);

    // Media
    $r->get('/media',                  [MediaController::class, 'index']);
    $r->post('/media/upload',          [MediaController::class, 'upload']);
    $r->post('/media/:id/delete',      [MediaController::class, 'destroy']);

    // CMS — Sayfa Düzenleyici
    $r->get('/cms',                    [CmsPagesController::class, 'index']);
    $r->get('/cms/settings',           [CmsPagesController::class, 'settings']);
    $r->post('/cms/settings',          [CmsPagesController::class, 'settingsSave']);
    $r->get('/cms/:key/builder',       [CmsBuilderController::class, 'builder']);
    $r->post('/cms/:key/builder/save', [CmsBuilderController::class, 'save']);
    $r->post('/cms/builder/preview',   [CmsBuilderController::class, 'previewBlock']);
    $r->get('/cms/:key',               [CmsPagesController::class, 'edit']);
    $r->post('/cms/:key/update',       [CmsPagesController::class, 'update']);

    // PHPageBuilder — Sayfa Yöneticisi (custom Tabler UI)
    $r->get('/pagebuilder',                  [\App\Controllers\Admin\PageBuilderController::class, 'index']);
    $r->get('/pagebuilder/new',              [\App\Controllers\Admin\PageBuilderController::class, 'createForm']);
    $r->post('/pagebuilder/new',             [\App\Controllers\Admin\PageBuilderController::class, 'create']);
    $r->get('/pagebuilder/:id/settings',     [\App\Controllers\Admin\PageBuilderController::class, 'editForm']);
    $r->post('/pagebuilder/:id/settings',    [\App\Controllers\Admin\PageBuilderController::class, 'updateMeta']);
    $r->post('/pagebuilder/:id/delete',      [\App\Controllers\Admin\PageBuilderController::class, 'destroy']);

    // Settings
    $r->get('/settings',               [SettingsController::class, 'index']);
    $r->post('/settings',              [SettingsController::class, 'save']);
    $r->get('/settings/users',         [SettingsController::class, 'users']);
    $r->post('/settings/users/create', [SettingsController::class, 'createUser']);
    $r->post('/settings/users/:id/delete', [SettingsController::class, 'deleteUser']);
});
