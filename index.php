<?php
session_start();

// TODO: Automatic require for extension *.class.php
require_once 'conf/constants.php';
require_once 'recetario/Model/Usuario.class.php';
require_once 'recetario/Model/DataBase.class.php';

require_once("recetario/view/panel.view.php");
