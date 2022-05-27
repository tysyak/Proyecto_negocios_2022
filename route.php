<?php

use Controller\SuscripcionController;
use Model\Router;
use Controller\RecetaController;
use Controller\UsuarioController;

$router = new Router();

// RUTAS para vistas --------------------------------------

$router->get('/recetas', function ($params) use ($router) {
    $data = isset($params['f']) ? ['f' => (bool)$params['f']] : ['f' => false];
    $router->render('panel', $data);
});

$router->get('/receta', function ($params) use ($router) {
    if (isset($params['id'])) {
        $id_usuario = isset($_SESSION['username'])
            ? UsuarioController::get_id_usuario($_SESSION['username']) : null;

        $router->render('receta', RecetaController::get_receta(
            id: $params['id'],
            id_usuario: $id_usuario
        ));
    } else {
        $router->render('404');
    }
});

$router->get('/', function() use ($router) {
    $router->render('/landing');
});

$router->get('/about', function () use ($router) {
    $router->render('about');
});

$router->get('/contacto', function () use ($router) {
    $router->render('contacto');
});

$router->get('/subscripcion', function () use ($router) {
    $router->render('subscripcion');
});

$router->get('/subscripcion/nuevo', function () use ($router) {
    if (isset($_SESSION['username'])) {
        $data = SuscripcionController::get_all();
        $router->render('form-pago', $data);
    } else {
        $router->render('/login');
    }
});

$router->get('/login', function () use ($router) {
    if (!isset($_SESSION['username'])) {
        $router->render('/login');
    } else {
        header('HTTP/1.0 404 Not Found');
        $router->render('/');
    }
});

$router->add_not_found_handler(function () use ($router) {
    $router->render('404');
});

$router->get('/receta/editar', function ($params) use ($router){
    if (isset($_SESSION['username'])) {
        $datos_receta = RecetaController::get_receta(
            id_usuario:  $_SESSION['id_usuario'],
            only_user: true);
        $datos = (isset($params['id_receta'])) ?
            ['id_receta' =>  (int)$params['id_receta'], 'recetas' => $datos_receta]
            : ['recetas' => $datos_receta];
        $router->render('form_edit_recipe', $datos);
    } else {
        header('HTTP/1.0 401 Unauthorized');
        $router->render('401');
    }
});

$router->get('/receta/nueva', function () use ($router){
    if (isset($_SESSION['username'])) {
        $router->render('form_new_recipe');
    } else {
        header('HTTP/1.0 401 Unauthorized');
        $router->render('401');
    }
});


$router->get('/logout', function () use ($router) {
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['id_usuario']);
    $router->render('logout');


});

// Rutas exclusivas para JSON -----------------------------

 $router->get('/api/receta', function ($params) {
     $id = isset($params['id']) ? (int)$params['id'] : null;
     $only_fav = isset($params['f']);
     $id_usuario = isset($params['username'])
         ? UsuarioController::get_id_usuario($params['username']) : null;
     $limit = isset($params['limit']) ? (int)$params['limit'] : null;
     $offset = isset($params['limit']) ? (int)$params['limit'] : null;
     RecetaController::get_receta_json(
         id: $id,
         id_usuario: $id_usuario,
         limit: $limit,
         offset: $offset,
         only_fav: $only_fav
     );
 });

$router->get('/api/receta/titulo', function ($params) {
    $titulo = $params['titulo'] ?? null;
    RecetaController::get_id_receta_by_title($titulo);
});

$router->get('/api/esfavorito', function ($params) {
    if (isset($_SESSION['username'])) {
            $id_receta = (int)$params['id_receta'];
            $username = $params['username'];
            UsuarioController::cambiar_favorito($username, $id_receta);
    } else{
        echo json_encode([
            'status' => 401,
            'action' => 'nope',
            'msg' => 'No has iniciado sessión'
        ]);
    }
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

$router->post('/api/subscripcion/usuario/registrar', function ($params) {
    if (isset($_SESSION['username'])) {
        $id_sub = $params['sub'];
        $id_usuario = UsuarioController::get_id_usuario($_SESSION['username']);
        SuscripcionController::nueva_sub($id_sub, $id_usuario);
    }  else {
        echo json_encode([
            'status' => 401,
            'action' => 'nope',
            'msg' => 'No has iniciado sessión'
        ]);
    }
});

$router->get('/api/suscripcion/info', function ($params) {
    if (isset($_SESSION['username'])) {
        $id_sub = $_SESSION['id_sub'];
        $id_usuario = UsuarioController::get_id_usuario($_SESSION['username']);
        SuscripcionController::get_info_sub($id_usuario, true);
    }  else {
        echo json_encode([
            'status' => 200,
            'action' => 'nope',
            'msg' => 'No has iniciado sessión'
        ]);
    }
});

$router->post('/api/suscripcion/usuario/info', function () {
    if (isset($_SESSION['username'])) {
        $id_usuario = UsuarioController::get_id_usuario($_SESSION['username']);
        if(SuscripcionController::tiene_sub_activa($id_usuario)['resp']) {
            SuscripcionController::get_info_sub($id_usuario, true);
        }
    }  else {
        echo json_encode([
            'status' => 200,
            'action' => 'nope',
            'msg' => 'No has iniciado sessión'
        ]);
    }
});


$router->post('/api/session/login', function ($params) {
    $username = $params['username'];
    $password = $params['password'];
    UsuarioController::begin_session($username, $password);
});

$router->run();
