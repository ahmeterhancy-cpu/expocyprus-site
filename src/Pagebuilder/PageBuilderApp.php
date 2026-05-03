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
            // PHPagebuilder PHP 8.3 ile dynamic property uyarıları üretir; suppress et
            error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
            $config = require BASE_PATH . '/config/pagebuilder.php';
            self::$instance = new PHPageBuilder($config);
        }
        return self::$instance;
    }

    /**
     * Mevcut URL bir PageBuilder URL'i mi?
     * /admin/pagebuilder/edit, /uploads/pagebuilder/*, /pb-assets/* (vendor dist alias)
     */
    public static function isPageBuilderUrl(string $uri): bool
    {
        $uri = explode('?', $uri, 2)[0];
        return str_starts_with($uri, '/admin/pagebuilder/edit')
            || str_starts_with($uri, '/uploads/pagebuilder/')
            || str_starts_with($uri, '/pb-assets/');
    }

    /**
     * PageBuilder request'i handle et.
     * - /pb-assets/* ve /uploads/pagebuilder/* → public asset (auth yok)
     * - /admin/pagebuilder/edit → admin login zorunlu
     */
    public static function handleAuthenticatedRequest(): void
    {
        $pb = self::instance();
        $uri = explode('?', $_SERVER['REQUEST_URI'] ?? '/', 2)[0];

        // Public asset URL'leri için auth yok
        $isPublicAsset = str_starts_with($uri, '/pb-assets/')
                      || str_starts_with($uri, '/uploads/pagebuilder/');

        if (!$isPublicAsset) {
            $auth = new AdminAuthBridge();
            if (!$auth->isAuthenticated()) {
                header('Location: /admin/login');
                exit;
            }
        }

        $action = $_GET['action'] ?? null;

        try {
            if (\phpb_in_module('pagebuilder')) {
                \phpb_set_in_editmode();
                $pb->getPageBuilder()->handleRequest($_GET['route'] ?? null, $action);
                return;
            }

            // Asset / uploads
            $pb->handlePublicRequest();
        } catch (\Throwable $e) {
            // Hatayı görünür yap (sessiz die yerine)
            http_response_code(500);
            header('Content-Type: text/html; charset=utf-8');
            echo "<h1>PageBuilder Error</h1>";
            echo "<pre style='background:#fee;padding:1em;border:1px solid #c00;'>";
            echo "Message: " . htmlspecialchars($e->getMessage()) . "\n";
            echo "File:    " . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . "\n\n";
            echo "Trace:\n" . htmlspecialchars($e->getTraceAsString());
            echo "</pre>";
        }
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
