<?php
declare(strict_types=1);

namespace App\Core;

class View
{
    private static array $shared = [];

    public static function share(string $key, mixed $value): void
    {
        self::$shared[$key] = $value;
    }

    public static function render(string $view, array $viewVars = [], string $layout = 'main'): void
    {
        $viewVars = array_merge(self::$shared, $viewVars);
        extract($viewVars, EXTR_SKIP);

        $viewFile = VIEWS_PATH . '/pages/' . $view . '.php';
        if (!file_exists($viewFile)) {
            $viewFile = VIEWS_PATH . '/' . $view . '.php';
        }

        if (!file_exists($viewFile)) {
            http_response_code(404);
            echo "View not found: $view";
            return;
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        $layoutFile = VIEWS_PATH . '/layouts/' . $layout . '.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    public static function partial(string $partial, array $viewVars = []): void
    {
        $viewVars = array_merge(self::$shared, $viewVars);
        extract($viewVars, EXTR_SKIP);
        $file = VIEWS_PATH . '/partials/' . $partial . '.php';
        if (file_exists($file)) require $file;
    }

    public static function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function redirect(string $url, int $status = 302): void
    {
        http_response_code($status);
        header("Location: $url");
        exit;
    }
}
