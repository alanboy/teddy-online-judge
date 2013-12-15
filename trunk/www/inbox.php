<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("head.php");

	// This page requires a logged user
	require_once("require_login.php")

?>
<div class="post_blanco">
	<table border=0>
		<form class="form-big" method=POST >
			<tr><td>Enviar Mensaje</td></tr>
			<tr><td><textarea name="msg" cols=44 rows=5></textarea></td></tr>
			<tr><td><input type=submit value="Enviar Mensaje"></td></tr>					
			<input type=hidden name="enviado" value="si" >
		</form>
	</table>
</div>

<?php include_once("footer.php"); ?>

