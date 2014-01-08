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


		if (SUCCESS($res)) {
			Logger::info("API CALL OK: " . $controller . "::" . $method . "()" );
		} else {
			Logger::error("API CALL FAILED: " . $controller . "::" . $method . "()\tREASON:" . $res["reason"] );
		}

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


