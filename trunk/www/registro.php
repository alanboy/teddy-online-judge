<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Registro");

	require_once("includes/head.php");

?>
<div class="post_blanco">
	<form  >
		<h2>Ingresa los datos necesarios para registrarte en el Juez Teddy.</h2>

		<?php writeFormInput("Usuario:",			"nick"); ?>
		<?php writeFormInput("Nombre completo",		"nombre"); ?>
		<?php writeFormInput("Correo electronico:",	"email"); ?>
		<?php writeFormInput("Password:",			"password"); ?>
		<?php writeFormInput("Confirna password:",	"re_password"); ?>

		<label>Ubicaci&oacute;n:</label>
		<select id="ubicacion" name="ubicacion" >
			<script language="javascript">
			for(var hi=0; hi<states.length; hi++)
			{
				document.write("<option value='"+states[hi]+"'>"+states[hi]+"</option>");
			}
			</script>
		</select>

		<?php writeFormInput("Escuela de Procedencia :", "escuela"); ?>

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
	<?php include_once("includes/footer.php"); ?>

