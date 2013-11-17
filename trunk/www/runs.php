<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Runs");

	require_once("includes/head.php");

?>
	<div class="post_blanco">

	<?php

	if (isset($_GET["user"]))
	{
		include ("includes/profile.php");

		$envios = c_usuario::runs( $_GET );
	}
	else
	{
		?>
			<h2>Ultimos envios</h2>
		<?php
		$envios = c_ejecucion::lista();
	}

	$envios = $envios["runs"];
	gui::listaDeRuns($envios);

	?>

	</div>

	<?php include_once("includes/footer.php"); ?>

