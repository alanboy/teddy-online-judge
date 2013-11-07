<?php

date_default_timezone_set('America/Mexico_City');

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ );
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . "/../www/" );

if (isset($_REQUEST['sid']))
{
	session_id($_REQUEST['sid']);
}
$PATH_TO_BACKUPS = __DIR__ . "/../backups/";

define("LOGFILENAME", "../../bin/log");

session_start();

require_once("config.php");


// controllers
require_once("c_controller.php");
require_once("c_usuario.php");

// libs
require_once("c_mail.php");
require_once("c_backup.php");
require_once("lib/adodb_lite/adodb.inc.php");

require_once("includes/utils.php");

$db = ADONewConnection('mysql');
$result = $db->Connect("$TEDDY_DB_SERVER", "$TEDDY_DB_USER", "$TEDDY_DB_PASS", "$TEDDY_DB_NAME");



