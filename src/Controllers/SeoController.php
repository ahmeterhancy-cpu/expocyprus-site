<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Request, DB};

class SeoController
{
    public function robots(Request $req, array $params = []): void
    {
        header('Content-Type: text/plain; charset=utf-8');
        $base = rtrim(env('APP_URL', ''), '/');
        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /uye/\n";
        echo "Disallow: /api/\n";
        echo "Disallow: /sepet\n";
        echo "Disallow: /odeme\n";
        echo "Disallow: /siparis/\n";
        echo "Crawl-delay: 1\n\n";
        echo "Sitemap: $base/sitemap.xml\n";
        exit;
    }

    public function sitemap(Request $req, array $params = []): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        $base = rtrim(env('APP_URL', ''), '/');
        $today = date('Y-m-d');

        $urls = [];

        // Static pages — TR + EN
        $static = [
            ['/',                    1.0,  'daily'],
            ['/hakkimizda',          0.9,  'monthly'],
            ['/tarihce',             0.7,  'yearly'],
            ['/ekip',                0.7,  'monthly'],
            ['/misyon-vizyon',       0.7,  'yearly'],
            ['/hizmetler',           0.95, 'weekly'],
            ['/fuarlarimiz',         0.95, 'weekly'],
            ['/stand-katalogu',      0.95, 'weekly'],
            ['/oteller',             0.85, 'weekly'],
            ['/blog',                0.85, 'daily'],
            ['/referanslar',         0.7,  'monthly'],
            ['/iletisim',            0.85, 'monthly'],
            ['/teklif-al',           0.9,  'monthly'],
            ['/talep-formu',         0.75, 'monthly'],
            ['/malzeme-talebi',      0.75, 'monthly'],
            ['/unifex-crew',         0.7,  'monthly'],
            ['/sss',                 0.6,  'monthly'],
            ['/kvkk',                0.3,  'yearly'],
            ['/gizlilik-politikasi', 0.3,  'yearly'],
            ['/cerez-politikasi',    0.3,  'yearly'],
        ];
        foreach ($static as [$path, $prio, $freq]) {
            $urls[] = ['loc' => $base . $path, 'changefreq' => $freq, 'priority' => $prio, 'lastmod' => $today, 'tr_url' => $base . $path, 'en_url' => $base . '/en' . ($path === '/' ? '' : $path)];
        }

        // Dynamic — Services
        try {
            $services = DB::query("SELECT slug, updated_at FROM services WHERE status = 'active'");
            foreach ($services as $s) {
                $urls[] = [
                    'loc' => $base . '/hizmetler/' . $s['slug'],
                    'changefreq' => 'monthly', 'priority' => 0.8,
                    'lastmod' => date('Y-m-d', strtotime($s['updated_at'])),
                    'tr_url' => $base . '/hizmetler/' . $s['slug'],
                    'en_url' => $base . '/en/hizmetler/' . $s['slug'],
                ];
            }
        } catch (\Throwable $e) {}

        // Dynamic — Fairs
        try {
            $fairs = DB::query("SELECT slug, updated_at FROM fairs WHERE status = 'active'");
            foreach ($fairs as $f) {
                $urls[] = [
                    'loc' => $base . '/fuarlarimiz/' . $f['slug'],
                    'changefreq' => 'monthly', 'priority' => 0.8,
                    'lastmod' => date('Y-m-d', strtotime($f['updated_at'])),
                    'tr_url' => $base . '/fuarlarimiz/' . $f['slug'],
                    'en_url' => $base . '/en/fuarlarimiz/' . $f['slug'],
                ];
            }
        } catch (\Throwable $e) {}

        // Dynamic — Catalog
        try {
            $catalog = DB::query("SELECT model_no, slug, updated_at FROM catalog_items WHERE status = 'active'");
            foreach ($catalog as $c) {
                $slug = $c['slug'] ?? strtolower($c['model_no']);
                $urls[] = [
                    'loc' => $base . '/stand-katalogu/' . $slug,
                    'changefreq' => 'monthly', 'priority' => 0.7,
                    'lastmod' => date('Y-m-d', strtotime($c['updated_at'])),
                    'tr_url' => $base . '/stand-katalogu/' . $slug,
                    'en_url' => $base . '/en/stand-katalogu/' . $slug,
                ];
            }
        } catch (\Throwable $e) {}

        // Dynamic — Blog
        try {
            $posts = DB::query("SELECT slug, updated_at FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC");
            foreach ($posts as $p) {
                $urls[] = [
                    'loc' => $base . '/blog/' . $p['slug'],
                    'changefreq' => 'monthly', 'priority' => 0.6,
                    'lastmod' => date('Y-m-d', strtotime($p['updated_at'])),
                    'tr_url' => $base . '/blog/' . $p['slug'],
                    'en_url' => $base . '/en/blog/' . $p['slug'],
                ];
            }
        } catch (\Throwable $e) {}

        // Dynamic — Hotels
        try {
            $hotels = DB::query("SELECT slug, updated_at FROM hotels WHERE status = 'active'");
            foreach ($hotels as $h) {
                $urls[] = [
                    'loc' => $base . '/oteller/' . $h['slug'],
                    'changefreq' => 'monthly', 'priority' => 0.6,
                    'lastmod' => date('Y-m-d', strtotime($h['updated_at'])),
                    'tr_url' => $base . '/oteller/' . $h['slug'],
                    'en_url' => $base . '/en/oteller/' . $h['slug'],
                ];
            }
        } catch (\Throwable $e) {}

        // Output XML with hreflang
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
        foreach ($urls as $u) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            echo "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
            echo "    <changefreq>" . $u['changefreq'] . "</changefreq>\n";
            echo "    <priority>" . $u['priority'] . "</priority>\n";
            if (!empty($u['tr_url']) && !empty($u['en_url'])) {
                echo '    <xhtml:link rel="alternate" hreflang="tr" href="' . htmlspecialchars($u['tr_url']) . "\"/>\n";
                echo '    <xhtml:link rel="alternate" hreflang="en" href="' . htmlspecialchars($u['en_url']) . "\"/>\n";
                echo '    <xhtml:link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($u['tr_url']) . "\"/>\n";
            }
            echo "  </url>\n";
        }
        echo '</urlset>';
        exit;
    }
}
