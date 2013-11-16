<?php

//use Respect\Validation\Validator as validator;
//$usernameValidator = validator::alnum()->noWhitespace()->length(1,15);

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

	public static function nuevo($request)
	{

		// Validate logic
		if(self::getByNickOrEmail($request))
		{

		}

		$sql = "insert into Usuario (userID, nombre, pswd, ubicacion, escuela, mail, twitter) values (?,?,?,?,?,?,?,)";

		$inputarray = array(
			$request["nombre"],
			$request["email"],
			$request["password"],
			$request["ubicacion"],
			$request["escuela"],
			$request["nick"],
			$request["twitter"]
		);

		global $db;
		$db->Execute($sql, $inputarray);

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

