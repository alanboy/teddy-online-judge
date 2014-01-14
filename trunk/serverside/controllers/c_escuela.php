<?php

class c_escuela extends c_controller
{
	public static function lista($request=null)
	{
		$sql = "SELECT `escuela` , COUNT( * ) AS count
				FROM Usuario
				WHERE length( escuela ) >2
				GROUP BY escuela
				ORDER BY count DESC ";

		global $db;
		$result = $db->Execute($sql);

		$arrayresult = $result->GetArray();
		return array(
				"result" => "ok",
				"count" => sizeof($arrayresult),
				"escuelas" => $arrayresult
			);
	}

}

