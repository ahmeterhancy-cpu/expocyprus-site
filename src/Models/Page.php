<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class Page extends BaseModel
{
    protected static string $table = 'pages';

    public static function findBySlug(string $slug): ?array
    {
        return DB::first("SELECT * FROM pages WHERE slug = ? AND status = 'published' LIMIT 1", [$slug]);
    }

    public static function allPublished(): array
    {
        return DB::query("SELECT * FROM pages WHERE status = 'published' ORDER BY title_tr");
    }
}
