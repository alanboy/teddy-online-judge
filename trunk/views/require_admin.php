<?php
	if (!c_sesion::isAdmin())
	{
		$result = c_sesion::usuarioActual();
		if (SUCCESS($result))
		{
			Logger::warn($result["userID"] . " quiso entrar a admin y no es admin");
		}

		?>
		<div class="post_blanco">
			Necesitas ser administrador .
		</div>
		<?php
		include_once("post_footer.php"); 
		exit;
	}

