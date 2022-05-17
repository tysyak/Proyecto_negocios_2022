<?php
session_start();


require_once 'conf/constants.php';

/** Carga las clases y controladores */
function load_model(string $class_name)
{
    $class_name = str_replace('\\','/',$class_name);
    $path_to_file = PATH.'/recetario/'.$class_name.'.class.php';

    if (file_exists($path_to_file)) {
        require $path_to_file;
    }
    $path_to_file = PATH.'/recetario/'.$class_name.'.php';

    if (file_exists($path_to_file)) {
        require $path_to_file;
    }
}

spl_autoload_register('load_model');

use Controller\RecetaController;
use Model\Router;


$router = new Router();



// Index
$router->get('/', function () use ($router) {
    $router->render('panel');
});

// Ejemplo con parametros en POST
 $router->post('/api/receta', function ($params) {
     $id = $params['id'] ?? null;
     header('Content-Type: application/json');
     RecetaController::get_receta($id);
 });

$router->get('/about', function () use ($router) {
    $router->render('about');
});

$router->get('/contacto', function () use ($router) {
    $router->render('contacto');
});

$router->add_not_found_handler(function () use ($router) {
    $router->render('404');
});

$router->run();
