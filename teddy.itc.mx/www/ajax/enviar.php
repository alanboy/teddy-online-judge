<?php


require_once("../bootstrap.php");


if(!isset($_SESSION["userID"])){
	utils::json_die("Debes iniciar sesion para poder enviar problemas.");
}


if(!(isset($_REQUEST['id_problema']) && isset($_REQUEST['lang']))){
	utils::json_die("Faltan parametros.");
}
	

	
if(empty($_FILES) && !isset($_REQUEST["plain_source"])) {
	utils::json_die("No se envio el codigo fuente.");
}





/**
 * Hay dos maneras de enviar un codigo fuente.
 *
 * 1) Ajax
 * 2) POST
 *
 * Otros parametros
 * id_problema int el id del problema a resolver
 * id_concurso int el id del concurso si es que este run pertenece a un concurso
 * lang String el identificador del lenguaje ( c,cpp,java,py,php,pl)
 * */
$usuario 		= $_SESSION["userID"];
$id_problema   	= stripslashes($_REQUEST["id_problema"]);
$lang   		= stripslashes($_REQUEST["lang"]);


if(isset($_REQUEST["id_concurso"])){
	$id_concurso   	= stripslashes($_REQUEST["id_concurso"]);	

}else{
	$id_concurso   	= null;

}







//buscar el id de este problea y que sea publico
//revisar si existe este problema
$consulta = "select probID , titulo from Problema where BINARY ( probID = '{$id_problema}' AND publico = 'SI') ";
$resultado = mysql_query( $consulta ) or utils::json_die("Error al buscar el problema en la BD.");


//insertar un nuevo run y obtener el id insertado
//como estado, hay que ponerle uploading
if(mysql_num_rows($resultado) == 0) {
	utils::json_die("Este problema no existe !");
}

$lang_desc = null;

switch($lang){
	case "java"	: $lang_desc = "JAVA"; 	break;
	case "c"	: $lang_desc = "C"; 	break;
	case "cpp"	: $lang_desc = "C++"; 	break;
	case "py"	: $lang_desc = "Python"; break;
	case "cs"	: $lang_desc = "C#"; 	break;
	case "pl"	: $lang_desc = "Perl"; 	break;	
	default:
		utils::json_die("Este no es un lenguaje reconocido por Teddy.");
}



/**
 * @todo
 * -vamos a ver si estoy en un concurso, y si estoy en un concurso, que ese problema pertenesca a ese concurso 
 * -vamos a ver que no haya enviado hace menos de 5 min si esta en un concurso
 * 
 **/


//insertar userID, probID, remoteIP
if($id_concurso === null){
	$q = "INSERT INTO Ejecucion (`userID`, `status`, `probID` , `remoteIP`, `LANG`, `fecha`  ) 
			VALUES (
				'{$usuario}', 
				'WAITING', 
				{$id_problema}, 
				'" . $_SERVER['REMOTE_ADDR']. "', 
				'{$lang_desc}', 
				'".  date("Y-m-d H:i:s", mktime(date("H"), date("i") )) ."'
			); ";

}else{
	$q = "INSERT INTO Ejecucion (`userID` ,`status`, `probID` , `remoteIP`, `LANG`, `Concurso`, `fecha`  ) 
			VALUES (
				'{$usuario}',
				'WAITING', 
				{$id_problema}, 
				'" . $_SERVER['REMOTE_ADDR']. "', 
				'{$lang_desc}', 
				{$id_concurso}, 
				'".  date("Y-m-d H:i:s", mktime(date("H"), date("i") )) ."'
			); ";

}
	


mysql_query ( $q ) or utils::json_die("Error al escribir el nuevo run en la BD.");

//get latest ID
$execID = mysql_insert_id();



$resultado = mysql_query ( "SELECT `execID` 
							FROM `Ejecucion` 
							order by `fecha` 
							desc limit 1;" ) or utils::json_die("Error al escribir el nuevo run en la BD.");

$row = mysql_fetch_array ( $resultado );

$execID = $row["execID"];




/**
 * GUARDAR EL ARCHIVO
 * Ok vamos a guardar el archivo
 * 
 * */
if(!empty($_FILES)){
	//se nos envio un archivo
	if (!move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../codigos/" . $execID . "." . $lang  )){
		utils::json_die("Whoops, error al subir el archivo");
	}
	
}else{
	//se envio el codigo fuente
	if( file_put_contents("../../codigos/".$execID . "." . $lang, $_REQUEST['plain_source']) === false){
		utils::json_die("Whoops, error al subir el archivo");
	}
}

die(json_encode(array( "success" => true, "execID" => $execID )));

	
