<?php

require_once("../../serverside/bootstrap.php");

if (!isset($_REQUEST['user'])) {
	utils::json_die("Missing user");
}

$usuario = addslashes( $_REQUEST['user'] );

$resultado = mysql_query ( "SELECT `userID` FROM `Usuario` where userID = '". $usuario ."' or mail = '". $usuario ."';" ) or die('Algo anda mal: ' . mysql_error());

if (mysql_num_rows($resultado) != 1) {
	utils::json_die("Este usuario no existe.");
}

$row = mysql_fetch_array($resultado);
$usuario = $row[0];

$token = md5("teddy-salt" . $usuario  . time());

mysql_query ( 
	"INSERT INTO LostPassword 
			(`userID` , `IP` , `Token` ) 
		VALUES 
			('{$usuario}', '" . $_SERVER['REMOTE_ADDR']. "', '{$token}'); " ) or die('Algo anda mal: ' . mysql_error());


//enviar correo electronico


echo "{ \"success\" : true }";


