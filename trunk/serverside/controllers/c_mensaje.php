<?php

class c_mensaje extends c_controller
{	
	/**
	 *
	 * @param para
	 * @param msg
	 * @param 
	 *
	 **/
	public static function Nuevo($request)
	{
		$apiresult = c_usuario::getByNick(array( "user" => $request["para"]));

		global $db;

		if(SUCCESS($apiresult))
		{
			$sql = "INSERT INTO Mensaje (de , para , mensaje, fecha ) VALUES (  ?, ?, ?, ?);";
			$inputarray = array($_SESSION['userID'], $request["para"], $request["msg"], date("Y-m-d H:i:s", time()));
			$result = $db->Execute($sql, $inputarray);
		}

		if (SUCCESS($apiresult)
			/* destinatario tiene correo valido */ 
			/* destinatario tiene opcion de recibir correos */)
		{
			$mensaje = "Hola,\n\nTienes un nuevo mensaje en teddy de parte de " .  $_SESSION['userID'] . ": https://" . $_SERVER['SERVER_NAME'] . "/inbox.php";

			// Ignorar el resultado
			$ignore_apiresult  = c_mail::EnviarMail($mensaje, $apiresult["user"]["mail"], "Nuevo mensaje en Teddy");

			$apiresult  = array('result' => "ok" );
		}

		unset($apiresult["user"]);

		return $apiresult;
	}

	public static function MarcarComoLeido()
	{

		$sql = "UPDATE  `Mensaje` SET `unread` =  '0' WHERE para = ? ;";
		$inputarray = array( $request["para"] );

		global $db;
		$result = $db->Execute($sql, $inputarray);

		return array( "result" => "ok" );
	}
	
	public static function Lista($request)
	{
		$sql = "SELECT * FROM Mensaje WHERE de = ? OR para = ? ORDER BY fecha DESC";
		$inputarray = array(  $request["userID"], $request["userID"] );

		global $db;
		$result = $db->Execute($sql, $inputarray);

		return array(
				"result" => "ok", 
				"mensajes" => $result->GetArray()
			);
	}

}
