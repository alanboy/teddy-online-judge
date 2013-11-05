<?php 
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");
	require_once("includes/head.php");

?>
	<div class="post_blanco">
		<h2>enviar solucion</h2>
		<?php
			if( !isset($_SESSION['userID'] ))
			{
				?><div align="center">Debes iniciar sesion en la parte de arriba para poder enviar problemas a <b>Teddy</b>.</div> <?php
			}
			else
			{
				envios::imprimir_forma_de_envio();
			}
		?>
	</div>

	<?php include_once("includes/footer.php"); ?>

