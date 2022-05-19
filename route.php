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
$router->get('/receta/nueva', function ($params) use ($router){
    $router->render('form_new_recipe');
});

 $router->post('/api/receta/nuevo', function ($params) {

 });

$router->post('/api/receta/editar', function ($params) {
    $id_receta = (int) $params['id_receta'];
    $titulo = $params['titulo'];
    $pasos = $params['pasos'];
    $materiales = $params['materiales'];
    $borrar_imagen = isset($params['borrar_imagen']);
    $image = !$borrar_imagen ? $params['prev_image'] : null;
    RecetaController
        ::update_receta($id_receta,$titulo,$pasos,$materiales,$image, $borrar_imagen);
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
