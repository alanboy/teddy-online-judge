<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("includes/head.php");

?>
	<div class="post_blanco" >
		<div align="center">
			<h2>Problem-Set</h2>
		</div>

		<div align="center">
		<!--
			Hay un total de <b><span id='probs_left'></span></b> problemas no resueltos
		-->
		<table>
		<thead>
		<tr>
			<th width='5%'>ID</th>
			<th width='25%'>Titulo</th>
			<th width='12%'><a href="problemas.php?orden=vistas">Vistas</a></th>
			<th width='12%'><a href="problemas.php?orden=aceptados">Aceptados</a></th>
			<th width='12%'><a href="problemas.php?orden=intentos">Intentos</a></th>
			<th width='12%'>Radio</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while(false)
		{
			echo "<TR style=\"background:#e7e7e7;\">";
			echo "<TD align='center' >". $row['probID'] ."</TD>";
			echo "<TD align='left' ><a href='verProblema.php?id=". $row['probID']  ."'>". $row['titulo']   ."</a> </TD>";
			echo "<TD align='center' >". $row['vistas']   ." </TD>";
			echo "<TD align='center' >". $row['aceptados']   ." </TD>";
			echo "<TD align='center' >". $row['intentos']   ." </TD>";
			printf("<TD align='center' >%2.2f%%</TD>", $ratio);
			echo "</TR>";
		}
		?>
		</tbody>
		</table>
		</div>
	</div>

	<?php include_once("includes/footer.php"); ?>

