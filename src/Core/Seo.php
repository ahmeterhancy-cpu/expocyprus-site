<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Centralized SEO helper — title, meta, Open Graph, Twitter, JSON-LD, canonical.
 * Use $seo = Seo::for(...) in views, then echo $seo->meta(), $seo->jsonLd(), etc.
 */
class Seo
{
    private array $data = [
        'title'         => '',
        'description'   => '',
        'canonical'     => '',
        'image'         => '',
        'type'          => 'website',
        'locale'        => 'tr_TR',
        'site_name'     => 'Expo Cyprus',
        'twitter_card'  => 'summary_large_image',
        'twitter_site'  => '@expocyprus',
        'noindex'       => false,
        'breadcrumb'    => [],   // [['name' => 'Home', 'url' => '/'], ...]
        'structured'    => [],   // additional JSON-LD blobs
        'hreflang'      => [],   // ['tr' => '...', 'en' => '...']
        'keywords'      => [],
    ];

    public static function for(string $title, string $description = '', array $extras = []): self
    {
        $self = new self();
        $self->data['title']       = $title;
        $self->data['description'] = $description;
        $self->data['canonical']   = $extras['canonical'] ?? self::currentUrl();
        $self->data['image']       = $extras['image'] ?? self::defaultImage();
        $self->data['locale']      = $extras['locale'] ?? (lang() === 'en' ? 'en_US' : 'tr_TR');
        if (isset($extras['type']))       $self->data['type']       = $extras['type'];
        if (isset($extras['breadcrumb'])) $self->data['breadcrumb'] = $extras['breadcrumb'];
        if (isset($extras['structured'])) $self->data['structured'] = $extras['structured'];
        if (isset($extras['hreflang']))   $self->data['hreflang']   = $extras['hreflang'];
        if (isset($extras['keywords']))   $self->data['keywords']   = $extras['keywords'];
        if (isset($extras['noindex']))    $self->data['noindex']    = (bool)$extras['noindex'];
        return $self;
    }

    public static function currentUrl(): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $_SERVER['HTTP_HOST'] ?? env('APP_URL', 'localhost');
        $uri    = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
        return $scheme . '://' . $host . $uri;
    }

    public static function defaultImage(): string
    {
        $base = rtrim(env('APP_URL', ''), '/');
        return $base . '/assets/images/og-default.webp';
    }

    public function meta(): string
    {
        $d = $this->data;
        $title = e($d['title']);
        $desc  = e(mb_substr(strip_tags($d['description']), 0, 160));
        $canon = e($d['canonical']);
        $image = e($d['image']);
        $robots = $d['noindex'] ? 'noindex, nofollow' : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
        $kw    = !empty($d['keywords']) ? e(implode(', ', $d['keywords'])) : '';

        $html  = "<title>$title</title>\n";
        $html .= "<meta name=\"description\" content=\"$desc\">\n";
        if ($kw) $html .= "<meta name=\"keywords\" content=\"$kw\">\n";
        $html .= "<meta name=\"robots\" content=\"$robots\">\n";
        $html .= "<link rel=\"canonical\" href=\"$canon\">\n";

        // Hreflang
        foreach ($d['hreflang'] as $lng => $url) {
            $html .= "<link rel=\"alternate\" hreflang=\"" . e($lng) . "\" href=\"" . e($url) . "\">\n";
        }
        if (empty($d['hreflang'])) {
            $base = rtrim(env('APP_URL', ''), '/');
            $path = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
            $cleanPath = preg_replace('#^/en(/|$)#', '/', $path);
            $html .= '<link rel="alternate" hreflang="tr" href="' . e($base . $cleanPath) . "\">\n";
            $html .= '<link rel="alternate" hreflang="en" href="' . e($base . '/en' . ($cleanPath === '/' ? '' : $cleanPath)) . "\">\n";
            $html .= '<link rel="alternate" hreflang="x-default" href="' . e($base . $cleanPath) . "\">\n";
        }

        // Open Graph
        $html .= "<meta property=\"og:type\" content=\"" . e($d['type']) . "\">\n";
        $html .= "<meta property=\"og:title\" content=\"$title\">\n";
        $html .= "<meta property=\"og:description\" content=\"$desc\">\n";
        $html .= "<meta property=\"og:url\" content=\"$canon\">\n";
        $html .= "<meta property=\"og:image\" content=\"$image\">\n";
        $html .= "<meta property=\"og:image:width\" content=\"1200\">\n";
        $html .= "<meta property=\"og:image:height\" content=\"630\">\n";
        $html .= "<meta property=\"og:locale\" content=\"" . e($d['locale']) . "\">\n";
        $html .= "<meta property=\"og:site_name\" content=\"" . e($d['site_name']) . "\">\n";

        // Twitter
        $html .= "<meta name=\"twitter:card\" content=\"" . e($d['twitter_card']) . "\">\n";
        $html .= "<meta name=\"twitter:site\" content=\"" . e($d['twitter_site']) . "\">\n";
        $html .= "<meta name=\"twitter:title\" content=\"$title\">\n";
        $html .= "<meta name=\"twitter:description\" content=\"$desc\">\n";
        $html .= "<meta name=\"twitter:image\" content=\"$image\">\n";

        return $html;
    }

    public function jsonLd(): string
    {
        $d = $this->data;
        $base = rtrim(env('APP_URL', ''), '/');

        $blocks = [];

        // Organization (always present)
        $blocks[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => 'Expo Cyprus',
            'alternateName' => 'UNIFEX Fuarcılık Organizasyon Ltd.',
            'url'      => $base,
            'logo'     => $base . '/assets/images/logo/unifex-logo.webp',
            'foundingDate' => '2004',
            'address'  => [
                '@type'    => 'PostalAddress',
                'addressLocality' => 'Lefkoşa',
                'addressCountry'  => 'CY',
            ],
            'contactPoint' => [
                '@type'       => 'ContactPoint',
                'telephone'   => '+90-548-XXX-XXXX',
                'contactType' => 'customer service',
                'availableLanguage' => ['Turkish', 'English'],
            ],
            'sameAs' => [
                'https://www.instagram.com/expocyprus',
                'https://www.facebook.com/expocyprus',
                'https://www.linkedin.com/company/expocyprus',
            ],
        ];

        // WebSite
        $blocks[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => 'Expo Cyprus',
            'url'      => $base,
            'potentialAction' => [
                '@type'  => 'SearchAction',
                'target' => $base . '/search?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];

        // Breadcrumb
        if (!empty($d['breadcrumb'])) {
            $items = [];
            foreach ($d['breadcrumb'] as $i => $bc) {
                $items[] = [
                    '@type'    => 'ListItem',
                    'position' => $i + 1,
                    'name'     => $bc['name'],
                    'item'     => str_starts_with($bc['url'], 'http') ? $bc['url'] : ($base . $bc['url']),
                ];
            }
            $blocks[] = [
                '@context'        => 'https://schema.org',
                '@type'           => 'BreadcrumbList',
                'itemListElement' => $items,
            ];
        }

        // Custom structured data (Article, Product, Event etc.)
        foreach ($d['structured'] as $struct) {
            if (!isset($struct['@context'])) $struct['@context'] = 'https://schema.org';
            $blocks[] = $struct;
        }

        $html = '';
        foreach ($blocks as $b) {
            $html .= '<script type="application/ld+json">' . "\n"
                   . json_encode($b, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n"
                   . '</script>' . "\n";
        }
        return $html;
    }

    public function all(): string
    {
        return $this->meta() . $this->jsonLd();
    }
}
