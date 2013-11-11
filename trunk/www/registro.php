<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Registro");

	require_once("includes/head.php");

	if (isset($_POST["form"]))
	{
		$result = c_usuario::nuevo($_POST);

		if (SUCCESS($result))
		{
			?>
			<div class="post_blanco">
				Ok !
			</div>
			<?php
		}
		else
		{
			?>
			<div class="post_blanco">
			Ups, algo no salio bien
			</div>
			<?php
		}
	}


?>
<div class="post_blanco">
	<form action="" method="post" onsubmit="return validateNewUser()">
		<h2>Ingresa los datos necesarios para registrarte en el Juez Teddy.</h2>
		<?php writeFormInput("Nombre completo",		"nombre"); ?>
		<?php writeFormInput("Correo electronico:",	"email"); ?>
		<?php writeFormInput("Twitter:",			"twitter"); ?>
		<?php writeFormInput("Nick:",				"nick"); ?>
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

		<input type="submit" class="button" value="Registrar" />
		<input type="hidden" id="form" name="form" value="false" />
	</form>
</div>

	<?php include_once("includes/footer.php"); ?>

