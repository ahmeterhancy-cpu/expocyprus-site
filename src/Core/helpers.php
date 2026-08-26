<?php
declare(strict_types=1);

use App\Core\{Application, Lang, Session, View};

function app(): Application
{
    return Application::getInstance();
}

function env(string $key, mixed $default = null): mixed
{
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

function config(string $key, mixed $default = null): mixed
{
    return app()->config($key, $default);
}

function lang(): string
{
    return Lang::get();
}

function __(string $key, array $replace = []): string
{
    return Lang::trans($key, $replace);
}

function url(string $path = ''): string
{
    return Lang::url($path);
}

function asset(string $path): string
{
    $base = rtrim(env('APP_URL', ''), '/');
    return $base . '/assets/' . ltrim($path, '/');
}

function redirect(string $url, int $status = 302): void
{
    View::redirect($url, $status);
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . Session::csrf() . '">';
}

function csrf_token(): string
{
    return Session::csrf();
}

function flash(string $key, mixed $value = null): mixed
{
    if ($value !== null) {
        Session::flash($key, $value);
        return null;
    }
    return Session::getFlash($key);
}

function old(string $key, mixed $default = ''): mixed
{
    return Session::getFlash('old_input')[$key] ?? $default;
}

function e(string|null $value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function slug(string $text): string
{
    $text = mb_strtolower(trim($text), 'UTF-8');
    $tr   = ['ş' => 's', 'ı' => 'i', 'ğ' => 'g', 'ü' => 'u', 'ö' => 'o', 'ç' => 'c',
             'Ş' => 's', 'İ' => 'i', 'Ğ' => 'g', 'Ü' => 'u', 'Ö' => 'o', 'Ç' => 'c'];
    $text = strtr($text, $tr);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

function timeAgo(?string $datetime): string
{
    if (!$datetime) return '—';
    $diff = time() - strtotime($datetime);
    if ($diff < 60)     return $diff . ' saniye önce';
    if ($diff < 3600)   return floor($diff / 60) . ' dakika önce';
    if ($diff < 86400)  return floor($diff / 3600) . ' saat önce';
    if ($diff < 604800) return floor($diff / 86400) . ' gün önce';
    return date('d.m.Y', strtotime($datetime));
}

function isAdmin(): bool
{
    return Session::has('admin_id');
}

function adminUser(): ?array
{
    return Session::get('admin_user');
}

/**
 * CMS page content helper.
 * Returns lang-appropriate field with fallback to default.
 *
 * Usage:
 *   $hero = cms('about', 'hero_title', 'Default Title');
 *   echo cms('about', 'body');
 */
function cms(string $pageKey, string $field, ?string $fallback = null): ?string
{
    static $cache = [];
    if (!isset($cache[$pageKey])) {
        try {
            $cache[$pageKey] = \App\Models\CmsPage::content($pageKey);
        } catch (\Throwable $e) {
            $cache[$pageKey] = [];
        }
    }
    $page = $cache[$pageKey];
    $isEn = (lang() === 'en');
    $tr = $page[$field . '_tr'] ?? null;
    $en = $page[$field . '_en'] ?? null;
    $val = $isEn ? ($en ?: $tr) : ($tr ?: $en);
    if ($val !== null && $val !== '') return $val;
    // Try non-suffixed field (e.g. hero_image, og_image, sections_json)
    if (isset($page[$field]) && $page[$field] !== '' && $page[$field] !== null) {
        return $page[$field];
    }
    return $fallback;
}

/**
 * CMS site setting helper.
 * Usage: setting('company_phone', '+90 ...');
 */
function setting(string $key, string $default = ''): string
{
    static $cache = null;
    if ($cache === null) {
        try {
            $cache = \App\Models\CmsPage::allSettings();
        } catch (\Throwable $e) {
            $cache = [];
        }
    }
    return !empty($cache[$key]) ? (string)$cache[$key] : $default;
}

/**
 * ═══════════════════════════════════════════════════════════════
 * KATALOG İÇERİK NORMALİZASYONU
 * Admin panelinden girilen içerik dağınık olabilir:
 *  - özellik satırları başında "• ", "- " gibi işaretler
 *  - açıklama alanına özellik listesinin aynısının yapıştırılması
 *  - boş satırlar
 * Bu yardımcılar kartın her zaman derli toplu görünmesini sağlar.
 * ═══════════════════════════════════════════════════════════════
 */

/** Tek bir özellik satırını temizler: baştaki madde işareti, fazla boşluk. */
function catalog_clean_feature(string $line): string
{
    $line = str_replace("\u{00A0}", ' ', $line);
    $line = preg_replace('/^[\s\x{2022}\x{00B7}\x{25AA}\x{25CF}\x{2013}\x{2014}\-\*\+]+/u', '', $line) ?? $line;
    $line = preg_replace('/\s+/u', ' ', $line) ?? $line;
    return trim($line, " \t\n\r\0\x0B.;,");
}

/** Serbest metni ("• A • B • C" veya satır satır) özellik dizisine çevirir. */
function catalog_split_features(?string $text): array
{
    if ($text === null || trim($text) === '') return [];
    $text = strip_tags($text);
    $parts = preg_split('/\R+|(?<!^)\s*[\x{2022}\x{00B7}\x{25AA}\x{25CF}]\s*/u', $text) ?: [];
    $out = [];
    foreach ($parts as $p) {
        $p = catalog_clean_feature($p);
        if ($p !== '') $out[] = $p;
    }
    return $out;
}

/** Karşılaştırma için metni sadeleştirir (büyük/küçük, noktalama, boşluk farkını yok sayar). */
function catalog_fingerprint(string $text): string
{
    $t = mb_strtolower(strip_tags($text), 'UTF-8');
    $t = preg_replace('/[^\p{L}\p{N}]+/u', '', $t) ?? $t;
    return $t;
}

/**
 * Bir katalog kaydının özellik listesini dile göre, temizlenmiş olarak döndürür.
 * features_en_json yoksa features_json'a düşer.
 */
function catalog_features(array $item): array
{
    $primary   = lang() === 'en' ? ($item['features_en_json'] ?? null) : ($item['features_json'] ?? null);
    $fallback  = lang() === 'en' ? ($item['features_json'] ?? null)    : ($item['features_en_json'] ?? null);

    foreach ([$primary, $fallback] as $raw) {
        if (empty($raw)) continue;
        $list = is_array($raw) ? $raw : json_decode((string) $raw, true);
        if (!is_array($list)) continue;
        $clean = [];
        foreach ($list as $f) {
            if (is_array($f)) $f = implode(' ', $f);
            $f = catalog_clean_feature((string) $f);
            if ($f !== '') $clean[] = $f;
        }
        $clean = array_values(array_unique($clean));
        if ($clean !== []) return $clean;
    }
    return [];
}

/**
 * Kartta paragraf olarak gösterilecek tanıtım metni.
 * Metin zaten özellik listesinin tekrarıysa (madde madde aynı içerik) boş döner —
 * böylece aynı bilgi kartta iki kez görünmez.
 */
function catalog_intro(array $item, array $features = []): string
{
    $desc = lang() === 'en'
        ? (string) ($item['description_en'] ?? $item['description'] ?? '')
        : (string) ($item['description'] ?? $item['description_en'] ?? '');
    $desc = trim(strip_tags($desc));
    if ($desc === '') return '';

    $descParts = catalog_split_features($desc);

    // Madde işaretiyle yazılmış / çok parçalı metin = özellik listesi, tanıtım değil.
    if (count($descParts) > 1) return '';

    if ($features === []) return $desc;

    // Tek parça olsa bile özelliklerden biriyle birebir aynıysa tekrar sayılır.
    $descFp = catalog_fingerprint($desc);
    foreach ($features as $f) {
        if (catalog_fingerprint($f) === $descFp) return '';
    }

    return $desc;
}

/** "3m x 3m", "10 x 3m" gibi ölçüleri tek biçime getirir: "3m × 3m". */
function catalog_dimensions(?string $dim): string
{
    $dim = trim((string) $dim);
    if ($dim === '') return '';
    $dim = preg_replace('/\s*[x×X\*]\s*/u', ' × ', $dim) ?? $dim;
    // Birimi olmayan sayılara "m" ekle: "10 × 3m" → "10m × 3m"
    $dim = preg_replace('/(\d+(?:[.,]\d+)?)(?=\s*×)/u', '$1m', $dim) ?? $dim;
    $dim = preg_replace('/(\d)m+m/u', '$1m', $dim) ?? $dim;
    return preg_replace('/\s+/u', ' ', $dim) ?? $dim;
}
