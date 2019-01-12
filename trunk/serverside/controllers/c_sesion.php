<?php

class c_sesion extends c_controller
{

	public static function isLoggedIn($request = null)
	{
		return isset($_SESSION['userID']);
	}

	public static function isAdmin($request = null)
	{
		if ($request == null)
		{
			$request = self::usuarioActual();
		}
		else
		{
			$request = c_usuario::getByNick($request);
		}

		if (SUCCESS($request))
		{
			return ($request["user"]["cuenta"]=="ADMIN") || $request["user"]["cuenta"]=="OWNER";
		}

		return false;
	}

	public static function usuarioActual()
	{
		$user = null;
		$result = array("result" => "error");

		if (self::isLoggedIn())
		{
			$result = c_usuario::getByNick(array( "nick" => $_SESSION['userID']));

			if (SUCCESS($result))
			{
				$result = array(
					"result" => "ok",
					"user" => $result["user"],
					"userID" => $_SESSION['userID']);
			}
		}

		return $result;
	}

	/**
	 * @param user
	 * @param pass
	 *
	 * */
	public static function login($request)
	{
		$request["user"] = isset($request["user"]) ? $request["user"] : null;
		$request["email"] = $request["user"];

		if (isset($request["password"]))
		{
			$request["pass"] = $request["password"];
		}

		$sql = "select pswd, cuenta, userID, mail from Usuario where BINARY ( userID = ? or mail = ? )";
		$inputarray = array($request["user"], $request["email"]);

		global $db;
		$result = $db->Execute($sql, $inputarray);
		$resultData = $result->GetArray();

		if (sizeof($resultData) == 1)
		{
			$dbUser = $resultData[0];

			if (crypt($request["pass"], $dbUser["pswd"] ) == $dbUser["pswd"])
			{
				unset($dbUser["pswd"]);
				unset($dbUser[0]);

				$_SESSION['userID'] = $dbUser['userID'];

				Logger::info("sesion iniciada para ". $dbUser["userID"]);
				return array(
					"result" => "ok",
					"user" => $dbUser
				);
			}
		}

		Logger::error("Credenciales invalidas para usuario :" . $request["user"] );
		return array(
			"result" => "error",
			"reason" => "Credenciales invalidas." );
	}

	public static function logout($request = null)
	{
		unset($_SESSION['userID']);
		return array( "result" => "ok" );
	}
}

