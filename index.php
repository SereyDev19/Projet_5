<?php
require __DIR__ . '/vendor/autoload.php';

use App\Router\Frontend;

try {
    $router = new \App\Router\frontend\Router();
    $router->method();
    $router->run();
} catch
(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
