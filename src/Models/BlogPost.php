<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class BlogPost extends BaseModel
{
    protected static string $table = 'blog_posts';

    public static function published(string $lang = 'tr', int $limit = 3): array
    {
        return DB::query(
            "SELECT * FROM blog_posts WHERE status = 'published' AND lang = ? ORDER BY published_at DESC LIMIT ?",
            [$lang, $limit]
        );
    }

    public static function findBySlug(string $slug, string $lang = 'tr'): ?array
    {
        return DB::first("SELECT * FROM blog_posts WHERE slug = ? AND lang = ? LIMIT 1", [$slug, $lang]);
    }

    public static function allPublished(string $lang = 'tr', int $page = 1, int $perPage = 9): array
    {
        $offset = ($page - 1) * $perPage;
        $total  = (int)(DB::first("SELECT COUNT(*) as cnt FROM blog_posts WHERE status = 'published' AND lang = ?", [$lang])['cnt'] ?? 0);
        $rows   = DB::query("SELECT * FROM blog_posts WHERE status = 'published' AND lang = ? ORDER BY published_at DESC LIMIT $perPage OFFSET $offset", [$lang]);
        return ['data' => $rows, 'total' => $total, 'page' => $page, 'last_page' => (int)ceil($total / $perPage)];
    }
}
