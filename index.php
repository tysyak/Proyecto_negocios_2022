<?php
session_start();


require_once 'conf/constants.php';


/** Carga las clases y controladores */
function load_model(string $class_name)
{
    $class_name = str_replace('\\','/',$class_name);
    $path_to_file = PATH.'/recetario/'.$class_name.'.class.php';
    if (PHP_OS == 'WINNT') {
        $path_to_file = str_replace('\\','/',$path_to_file);
    }

    if (file_exists(str_replace('\\','/',$path_to_file))) {

        require $path_to_file;
    }
    $path_to_file = PATH.'/recetario/'.$class_name.'.php';

    if (file_exists($path_to_file)) {
        require $path_to_file;
    }
}

spl_autoload_register('load_model');

require_once 'route.php';
