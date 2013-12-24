<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Resetear Password");

	require_once("head.php");


?>

<div class="post_blanco">

	<?php

	if (!c_usuario::IsResetPassTokenValid($_GET))
	{
		?><p>Este token no es valido</p><?php
	}
	else
	{
		?>
		<form class="datos"  >
			<h2>Nuevo password</h2>

			<label>Contrase&ntilde;a</label>
			<input class="text" type='password' id="password" name="password"  required/>

			<label>Repetir contrase&ntilde;a</label>
			<input class="text" type='password' id="re_password" name="re_password"  required/>

			<input type="hidden" name="token" value="<?php echo $_GET["token"]; ?>"/>

			<input type="button" class="button" value="Aceptar" onClick="ResetPasswordWithToken(this)" />
		</form>
	 <?php
	}

	?>
	<script>
	function ResetPasswordWithToken(form)
	{
		if ($("#password").val() != $("#re_password").val())
		{
			return Teddy.error("Las contrase&ntilde;as no coinciden.");
		}

		if ($("#password").val().length  < 5 )
		{
			return Teddy.error("Intenta con una contrase&ntilde;as de mas de 5 caracteres.");
		}

		Util.SerializeAndCallApi( 
			$(form).parent(),
			Teddy.c_usuario.ResetPasswordWithToken,
			function(result) {
				window.location = "index.php?";
			});
	}
	</script>
	
</div>

<?php include_once("footer.php"); ?>

