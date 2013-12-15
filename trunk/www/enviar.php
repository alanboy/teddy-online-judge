<?php 
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("head.php");

	require_once("require_login.php")
?>

	<div class="post_blanco">
	<?php
			include ("form.new-submission.php")
	?>
	</div>

	<?php include_once("footer.php"); ?>

