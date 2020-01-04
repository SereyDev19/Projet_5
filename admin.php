<?php
require('controller/backend.php');
require('router/router.php');
try {
    $router = new \SC19DEV\App\Router\Router();
    $router->method();
    $router->run();
} catch
(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}