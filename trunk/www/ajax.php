<?php

	require_once("../serverside/bootstrap.php");

	if (!isset($_REQUEST["controller"]) || !isset($_REQUEST["method"]))
	{
		echo json_encode(array(
				"result" => "error",
				"reason" => "Faltan parametros."
			));
	}
	else
	{
		$controller = $_REQUEST["controller"];
		$method = $_REQUEST["method"];

		$res = $controller::$method($_REQUEST);

		Logger::info("API CALL: " . $controller . "::" . $method . "()    \tRESULT:" . $res["result"] );
		header('Content-type: application/json');

		if (SUCCESS($res))
		{
			echo json_encode($res);
		}
		else
		{
			$reason = "Error interno en Teddy.";

			if (isset($res["reason"]))
			{
				$reason = $res["reason"];
			}

			echo json_encode(array(
					"result" => "error",
					"reason" => $reason
				));
		}
	}


