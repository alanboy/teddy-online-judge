<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Nuevo problema");

	require_once("head.php");

	$editarproblema = null;
	if (isset($_GET["probID"]))
	{
		$result = c_problema::problema($_GET);

		if (SUCCESS($result))
		{
			$editarproblema = $result["problema"];
			include ("post_nuevoproblema.php");
		}
		else
		{
			?><div>Este problema no existe.</div><?php
		}
	}
	else
	{
		include ("post_nuevoproblema.php");
	}

	include ("post_footer.php");
