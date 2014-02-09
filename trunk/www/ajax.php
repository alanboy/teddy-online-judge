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

		$sparams = "";
		foreach ($_REQUEST as $key => $value) {

			if (($key == "pass")
				 ||($key == "controller")
				 ||($key == "method"))
			{
				// Do not leak password
			}else{
				$sparams .= $key . " = " . ( strlen($value) > 16 ? substr($value, 0, 16 ) . "..."  : $value  ).", ";
			}
		}

		if (SUCCESS($res)) {
			Logger::info("API CALL OK: " . $controller . "::" . $method . "(".$sparams . ")" );

		} else {
			Logger::error("API CALL FAILED: " . $controller . "::" . $method . "(" .$sparams . ")\tREASON:" . $res["reason"] );
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


