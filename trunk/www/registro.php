<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Registro");

	require_once("head.php");

?>
<div class="post_blanco">
	<form  >
		<h2>Registro</h2>


		<label>Usuario</label>
		<input type='text' id="nick" name="nick"  value='' />


		<label>Nombre completo</label>
		<input type='text' id="nombre" name="nombre"  value='' />


		<label>Correo electronico</label>
		<input type='text' id="email" name="email"  value='' />


		<label>Password</label>
		<input type='password' id="password" name="password"  value='' />


		<label>Confirna password</label>
		<input type='password' id="re_password" name="re_password"  value='' />



		<label>Ubicacion</label>
		<select id="ubicacion" name="ubicacion" >
			<script language="javascript">
			for(var hi=0; hi<states.length; hi++)
			{
				document.write("<option value='"+states[hi]+"'>"+states[hi]+"</option>");
			}
			</script>
		</select>

		<label>Escuela de Procedencia</label>
		<input type='text' id="escuela" name="escuela"  value='' />

		<input type="button" class="button" value="Registrar" onClick="RegistrarUsuario(this)" />
	</form>
</div>
	<script>
	function RegistrarUsuario(form)
	{
		Util.SerializeAndCallApi( 
			$(form).parent(), 
			Teddy.c_usuario.nuevo,
			function(result) {
				window.location = "login.php?registered=1";
			});
	}
	</script>
	<?php include_once("footer.php"); ?>

