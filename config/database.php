<?php
declare(strict_types=1);

$pdoOptions = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
// PHP 8.4 ile PDO::MYSQL_ATTR_INIT_COMMAND yerini Pdo\Mysql::ATTR_INIT_COMMAND aldi;
// 8.5'te eski sabit deprecated ve ciktinin en basina uyari basiyor (header/HTML bozuluyor).
$initCommand = "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci";
if (defined('Pdo\Mysql::ATTR_INIT_COMMAND')) {
    $pdoOptions[constant('Pdo\Mysql::ATTR_INIT_COMMAND')] = $initCommand;
} elseif (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
    $pdoOptions[constant('PDO::MYSQL_ATTR_INIT_COMMAND')] = $initCommand;
}

return [
    'driver'   => 'mysql',
    'host'     => env('DB_HOST', 'localhost'),
    'port'     => (int) env('DB_PORT', 3306),
    'database' => env('DB_NAME', 'expocyprus'),
    'username' => env('DB_USER', 'root'),
    'password' => env('DB_PASS', ''),
    'charset'  => 'utf8mb4',
    'options'  => $pdoOptions,
];
