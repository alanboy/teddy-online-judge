<div class="post">
	<div class="navcenter">
		<a href="index.php">home</a>&nbsp;&nbsp;&nbsp;
		<?php
		if (!c_sesion::isLoggedIn()) {
			?><a href="registro.php">registro</a>&nbsp;&nbsp;&nbsp;<?php
		}
		?>
		<a href="problemas.php">problemas</a>&nbsp;&nbsp;&nbsp;
		<a href="enviar.php">enviar solucion</a>&nbsp;&nbsp;&nbsp;
		<a href="runs.php">ejecuciones</a>&nbsp;&nbsp;&nbsp;
		<a href="rank.php">rank</a>&nbsp;&nbsp;&nbsp;
		<a href="contest.php">concursos</a>&nbsp;&nbsp;&nbsp;
		<a href="faq.php">preguntas frecuentes</a>&nbsp;&nbsp;&nbsp;
	</div>
</div>

<?php
	if (c_sesion::isAdmin())
	{
		?>
		<div class="post">
			<div class="navcenter">
				<a href="../index.php">teddy home</a>&nbsp;&nbsp;&nbsp;
				<a href="test.php">estado</a>&nbsp;&nbsp;&nbsp;
				<a href="problemas.php">problemas</a>&nbsp;&nbsp;&nbsp;
				<a href="soluciones.php">soluciones</a>&nbsp;&nbsp;&nbsp;
				<a href="inbox.php">mensajes</a>&nbsp;&nbsp;&nbsp;
				<a href="runs.php">ejecuciones</a>&nbsp;&nbsp;&nbsp;
				<a href="usuarios.php">usuarios</a>&nbsp;&nbsp;&nbsp;
				<a href="log.php">log</a>&nbsp;&nbsp;&nbsp;
				<a href="config.php">configuracion</a>&nbsp;&nbsp;&nbsp;
			</div>
		</div>
		<?php
	}
?>

<div id="notif_area"  class="post hidden" >
	<div class="navcenter">
	</div>
</div>
