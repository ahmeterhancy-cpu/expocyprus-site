<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class Hotel extends BaseModel
{
    protected static string $table = 'hotels';

    public static function allActive(string $region = ''): array
    {
        if ($region) {
            return DB::query(
                "SELECT * FROM hotels WHERE status = 'active' AND region = ? ORDER BY sort_order ASC, stars DESC, name ASC",
                [$region]
            );
        }
        return DB::query(
            "SELECT * FROM hotels WHERE status = 'active' ORDER BY sort_order ASC, stars DESC, name ASC"
        );
    }

    public static function findBySlug(string $slug): ?array
    {
        return DB::first("SELECT * FROM hotels WHERE slug = ? LIMIT 1", [$slug]);
    }

    public static function regions(): array
    {
        $rows = DB::query("SELECT DISTINCT region FROM hotels WHERE status = 'active' ORDER BY region ASC");
        return array_column($rows, 'region');
    }

    public static function countByRegion(): array
    {
        $rows = DB::query("SELECT region, COUNT(*) as cnt FROM hotels WHERE status = 'active' GROUP BY region");
        $out = [];
        foreach ($rows as $r) $out[$r['region']] = (int)$r['cnt'];
        return $out;
    }
}
