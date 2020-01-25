<?php
require __DIR__ . '/vendor/autoload.php';


use App\Router\Frontend\Router;
//use App\Router\Router;
//require_once(__DIR__ . '/src/Router/Frontend/router.php');

try {
    $router = new Router();
//    $router = new Router();
    $router->method();
    $router->run();
} catch
(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
