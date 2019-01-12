<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Inbox");

	require_once("head.php");

	require_once("require_login.php")

?>
<div class="post">

	<form>
		<textarea name="msg" cols=44 rows=5></textarea>
		<input type="button" onClick="EnviarMensaje(this)" value="Enviar Mensaje">
		<input type="hidden" name="para" value="alanboy">
	</form>

	<script>
	function EnviarMensaje(form)
	{
		Util.SerializeAndCallApi( 
			$(form).parent(),
			Teddy.c_mensaje.Nuevo,
			function(result) {
				Teddy.msg("OK");
			});
	}
	</script>

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

<?php include_once("post_footer.php"); ?>

