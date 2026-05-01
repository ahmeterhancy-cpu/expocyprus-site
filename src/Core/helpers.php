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
