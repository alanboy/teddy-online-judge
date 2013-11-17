<?php

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ );
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . "/../www/" );

// Start session
session_start();

// Define configuration options
date_default_timezone_set('America/Mexico_City');
define("PATH_TO_BACKUPS", __DIR__ . "/../backups/");
define("LOGFILENAME", "../../bin/log");
require_once("config.php");

// Inlclude controllers
require_once("c_controller.php");
require_once("c_usuario.php");
require_once("c_problema.php");
require_once("c_sesion.php");
require_once("c_concurso.php");
require_once("c_ejecucion.php");

require_once("gui.php");

// Inlclude libs
require_once("c_mail.php");
require_once("c_backup.php");
require_once("lib/adodb_lite/adodb.inc.php");

require_once("utils.php");

require_once("includes/utils.php");

// Create a "SuperCage" to wrap all possible user input
// the SuperCage should be created before doing *anything* else
//$input = Inspekt::makeSuperCage();

// Connect to DB
$db = ADONewConnection('mysql');
$result = $db->Connect("$TEDDY_DB_SERVER", "$TEDDY_DB_USER", "$TEDDY_DB_PASS", "$TEDDY_DB_NAME");

