<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("head.php");

	require_once("require_login.php");

	$respuesta = c_sesion::usuarioActual();
	$datos = $respuesta["user"];

?>
	<div class="post" >
		<form action="" method="post" onsubmit="return validate()" class="datos">
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
	</div>

<!--
	<label for="password">
		Password:
	</label>
	<input type="password" id="password" name="password" class="text" value=""/>
	<label for="re_password">
		Confirma Password:
	</label>
	<input type="password" id="re_password" name="re_password" class="text" value=""/>
-->

	<?php include_once("footer.php"); ?>

