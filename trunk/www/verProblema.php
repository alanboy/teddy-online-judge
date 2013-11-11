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

<?php
	if (!isset($_REQUEST['cid']))
	{
?>
	<div class="post_blanco">
	<div align="center" >
		<h3>Top 5 tiempos para este problema</h3><br>
		<table>
		<thead>
		<tr >
		<th width='12%'>execID</th> 
		<th width='12%'>Usuario</th> 
		<th width='12%'>Lenguaje</th> 
		<th width='12%'>Tiempo</th> 
		<th width='12%'>Fecha</th>
		</tr> 
		</thead> 
		<tbody>
<?php
		$res = c_problema::problemaBestTimes($prob);
		if (SUCCESS($res))
		{
			$best_times = $res["tiempos"];
			for ($n = 0; $n < sizeof($best_times); $n++)
			{
				$row = $best_times[$n];
				echo "<TD align='center' ><a href='verCodigo.php?execID={$row['execID']}'>". $row['execID'] ."</a></TD>";
				echo "<TD align='center' ><a href='runs.php?user=". $row['userID']  ."'>". $row["userID"]   ."</a> </TD>";
				echo "<TD align='center' >". $row['LANG']   ."</TD>";
				echo "<TD align='center' ><b>". $row['tiempo'] / 1000  ."</b> Segundos </TD>";
				echo "<TD align='center' >". $row["fecha"]   ." </TD>";
				echo "</TR>";
			}
?>
		</tbody>
		</table>
		</div>
		</div>
<?php
		}
	}
	?>

	<?php include_once("includes/footer.php"); ?>

