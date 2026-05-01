<?php
declare(strict_types=1);

namespace App\Core;

class Application
{
    private static Application $instance;
    public Router  $router;
    public Request $request;
    public array   $config = [];

    public function __construct()
    {
        self::$instance = $this;
        $this->config['app'] = require BASE_PATH . '/config/app.php';
        $this->config['db']  = require BASE_PATH . '/config/database.php';

        date_default_timezone_set($this->config['app']['timezone']);
        ini_set('display_errors', $this->config['app']['debug'] ? '1' : '0');
        error_reporting($this->config['app']['debug'] ? E_ALL : 0);

        Session::start();
        $this->request = new Request();
        $this->router  = new Router();

        Lang::detect($this->request);
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function run(): void
    {
        require_once BASE_PATH . '/config/routes.php';
        $this->router->dispatch($this->request);
    }

    public function config(string $key, mixed $default = null): mixed
    {
        $parts = explode('.', $key);
        $value = $this->config;
        foreach ($parts as $part) {
            if (!is_array($value) || !array_key_exists($part, $value)) return $default;
            $value = $value[$part];
        }
        return $value;
    }
}
