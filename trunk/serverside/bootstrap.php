<?php

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ );
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . "/../www/" );
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . "/../views/" );

// Start session
session_start();

// Define configuration options
date_default_timezone_set('America/Mexico_City');

define("PATH_TO_BACKUPS", __DIR__ . "/../backups/");


require_once("config.php");

// Inlclude controllers
require_once("c_controller.php");
require_once("c_usuario.php");
require_once("c_problema.php");
require_once("c_sesion.php");
require_once("c_concurso.php");
require_once("c_ejecucion.php");
require_once("c_mail.php");
require_once("c_backup.php");


// Inlclude libs
require_once("gui.php");
require_once("lib/adodb_lite/adodb.inc.php");
require_once("utils.php");
require_once "Mail.php";


// Connect to DB
$db = ADONewConnection('mysql');
$result = $db->Connect( $TEDDY_DB_SERVER, $TEDDY_DB_USER, $TEDDY_DB_PASS, $TEDDY_DB_NAME);
