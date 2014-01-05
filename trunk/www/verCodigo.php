<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("head.php");

	require_once("require_login.php");

?>
<div class="post_blanco">
	<?php
		$result = c_ejecucion::canUserViewRun();

		if($result) {
			include ("showsourcecode.php");	
		}
		
	?>
</div>

<?php include_once("footer.php"); ?>

