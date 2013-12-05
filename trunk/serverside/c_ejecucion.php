<?php

class c_ejecucion extends c_controller
{
	public static function  lista()
	{
		$sql = "SELECT `execID`, `userID`, `probID`, `status`, `tiempo`, `fecha`, `LANG`, `Concurso`  FROM `Ejecucion` order by fecha desc limit 100";

		global $db;
		$result = $db->Execute($sql);

		return array(
				"result" => "ok", 
				"runs" => $result->GetArray()
			);
	}


	/**
	 * @param id_problema int el id del problema a resolver
	 * @param id_concurso int el id del concurso si es que este run pertenece a un concurso
	 * @param lang String el identificador del lenguaje ( c,cpp,java,py,php,pl)
	 * */
	public static function nuevo($request)
	{
		if (!isset($_SESSION["userID"]))
		{
			return array("result" => "error", "reason" =>"Debes iniciar sesion para poder enviar problemas.");
		}

		if (!(isset($request['id_problema']) && isset($request['lang'])))
		{
			return array("result" => "error", "reason" => "Faltan parametros");
		}

		if (empty($_FILES) && !isset($request["plain_source"]))
		{
			return array("result" => "error", "reason" => "No se envio el codigo fuente.");
		}

		$usuario      = $_SESSION["userID"];
		$id_problema  = stripslashes($_REQUEST["id_problema"]);
		$lang         = stripslashes($_REQUEST["lang"]);

		if (isset($_REQUEST["id_concurso"]))
		{
			$id_concurso  = stripslashes($_REQUEST["id_concurso"]);
		}
		else
		{
			$id_concurso  = null;
		}

		// @todo Reescribir esto:
		//buscar el id de este problea y que sea publico
		//revisar si existe este problema
		$consulta = "select probID , titulo from Problema where BINARY ( probID = '{$id_problema}' AND publico = 'SI') ";
		$resultado = mysql_query( $consulta ) or utils::json_die("Error al buscar el problema en la BD.");

		//insertar un nuevo run y obtener el id insertado
		//como estado, hay que ponerle uploading
		if (mysql_num_rows($resultado) == 0)
		{
			return array("result" => "error", "reason" => "El problema no existe.");
		}

		$lang_desc = null;

		switch($lang)
		{
			case "java"     : $lang_desc = "JAVA";  break;
			case "c"        : $lang_desc = "C";     break;
			case "cpp"      : $lang_desc = "C++";   break;
			case "py"       : $lang_desc = "Python";break;
			case "cs"       : $lang_desc = "C#";    break;
			case "pl"       : $lang_desc = "Perl";  break;
			default:
				return array("result" => "error", "reason" =>"Este no es un lenguaje reconocido por Teddy.");
		}

		/**
		 * @todo
		 * -vamos a ver si estoy en un concurso, y si estoy en un concurso, que ese problema pertenesca a ese concurso 
		 * -vamos a ver que no haya enviado hace menos de 5 min si esta en un concurso
		 * 
		 **/
		if ($id_concurso === null)
		{
			$sql = "INSERT INTO Ejecucion (`userID`, `status`, `probID` , `remoteIP`, `LANG`, `fecha`  ) 
									VALUES (?, 'WAITING', ?, ?, ?, ?);";

			$inputarray = array( $usuario, $id_problema, $_SERVER['REMOTE_ADDR'], $lang_desc, date("Y-m-d H:i:s", mktime(date("H"), date("i") )));
		}
		else
		{
			$sql = "INSERT INTO Ejecucion (`userID` ,`status`, `probID` , `remoteIP`, `LANG`, `Concurso`, `fecha`  ) 
									VALUES (?, 'WAITING', ?, ?, ?, ?, ?);";
			
			$inputarray = array( $usuario, $id_problema, $_SERVER['REMOTE_ADDR'], $lang_desc, $id_concurso, date("Y-m-d H:i:s", mktime(date("H"), date("i") )));
		}

		global $db;
		$result = $db->Execute($sql, $inputarray);

		// @TODO Overflow
		$execID = $db->Insert_ID( );

		if (!empty($_FILES))
		{
			if (!move_uploaded_file($_FILES['Filedata']['tmp_name'], "../../codigos/" . $execID . "." . $lang  ))
			{
				return array("result" => "error", "reason" => "Error al subir el archivo");
			}

		}
		else
		{
			if (!is_dir("../codigos/"))
			{
				return array("result" => "error", "reason" => "El directorio de codigos no existe.");
			}

			if (!is_writable("../codigos/"))
			{
				return array("result" => "error", "reason" => "No se puede escribir en el directorio de codigos.");
			}

			// Crear un archivo y escribir el contenido
			if (file_put_contents("../codigos/".$execID . "." . $lang, $_REQUEST['plain_source']) === false)
			{
				return array("result" => "error");
			}
		}

		return array("result" => "ok", "execID" => $execID);
	}


}

