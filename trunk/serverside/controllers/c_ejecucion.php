<?php

class c_ejecucion extends c_controller
{
	public static function details($request)
	{
		$sql = "SELECT *  FROM `Ejecucion` where execID = ? limit 1";

		global $db;
		$data = array( $request["execID"] );
		$result = $db->Execute($sql, $data)->GetArray();

		return array(
				"result" => "ok", 
				"run" => $result[0]
			);
	}

	public static function canUserViewRun()
	{
		global $enlace;
		$asdf =  mysql_real_escape_string($_REQUEST["execID"]);
		$consulta = "select * from Ejecucion where BINARY ( execID = '{$asdf}' )";
		$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());
	
		if(mysql_num_rows($resultado) != 1){
			return false;
		}

		$row = mysql_fetch_array($resultado);

		if(!isset($_SESSION['userID'])){
			return false;
		}

		if( ($row['userID'] == $_SESSION['userID']) || ($row['userID'] == "dventura11") || ($row['userID'] == "alanboy") || c_sesion::isAdmin()){
			//este codigo es tuyo o eres OWNER
			//mostrarCodigo($row['LANG'], $_REQUEST["execID"] , $row);
			return true;

		} else {
			//no puedes ver codigos que estan mal
			if($row['status'] != "OK"){
				return false;
			}

			//no puedes ver codigos que son parte de algun concurso
			if($row['Concurso'] != "-1"){
				return false;
			}

			//este codigo no es tuyo, pero vamos a ver si ya lo resolviste con mejor tiempo y que no sea parte de un concurso
			$consulta = "select * from Ejecucion where probID = '". $row['probID'] ."' AND userID = '". $_SESSION['userID'] ."' AND tiempo < " . $row['tiempo'] . " AND status = 'OK' ;";
			$resultado2 = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());
			$nr = mysql_num_rows($resultado2);

			if($nr >= 1){
				//  ste codigo no es tuyo, pero lo puedes ver porque ya lo resolviste con un mejor tiempo.
				return true;
			}else{
				//no cumples con los requisitos
				//  <img src="img/12.png">Estas intentado ver un codigo que no es tuyo. Para poder verlo tienes que resolver este problema y tener un mejor tiempo que el codigo que quieres ver.
				return false;
			}
			

		}

	}

	public static function  lista($request = null)
	{
		$inputarray = array();

		if(!is_null($request) && array_key_exists("cid", $request)) {
			$sql = "SELECT `execID`, `userID`, `probID`, `status`, `tiempo`, `fecha`, `LANG`, `Concurso`  FROM `Ejecucion` where `Concurso` = ? order by fecha desc limit 100";
			$inputarray [0] = $request["cid"];

		}else {
			$sql = "SELECT `execID`, `userID`, `probID`, `status`, `tiempo`, `fecha`, `LANG`, `Concurso`  FROM `Ejecucion` order by fecha desc limit 100";
		}
		

		global $db;
		$result = $db->Execute($sql, $inputarray);

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

		if (sizeof($result) ==0) {
			return array(
					"result" => "error", 
					"reason" => "Este run no existe"
				);
		}

		if (!is_dir(PATH_TO_CODIGOS))
		{
			Logger::warn("El directorio de codigos no existe: " . PATH_TO_CODIGOS);
			return array("result" => "error", "reason" => "El directorio de codigos no existe.");
		}

		$status =  $result[0][0];

		$result = array(
				"result" => "ok",
				"status" => $status
			);

		if ($status == "COMPILACION"
			&& file_exists(PATH_TO_CODIGOS.$request['execID'] . ".compiler_out")) {
			$compiler = file_get_contents(PATH_TO_CODIGOS.$request['execID'] . ".compiler_out");
			$result["compilador"] = $compiler;
		}

		return $result;
	}

	/**
	 * @param id_problema int el id del problema a resolver
	 * @param id_concurso int el id del concurso si es que este run pertenece a un concurso
	 * @param lang String el identificador del lenguaje ( c,cpp,java,py,php,pl)
	 * @param plain_source String 
	 *
	 * */
	public static function nuevo($request)
	{
		if (!c_sesion::isLoggedIn())
		{
			Logger::warn("Se intento enviar una ejecucion sin sesion");
			return array("result" => "error", "reason" => "Debes iniciar sesion para poder enviar problemas.");
		}

		if (!(isset($request['id_problema']) && isset($request['lang'])))
		{
			return array("result" => "error", "reason" => "Faltan parametros (id_problema y lang)");
		}

		if (empty($_FILES) && !isset($request["plain_source"]))
		{
			return array("result" => "error", "reason" => "No se envio el codigo fuente.");
		}

		$usuarioArray      = c_sesion::usuarioActual();
		$usuario      =  $usuarioArray["userID"];
		$id_problema  = stripslashes($request["id_problema"]);
		$lang         = stripslashes($request["lang"]);

		if (isset($request["id_concurso"]))
		{
			$id_concurso  = stripslashes($request["id_concurso"]);
		}
		else
		{
			$id_concurso  = null;
		}

		// Revisar que pueda escribir el codigo fuente
		if (!is_dir(PATH_TO_CODIGOS))
		{
			Logger::error("El directorio : " . PATH_TO_CODIGOS . ", no existe");
			return array("result" => "error", "reason" => "El directorio de codigos no existe.");
		}

		if (!is_writable(PATH_TO_CODIGOS))
		{
			Logger::error("El directorio " . PATH_TO_CODIGOS . ", no esta accesible (writtable)");
			return array("result" => "error", "reason" => "No se puede escribir en el directorio de codigos.");
		}

		global $db;
		$sql = "select probID from Problema where BINARY ( probID = ?) ";
		$inputarray = array($request["id_problema"]);
		$resultado = $db->Execute($sql, $inputarray);

		if ($resultado->RecordCount() == 0)
		{
			return array("result" => "error", "reason" => "El problema no existe.");
		}

		// si el concurso no es publico, solo un admin puede enviar problemas
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
				return array("result" => "error", "reason" =>"\"" . $lang . "\" no es un lenguaje reconocido por Teddy.");
		}

		if (isset($_SERVER["REMOTE_ADDR"])) {
			$ip = $_SERVER["REMOTE_ADDR"];
		} else {
			$ip = "0.0.0.0";
		}

		/**
		 * @todo
		 * - insertar un nuevo run y obtener el id insertado, como estado, hay que ponerle uploading
		 **/
		if ($id_concurso === null)
		{
			$sql = "INSERT INTO Ejecucion (`userID`, `status`, `probID` , `remoteIP`, `LANG`, `fecha`  ) 
									VALUES (?, 'WAITING', ?, ?, ?, ?);";

			$inputarray = array( $usuario, $id_problema, $ip, $lang_desc, date("Y-m-d H:i:s", mktime(date("H"), date("i") )));
		}
		else
		{
			// vamos a verificar que el concurso este activo			// vamos a verificar que el concurso este activo
			$sql = "SELECT CID FROM teddy.Concurso WHERE CID = ? AND NOW() between Inicio AND Final;";
			$inputarray = array($id_concurso);
			$resultado = $db->Execute($sql, $inputarray);
			if ($resultado->RecordCount() == 0)
			{
				return array("result" => "error", "reason" => "El concurso no esta activo.");
			}

			// vamos a verificar que el problema sea parte de este concurso
			$sql = "SELECT CID FROM teddy.Concurso WHERE CID = ? AND Problemas like ?;";
			$inputarray = array($id_concurso, "%$id_problema%");
			$resultado = $db->Execute($sql, $inputarray);
			if ($resultado->RecordCount() == 0)
			{
				return array("result" => "error", "reason" => "El problema no es parte del concurso.");
			}

			$sql = "INSERT INTO Ejecucion (`userID` ,`status`, `probID` , `remoteIP`, `LANG`, `Concurso`, `fecha`  ) 
									VALUES (?, 'WAITING', ?, ?, ?, ?, ?);";
			
			$inputarray = array( $usuario, $id_problema, $ip, $lang_desc, $id_concurso, date("Y-m-d H:i:s", mktime(date("H"), date("i") )));
		}

		$result = $db->Execute($sql, $inputarray);

		// Si hacemos esto $execID = $db->Insert_ID( ); hay un Overflow porque los ids son muy grandes
		$sql = "select execID from Ejecucion where ( userId = ? ) order by fecha DESC LIMIT 1";
		$inputarray = array($usuario);

		try{
			$resultado = $db->Execute($sql, $inputarray)->GetArray();
			$execID = $resultado[0]["execID"];

		}catch(exception $e){
			Logger::error($e);
			return array("result" => "error", "reason" => "Error al hacer la consulta");
		}

		if (!empty($_FILES))
		{
			if (!move_uploaded_file($_FILES['Filedata']['tmp_name'], PATH_TO_CODIGOS. $execID . "." . $lang  ))
			{
				return array("result" => "error", "reason" => "Error al subir el archivo");
			}
		}
		else
		{
			// Crear un archivo y escribir el contenido
			if (file_put_contents(PATH_TO_CODIGOS . "/" . $execID . "." . $lang, $request['plain_source']) === false)
			{
				Logger::Error("file_put_contents() fallo, tal vez no puedo escribir en  :".PATH_TO_CODIGOS);
				return array("result" => "error");
			}
		}

		Logger::info("Nueva ejecucion " . $execID);
		return array("result" => "ok", "execID" => $execID);
	}


}

