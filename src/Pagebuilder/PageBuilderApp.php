<?php
declare(strict_types=1);

namespace App\Pagebuilder;

use PHPageBuilder\PHPageBuilder;

/**
 * PHPageBuilder bootstrap — tek bir yerden örnek oluşturur ve handler delegate eder.
 */
class PageBuilderApp
{
    private static ?PHPageBuilder $instance = null;

    public static function instance(): PHPageBuilder
    {
        if (self::$instance === null) {
            $config = require BASE_PATH . '/config/pagebuilder.php';
            self::$instance = new PHPageBuilder($config);
        }
        return self::$instance;
    }

    /**
     * Mevcut URL bir PageBuilder URL'i mi?
     * /admin/pagebuilder/edit/*, /uploads/pagebuilder/*, /vendor/hansschouten/phpagebuilder/dist/*
     */
    public static function isPageBuilderUrl(string $uri): bool
    {
        $uri = explode('?', $uri, 2)[0];
        return str_starts_with($uri, '/admin/pagebuilder/edit')
            || str_starts_with($uri, '/uploads/pagebuilder/')
            || str_starts_with($uri, '/vendor/hansschouten/phpagebuilder/dist/');
    }

    /**
     * Authenticated PageBuilder request'i handle et (admin login zorunlu).
     * /admin/pagebuilder/edit?route=pagebuilder&action=edit&page=N
     */
    public static function handleAuthenticatedRequest(): void
    {
        $pb = self::instance();
        $auth = new AdminAuthBridge();
        if (!$auth->isAuthenticated()) {
            header('Location: /admin/login');
            exit;
        }

        $action = $_GET['action'] ?? null;

        if (\phpb_in_module('pagebuilder')) {
            \phpb_set_in_editmode();
            $pb->getPageBuilder()->handleRequest($_GET['route'] ?? null, $action);
            return;
        }

        // Asset / uploads
        $pb->handlePublicRequest();
    }

    /**
     * Frontend: bu URL için PB DB'sinde sayfa var mı? Varsa render et.
     */
    public static function tryRenderPublicPage(string $uri): bool
    {
        $pb = self::instance();
        return (bool)$pb->handlePublicRequest();
    }
}
