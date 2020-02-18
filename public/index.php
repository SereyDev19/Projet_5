<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Router\Frontend\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


try {
    $router = new \App\Router\Router();
    $router = new Router();
    $router->method();
    $router->run();
} catch
(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
