
<div class="post_blanco">
<table width="100%">
<thead>
<tr >
	<th width='12%'>Nombre</th> 
	<th width='12%'>Usuarios</th> 
	<th width='12%'>Ciudades</th> 
</tr> 
</thead> 
<tbody>
<?php
	for ($n = 0; $n < sizeof($escuelas); $n++)
	{
		$row = $escuelas[$n];
		if ($n %2 ==0)
		{
			echo "<TR style='background:#e7e7e7;' align=center>";
		}
		else
		{
			echo "<TR align=center>";
		}

		echo "<TD align='center' ><a href='runs.php?user=". $row['escuela']  ."'>". $row["escuela"]   ."</a> </TD>";
		echo "<TD align='center' >". $row['count']   ."</TD>";
		echo "<TD align='center' ></TD>";

		echo "</TR>";
	}
?>
</tbody>
</table>
</div>