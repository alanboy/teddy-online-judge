<?php
	// @param runs
?>
<table width="100%">
<thead>
<tr >
	<th width='12%'>Ejecucion</th> 
	<?php
		if (isset($runs[0]["probID"]))
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
			echo "<TD align='center' ><a href='verProblema.php?id=". $row['probID']  ."'>". $row["probID"]   ."</a> </TD>";
		}

		echo "<TD align='center' ><a href='runs.php?user=". $row['userID']  ."'>". $row["userID"]   ."</a> </TD>";
		echo "<TD align='center' >". $row['LANG']   ."</TD>";
		echo "<TD align='center' >".  utils::color_result( $row['status'] ) ."</TD>";
		printf("<TD align='center' > %2.4fs </TD>", $row["tiempo"] / 1000);
		echo "<TD align='center' >". $row["fecha"]   ." </TD>";
		echo "</TR>";
	}
?>
</tbody>
</table>
