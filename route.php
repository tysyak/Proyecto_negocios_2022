<?php
use Model\Router;
use Controller\RecetaController;

$router = new Router();

// Index
$router->get('/', function () use ($router) {
    $router->render('panel');
});

// Ejemplo con parametros en GEt
 $router->get('/api/receta', function ($params) {
     $id = $params['id'] ?? null;
     RecetaController::get_receta($id, RecetaController::JSON_MODE);
 });

$router->get('/api/receta/titulo', function ($params) {
    $titulo = $params['titulo'] ?? null;
    RecetaController::get_id_receta_by_title($titulo, RecetaController::JSON_MODE);
});

$router->get('/receta/editar', function ($params) use ($router){
    $datos = RecetaController::get_receta();
    $router->render('form_edit_recipe', (array)$datos);
});

 $router->post('/api/receta/nuevo', function ($params) {

 });

$router->post('/api/receta/editar', function ($params) {

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
