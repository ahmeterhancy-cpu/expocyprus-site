<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Block-tabanlı sayfa oluşturucu — Elementor tarzı.
 * Her bloğun bir tipi (hero, heading, text, image, stats vb.) ve özellikleri vardır.
 * Frontend'de blocks_json'dan render edilir.
 */
class BlockRenderer
{
    /** Block tipi tanımları — admin UI ve render için kullanılır */
    public const BLOCK_TYPES = [
        'hero' => [
            'label' => 'Hero (Apple Cinematic)',
            'icon'  => '🎬',
            'desc'  => 'Tam ekran kahraman bölümü — büyük başlık, alt etiket, parallax görsel',
            'fields' => [
                'eyebrow_tr'  => ['label' => 'Üst Etiket (TR)', 'type' => 'text', 'placeholder' => 'SINCE 2004'],
                'eyebrow_en'  => ['label' => 'Üst Etiket (EN)', 'type' => 'text'],
                'title_tr'    => ['label' => 'Başlık (TR)',     'type' => 'text', 'placeholder' => 'Büyük dramatik başlık'],
                'title_en'    => ['label' => 'Başlık (EN)',     'type' => 'text'],
                'subtitle_tr' => ['label' => 'Alt Başlık (TR)', 'type' => 'textarea'],
                'subtitle_en' => ['label' => 'Alt Başlık (EN)', 'type' => 'textarea'],
                'image'       => ['label' => 'Arkaplan Görseli','type' => 'image'],
                'cta_text_tr' => ['label' => 'Buton Metni (TR)','type' => 'text'],
                'cta_text_en' => ['label' => 'Buton Metni (EN)','type' => 'text'],
                'cta_url'     => ['label' => 'Buton URL',       'type' => 'text'],
                'accent'      => ['label' => 'Vurgu Rengi',     'type' => 'color', 'default' => '#E30613'],
                'text_color'  => ['label' => 'Yazı Rengi',      'type' => 'color'],
                'bg_color'    => ['label' => 'Arkaplan Rengi (görsel yoksa)', 'type' => 'color'],
            ],
        ],
        'heading' => [
            'label' => 'Başlık',
            'icon'  => '🅷',
            'desc'  => 'Bölüm başlığı — büyük başlık + üst etiket',
            'fields' => [
                'eyebrow_tr' => ['label' => 'Üst Etiket (TR)', 'type' => 'text'],
                'eyebrow_en' => ['label' => 'Üst Etiket (EN)', 'type' => 'text'],
                'title_tr'   => ['label' => 'Başlık (TR)',     'type' => 'text'],
                'title_en'   => ['label' => 'Başlık (EN)',     'type' => 'text'],
                'align'      => ['label' => 'Hizalama',        'type' => 'select', 'options' => ['left' => 'Sol', 'center' => 'Orta', 'right' => 'Sağ'], 'default' => 'left'],
                'size'       => ['label' => 'Boyut',           'type' => 'select', 'options' => ['md' => 'Orta', 'lg' => 'Büyük', 'xl' => 'Çok Büyük'], 'default' => 'lg'],
                'text_color' => ['label' => 'Yazı Rengi',      'type' => 'color'],
                'bg_color'   => ['label' => 'Arkaplan Rengi',  'type' => 'color'],
            ],
        ],
        'text' => [
            'label' => 'Metin',
            'icon'  => '¶',
            'desc'  => 'Rich text paragraf bölümü',
            'fields' => [
                'body_tr' => ['label' => 'İçerik (TR — HTML)', 'type' => 'richtext'],
                'body_en' => ['label' => 'İçerik (EN — HTML)', 'type' => 'richtext'],
                'text_color' => ['label' => 'Yazı Rengi',     'type' => 'color'],
                'bg_color'   => ['label' => 'Arkaplan Rengi', 'type' => 'color'],
            ],
        ],
        'image' => [
            'label' => 'Görsel',
            'icon'  => '🖼️',
            'desc'  => 'Tek görsel + opsiyonel açıklama',
            'fields' => [
                'image'       => ['label' => 'Görsel',           'type' => 'image'],
                'caption_tr'  => ['label' => 'Açıklama (TR)',    'type' => 'text'],
                'caption_en'  => ['label' => 'Açıklama (EN)',    'type' => 'text'],
                'rounded'     => ['label' => 'Yuvarlak köşe',    'type' => 'checkbox', 'default' => '1'],
                'full_width'  => ['label' => 'Tam genişlik',     'type' => 'checkbox'],
                'bg_color'    => ['label' => 'Arkaplan Rengi',   'type' => 'color'],
            ],
        ],
        'image_text' => [
            'label' => 'Görsel + Metin',
            'icon'  => '◧',
            'desc'  => 'İki kolon — görsel ve metin yan yana',
            'fields' => [
                'image'    => ['label' => 'Görsel',         'type' => 'image'],
                'title_tr' => ['label' => 'Başlık (TR)',    'type' => 'text'],
                'title_en' => ['label' => 'Başlık (EN)',    'type' => 'text'],
                'body_tr'  => ['label' => 'Metin (TR)',     'type' => 'richtext'],
                'body_en'  => ['label' => 'Metin (EN)',     'type' => 'richtext'],
                'layout'   => ['label' => 'Düzen',          'type' => 'select', 'options' => ['left' => 'Görsel solda', 'right' => 'Görsel sağda'], 'default' => 'left'],
                'tilt'     => ['label' => '3D Tilt efekti', 'type' => 'checkbox'],
                'text_color' => ['label' => 'Yazı Rengi',   'type' => 'color'],
                'bg_color'   => ['label' => 'Arkaplan Rengi','type' => 'color'],
            ],
        ],
        'stats' => [
            'label' => 'İstatistikler',
            'icon'  => '📊',
            'desc'  => '3-4 büyük sayı — performans / başarı göstergeleri',
            'fields' => [
                'theme' => ['label' => 'Tema', 'type' => 'select', 'options' => ['light' => 'Açık', 'dark' => 'Koyu'], 'default' => 'dark'],
                'stat1_num' => ['label' => 'Sayı 1', 'type' => 'text'],
                'stat1_tr'  => ['label' => 'Etiket 1 (TR)', 'type' => 'text'],
                'stat1_en'  => ['label' => 'Etiket 1 (EN)', 'type' => 'text'],
                'stat2_num' => ['label' => 'Sayı 2', 'type' => 'text'],
                'stat2_tr'  => ['label' => 'Etiket 2 (TR)', 'type' => 'text'],
                'stat2_en'  => ['label' => 'Etiket 2 (EN)', 'type' => 'text'],
                'stat3_num' => ['label' => 'Sayı 3', 'type' => 'text'],
                'stat3_tr'  => ['label' => 'Etiket 3 (TR)', 'type' => 'text'],
                'stat3_en'  => ['label' => 'Etiket 3 (EN)', 'type' => 'text'],
                'stat4_num' => ['label' => 'Sayı 4', 'type' => 'text'],
                'stat4_tr'  => ['label' => 'Etiket 4 (TR)', 'type' => 'text'],
                'stat4_en'  => ['label' => 'Etiket 4 (EN)', 'type' => 'text'],
                'text_color'=> ['label' => 'Yazı Rengi',   'type' => 'color'],
                'bg_color'  => ['label' => 'Arkaplan Rengi','type' => 'color'],
            ],
        ],
        'features' => [
            'label' => 'Özellikler Grid',
            'icon'  => '⚏',
            'desc'  => '3-6 özellik kartı — ikon + başlık + açıklama',
            'fields' => [
                'columns' => ['label' => 'Kolon Sayısı', 'type' => 'select', 'options' => ['2' => '2', '3' => '3', '4' => '4'], 'default' => '3'],
                'feat1_icon' => ['label' => 'Özellik 1 İkon', 'type' => 'text', 'placeholder' => '🚀 emoji veya ikon'],
                'feat1_title_tr' => ['label' => 'Başlık 1 (TR)', 'type' => 'text'],
                'feat1_title_en' => ['label' => 'Başlık 1 (EN)', 'type' => 'text'],
                'feat1_desc_tr'  => ['label' => 'Açıklama 1 (TR)', 'type' => 'textarea'],
                'feat1_desc_en'  => ['label' => 'Açıklama 1 (EN)', 'type' => 'textarea'],
                'feat2_icon' => ['label' => 'Özellik 2 İkon', 'type' => 'text'],
                'feat2_title_tr' => ['label' => 'Başlık 2 (TR)', 'type' => 'text'],
                'feat2_title_en' => ['label' => 'Başlık 2 (EN)', 'type' => 'text'],
                'feat2_desc_tr'  => ['label' => 'Açıklama 2 (TR)', 'type' => 'textarea'],
                'feat2_desc_en'  => ['label' => 'Açıklama 2 (EN)', 'type' => 'textarea'],
                'feat3_icon' => ['label' => 'Özellik 3 İkon', 'type' => 'text'],
                'feat3_title_tr' => ['label' => 'Başlık 3 (TR)', 'type' => 'text'],
                'feat3_title_en' => ['label' => 'Başlık 3 (EN)', 'type' => 'text'],
                'feat3_desc_tr'  => ['label' => 'Açıklama 3 (TR)', 'type' => 'textarea'],
                'feat3_desc_en'  => ['label' => 'Açıklama 3 (EN)', 'type' => 'textarea'],
                'feat4_icon' => ['label' => 'Özellik 4 İkon', 'type' => 'text'],
                'feat4_title_tr' => ['label' => 'Başlık 4 (TR)', 'type' => 'text'],
                'feat4_title_en' => ['label' => 'Başlık 4 (EN)', 'type' => 'text'],
                'feat4_desc_tr'  => ['label' => 'Açıklama 4 (TR)', 'type' => 'textarea'],
                'feat4_desc_en'  => ['label' => 'Açıklama 4 (EN)', 'type' => 'textarea'],
                'text_color' => ['label' => 'Yazı Rengi',     'type' => 'color'],
                'bg_color'   => ['label' => 'Arkaplan Rengi', 'type' => 'color'],
            ],
        ],
        'cta' => [
            'label' => 'CTA — Çağrı',
            'icon'  => '📣',
            'desc'  => 'Büyük çağrı bölümü — başlık + 2 buton',
            'fields' => [
                'title_tr' => ['label' => 'Başlık (TR)',         'type' => 'text'],
                'title_en' => ['label' => 'Başlık (EN)',         'type' => 'text'],
                'subtitle_tr' => ['label' => 'Alt Başlık (TR)',  'type' => 'textarea'],
                'subtitle_en' => ['label' => 'Alt Başlık (EN)',  'type' => 'textarea'],
                'btn1_text_tr' => ['label' => 'Buton 1 (TR)',    'type' => 'text'],
                'btn1_text_en' => ['label' => 'Buton 1 (EN)',    'type' => 'text'],
                'btn1_url'     => ['label' => 'Buton 1 URL',     'type' => 'text'],
                'btn2_text_tr' => ['label' => 'Buton 2 (TR)',    'type' => 'text'],
                'btn2_text_en' => ['label' => 'Buton 2 (EN)',    'type' => 'text'],
                'btn2_url'     => ['label' => 'Buton 2 URL',     'type' => 'text'],
                'theme' => ['label' => 'Tema', 'type' => 'select', 'options' => ['light' => 'Açık', 'dark' => 'Koyu', 'gradient' => 'Gradient'], 'default' => 'light'],
                'text_color' => ['label' => 'Yazı Rengi',     'type' => 'color'],
                'bg_color'   => ['label' => 'Arkaplan Rengi', 'type' => 'color'],
            ],
        ],
        'quote' => [
            'label' => 'Alıntı',
            'icon'  => '❝',
            'desc'  => 'Büyük pull quote — vurgulu metin',
            'fields' => [
                'quote_tr'  => ['label' => 'Alıntı (TR)',  'type' => 'textarea'],
                'quote_en'  => ['label' => 'Alıntı (EN)',  'type' => 'textarea'],
                'author'    => ['label' => 'Kaynak/Yazar', 'type' => 'text'],
                'theme' => ['label' => 'Tema', 'type' => 'select', 'options' => ['light' => 'Açık', 'dark' => 'Koyu'], 'default' => 'dark'],
                'text_color' => ['label' => 'Yazı Rengi',     'type' => 'color'],
                'bg_color'   => ['label' => 'Arkaplan Rengi', 'type' => 'color'],
            ],
        ],
        'showcase' => [
            'label' => 'Showcase Görsel',
            'icon'  => '🌅',
            'desc'  => 'Tam genişlik parallax görsel + üzerinde tek satır metin',
            'fields' => [
                'image'    => ['label' => 'Arkaplan Görseli', 'type' => 'image'],
                'title_tr' => ['label' => 'Üzerine Yazı (TR)','type' => 'text'],
                'title_en' => ['label' => 'Üzerine Yazı (EN)','type' => 'text'],
                'text_color'=> ['label' => 'Yazı Rengi',      'type' => 'color'],
            ],
        ],
        'spacer' => [
            'label' => 'Boşluk',
            'icon'  => '⎯',
            'desc'  => 'Dikey boşluk',
            'fields' => [
                'size' => ['label' => 'Boyut', 'type' => 'select', 'options' => ['sm' => 'Küçük', 'md' => 'Orta', 'lg' => 'Büyük', 'xl' => 'Çok Büyük'], 'default' => 'md'],
            ],
        ],
        'video' => [
            'label' => 'Video Embed',
            'icon'  => '▶',
            'desc'  => 'YouTube veya Vimeo videosu',
            'fields' => [
                'url'        => ['label' => 'Video URL (YouTube/Vimeo)', 'type' => 'text'],
                'caption_tr' => ['label' => 'Açıklama (TR)', 'type' => 'text'],
                'caption_en' => ['label' => 'Açıklama (EN)', 'type' => 'text'],
            ],
        ],
    ];

    /** Render tüm blocks JSON'dan HTML üret */
    public static function renderAll(?string $blocksJson): string
    {
        if (empty($blocksJson)) return '';
        $blocks = json_decode($blocksJson, true);
        if (!is_array($blocks)) return '';
        $html = '';
        foreach ($blocks as $block) {
            $html .= self::renderOne($block);
        }
        return $html;
    }

    public static function renderOne(array $block): string
    {
        $type = $block['type'] ?? '';
        $data = $block['data'] ?? [];
        $method = 'render_' . $type;
        if (method_exists(self::class, $method)) {
            return call_user_func([self::class, $method], $data);
        }
        return '<!-- Unknown block: ' . htmlspecialchars($type) . ' -->';
    }

    private static function lng(array $d, string $key): string
    {
        $isEn = (lang() === 'en');
        $tr = $d[$key . '_tr'] ?? '';
        $en = $d[$key . '_en'] ?? '';
        return (string)($isEn ? ($en ?: $tr) : ($tr ?: $en));
    }

    private static function e(string $s): string
    {
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Tüm block'lar için ortak renk override'larını inline style olarak döndürür.
     * Block ayarlarındaki bg_color ve text_color CSS sınıflarını ezer.
     */
    private static function colorStyle(array $d, string $extra = ''): string
    {
        $parts = [];
        if (!empty($d['bg_color']))   $parts[] = 'background:' . self::e((string)$d['bg_color']);
        if (!empty($d['text_color'])) $parts[] = 'color:' . self::e((string)$d['text_color']);
        if ($extra) $parts[] = $extra;
        return $parts ? ' style="' . implode(';', $parts) . '"' : '';
    }

    /* ─── BLOCK RENDERERS ──────────────────────────── */

    private static function render_hero(array $d): string
    {
        $eyebrow = self::e(self::lng($d, 'eyebrow'));
        $title   = self::e(self::lng($d, 'title'));
        $subtitle = self::e(self::lng($d, 'subtitle'));
        $cta     = self::e(self::lng($d, 'cta_text'));
        $ctaUrl  = self::e($d['cta_url'] ?? '#');
        $image   = self::e($d['image'] ?? '');
        $accent  = self::e($d['accent'] ?? '#E30613');
        $bg = $image ? "background-image:url('$image')" : '';

        $h = '<section class="bb-hero"' . self::colorStyle($d, '--accent:' . $accent) . '>';
        $h .= '<div class="bb-hero-bg" style="' . $bg . '"></div>';
        $h .= '<div class="bb-hero-overlay"></div>';
        $h .= '<div class="bb-hero-content">';
        if ($eyebrow)  $h .= '<span class="bb-hero-eyebrow">' . $eyebrow . '</span>';
        if ($title)    $h .= '<h1 class="bb-hero-title">' . $title . '</h1>';
        if ($subtitle) $h .= '<p class="bb-hero-sub">' . $subtitle . '</p>';
        if ($cta && $ctaUrl) $h .= '<div class="bb-hero-actions"><a href="' . $ctaUrl . '" class="bb-btn bb-btn-primary">' . $cta . ' →</a></div>';
        $h .= '</div></section>';
        return $h;
    }

    private static function render_heading(array $d): string
    {
        $eyebrow = self::e(self::lng($d, 'eyebrow'));
        $title   = self::e(self::lng($d, 'title'));
        $align   = self::e($d['align'] ?? 'left');
        $size    = self::e($d['size'] ?? 'lg');
        $h = '';
        $h .= '<section class="bb-heading bb-align-' . $align . ' bb-size-' . $size . '"' . self::colorStyle($d) . '><div class="bb-container">';
        if ($eyebrow) $h .= '<span class="bb-eyebrow">' . $eyebrow . '</span>';
        if ($title)   $h .= '<h2 class="bb-h2">' . $title . '</h2>';
        $h .= '</div></section>';
        return $h;
    }

    private static function render_text(array $d): string
    {
        $body = self::lng($d, 'body'); // HTML — not escaped
        return '<section class="bb-text"' . self::colorStyle($d) . '><div class="bb-container bb-prose">' . $body . '</div></section>';
    }

    private static function render_image(array $d): string
    {
        $img = self::e($d['image'] ?? '');
        if (!$img) return '';
        $caption = self::e(self::lng($d, 'caption'));
        $rounded = !empty($d['rounded']) ? 'bb-img-rounded' : '';
        $full = !empty($d['full_width']) ? 'bb-img-full' : '';
        $h = '<section class="bb-image-section"' . self::colorStyle($d) . '><div class="bb-container ' . $full . '">';
        $h .= '<img src="' . $img . '" alt="' . $caption . '" class="bb-img ' . $rounded . '" loading="lazy">';
        if ($caption) $h .= '<p class="bb-img-caption">' . $caption . '</p>';
        $h .= '</div></section>';
        return $h;
    }

    private static function render_image_text(array $d): string
    {
        $img = self::e($d['image'] ?? '');
        $title = self::e(self::lng($d, 'title'));
        $body = self::lng($d, 'body');
        $layout = self::e($d['layout'] ?? 'left');
        $tilt = !empty($d['tilt']) ? 'bb-tilt' : '';
        $h = '<section class="bb-imgtext bb-imgtext-' . $layout . '"' . self::colorStyle($d) . '><div class="bb-container">';
        $h .= '<div class="bb-imgtext-grid">';
        if ($img) $h .= '<div class="bb-imgtext-img ' . $tilt . '"><img src="' . $img . '" alt="" loading="lazy"></div>';
        $h .= '<div class="bb-imgtext-body">';
        if ($title) $h .= '<h3 class="bb-h3">' . $title . '</h3>';
        if ($body) $h .= '<div class="bb-prose">' . $body . '</div>';
        $h .= '</div></div></div></section>';
        return $h;
    }

    private static function render_stats(array $d): string
    {
        $theme = self::e($d['theme'] ?? 'dark');
        $stats = [];
        for ($i = 1; $i <= 4; $i++) {
            $num = $d["stat{$i}_num"] ?? '';
            $lbl = self::lng($d, "stat{$i}_label") ?: self::lng($d, "stat{$i}");
            // Try fallback: build from stat{$i}_tr / _en directly
            if (!$lbl) {
                $isEn = (lang() === 'en');
                $tr = $d["stat{$i}_tr"] ?? '';
                $en = $d["stat{$i}_en"] ?? '';
                $lbl = $isEn ? ($en ?: $tr) : ($tr ?: $en);
            }
            if ($num !== '' || $lbl !== '') $stats[] = ['num' => $num, 'lbl' => $lbl];
        }
        if (empty($stats)) return '';
        $h = '<section class="bb-stats bb-theme-' . $theme . '"' . self::colorStyle($d) . '><div class="bb-container"><div class="bb-stats-grid">';
        foreach ($stats as $s) {
            $h .= '<div class="bb-stat"><div class="bb-stat-num">' . self::e($s['num']) . '</div><div class="bb-stat-lbl">' . self::e($s['lbl']) . '</div></div>';
        }
        $h .= '</div></div></section>';
        return $h;
    }

    private static function render_features(array $d): string
    {
        $cols = (int)($d['columns'] ?? 3);
        $feats = [];
        for ($i = 1; $i <= 6; $i++) {
            $icon = $d["feat{$i}_icon"] ?? '';
            $title = self::lng($d, "feat{$i}_title");
            $desc  = self::lng($d, "feat{$i}_desc");
            if ($title || $desc) $feats[] = ['icon' => $icon, 'title' => $title, 'desc' => $desc];
        }
        if (empty($feats)) return '';
        $h = '<section class="bb-features"' . self::colorStyle($d) . '><div class="bb-container"><div class="bb-feat-grid bb-feat-cols-' . $cols . '">';
        foreach ($feats as $f) {
            $h .= '<div class="bb-feat-card">';
            if ($f['icon']) $h .= '<div class="bb-feat-icon">' . self::e($f['icon']) . '</div>';
            if ($f['title']) $h .= '<h4 class="bb-feat-title">' . self::e($f['title']) . '</h4>';
            if ($f['desc']) $h .= '<p class="bb-feat-desc">' . self::e($f['desc']) . '</p>';
            $h .= '</div>';
        }
        $h .= '</div></div></section>';
        return $h;
    }

    private static function render_cta(array $d): string
    {
        $title = self::e(self::lng($d, 'title'));
        $sub = self::e(self::lng($d, 'subtitle'));
        $b1 = self::e(self::lng($d, 'btn1_text'));
        $b1u = self::e($d['btn1_url'] ?? '');
        $b2 = self::e(self::lng($d, 'btn2_text'));
        $b2u = self::e($d['btn2_url'] ?? '');
        $theme = self::e($d['theme'] ?? 'light');
        $h = '<section class="bb-cta bb-theme-' . $theme . '"' . self::colorStyle($d) . '><div class="bb-container">';
        if ($title) $h .= '<h2 class="bb-cta-title">' . $title . '</h2>';
        if ($sub)   $h .= '<p class="bb-cta-sub">' . $sub . '</p>';
        if ($b1 || $b2) {
            $h .= '<div class="bb-cta-actions">';
            if ($b1) $h .= '<a href="' . $b1u . '" class="bb-btn bb-btn-primary">' . $b1 . '</a>';
            if ($b2) $h .= '<a href="' . $b2u . '" class="bb-btn bb-btn-ghost">' . $b2 . '</a>';
            $h .= '</div>';
        }
        $h .= '</div></section>';
        return $h;
    }

    private static function render_quote(array $d): string
    {
        $q = self::e(self::lng($d, 'quote'));
        $author = self::e($d['author'] ?? '');
        $theme = self::e($d['theme'] ?? 'dark');
        if (!$q) return '';
        return '<section class="bb-quote bb-theme-' . $theme . '"' . self::colorStyle($d) . '><div class="bb-container"><blockquote class="bb-quote-text">' . $q . '</blockquote>'
            . ($author ? '<cite class="bb-quote-author">— ' . $author . '</cite>' : '')
            . '</div></section>';
    }

    private static function render_showcase(array $d): string
    {
        $img = self::e($d['image'] ?? '');
        $title = self::e(self::lng($d, 'title'));
        if (!$img) return '';
        return '<section class="bb-showcase"' . self::colorStyle($d) . '><div class="bb-showcase-img" style="background-image:url(\'' . $img . '\')"></div>'
            . '<div class="bb-showcase-overlay"></div>'
            . ($title ? '<div class="bb-container"><h3 class="bb-showcase-text">' . $title . '</h3></div>' : '')
            . '</section>';
    }

    private static function render_spacer(array $d): string
    {
        $size = self::e($d['size'] ?? 'md');
        return '<div class="bb-spacer bb-spacer-' . $size . '"></div>';
    }

    private static function render_video(array $d): string
    {
        $url = $d['url'] ?? '';
        $caption = self::e(self::lng($d, 'caption'));
        if (!$url) return '';
        // Convert YouTube/Vimeo URLs to embed
        $embed = '';
        if (preg_match('#youtu(?:\.be|be\.com)/(?:watch\?v=|embed/|v/|)([a-zA-Z0-9_-]+)#', $url, $m)) {
            $embed = 'https://www.youtube.com/embed/' . $m[1];
        } elseif (preg_match('#vimeo\.com/(\d+)#', $url, $m)) {
            $embed = 'https://player.vimeo.com/video/' . $m[1];
        } else {
            $embed = $url;
        }
        return '<section class="bb-video"><div class="bb-container">'
            . '<div class="bb-video-frame"><iframe src="' . self::e($embed) . '" frameborder="0" allow="accelerometer;autoplay;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe></div>'
            . ($caption ? '<p class="bb-video-caption">' . $caption . '</p>' : '')
            . '</div></section>';
    }
}
