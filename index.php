<?php
require __DIR__ . '/vendor/autoload.php';
use App\Router\Frontend;
mail("serey.chhim@gmail.com", "Sujet", "Le message\nligne2");

try {
    $router = new \App\Router\frontend\Router();
    $router->method();
    $router->run();
} catch
(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
