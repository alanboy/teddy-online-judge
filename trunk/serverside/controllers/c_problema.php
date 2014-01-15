<?php

class c_problema extends c_controller
{
	public static function lista($request = null)
	{
		$sql = "select probID, titulo, vistas, aceptados, intentos from Problema WHERE publico = ? ";
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

		if (array_key_exists("orden", $request)) {
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

	public static function problema($request = null)
	{
		$sql = "select titulo, problema, tiempoLimite, aceptados, intentos from Problema WHERE probID = ? limit 1;";
		$inputarray = array($request["probID"]);

		global $db;
		$result = $db->Execute($sql, $inputarray);

		return array(
				"result" => "ok",
				"problema" => $result->GetArray()
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

