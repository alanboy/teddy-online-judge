<?php

require_once("../bootstrap.php");


if(isset($_REQUEST['execID'])){
	$execID = addslashes($_REQUEST['execID']);	

}else{
	utils::json_die("Faltan parametros.");

}

$res = mysql_query("SELECT * FROM `Ejecucion` WHERE execID = '{$execID}' LIMIT 1");

if(mysql_num_rows($res) == 0)
{
	utils::json_die("Este run no existe.");
}

die(json_encode(mysql_fetch_assoc($res)));
