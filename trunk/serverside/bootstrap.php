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
require_once("controllers/c_controller.php");
require_once("controllers/c_usuario.php");
require_once("controllers/c_problema.php");
require_once("controllers/c_sesion.php");
require_once("controllers/c_concurso.php");
require_once("controllers/c_ejecucion.php");
require_once("controllers/c_mail.php");
require_once("controllers/c_backup.php");
require_once("controllers/c_mensaje.php");

// Inlclude libs
require_once("gui.php");
require_once("lib/adodb/adodb.inc.php");
require_once("utils.php");
require_once("lib/Logger.php");

if (file_exists("Mail.php")) {
	require_once "Mail.php";
}

if (isset($TEDDY_LOG)) {
	Logger::$file = $TEDDY_LOG;
}

if (array_key_exists("REQUEST_URI", $_SERVER)) {
	Logger::info("REQUEST:" . $_SERVER["REQUEST_URI"]);
}else{
	Logger::info("CLI");
}

// Connect to DB
$db = ADONewConnection('mysql');

try{
	$result = $db->Connect( $TEDDY_DB_SERVER, $TEDDY_DB_USER, $TEDDY_DB_PASS, $TEDDY_DB_NAME);

	if ($result == false) {
		Logger::error("No db connection");
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		die();
	}
	
}catch(Exception $e){
	Logger::error("No db connection");
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	die();
}

