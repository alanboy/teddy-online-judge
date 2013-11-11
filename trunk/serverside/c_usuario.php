<?php

//use Respect\Validation\Validator as validator;
//$usernameValidator = validator::alnum()->noWhitespace()->length(1,15);

class c_usuario extends c_controller
{
	public static function canCreateContest($request)
	{
			$consulta = "select COUNT( DISTINCT probID ) from Ejecucion where ( userID = '". addslashes( $_SESSION['userID'] ) ."' AND  status = 'OK' )";
			$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());
			$row = mysql_fetch_array($resultado);
	}

	public static function getByNickOrEmail($request)
	{
		$query = "select * from Usuario where userID = ? or mail = ?";
		$values = array($request["nick"], $request["email"]);
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


	public static function login($request)
	{
		if (!isset($_POST["user"])) {
			TEDDY_LOG("Faltan parametros para iniciar sesion");
			echo json_encode(array(
				"sucess" => false,
				"success" => false
			));
			return;
		}

		$usuario = addslashes( $_POST["user"] );
		$pass = $_POST["pswd"];

		if (($usuario != $_POST["user"])) {
			echo "{\"sucess\": false, \"badguy\": true, \"msg\": \"Portate bien <b>". $_SERVER['REMOTE_ADDR'] ."</b>\"}";
			return;
		}

		//consultasr contraseña de estre presunto usuario
		$consulta = "select pswd, cuenta, userID, mail from Usuario where BINARY ( userID = '{$usuario}' or mail = '{$usuario}')";
		$resultado = mysql_query($consulta) or die('Dont be evil with teddy :P ');
		TEDDY_LOG("hi there");

		//si regreso 0 resultados tons este usuario ni existe
		if(mysql_num_rows($resultado) != 1) {
			$_SESSION['status'] = "WRONG";
			if( isset($resultado))
				mysql_free_result($resultado);
			mysql_close($enlace);
			echo "{\"sucess\": false, \"badguy\": false}";
			return;
		}


		//si existe este usuario, revisar su contraseña
		$row = mysql_fetch_array($resultado);

		if(crypt($pass, $row[0] ) != $row[0]){
			$_SESSION['status'] = "WRONG";
			echo "{\"sucess\": false, \"badguy\": false}";
			if( isset($resultado))
				mysql_free_result($resultado);
			mysql_close($enlace);
			return;
		}

		$_SESSION['userID'] = $row['userID'];
		$_SESSION['mail'] = $row['mail'];
		$_SESSION['status'] = "OK";
		$_SESSION['userMode'] = $row["cuenta"] ;
		echo "{\"sucess\": true, \"badguy\": false}";

	}


	public static function logout($request)
	{
		unset($_SESSION['status']);
		unset($_SESSION['userID']);
		unset($_SESSION['userMode']);
		unset($_SESSION['mail']);
		echo "<script> window.location = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
	}
}

