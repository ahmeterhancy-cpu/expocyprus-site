<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class AdminUser extends BaseModel
{
    protected static string $table = 'admin_users';

    public static function authenticate(string $email, string $password): ?array
    {
        $user = DB::first(
            "SELECT * FROM admin_users WHERE email = ? AND status = 'active' LIMIT 1",
            [$email]
        );
        if (!$user) return null;
        if (!password_verify($password, $user['password_hash'])) return null;

        DB::execute("UPDATE admin_users SET last_login = NOW() WHERE id = ?", [$user['id']]);
        unset($user['password_hash']);
        return $user;
    }

    public static function create(array $data): int|string
    {
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
            unset($data['password']);
        }
        return parent::create($data);
    }

    public static function changePassword(int $id, string $newPassword): int
    {
        return DB::update('admin_users', [
            'password_hash' => password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]),
            'updated_at'    => date('Y-m-d H:i:s'),
        ], ['id' => $id]);
    }
}
