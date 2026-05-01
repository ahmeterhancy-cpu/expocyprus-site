<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

abstract class BaseModel
{
    protected static string $table = '';
    protected static string $pk    = 'id';

    public static function all(string $orderBy = 'id DESC'): array
    {
        return DB::query("SELECT * FROM `" . static::$table . "` ORDER BY $orderBy");
    }

    public static function find(int|string $id): ?array
    {
        return DB::first(
            "SELECT * FROM `" . static::$table . "` WHERE `" . static::$pk . "` = ? LIMIT 1",
            [$id]
        );
    }

    public static function findBy(string $column, mixed $value): ?array
    {
        return DB::first(
            "SELECT * FROM `" . static::$table . "` WHERE `$column` = ? LIMIT 1",
            [$value]
        );
    }

    public static function where(string $column, mixed $value, string $orderBy = 'id DESC'): array
    {
        return DB::query(
            "SELECT * FROM `" . static::$table . "` WHERE `$column` = ? ORDER BY $orderBy",
            [$value]
        );
    }

    public static function create(array $data): int|string
    {
        if (!isset($data['created_at'])) $data['created_at'] = date('Y-m-d H:i:s');
        if (!isset($data['updated_at'])) $data['updated_at'] = date('Y-m-d H:i:s');
        return DB::insert(static::$table, $data);
    }

    public static function update(int|string $id, array $data): int
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return DB::update(static::$table, $data, [static::$pk => $id]);
    }

    public static function delete(int|string $id): int
    {
        return DB::delete(static::$table, [static::$pk => $id]);
    }

    public static function count(array $where = []): int
    {
        if (empty($where)) {
            $row = DB::first("SELECT COUNT(*) as cnt FROM `" . static::$table . "`");
            return (int)($row['cnt'] ?? 0);
        }
        $cond   = implode(' AND ', array_map(fn($k) => "`$k` = ?", array_keys($where)));
        $row    = DB::first("SELECT COUNT(*) as cnt FROM `" . static::$table . "` WHERE $cond", array_values($where));
        return (int)($row['cnt'] ?? 0);
    }

    public static function paginate(int $page, int $perPage = 20, string $where = '', array $params = []): array
    {
        $offset = ($page - 1) * $perPage;
        $whereClause = $where ? "WHERE $where" : '';
        $total = (int)(DB::first(
            "SELECT COUNT(*) as cnt FROM `" . static::$table . "` $whereClause", $params
        )['cnt'] ?? 0);
        $rows = DB::query(
            "SELECT * FROM `" . static::$table . "` $whereClause ORDER BY id DESC LIMIT $perPage OFFSET $offset",
            $params
        );
        return [
            'data'      => $rows,
            'total'     => $total,
            'per_page'  => $perPage,
            'page'      => $page,
            'last_page' => (int)ceil($total / $perPage),
        ];
    }
}
