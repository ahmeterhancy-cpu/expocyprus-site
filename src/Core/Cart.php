<?php
declare(strict_types=1);
namespace App\Core;

use App\Models\CatalogItem;

class Cart
{
    private const KEY = 'stand_cart';

    public static function items(): array
    {
        return $_SESSION[self::KEY] ?? [];
    }

    public static function add(string $modelNo, int $qty = 1): bool
    {
        $modelNo = strtoupper(trim($modelNo));
        if ($qty < 1) $qty = 1;
        try { $model = CatalogItem::findByModelNo($modelNo); } catch (\Throwable $e) { return false; }
        if (!$model) return false;

        if (!isset($_SESSION[self::KEY])) $_SESSION[self::KEY] = [];
        if (isset($_SESSION[self::KEY][$modelNo])) {
            $_SESSION[self::KEY][$modelNo]['qty'] += $qty;
        } else {
            $_SESSION[self::KEY][$modelNo] = [
                'model_no'   => $modelNo,
                'name_tr'    => $model['name_tr'] ?? $modelNo,
                'name_en'    => $model['name_en'] ?? $modelNo,
                'dimensions' => $model['dimensions'] ?? '',
                'price'      => (float)($model['price'] ?? 0),
                'currency'   => $model['currency'] ?? 'EUR',
                'image'      => $model['image_main'] ?? '',
                'qty'        => $qty,
            ];
        }
        return true;
    }

    public static function update(string $modelNo, int $qty): void
    {
        $modelNo = strtoupper(trim($modelNo));
        if ($qty < 1) { self::remove($modelNo); return; }
        if (isset($_SESSION[self::KEY][$modelNo])) {
            $_SESSION[self::KEY][$modelNo]['qty'] = $qty;
        }
    }

    public static function remove(string $modelNo): void
    {
        $modelNo = strtoupper(trim($modelNo));
        unset($_SESSION[self::KEY][$modelNo]);
    }

    public static function clear(): void
    {
        unset($_SESSION[self::KEY]);
    }

    public static function count(): int
    {
        $sum = 0;
        foreach (self::items() as $i) $sum += (int)$i['qty'];
        return $sum;
    }

    public static function subtotal(): float
    {
        $sum = 0.0;
        foreach (self::items() as $i) $sum += (float)$i['price'] * (int)$i['qty'];
        return $sum;
    }

    public static function currency(): string
    {
        foreach (self::items() as $i) return $i['currency'] ?? 'EUR';
        return 'EUR';
    }
}
