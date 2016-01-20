<?php

use Respect\Validation\Validator as validator;

class c_problema extends c_controller
{
	/*
	 * titulo
	 * problema
	 * tiempoLimite
	 * entrada
	 * salida
	 *
	 **/
	private static function ProblemaValido($request)
	{
		$tituloValidator = validator::notEmpty()->alnum()->length(4,15);
		$problemaValidator = validator::notEmpty()->length(100,1024*5);
		$entradaValidator = validator::notEmpty()->alnum("()")->length(3,50);
		$salidaValidator = validator::notEmpty()->alnum("()")->length(3,50);

		if (array_key_exists("titulo", $request)) {
			$tituloValidator->check($request["titulo"]);
		} else{
			throw new InvalidArgumentException("Falta titulo");
		}

		if (array_key_exists("problema", $request)) {
			$problemaValidator->check($request["problema"]);
		} else{
			throw new InvalidArgumentException("Falta redaccion de problema");
		}

		if (!array_key_exists("tiempoLimite", $request)) {
			throw new InvalidArgumentException("Falta tiempolimite");
		}

		return true;
	}

	public static function Nuevo($request)
	{

		try{
			self::ProblemaValido($request);

		} catch(InvalidArgumentException $e) {
			Logger::warn("imposible crear nuevo problema:" . $e->getMessage());
			return array( "result" => "error", "reason" => $e->getMessage() );

		}

		$usuarioActual = c_sesion::usuarioActual();
		if (!SUCCESS($usuarioActual))
		{
			Logger::error("no hay permiso para crear nuevo problema");
			return array("result" => "error", "reason" => "No tienes permiso de hacer esto.");
		}

		$sql = "insert into Problema (titulo, problema, tiempoLimite, usuario_redactor) values (?,?,?,?)";

		$inputarray = array(
			$request["titulo"],
			$request["problema"],
			$request["tiempoLimite"],
			$usuarioActual["userID"]
		);

		global $db;
		$res = $db->Execute($sql, $inputarray);

		if($res===false)
		{
			Logger::error("TEDDY:" . $db->ErrorNo() ." " . $db->ErrorMsg() );
			return array("result" => "error", "reason" => "Error interno.");
		}

		$id = $db->Insert_ID();

		if (file_exists(PATH_TO_CASOS) === FALSE)
		{
			Logger::error("TEDDY: " . PATH_TO_CASOS . " no existe");
			return array("result" => "error", "reason" => "Error interno.");
		}

		file_put_contents(PATH_TO_CASOS . "/" . $id . ".in", $request["entrada"]);
		file_put_contents(PATH_TO_CASOS . "/" . $id . ".out", $request["salida"]);

		Logger::info("Nuevo problema creado. ProbID: ". $id ." Titulo: " . $request["titulo"]);

		return array(
				"result" => "ok",
				"probID" => $id
			);
	}

	public static function lista($request = null)
	{
		$sql = "select probID, titulo, problema, vistas, aceptados, intentos, tiempoLimite from Problema WHERE publico = ? ";
		$inputarray = array($request["public"]);

		/*
		 *  Why the fuck does this not work?
		 *
		 *
				if (array_key_exists("orden", $request)) {
					$sql .= " order by ? ";
					array_push($inputarray, $request["orden"]);
				}
		 */

		if ( !is_null($request) && array_key_exists("orden", $request)) {
			$sql .= " order by ". $request["orden"];
		}

		$sql .= ";";

		global $db;
		try {
			$result = $db->Execute($sql, $inputarray);

		} catch(Exception  $e) {
			Logger::error($e);
		}

		if (!$result) {
			Logger::error("Imposible obtener lista de problemas" );
			return array( "result" => "error" );
		}

		return array(
				"result" => "ok",
				"problemas" => $result->GetArray()
			);
	}

	public static function problema($request)
	{
		if (!isset($request["probID"]))
		{
			return array("result" => "error",
							"reason" => "Este problema no existe");
		}

		$sql = "select titulo, problema, tiempoLimite, aceptados, intentos, publico from Problema WHERE probID = ? limit 1;";
		$inputarray = array($request["probID"]);

		global $db;
		$result = $db->Execute($sql, $inputarray);

		$data =  $result->GetArray();

		if (sizeof($data) == 0)
		{
			return array("result" => "error",
							"reason" => "Este problema no existe");
		}

		return array(
				"result" => "ok",
				"problema" => $data[0]
			);
	}

	public static function problemaAddView($request = null)
	{
		$sql = "UPDATE Problema SET vistas = (vistas + 1) WHERE probID = ? limit 1;";
		$inputarray = array($request["probID"]);

		global $db;
		$result = $db->Execute($sql, $inputarray);

		return array(
				"result" => "ok",
			);
	}


	public static function mejoresTiempos($request = null)
	{
		$sql = "SELECT DISTINCT 
			`userID`, `execID` , `status` , MIN(`tiempo`) as 'tiempo', fecha, `LANG`
			FROM 
			`Ejecucion`
			WHERE
			( probID = ? AND STATUS =  'OK' )
			GROUP BY
			`userID`
			order by
			tiempo asc
			LIMIT 10";

		$inputarray = array($request["probID"]);

		global $db;
		$result = $db->Execute($sql, $inputarray);

		return array(
				"result" => "ok",
				"tiempos" => $result->GetArray()
			);
	}


}

