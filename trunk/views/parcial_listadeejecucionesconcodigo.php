<?php
	// @param runs
?>
<table width="100%" border=0>
<tbody>
<?php
	for ($n = 0; $n < sizeof($runs); $n++)
	{
		$row = $runs[$n];

		echo "<TR >";
		echo "<TD valign=top >";
			?>
			<table width=100% style="text-align:center; margin-top:60px;">
<tr><td>
up
</td></tr>
<tr><td>
<div style="font-size:40px">
0
</div>
</td></tr>
<tr><td>
down
</td></tr>
<tr><td>
<img src="img/50.png">Reportar
</td></tr>
<tr><td>
<img src="img/14.png">Favorito
</td></tr>
</table>


			<?php
		echo "</TD>";
		echo "<TD>";
		echo "<div style='padding:10px'>";
		$execID = $row['execID'];
		include 'parcial_mostrarcodigo.php';
		?>
		
		<textarea style="width:85%; margin-left:45px" placeholder="Comentario"></textarea>
		<input type="button" value="Comentar">
<br><br>

		<?php
		echo "</div>";
		echo "</TD >";
		echo "</TR>";
	}
?>
</tbody>
</table>
