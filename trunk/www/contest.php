<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Concursos");

	require_once("includes/head.php");

?>
<table>
	<tr>
	<td valign=top>
	<div id="new_contest_form" class="post_blanco">
		<h2>Crear un concurso</h2>
		<?php
			include("includes/form.new-contest.php");
		?>
	</div>
	</td>

	<td>
	<div class="post"  align=center>
		<table >
		<tr>
		<td>
		<?php
		while( $row = mysql_fetch_array($resultado) )
		{
				echo "<div style=\"font-size: 16px\"><a href=\"contest_rank.php?cid=" . $row["CID"] .  "\"><b>".$row["Titulo"]."</b>&nbsp;<img src=\"img/1.png\"></a></div>";
				echo "<b>Descripcion</b> " . $row["Descripcion"] . "<br>";
				echo "<b>Organizador</b> ". $row['Owner'] ."<br>";
				echo "<b>Hora de inicio</b> " . $row["Inicio"] . "<br>";
				echo "<b>Hora de cierre</b> " . $row["Final"] . "<br>";
				$probs = explode(' ', $row["Problemas"]);
				echo "<b>Problemas </b>" . sizeof( $probs ) ;
				echo "<br><br>";
		}
		?>
		</td>
		<td>
		<?php
		if(0)
		{
			while( $row = mysql_fetch_array($resultado) )
			{
				echo "<div style=\"font-size: 16px\"><a href=\"contest_rank.php?cid=" . $row["CID"] .  "\"><b>".$row["Titulo"]."</b>&nbsp;<img src=\"img/1.png\"></a></div>";
				echo "<b>Descripcion</b> " . $row["Descripcion"] . "<br>";
				echo "<b>Organizador</b> ". $row['Owner'] ."<br>";
				echo "<b>Hora de inicio</b> " . $row["Inicio"] . "<br>";
				echo "<b>Hora de cierre</b> " . $row["Final"] . "<br>";
				$probs = explode(' ', $row["Problemas"]);
				echo "<b>Problemas </b>" . sizeof( $probs ) ;
				echo "<br><br>";
			}
		}
		?>
		</td>
		<td>
		<?php

		//concursos futuros
		echo "<h2>Concursos Pasados</h2>";
		if(mysql_num_rows($resultado) > 0)
		{
			while( $row = mysql_fetch_array($resultado) )
			{
				echo "<div style=\"font-size: 16px\"><a href=\"contest_rank.php?cid=" . $row["CID"] .  "\"><b>".$row["Titulo"]."</b>&nbsp;<img src=\"img/1.png\"></a></div>";
				echo "<b>Descripcion</b> " . $row["Descripcion"] . "<br>";
				echo "<b>Organizador</b> ". $row['Owner'] ."<br>";
				echo "<b>Hora de inicio</b> " . $row["Inicio"] . "<br>";
				echo "<b>Hora de cierre</b> " . $row["Final"] . "<br>";
				$probs = explode(' ', $row["Problemas"]);
				echo "<b>Problemas </b>" . sizeof( $probs ) ;
				echo "<br><br>";
			}
		}
		?>
		</td>
		</tr>
	</table>
</div>
</td>
</tr>
</table>

<?php include_once("includes/footer.php"); ?>

