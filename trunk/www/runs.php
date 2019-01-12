<?php

	require_once("../serverside/bootstrap.php");

	$title = isset($_GET["user"]) ? $_GET["user"] : "Perfil";
	define("PAGE_TITLE", $title);

	require_once("head.php");

?>
<div class="post_blanco">

	<?php
	if (isset($_GET["user"]))
	{
		include ("parcial_perfil.php");
		$envios = c_usuario::runs( $_GET );
	}
	else
	{
		$envios = c_ejecucion::lista();
	}

	$runs = $envios["runs"];
	include ("parcial_listadeejecuciones.php");

	?>

</div>

<?php include_once("post_footer.php"); ?>

