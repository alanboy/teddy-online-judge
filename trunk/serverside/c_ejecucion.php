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

	public static function  status($request)
	{
		$sql = "SELECT `status`  FROM `Ejecucion` where execID = ? limit 1";

		global $db;
		$data = array( $request["execID"] );
		$result = $db->Execute($sql, $data)->GetArray();

		return array(
				"result" => "ok", 
				"status" => $result[0][0]
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
			return array("result" => "error", "reason" => "Debes iniciar sesion para poder enviar problemas.");
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

		global $db;
		$sql = "select probID from Problema where BINARY ( probID = ? AND publico = 'SI') ";
		$inputarray = array($request["id_problema"]);
		$resultado = $db->Execute($sql, $inputarray);

		if ($resultado->RecordCount() == 0)
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
			case "php"      : $lang_desc = "Php";   break;
			default:
				return array("result" => "error", "reason" =>"Este no es un lenguaje reconocido por Teddy.");
		}

		/**
		 * @todo
		 * - vamos a ver si estoy en un concurso, y si estoy en un concurso, que ese problema pertenesca a ese concurso 
		 * - vamos a ver que no haya enviado hace menos de 5 min si esta en un concurso
		 * - insertar un nuevo run y obtener el id insertado, como estado, hay que ponerle uploading
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

		$result = $db->Execute($sql, $inputarray);

		// Si hacemos esto $execID = $db->Insert_ID( ); hay un Overflow porque los ids son muy grandes
		$sql = "select execID from Ejecucion where ( userId = ? ) order by fecha DESC LIMIT 1";
		$inputarray = array($usuario);
		$resultado = $db->Execute($sql, $inputarray)->GetArray();
		$execID = $resultado[0]["execID"];


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

