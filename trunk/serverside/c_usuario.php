<?php

class c_usuario extends c_controller
{


	public static function solvedProblems($request)
	{
		$query = "select distinct probID from Ejecucion where userID = ? AND status = 'OK' order by probID";
		$reques["userID"];
	}

	public static function canCreateContest($request)
	{
			$consulta = "select COUNT( DISTINCT probID ) from Ejecucion where ( userID = '". addslashes( $_SESSION['userID'] ) ."' AND  status = 'OK' )";
			$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());
			$row = mysql_fetch_array($resultado);
	}

	public static function runs($request)
	{
		$sql = "SELECT `execID`, `userID`, `probID`, `status`, `tiempo`, `fecha`, `LANG`, `Concurso`  FROM `Ejecucion`  where userID = ? order by fecha desc limit 100";
		$inputarray = array( $request["user"] );

		global $db;
		$result = $db->Execute($sql, $inputarray);

		return array(
				"result" => "ok",
				"runs" => $result->GetArray()
			);
	}

	/**
	 * @param nick
	 * @param mail
	 *
	 *
	 * */
	public static function getByNickOrEmail($request)
	{
		$searchValue = null;
		if (isset($request["nick"]))
		{
			$searchValue = $request["nick"];
		}
		else if (isset($request["mail"]))
		{
			$searchValue = $request["mail"];
		}

		$sql = "select * from Usuario where userID = ? or mail = ? limit 1";
		$inputarray = array($searchValue, $searchValue);

		global $db;
		$result = $db->Execute($sql, $inputarray);
		$resultData = $result->GetArray();

		if (sizeof($resultData) == 0)
		{
			return array(
					"result" => "ok",
					"user" => null
				);
		}

		// Calcular el rank
		if( $resultData[0]["solved"] != 0 )
		{
			$rat = ($resultData[0]["solved"]/$resultData[0]["tried"])*100;
			$resultData[0]["ratio"] = substr( $rat , 0 , 5 ) . "%";
		}
		else
			$resultData[0]["ratio"] = "0.0%";

		return array(
				"result" => "ok",
				"user" => $resultData[0]
			);
	}

	public static function rank($request = null)
	{
		$sql = "select * from Usuario order by nombre;";
		$inputarray = array();

		global $db;
		$result = $db->Execute($sql, $inputarray);

		return array(
				"result" => "ok", 
				"rank" => $result->GetArray()
			);
	}

	/**
	 *
	 * @param nombre
	 * @param email
	 * @param password
	 * @param ubicacion
	 * @param escuela
	 * @param nick
	 * @param twitter
	 *
	 * */
	public static function nuevo($request)
	{
		// Validate logic
		if(self::getByNickOrEmail($request))
		{

		}

		$sql = "insert into Usuario (userID, nombre, pswd, ubicacion, escuela, mail, twitter) values (?,?,?,?,?,?,?)";

		$inputarray = array(
			$request["nick"],
			$request["nombre"],
			$request["password"],
			$request["ubicacion"],
			$request["escuela"],
			$request["email"],
			"foo"
		);

		global $db;
		$res = $db->Execute($sql, $inputarray);

		if($res===false)
		{
			error_log("TEDDY:" . $db->ErrorNo() ." " . $db->ErrorMsg() );
			return array( "result" => "error", "reason" => "Error interno." );
		}
		return array( "result" => "ok" );
	}

	public static function editar()
	{

		$nombre = addslashes($_REQUEST["nombre"]);
		$email = addslashes($_REQUEST["email"]);
	//	$ubicacion = addslashes($_REQUEST["ubicacion"]);
		$escuela = addslashes($_REQUEST["escuela"]);
		$form = addslashes($_REQUEST["form"]);

		$twitter = addslashes($_REQUEST["twitter"]);

		$query = "update  `Usuario` 
			SET  nombre = '{$nombre}', escuela = '{$escuela}', mail = '{$email}', `twitter` =  '{$twitter}' 
			WHERE  `Usuario`.`userID` =  '{$_SESSION['userID']}' LIMIT 1 ;";

		$rs = mysql_query($query) or die(mysql_error());
	}
}

