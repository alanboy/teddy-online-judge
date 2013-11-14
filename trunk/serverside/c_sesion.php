<?php

class c_sesion extends c_controller
{

	/**
	 * @param nick
	 * @param email
	 * @param pass
	 *
	 * */
	public static function login($request)
	{
		$request["nick"] = $request["user"];
		$request["email"] = $request["user"];

		$sql = "select pswd, cuenta, userID, mail from Usuario where BINARY ( userID = ? or mail = ? )";
		$inputarray = array($request["nick"], $request["email"]);

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

				return array(
					"result" => "ok",
					"user" => $dbUser
				);
			}
		}
		return array("result" => "ok", "user" => null);
	}

	/**
	 *
	 * @param userID Si quieres cerrar la sesion de alguien mas. Si quieres cerrar la tuya no mandes nada.
	 *
	 * */
	public static function logout($request = null)
	{
		unset($_SESSION['userID']);
	}
}

