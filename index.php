<?php
session_start();


require_once 'conf/constants.php';

require_once 'recetario/Model/Router.class.php';

use Model\Router;

$router = new Router();

// Index
$router->get('/', function () { require_once __DIR__.'/recetario/view/panel.view.php';
});

// Ejemplo con parametros en GET
$router->get('/about', function (array $params) {
    echo 'About';
    echo '<h1>'. $params['parametro']. '</h1>';
});

$router->add_not_found_handler(function () {
    $title = '404 No se encuentra lo que buscas, verifica la URL';
    require_once __DIR__.'/recetario/view/404.view.php';
});

$router->run();