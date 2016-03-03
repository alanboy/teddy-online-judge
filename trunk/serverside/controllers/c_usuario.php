<?php

use Respect\Validation\Validator as validator;

class c_usuario extends c_controller
{
	public static function problemasResueltos($request)
	{
		$sql = "select distinct probID from Ejecucion where userID = ? AND status = 'OK' order by probID";
		$inputarray = array( $request["userID"] );

		global $db;
		$result = $db->Execute($sql, $inputarray);

		$it = $result->GetArray();
		$resultArray = Array();

		for ($i = 0;  $i < sizeof($it); $i++) {
			array_push($resultArray, $it[$i]["probID"]);
		}

		return array(
				"result" => "ok",
				"problemas" => $resultArray
			);
	}

	public static function problemasIntentados($request)
	{
		$sql = "select
			distinct probID 
			from 
			Ejecucion 
			where 
			userID = ? 
			AND status != 'OK' 
			AND probID not in ( select distinct probID from Ejecucion where userID = ? AND status = 'OK' order by probID )
			order by probID";

		$inputarray = array( $request["userID"], $request["userID"] );

		global $db;
		$result = $db->Execute($sql, $inputarray);

		$it = $result->GetArray();
		$resultArray = Array();

		for ($i = 0;  $i < sizeof($it); $i++) {
			array_push($resultArray, $it[$i]["probID"]);
		}

		return array(
				"result" => "ok",
				"problemas" => $resultArray
			);

		return $result;
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
	public static function getByNick($request)
	{
		$searchValue = null;
		if (isset($request["nick"]))
		{
			$searchValue = $request["nick"];
		}
		elseif (isset($request["userID"]))
		{
			$searchValue = $request["userID"];
		}

		$sql = "select * from Usuario where userID = ?  limit 1";
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

	public static function getByEmail($request)
	{
		$searchValue = null;
		if (isset($request["email"]))
		{
			$searchValue = $request["email"];
		}

		$sql = "select * from Usuario where mail = ? limit 1";
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
		$sql = "select * from Usuario order by solved DESC, tried ASC ;";
		$inputarray = array();

		global $db;
		$result = $db->Execute($sql, $inputarray);

		return array(
				"result" => "ok", 
				"rank" => $result->GetArray()
			);
	}

	private static function UsuarioValido($request)
	{
		$usernameValidator = validator::alnum()->noWhitespace()->length(4,15);
		$escuelaValidator = validator::alnum("()")->length(3,50);

		try {
			$usernameValidator->check($request["nick"]);

			if (array_key_exists("escuela", $request)) {
				$escuelaValidator->check($request["escuela"]);
			}

		} catch(InvalidArgumentException $e) {
			return false;
		}

		return true;
	}

	/**
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

		if ( !array_key_exists("nombre", $request)
			|| !array_key_exists("email", $request)
			|| !array_key_exists("password", $request)
			|| !array_key_exists("nick", $request))
		{
			Logger::warn("Faltan parametros");
			return array("result" => "error", "reason" => "Faltan datos");
		}

		Logger::info("Creando usuario " . $request["nick"] . " / " . $request["email"]);

		if (!self::UsuarioValido($request)) {
			Logger::warn("Validacion fallo");
			return array("result" => "error", "reason" => "El nombre de usuario no debe contener espacios" );
		}

		$result = self::getByNick($request);
		if (!is_null($result["user"]))
		{
			$msg = "Este usuario ya estan registrado";
			Logger::warn($msg);
			return array( "result" => "error", "reason" => $msg);
		}

		$result = self::getByEmail($request);
		if (!is_null($result["user"]))
		{
			$msg = "Este email ya estan registrado";
			Logger::warn($msg);
			return array( "result" => "error", "reason" => $msg);
		}

		$sql = "insert into Usuario (userID, nombre, pswd, ubicacion, escuela, mail, twitter) values (?,?,?,?,?,?,?)";

		$inputarray = array(
			$request["nick"],
			$request["nombre"],
			crypt($request["password"]),
			isset($request["ubicacion"]) ? $request["ubicacion"] : "",
			isset($request["escuela"]) ? $request["escuela"] : "",
			$request["email"],
			""
		);
		global $db;
		$res = $db->Execute($sql, $inputarray);

		if($res===false)
		{
			Logger::error("TEDDY:" . $db->ErrorNo() ." " . $db->ErrorMsg() );
			return array( "result" => "error", "reason" => "Error interno." );
		}

		$request["user"] = $request["nick"];
		$request["pass"] =	$request["password"];

		$result = c_sesion::login($request);
		if (!SUCCESS($result))
		{
			Logger::error("TEDDY: Error al iniciar sesion despues de registar usuario" );
			return array( "result" => "error", "reason" => "Error interno." );
		}

		Logger::info("Creado usuario " . $request["nick"] );
		return array( "result" => "ok" );
	}

	public static function IsResetPassTokenValid($request)
	{
		if (!isset($request["token"]))
		{
			return false;
		}

		$sql = "select userID from LostPassword where Token = ?;" ;

		$inputarray = array( $request["token"] );

		global $db;
		$res = $db->Execute($sql, $inputarray)->GetArray();

		return (sizeof($res) == 1);
	}

	public static function ResetPassword($request)
	{

		$user = c_sesion::usuarioActual();

		if (SUCCESS($user) && !is_null($user["user"]))
		{
			$request["user"] = $user["user"]["userID"];
		}
		
	
		$sql = "update Usuario set pswd = ? where userID = ?";

		$inputarray = array(
					crypt($request["password"]),
					$request["user"] );

		global $db;
		$res = $db->Execute($sql, $inputarray);

		return array("result" => "ok");
	}

	public static function ResetPasswordWithToken($request)
	{
		if (!isset($request["token"]))
		{
			return array("result" => "error", "reason" => "Token de reset invalido.");
		}

		if (!self::IsResetPassTokenValid($request))
		{
			return array("result" => "error", "reason" => "Token de reset invalido.");
		}

		$sql = "select userID, id from LostPassword where Token = ?;" ;
		$inputarray = array( $request["token"] );

		global $db;
		$res = $db->Execute($sql, $inputarray)->GetArray();

		$request["user"] = $res[0]["userID"];

		$result = self::ResetPassword( $request );

		if (SUCCESS($result))
		{
			$sql = "DELETE FROM `LostPassword` WHERE `LostPassword`.`ID` = ?;" ;
			$inputarray = array( $res[0]["id"] );
			$res = $db->Execute($sql, $inputarray);
		}

		// Cambiar el password
		return array("result" => "ok");
	}

	public static function RequestResetPass($request)
	{
		$request["nick"] = $request["user"];

		$result = self::getByNick($request);
		if (is_null($result["user"]))
		{
			return array( "result" => "error", "reason" => "Este usuario no existe." );
		}

		$user = $result["user"];

		$foo = 55;
		$bar = "";
		while($foo-- > 0){
			$bar .= rand( 5, 123 );
		}

		$token = md5($bar);

		$sql = "INSERT INTO LostPassword (`userID` , `IP` , `Token` ) VALUES (?,?,?);" ;

		if (isset($_SERVER["REMOTE_ADDR"])) {
			$ip = $_SERVER["REMOTE_ADDR"];
		} else {
			$ip = "0.0.0.0";
		}

		$inputarray = array(
			$user["userID"],
			$ip,
			$token
		);

		global $db;
		$res = $db->Execute($sql, $inputarray);
		$resetid = $db->Insert_ID();
		$content = "Hola,\n\nSigue este enlace para resetear tu password en Teddy: https://" . $_SERVER['SERVER_NAME'] . "/reset.php?token=" . $token;

		$result = c_mail::EnviarMail( $content, $user["mail"], "Teddy Online Judge");

		if(!SUCCESS($result))
		{
			return array("result" => "error", "reason" => "impsible enviar el correo electronico");
		}

		$sql = "update LostPassword set mailSent = 1 where id = ?";

		$inputarray = array( $resetid );

		$res = $db->Execute($sql, $inputarray);

		return array( "result" => "ok" );
	}


	public static function editar($request)
	{
		$result = self::getByNick($request);
		if (is_null($result["user"]))
		{
			return array( "result" => "error", "reason" => "Este usuario no existe." );
		}

		if (!self::UsuarioValido($request)) {
			Logger::warn("Validacion fallo");
			return array("result" => "error", "reason" => "El nombre de usuario no debe contener espacios" );
		}

		$sql = "update  `Usuario`  SET  nombre = ?, escuela = ?, mail = ?, `twitter` =  ? 
									WHERE  `Usuario`.`userID` =  ? LIMIT 1 ;";

		$inputarray = array(
			$request["nombre"],
			isset($request["escuela"]) ? $request["escuela"] : "",
			$request["email"],
			isset($request["twitter"]) ? $request["twitter"] : "",
			$request["nick"]
		);

		global $db;
		$res = $db->Execute($sql, $inputarray);

		if($res===false)
		{
			Logger::error("TEDDY:" . $db->ErrorNo() ." " . $db->ErrorMsg() );
			return array( "result" => "error", "reason" => "Error interno." );
		}

		return array( "result" => "ok" );
	}
}

