<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("head.php");

	// This page requires a logged user
	require_once("require_login.php");

?>
<div class="post_blanco">
	<h2>Revisar un codigo fuente</h2>
	<?php

		$result = c_ejecucion::canUserViewRun();
		if($result)
		{
			include ("showsourcecode.php");	
		}
		
	?>
</div>

<?php include_once("footer.php"); ?>

