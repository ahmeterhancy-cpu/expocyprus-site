<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class FormSubmission extends BaseModel
{
    protected static string $table = 'form_submissions';

    public static function todayCount(): int
    {
        $row = DB::first("SELECT COUNT(*) as cnt FROM form_submissions WHERE DATE(created_at) = CURDATE()");
        return (int)($row['cnt'] ?? 0);
    }

    public static function recentByType(string $type = '', int $limit = 10): array
    {
        if ($type) {
            return DB::query(
                "SELECT * FROM form_submissions WHERE form_type = ? ORDER BY created_at DESC LIMIT ?",
                [$type, $limit]
            );
        }
        return DB::query("SELECT * FROM form_submissions ORDER BY created_at DESC LIMIT ?", [$limit]);
    }

    public static function markRead(int $id): void
    {
        DB::execute("UPDATE form_submissions SET is_read = 1 WHERE id = ?", [$id]);
    }

    public static function unreadCount(): int
    {
        $row = DB::first("SELECT COUNT(*) as cnt FROM form_submissions WHERE is_read = 0");
        return (int)($row['cnt'] ?? 0);
    }
}
