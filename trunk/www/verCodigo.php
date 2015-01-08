<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Ver Codigo");

	require_once("head.php");

	require_once("require_login.php");

?>
<div class="post_blanco">
	<?php
		$result = c_ejecucion::canUserViewRun();

		if($result) {
			$execID = $_GET["execID"];
			include ("parcial_mostrarcodigo.php");	
		}
		
	?>
</div>

<?php include_once("post_footer.php"); ?>

