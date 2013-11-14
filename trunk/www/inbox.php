<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("includes/head.php");

	// This page requires a logged user
	require_once("includes/require_login.php")

?>
	<div class="post_blanco">
<table>
<?php
	$order = array("\r\n", "\n", "\r");
	// Processes \r\n's first so they aren't converted twice.
	//$newstr = str_replace($order, $replace, $str);
?>
	<table border=0>
		<form class="form-big" method=POST >
			<tr><td>Enviar Mensaje</td></tr>
			<tr><td><textarea name="msg" cols=44 rows=5></textarea></td></tr>
			<tr><td><input type=submit value="Enviar Mensaje"></td></tr>					
			<input type=hidden name="enviado" value="si" >
		</form>
	</table>
	</div>

	<?php include_once("includes/footer.php"); ?>

