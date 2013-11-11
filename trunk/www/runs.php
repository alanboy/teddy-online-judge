<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Runs");

	require_once("includes/head.php");

?>
	<div class="post_blanco">
	<?php

	if(isset($_GET["user"]))
	{
		include ("includes/profile.php");
	}
	else
	{
?>
			<div align="center">
				<h2>Run-Status</h2>
				Mostrando los ultimos 100 envios a Teddy. 
			</div>
<?php
	}
	?>
	<div align="center" >
	<table   > 
	<thead> <tr >
		<th width='12%'>execID</th> 
		<th width='12%'>Problema</th> 
		<th width='12%'>Usuario</th> 
		<th width='12%'>Lenguaje</th> 
		<th width='12%'>Resultado</th> 
		<th width='12%'>Tiempo</th> 
		<th width='12%'>Fecha</th>
		</tr> 
	</thead> 
	<tbody>
	<?php
	$consulta = "SELECT `execID`, `userID`, `probID`, `status`, `tiempo`, `fecha`, `LANG`, `Concurso`  FROM `Ejecucion` order by fecha desc limit 100";
	$resultado = mysql_query($consulta);

	while($row = mysql_fetch_array($resultado))
	{
		$ESTADO = $row['status'];
		$nick = htmlentities( $row['userID'] );

		//checar si hay una sesion y si si hay mostrar el usuario actual en cierto color
		$foobar = $row['execID'];
		$tooltip = "Ver este Codigo";
		if( $row["Concurso"] != -1 )
		{
			$foobar = "" . $row['execID'] . "*";
			$tooltip = "Este run fue parte de algun concurso online";
		}

		echo "<TD align='center' ><a title='$tooltip' href='verCodigo.php?execID={$row['execID']}'>". $foobar  ."</a></TD>";
		echo "<TD align='center' ><a title='". $row["probID"] ."' href='verProblema.php?id=". $row['probID']  ."'>". $row['probID']   ."</a> </TD>";
		echo "<TD align='center' ><a title='Ver perfil' href='runs.php?user=". $row['userID']  ."'>". $nick   ."</a> </TD>";
		echo "<TD align='center' >". $row['LANG']   ."</TD>";
		echo "<TD align='center' >". utils::color_result($ESTADO) ."</TD>";
		printf("<TD align='center' >%1.3fs </TD>", $row['tiempo'] / 1000);
		echo "<TD align='center' >". $row['fecha']   ." </TD>";
		echo "</TR>";
	}
	?>
	</tbody>
	</table>
	</div>
	</div>

	<?php include_once("includes/footer.php"); ?>
