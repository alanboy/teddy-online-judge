<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Registro");

	require_once("head.php");

?>
<div class="post">
	<form class="datos"  >
		<h2>Registro</h2>

		<label for="nick">Usuario</label>
		<input class="text" type='text' id="nick" name="nick" placeholder="Asi te veran otros programdores en teddy" required autofocus/>

		<label>Nombre completo</label>
		<input class="text" type='text' id="nombre" name="nombre"  required/>

		<label>Correo electronico</label>
		<input class="text" value type="email" id="email" name="email"  required/>

		<label>Contrase&ntilde;a</label>
		<input class="text" type='password' id="password" name="password"  required/>

		<label>Repetir contrase&ntilde;a</label>
		<input class="text" type='password' id="re_password" name="re_password"  required/>

		<label>Pa&iacute;s</label>
		<select class="text" id="ubicacion" name="ubicacion" >
			<script language="javascript">
			for(var hi=0; hi<states.length; hi++)
			{
				document.write("<option value='"+states[hi]+"'>"+states[hi]+"</option>");
			}
			</script>
		</select>

		<label>Escuela o empresa</label>
		<input class="text" type='text' id="escuela" name="escuela"   />

		<input type="button" class="button" value="Registrar" onClick="RegistrarUsuario(this)" />
	</form>
</div>
	<script>
	function RegistrarUsuario(form)
	{
		if ($("#nick").val().length < 4)
		{
			return Teddy.error("Intenta con un nombre de usuario de mas de 4 caracteres.");
		}

		// test weird chars in nick

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
			Teddy.c_usuario.nuevo,
			function(result) {
				window.location = "runs.php?user=" + $("#nick").val();
			});
	}
	</script>
	<?php include_once("footer.php"); ?>

