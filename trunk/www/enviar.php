<?php 
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Enviar");

	require_once("head.php");

	require_once("require_login.php")
?>

	<div class="post_blanco">
	<?php
			include ("parcial_nuevoenvio.php")
	?>
	</div>

	<?php include_once("post_footer.php"); ?>

