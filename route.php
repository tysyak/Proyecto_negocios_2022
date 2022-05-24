<?php
use Model\Router;
use Controller\RecetaController;

$router = new Router();

// RUTAS para vistas --------------------------------------

$router->get('/', function () use ($router) {
    $router->render('panel');
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

$router->get('/receta/editar', function ($params) use ($router){
    $datos = RecetaController::get_receta();

    $router->render('form_edit_recipe', (array)$datos);
});
$router->get('/receta/nueva', function ($params) use ($router){
    $router->render('form_new_recipe');
});

// Rutas exclusivas para JSON -----------------------------

 $router->get('/api/receta', function ($params) {
     $id = isset($params['id']) ? (int)$params['id'] : null;
     $limit = isset($params['limit']) ? (int)$params['limit'] : null;
     $offset = isset($params['limit']) ? (int)$params['limit'] : null;
     RecetaController::get_receta_json($id, $limit, $offset);
 });

$router->get('/api/receta/titulo', function ($params) {
    $titulo = $params['titulo'] ?? null;
    RecetaController::get_id_receta_by_title($titulo);
});


 $router->post('/api/receta/nuevo', function ($params) {
     $titulo = $params['titulo'];
     $pasos = $params['pasos'];
     $materiales = $params['materiales'];
     $image = $params['prev_image'] ;
     RecetaController::new_receta($titulo,$pasos,$materiales,$image);
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

$router->run();
