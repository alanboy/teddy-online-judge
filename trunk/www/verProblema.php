<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Ver Problema");

	require_once("includes/head.php");

	$prob = array( "probID" => $_GET["id"]);
	?>
	<div class="post">
	<?php
		$result = c_problema::problema($prob);

		if (SUCCESS($result))
		{
			c_problema::problemaAddView($prob);
			$row = $result["problema"][0];
			$tiempo = $row['tiempoLimite'] / 1000;

			echo "<h2>" . $_GET["id"] . ". " . $row['titulo'] ."</h2>";
			echo "<p>Limite de tiempo : <b>" . $tiempo . "</b> seg. &nbsp;&nbsp;";
			echo "Total runs : <b>" . $row['intentos'] . "</b>&nbsp;&nbsp;";
			echo "Aceptados : <b>" . $row['aceptados'] . "</b></p> ";
			echo  $row['problema'] ;

			if (!isset($_REQUEST['cid']))
			{
			?>
					<div align="center">
					<form action="enviar.php" method="get">
					<input type="hidden" name="send_to" value="<?php echo $_GET['id']; ?>">
					<input type="submit" value="enviar solucion">
					</form>
					</div>
			<?php
			}
			else
			{
				//si es concurso
			?>
				<!--
					<div align="center" >
					Enviar problema para el concurso
					<form action="contest_rank.php?cid=<?php echo $_REQUEST['cid']; ?>" method="POST" enctype="multipart/form-data">
					<br>
					<table border=0>
					<tr><td  style="text-align: right">Codigo fuente&nbsp;&nbsp;</td><td><input name="userfile" type="file"></td></tr>
					<tr><td></td><td><input type="submit" value="Enviar Solucion"></td></tr>
					</table>
					<input type="hidden" name="ENVIADO" value="SI">
					<input type="hidden" name="prob" value="<?php echo $_REQUEST['id']; ?>">
					<input type="hidden" name="cid" value="<?php echo $_REQUEST['cid']; ?>">
					</form> 
					</div>
				-->
			<?php
			}
		}
		else
		{
			echo "<div align='center'><h2>El problema " . $_GET["id"] . " no existe.</h2></div>";
		}
	?>
</div>

<div class="post_blanco">
	<h2>Mejores tiempos para este problema</h2>
	<?php
	if (!isset($_REQUEST['cid']))
	{
		$res = c_problema::problemaBestTimes($prob);
		if (SUCCESS($res))
		{
			gui::listaDeRuns($res["tiempos"]);
		}
	}
	?>
</div>

	<?php include_once("includes/footer.php"); ?>

