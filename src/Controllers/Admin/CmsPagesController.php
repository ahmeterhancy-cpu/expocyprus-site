<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\{CmsPage, MediaFile};

class CmsPagesController
{
    public function index(Request $req, array $params = []): void
    {
        $pages = CmsPage::allOrdered();

        // Dinamik alt sayfalar — DB'deki services + fairs + catalog modelleri + blog
        $services = [];
        $fairs    = [];
        $blogPosts = [];
        try {
            $services = \App\Core\DB::query("SELECT id, slug, title_tr, title_en, image, status, updated_at FROM services ORDER BY sort_order ASC, id ASC");
        } catch (\Throwable $e) {}
        try {
            $fairs = \App\Core\DB::query("SELECT id, slug, name_tr, name_en, image_hero AS image, status, updated_at FROM fairs ORDER BY sort_order ASC, id ASC");
        } catch (\Throwable $e) {}
        try {
            $blogPosts = \App\Core\DB::query("SELECT id, slug, title, image, status, updated_at, lang FROM blog_posts ORDER BY published_at DESC LIMIT 50");
        } catch (\Throwable $e) {}

        View::render('admin/cms/index', compact('pages', 'services', 'fairs', 'blogPosts'), 'admin');
    }

    public function edit(Request $req, array $params = []): void
    {
        CmsPage::ensureTable();
        $key = $params['key'] ?? '';
        $page = CmsPage::findByKey($key);
        if (!$page) {
            Session::flash('error', 'Sayfa bulunamadı.');
            View::redirect('/admin/cms');
        }
        View::render('admin/cms/edit', compact('page'), 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        $key = $params['key'] ?? '';
        $page = CmsPage::findByKey($key);
        if (!$page) {
            Session::flash('error', 'Sayfa bulunamadı.');
            View::redirect('/admin/cms');
        }

        // Handle hero image upload
        $heroImage = trim((string)$req->post('hero_image_current', $page['hero_image'] ?? ''));
        $heroFile = $req->file('hero_image_file');
        if ($heroFile && ($heroFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK && !empty($heroFile['name'])) {
            $result = MediaFile::upload($heroFile, 'cms');
            if ($result) $heroImage = $result['url'];
        }

        $ogImage = trim((string)$req->post('og_image_current', $page['og_image'] ?? ''));
        $ogFile = $req->file('og_image_file');
        if ($ogFile && ($ogFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK && !empty($ogFile['name'])) {
            $result = MediaFile::upload($ogFile, 'cms');
            if ($result) $ogImage = $result['url'];
        }

        // Sections JSON: kabul ederiz raw textarea olarak (admin advanced)
        $sectionsRaw = (string)$req->post('sections_json', '');
        $sectionsJson = null;
        if ($sectionsRaw !== '') {
            $decoded = json_decode($sectionsRaw, true);
            if (is_array($decoded)) $sectionsJson = json_encode($decoded, JSON_UNESCAPED_UNICODE);
            else $sectionsJson = $sectionsRaw; // korur, hata vermez
        }

        $data = [
            'title_tr'             => trim((string)$req->post('title_tr', '')),
            'title_en'             => trim((string)$req->post('title_en', '')) ?: null,
            'hero_eyebrow_tr'      => trim((string)$req->post('hero_eyebrow_tr', '')) ?: null,
            'hero_eyebrow_en'      => trim((string)$req->post('hero_eyebrow_en', '')) ?: null,
            'hero_title_tr'        => trim((string)$req->post('hero_title_tr', '')) ?: null,
            'hero_title_en'        => trim((string)$req->post('hero_title_en', '')) ?: null,
            'hero_subtitle_tr'     => trim((string)$req->post('hero_subtitle_tr', '')) ?: null,
            'hero_subtitle_en'     => trim((string)$req->post('hero_subtitle_en', '')) ?: null,
            'hero_image'           => $heroImage ?: null,
            'body_tr'              => $req->post('body_tr', '') ?: null,
            'body_en'              => $req->post('body_en', '') ?: null,
            'sections_json'        => $sectionsJson,
            'meta_title_tr'        => trim((string)$req->post('meta_title_tr', '')) ?: null,
            'meta_title_en'        => trim((string)$req->post('meta_title_en', '')) ?: null,
            'meta_description_tr'  => trim((string)$req->post('meta_description_tr', '')) ?: null,
            'meta_description_en'  => trim((string)$req->post('meta_description_en', '')) ?: null,
            'meta_keywords_tr'     => trim((string)$req->post('meta_keywords_tr', '')) ?: null,
            'meta_keywords_en'     => trim((string)$req->post('meta_keywords_en', '')) ?: null,
            'og_image'             => $ogImage ?: null,
            'noindex'              => (int)(bool)$req->post('noindex', 0),
            'status'               => $req->post('status', 'published'),
            'updated_by'           => $_SESSION['admin_id'] ?? null,
        ];

        CmsPage::update((int)$page['id'], $data);
        Session::flash('success', 'Sayfa içeriği güncellendi.');
        View::redirect('/admin/cms/' . $key);
    }

    /* ─── SITE SETTINGS (header, footer, contact, social) ─── */

    public function settings(Request $req, array $params = []): void
    {
        $settings = CmsPage::allSettings();
        View::render('admin/cms/settings', compact('settings'), 'admin');
    }

    public function settingsSave(Request $req, array $params = []): void
    {
        // Handle logo upload
        $logoFile = $req->file('site_logo_file');
        if ($logoFile && ($logoFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK && !empty($logoFile['name'])) {
            $r = MediaFile::upload($logoFile, 'cms');
            if ($r) CmsPage::setSetting('site_logo', $r['url'], 'general');
        }

        $favFile = $req->file('site_favicon_file');
        if ($favFile && ($favFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK && !empty($favFile['name'])) {
            $r = MediaFile::upload($favFile, 'cms');
            if ($r) CmsPage::setSetting('site_favicon', $r['url'], 'general');
        }

        $allowedKeys = [
            // General
            'site_name', 'site_tagline_tr', 'site_tagline_en',
            'company_address', 'company_phone', 'company_phone2', 'company_email', 'company_hours',
            // Social
            'social_instagram', 'social_facebook', 'social_linkedin', 'social_twitter', 'social_youtube', 'social_whatsapp',
            // Footer
            'footer_about_tr', 'footer_about_en', 'footer_copyright',
            // Header CTA
            'header_cta_text_tr', 'header_cta_text_en', 'header_cta_url',
            // SEO
            'seo_default_keywords', 'seo_google_verification', 'seo_bing_verification',
            'seo_ga_id', 'seo_gtm_id', 'seo_facebook_pixel',
        ];

        foreach ($allowedKeys as $k) {
            $v = $req->post($k, '');
            $v = is_string($v) ? trim($v) : '';
            CmsPage::setSetting($k, $v, str_starts_with($k, 'social_') ? 'social' : (str_starts_with($k, 'seo_') ? 'seo' : (str_starts_with($k, 'footer_') ? 'footer' : (str_starts_with($k, 'header_') ? 'header' : 'general'))));
        }

        Session::flash('success', 'Site ayarları güncellendi.');
        View::redirect('/admin/cms/settings');
    }
}
