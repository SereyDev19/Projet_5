<?php
require __DIR__ . '/vendor/autoload.php';



use App\Router;

try {
    $router = new \App\Router\Router();
    $router->method();
    $router->run();
} catch
(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}