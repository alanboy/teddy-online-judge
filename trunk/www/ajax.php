<?php

	require_once("../serverside/bootstrap.php");

	$controller = $_REQUEST["controller"];
	$method = $_REQUEST["method"];

	$res = $controller::$method($_REQUEST);

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
