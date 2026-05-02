<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array  $routes = [];
    private string $prefix = '';
    private array  $groupMiddleware = [];

    public function get(string $uri, array $handler, array $middleware = []): void
    {
        $this->add('GET', $uri, $handler, $middleware);
    }

    public function post(string $uri, array $handler, array $middleware = []): void
    {
        $this->add('POST', $uri, $handler, $middleware);
    }

    public function group(string $prefix, array $middleware, callable $cb): void
    {
        $prevPrefix = $this->prefix;
        $prevMw     = $this->groupMiddleware;
        $this->prefix = $prevPrefix . $prefix;
        $this->groupMiddleware = array_merge($prevMw, $middleware);
        $cb($this);
        $this->prefix = $prevPrefix;
        $this->groupMiddleware = $prevMw;
    }

    private function add(string $method, string $uri, array $handler, array $mw): void
    {
        $this->routes[] = [
            'method'     => $method,
            'uri'        => $this->prefix . $uri,
            'handler'    => $handler,
            'middleware' => array_merge($this->groupMiddleware, $mw),
        ];
    }

    public function dispatch(Request $req): void
    {
        $uri    = $this->normalize($req->path());
        $method = $req->method();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;
            $params = $this->match($route['uri'], $uri);
            if ($params === null) continue;

            foreach ($route['middleware'] as $mwClass) {
                (new $mwClass())->handle($req);
            }

            [$class, $action] = $route['handler'];
            (new $class())->$action($req, $params);
            return;
        }

        // Bilinen route bulunamadı — PHPagebuilder DB'sinde bu URL için sayfa var mı?
        if ($this->tryRenderPagebuilderPage($uri)) {
            return;
        }

        $this->send404($req);
    }

    /**
     * PHPagebuilder DB'sinde route eşleşen sayfa varsa render et.
     */
    private function tryRenderPagebuilderPage(string $uri): bool
    {
        if (!class_exists(\App\Pagebuilder\PageBuilderApp::class)) return false;
        try {
            return \App\Pagebuilder\PageBuilderApp::tryRenderPublicPage($uri);
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function normalize(string $uri): string
    {
        $uri = '/' . trim($uri, '/');
        return $uri === '/' ? $uri : rtrim($uri, '/');
    }

    private function match(string $pattern, string $uri): ?array
    {
        $regex = preg_replace('#/:([a-zA-Z_]+)#', '/(?P<$1>[^/]+)', $pattern);
        if (!preg_match('#^' . $regex . '$#i', $uri, $m)) return null;
        return array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
    }

    private function send404(Request $req): void
    {
        http_response_code(404);
        View::render('pages/404', ['lang' => lang()], 'main');
    }
}
