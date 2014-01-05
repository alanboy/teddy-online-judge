<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("head.php");

	require_once("require_login.php")

?>
<div class="post_blanco">
	<table border=0>
			<tr><td>Enviar Mensaje</td></tr>
			<tr><td><textarea name="msg" cols=44 rows=5></textarea></td></tr>
			<tr><td><input type=submit value="Enviar Mensaje"></td></tr>
	</table>
	<?php 
		$result = c_sesion::usuarioActual();
		if (SUCCESS($result)) {
			$request = array("userID" => $result["user"]["userID"]);
			$result = c_mensaje::lista($request);
		}

		if (SUCCESS($result)) {
			$msgs = $result["mensajes"];
			include "mensajes.php";
		}
	?>
</div>

<?php include_once("footer.php"); ?>

