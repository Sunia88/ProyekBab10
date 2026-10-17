<?php
// public/index.php - FRONT CONTROLLER: satu pintu masuk semua request
declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
require BASE_PATH . '/core/autoload.php';

session_start();

$router = new Core\Router();
require BASE_PATH . '/routes.php';            // daftarkan rute

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($_SERVER['REQUEST_METHOD'], $path);
