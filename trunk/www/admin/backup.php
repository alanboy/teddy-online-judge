<?php

	require_once("../../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("../includes/head.php");

	// This page requires a logged user
	require_once("require_login.php");
	require_once("require_admin.php");

?>
	<div class="post">
	</div>

	<?php include_once("../includes/footer.php"); ?>
