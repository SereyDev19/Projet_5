<?php

require('controller/frontend.php');
require('router/frontend/router.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            listPosts(true);
        }
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}


require('controller/backend.php');
require('router/router.php');


try {
    $router = new \SC19DEV\App\Router\Frontend\Router();
    $router->method();
    $router->run();
} catch
(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
