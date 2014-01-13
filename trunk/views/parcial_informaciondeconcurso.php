<?php
	//public static function informacionDeConcuso($concurso)
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