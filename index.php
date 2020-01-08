<?php

require('router/frontend/router.php');
require('router/router.php');

try {
    $router = new \SC19DEV\App\Router\Frontend\Router();
    $router->method();
    $router->run();
} catch
(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
