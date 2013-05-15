<?php

require_once("../www/bootstrap.php");

//
// Seleccionar los problemas
//
$query = "SELECT * FROM `Problema` 
	where 
	publico = \"SI\"
	and aceptados > 2
	and probID != 1
	and probID != 6
	and probID != 554
	order by dailyContest asc, rand()
	limit 4";

$result = mysql_query($query) or die(mysql_error());
$sProblems = "";
$sSqlIncrementarCuenta = "";

while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	$sProblems .= $row["probID"] . " ";

	if(strlen($sSqlIncrementarCuenta) > 0) {
		$sSqlIncrementarCuenta .= " OR";
	}
	$sSqlIncrementarCuenta .= " probID = '". $row["probID"] ."'";
}

//
// Subir la cuenta de uso para esos problemas.
//
mysql_query( "update Problema set dailyContest = dailyContest+1 where " . $sSqlIncrementarCuenta. ";");

//
// Insertar el nuevo concurso
//
$query = "INSERT INTO `teddy`.`Concurso` 
(
	`CID`,
	`Titulo`, 
	`Descripcion`, 
	`Inicio`, 
	`Final`, 
	`Problemas`, 
	`Owner`
)
VALUES
(
	NULL, 
	'Daily Contest  " . date('z') ."', 
	'Concurso diario abierto. Todos pueden participar.', 
	'".date("Y-m-d")." 20:00:00', 
	'".date("Y-m-d")." 22:00:00', 
	'".trim($sProblems)."', 
	'teddyOJ'
);";

mysql_query($query) or die(mysql_error());

