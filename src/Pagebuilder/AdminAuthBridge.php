<?php
declare(strict_types=1);

namespace App\Pagebuilder;

use PHPageBuilder\Contracts\AuthContract;

/**
 * PHPagebuilder ↔ mevcut admin login köprüsü.
 * AdminUser session'ı varsa authenticated kabul eder, yoksa /admin/login'e yönlendirir.
 */
class AdminAuthBridge implements AuthContract
{
    public function handleRequest($action): void
    {
        // Auth tamamen mevcut admin login akışında — bu noktada hiçbir işlem yok.
        // /admin/login mevcut AuthController tarafından handle ediliyor.
        if (!$this->isAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }
    }

    public function isAuthenticated(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }
        return !empty($_SESSION['admin_id']) || !empty($_SESSION['admin_user']);
    }

    public function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }
    }

    public function renderLoginForm(): void
    {
        header('Location: /admin/login');
        exit;
    }
}
