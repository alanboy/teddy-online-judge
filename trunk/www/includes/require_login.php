<?php

	// This script is included by every page
	// that requires a logged user

	if (!c_sesion::isLoggedIn())
	{
		?>
		<div class="post_blanco">
			Necesitas iniciar sesion.
		</div>
		<?php
		include_once("includes/footer.php"); 
		exit;
	}

