<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Runs");

	require_once("head.php");

?>
<div class="post_blanco">

	<?php

	if (isset($_GET["user"]))
	{
		include ("profile.php");
		$envios = c_usuario::runs( $_GET );
	}
	else
	{
		$envios = c_ejecucion::lista();
	}

	$envios = $envios["runs"];
	gui::listaDeRuns($envios);

	?>

</div>

<?php include_once("footer.php"); ?>

