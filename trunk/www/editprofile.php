<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("head.php");

	require_once("require_login.php");

	$respuesta = c_sesion::usuarioActual();
	$datos = $respuesta["user"];

?>
	<div class="post_blanco" >
		<form action="" method="post" onsubmit="return validate()" >
			<p>
				Aqui puedes cambiar los datos de tu perfil. 
			</p>

			<label for="nick">
				Usuario:
			</label>
			<input type="text" id="nick" name="nick" class="text" value="<?php echo $datos['userID']; ?>" DISABLED/>

			<label for="nombre" class="datos">
				Nombre completo :
			</label>
			<input type="text" id="nombre" name="nombre" class="text datos" value="<?php echo $datos['nombre']; ?>"/>

			<label for="email" class="datos">
				Correo :
			</label>
			<input type="text" id="email" name="email" class="text datos" value="<?php echo $datos['mail']; ?>"/>

			<label for="twitter">
				twitter :
			</label>
			<input type="text" id="twitter" name="twitter" class="text" value="<?php echo $datos['twitter']; ?>"/>

			<label>
				Escuela o empresa :
			</label>
			<input type="text" id="escuela" name="escuela" class="text" value="<?php echo $datos['escuela']; ?>"/>
			<!-- <input type="submit" class="button" value="Actualizar mis datos" /> -->
			<input type="hidden" name="nick" value="<?php echo $datos['userID']; ?>" />
			<input type="button" class="button" value="Actualizar" onClick="EditarUsuario(this)" />
		</form>
		<script>
		function EditarUsuario(form)
		{
			Util.SerializeAndCallApi( 
				$(form).parent(),
				Teddy.c_usuario.editar,
				function(result) {
					window.location = "runs.php?user=" + $("#nick").val();
				});
		}
		</script>

<br>
		<form >
			<p>Editar password</p>

			<label>Contrase&ntilde;a</label>
			<input class="text" type='password' id="password" name="password"  required/>

			<label>Repetir contrase&ntilde;a</label>
			<input class="text" type='password' id="re_password" name="re_password"  required/>


			<input type="button" class="button" value="Editar password" onClick="ResetPassword(this)" />
		</form>
	<script>
	function ResetPassword(form)
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
			Teddy.c_usuario.ResetPassword,
			function(result) {
				//window.location = "runs.php?user=" + $("#nick").val();
			});
	}
</script>
	
	</div>

	<?php include_once("footer.php"); ?>

