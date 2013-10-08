<?php

date_default_timezone_set('America/Mexico_City');

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ );
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . "/../www/" );

if (isset($_REQUEST['sid'])) {
	session_id($_REQUEST['sid']);
}
$PATH_TO_BACKUPS = __DIR__ . "/../backups/";

define("LOGFILENAME", "../../bin/log");

session_start();

require_once("config.php");

$enlace = mysql_connect(
            $TEDDY_DB_SERVER, 
            $TEDDY_DB_USER, 
            $TEDDY_DB_PASS) or die( "Error al conectar con la Base de Datos" );

mysql_select_db($TEDDY_DB_NAME) or die('No pudo seleccionarse la base de datos.');

require_once("c_backup.php");

require_once("includes/utils.php");

function TEDDY_LOG($s)
{
    error_log("TEDDY: " . $s);
}

