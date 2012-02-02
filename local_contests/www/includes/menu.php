<div class="post">
	<div class="navcenter">
		<a href="index.php">home</a>&nbsp;&nbsp;&nbsp;
		<?php
		if(isset($_SESSION['userID'])){
			/* is logged */
			?>
			<?php

		}else{
			/* is not logged */
			/*
			?><a href="registro.php">registro</a>&nbsp;&nbsp;&nbsp;<?php


			*/
		}
		?>
		
		
		
		
		<a href="contest.php">concursos</a>&nbsp;&nbsp;&nbsp;
		<a href="faq.php">ayuda</a>&nbsp;&nbsp;&nbsp;

	</div>
</div>
