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

