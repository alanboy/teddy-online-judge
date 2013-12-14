<?php 
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("includes/head.php");

	require_once("includes/require_login.php")
?>

	<div class="post_blanco">
		<h2>enviar solucion</h2>
		<?php
			envios::imprimir_forma_de_envio();
		?>
	</div>

	<?php include_once("includes/footer.php"); ?>

