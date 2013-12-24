<?php

class gui
{
	public static function listaDeConcursos($concursos)
	{
		foreach ($concursos as $row)
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
	
	public static function listaDeRuns($runs)
	{
		?>
		<table width="100%">
		<thead>
		<tr >
			<th width='12%'>Ejecucion</th> 
			<?php
				if (isset($row["probID"]))
				{
					echo "<th width='12%'>Problema</th>";
				}
			?>
			 
			<th width='12%'>Usuario</th> 
			<th width='12%'>Lenguaje</th> 
			<th width='12%'>Resultado</th> 
			<th width='12%'>Tiempo</th> 
			<th width='12%'>Fecha</th>
		</tr> 
		</thead> 
		<tbody>
		<?php
			for ($n = 0; $n < sizeof($runs); $n++)
			{
				$row = $runs[$n];
				if ($n %2 ==0)
				{
					echo "<TR style='background:#e7e7e7;' align=center>";
				}
				else
				{
					echo "<TR align=center>";
				}
				echo "<TD align='center' ><a href='verCodigo.php?execID={$row['execID']}'>". $row['execID'] ."</a></TD>";
				if (isset($row["probID"]))
				{
					echo "<TD align='center' ><a href='verProblema.php?pid=". $row['probID']  ."'>". $row["probID"]   ."</a> </TD>";
				}
				echo "<TD align='center' ><a href='runs.php?user=". $row['userID']  ."'>". $row["userID"]   ."</a> </TD>";
				echo "<TD align='center' >". $row['LANG']   ."</TD>";
				echo "<TD align='center' >".  $row['status'] ."</TD>";
				printf("<TD align='center' > %2.4fs </TD>", $row["tiempo"] / 1000);
				echo "<TD align='center' >". $row["fecha"]   ." </TD>";
				echo "</TR>";
			}
		?>
		</tbody>
		</table>
		<?php
	}

	public static function informacionDeConcuso($concurso)
	{
		$STATUS = $concurso["status"];
		?>
		<div align=center>
		<div><h2><?php echo $concurso["Titulo"]; ?></h2></div>
		<div><?php echo $concurso["Descripcion"]; ?></div>
		<table border='0' cellspacing="5" style="font-size: 14px;" > 
		<thead>
			<tr align=center>
			<th >Organizador</th>
			<?php
			if($STATUS == "NOW" || $STATUS == "PAST")
			{
				echo "<th >Problemas</th>";
			}
			?>
			<th >Inicia</th>
			<th >Termina</th>
			</tr> 
		</thead> 
		<tbody >
			<tr align=center style="background-color: #e7e7e7">
				<td><?php echo $concurso["Owner"]; ?></td>
			<?php
			// Si ya comenzo o esta en el pasado
			if($STATUS == "NOW" || $STATUS == "PAST"){
				echo "<td>";
				$probs = explode(' ', $concurso["Problemas"]);
				for ($i=0; $i< sizeof( $probs ); $i++)
				{
					echo "<a target='_blank' href='verProblema.php?id=". $probs[$i]  ."&cid=". $_REQUEST['cid'] ."'>". $probs[$i] ."</a>&nbsp;";
				}
				echo "</td>";
			}
			?>
				<td><?php echo $concurso["Inicio"]; ?></td>
				<td><?php echo $concurso["Final"]; ?></td>
			</tr>
		</tbody>
		</table>
		<a href="showcase.php?cid=<?php echo $_REQUEST["cid"]; ?>">[showcase/tablero para proyectar resultados]</a>
		</div>
		<?php
	}
}
