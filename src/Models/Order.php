<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class Order extends BaseModel
{
    protected static string $table = 'orders';

    public static function generateOrderNo(): string
    {
        $rand = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4));
        return 'EC-' . date('Ymd') . '-' . $rand;
    }

    public static function findByOrderNo(string $no): ?array
    {
        return DB::first("SELECT * FROM orders WHERE order_no = ? LIMIT 1", [$no]);
    }

    public static function recent(int $limit = 50): array
    {
        $limit = max(1, $limit);
        return DB::query("SELECT * FROM orders ORDER BY id DESC LIMIT $limit");
    }
}
