<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("includes/head.php");

	if (isset($_POST["form"]))
	{
		c_usuario::nuevo($_POST);
	}

?>
<div class="post_blanco">
	<form action="" method="post" onsubmit="return validate()">
			<h2>
			Ingresa los datos necesarios para registrarte en el Juez Teddy.
			</h2>
			<label for="nombre">
				Nombre Completo:
			</label>
			<input type="text" id="nombre" name="nombre" class="text" />
			<label for="email">
				Correo :
			</label>
			<input type="text" id="email" name="email" class="text" />

			<label for="twitter">
				twitter :
			</label>
			<input type="text" id="twitter" name="twitter" class="text" />

			<label for="nick">
				Nick (sin espacios):
			</label>
			<input type="text" id="nick" name="nick" class="text" />
			<label for="password">
				Password:
			</label>
			<input type="password" id="password" name="password" class="text" />
			<label for="re_password">
				Confirma Password:
			</label>
			<input type="password" id="re_password" name="re_password" class="text" />
			<label>
				Ubicaci&oacute;n:
			</label>
			<select id="ubicacion" name="ubicacion" >
	<script language="javascript">
	for(var hi=0; hi<states.length; hi++)
	{
		document.write("<option value=\""+states[hi]+"\">"+states[hi]+"</option>");
	}
	</script>
			</select>
			<label>
				Escuela de Procedencia :
			</label>
			<input type="text" id="escuela" name="escuela" class="text" />
			<input type="submit" class="button" value="Registrar" />
			<input type="hidden" id="form" name="form" value="false" />
		</form>
	</div>

	<?php include_once("includes/footer.php"); ?>

