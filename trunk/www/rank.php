<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("head.php");

?>
<div class="post_blanco">
	<table>
	<thead> <tr >
		<th width='5%'>Rank</th> 
		<th width='5%'>Usuario</th> 
		<th width='15%'>Ubicacion</th> 
		<th width='15%'><a href="rank.php?order=escuela">Escuela</a></th> 
		<th width='5%'><a href="rank.php?order=resueltos">Resueltos</a></th> 
		<th width='5%'><a href="rank.php?order=envios">Envios</a></th> 
		<th width='5%'>Radio</th> 
		</tr> 
	</thead> 
	<tbody>
	<?php
		$res = c_usuario::rank();
		$rank = $res["rank"];
		for ($n = 0; $n < sizeof($rank); $n++)
		{
			$user = $rank[$n];

			if ($n %2 ==0)
			{
				echo "<TR style='background:#e7e7e7;' align=center>";
			}
			else
			{
				echo "<TR align=center>";
			}
			echo "<TD align='center' >". $n ."</TD>";
			echo "<TD >". $user["userID"] ."</TD>";
			echo "<TD >". $user["ubicacion"] ."</TD>";
			echo "<TD >". $user["escuela"] ."</TD>";
			echo "<TD >". $user["solved"] ."</TD>";
			echo "<TD >". $user["tried"] ."</TD>";

			$ratio =  ($user['solved'] / ($user['tried']+1))*100 ;
			printf("<TD align='center' > %2.2f%% </TD>", $ratio);
			echo "</tr>";
		}
	?>
	</tbody>
	</table>
</div>

<?php include_once("footer.php"); ?>

