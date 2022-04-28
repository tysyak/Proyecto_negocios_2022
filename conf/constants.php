<?php
namespace Conf\Constants;

// prod, dev
define('ENV', 'dev');

// path: ubicacion real del proyecto
define('PATH', __FILE__.'/..');

// Configuracion de la base de datos, PDO


switch (ENV) {
    case 'prod':
        define('DRIVER', 'mysql');
        define('HOST', 'localhost');
        define('DBNAME', 'recipes');
        define('PORT', '3306');
        define('USER_DB', 'chef');
        define('PASS_DB', 'Hola1234!');
        define('SITIO', 'http://fxarch.proyecto_neg.site/');
        break;
    default:
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        define('DRIVER', 'mysql');
        define('HOST', 'localhost');
        define('DBNAME', 'recipes');
        define('PORT', '3306');
        define('USER_DB', 'chef');
        define('PASS_DB', 'Hola1234!');
        define('SITIO', 'http://fxarch.proyecto_neg.site/');
}
