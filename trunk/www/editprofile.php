<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("includes/head.php");

	// This page requires a logged user
	require_once("includes/require_login.php")
?>
	<div class="post" >
		<form action="" method="post" onsubmit="return validate()" class="datos">
			<p>
				Aqui puedes cambiar los datos de tu perfil. Todo menos tu nick.
			</p>

			<label for="nick">
				Nick :
			</label>
			<input type="text" id="nick" name="nick" class="text" value="<?php echo $datos['userID']; ?>" DISABLED/>

			<label for="nombre" class="datos">
				Nombre Completo :
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
				Escuela de Procedencia :
			</label>
			<input type="text" id="escuela" name="escuela" class="text" value="<?php echo $datos['escuela']; ?>"/>
			<input type="submit" class="button" value="Actualizar mis datos" />
			<input type="hidden" id="form" name="form" value="false" />
		</form>
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

	<?php include_once("includes/footer.php"); ?>

