<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Inicia sesion");

	require_once("head.php");

?>
	<div class="post_blanco">
		<h2>Iniciar sesion</h2>
		<form id="login-form" method="POST" >
			
			<input type='password' id="pass" name="pass"  value='' />
			<?php writeFormInput("Usuario/email:",			"user"); ?>

			<?php writeFormInput("Contrase&ntilde;a",		"pass"); ?>
			<input type='password' id="pass" name="pass"  value='' />

			<input type="submit" class="button" value="Iniciar sesion"  />
			<input type="button" class="button" value="Olvide mi contrase&ntilde;a" onClick="OlvideMiContrasena(this)" />
		</form>
	</div>

	<script>
	function IniciarSesion()
	{
		Util.SerializeAndCallApi( 
			$("#login-form"), 
			Teddy.c_sesion.iniciar,
			function(result) {
				window.location = "runs.php?user=" + result.user.userID;
			});
		return false;
	}
	
	$("#login-form").submit(IniciarSesion);
	</script>

	<?php include_once("footer.php"); ?>


