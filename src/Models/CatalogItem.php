<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class CatalogItem extends BaseModel
{
    protected static string $table = 'catalog_items';

    public static function filtered(array $filters = [], int $page = 1, int $perPage = 100): array
    {
        // Stand catalog: tek sayfada tüm modeller (kategori bazında gruplanır), pagination kullanılmaz
        $rows  = DB::query("SELECT * FROM catalog_items WHERE status = 'active' ORDER BY
                            FIELD(size_category, 'bir-birim', 'iki-birim', 'uc-birim', 'ada'),
                            model_no ASC");
        return ['data' => $rows, 'total' => count($rows), 'page' => 1, 'last_page' => 1];
    }

    public static function findByModelNo(string $modelNo): ?array
    {
        return DB::first("SELECT * FROM catalog_items WHERE model_no = ? AND status = 'active' LIMIT 1", [$modelNo]);
    }
}
