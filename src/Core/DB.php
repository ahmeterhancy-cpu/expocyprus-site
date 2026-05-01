<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo !== null) return self::$pdo;

        $cfg = require BASE_PATH . '/config/database.php';
        $dsn = sprintf(
            '%s:host=%s;port=%d;dbname=%s;charset=%s',
            $cfg['driver'], $cfg['host'], $cfg['port'], $cfg['database'], $cfg['charset']
        );

        try {
            self::$pdo = new PDO($dsn, $cfg['username'], $cfg['password'], $cfg['options']);
        } catch (PDOException $e) {
            if (env('APP_DEBUG', 'false') === 'true') {
                throw $e;
            }
            http_response_code(503);
            echo 'Veritabanı bağlantısı kurulamadı. Lütfen daha sonra tekrar deneyin.';
            exit;
        }

        return self::$pdo;
    }

    public static function query(string $sql, array $params = []): array
    {
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function first(string $sql, array $params = []): ?array
    {
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function execute(string $sql, array $params = []): int
    {
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public static function insert(string $table, array $data): int|string
    {
        $cols = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt = self::connect()->prepare("INSERT INTO `$table` ($cols) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
        return self::connect()->lastInsertId();
    }

    public static function update(string $table, array $data, array $where): int
    {
        $set   = implode(', ', array_map(fn($k) => "`$k` = ?", array_keys($data)));
        $cond  = implode(' AND ', array_map(fn($k) => "`$k` = ?", array_keys($where)));
        $stmt  = self::connect()->prepare("UPDATE `$table` SET $set WHERE $cond");
        $stmt->execute([...array_values($data), ...array_values($where)]);
        return $stmt->rowCount();
    }

    public static function delete(string $table, array $where): int
    {
        $cond = implode(' AND ', array_map(fn($k) => "`$k` = ?", array_keys($where)));
        $stmt = self::connect()->prepare("DELETE FROM `$table` WHERE $cond");
        $stmt->execute(array_values($where));
        return $stmt->rowCount();
    }

    public static function pdo(): PDO
    {
        return self::connect();
    }
}
