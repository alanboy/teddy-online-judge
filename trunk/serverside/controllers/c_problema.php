<?php

class c_problema extends c_controller
{
	public static function lista($request = null)
	{
		$sql = "select probID, titulo, vistas, aceptados, intentos from Problema WHERE publico = ?; ";
		$inputarray = array($request["public"]);

		global $db;
		$result = $db->Execute($sql, $inputarray);

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


	public static function problemaBestTimes($request = null)
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
			LIMIT 5";

		$inputarray = array($request["probID"]);

		global $db;
		$result = $db->Execute($sql, $inputarray);

		return array(
				"result" => "ok",
				"tiempos" => $result->GetArray()
			);
	}


}

