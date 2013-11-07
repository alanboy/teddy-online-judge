<?php
	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("includes/head.php");
?>
	<div class="post_blanco">
	<div align="center" >
	<table border='0' style="font-size: 14px;" > 
	<thead> <tr >
		<th width='5%'>Rank</th> 
		<th width='5%'>Usuario</th> 
		<th width='15%'>Ubicacion</th> 
		<th width='15%'><!--<a href="rank.php?order=escuela">-->Escuela<!--</a>--></th> 
		<th width='5%'><!--<a href="rank.php?order=resueltos">-->Resueltos<!--</a>--></th> 
		<th width='5%'><!--<a href="rank.php?order=envios">-->Envios<!--</a>--></th> 
		<th width='5%'>Radio</th> 
		</tr> 
	</thead> 
	<tbody>
	<?php
	while($false)
	{
		$nick = $row['userID'];

		if( $row['solved'] != 0 )
			$ratio = substr( ($row['solved'] / $row['tried'])*100 , 0, 5);
		else
			$ratio = 0.0;

		//checar si hay una sesion y si si hay mostrar el usuario actual en cierto color
		if(isset($_SESSION['userID']) &&  $_SESSION['userID'] == $row['userID'] ){
	        echo "<TR style=\"background:#566D7E; color:white;\">";
			$flag = !$flag;
		}else{ 
			if($flag){
				echo "<TR style=\"background:#e7e7e7;\">";
				$flag = false;
			}else{
				echo "<TR style=\"background:white;\">";
				$flag = true;
			}
		}

		echo "<TD align='center' >". $rank ."</TD>";
		
		if(isset($_SESSION['userID']) &&  $_SESSION['userID'] == $row['userID'] ){
			echo "<TD align='center' ><a style=\"color:white;\" href='runs.php?user=". htmlentities($row['userID'])  ."'>". $nick   ."</a> </TD>";
		}else{
			echo "<TD align='center' ><a href='runs.php?user=". htmlentities($row['userID'])  ."'>". $nick   ."</a> </TD>";
		}
		echo "<TD align='center' >".  htmlentities(utf8_decode($row['ubicacion'])) ." </TD>";
		echo "<TD align='center' >".  htmlentities(utf8_decode($row['escuela'])) ." </TD>";
		echo "<TD align='center' >". $row['solved']  ." </TD>";
		echo "<TD align='center' >". $row['tried']   ." </TD>";
		//echo "<TD align='center' > {$ratio}% </TD>";
		printf("<TD align='center' > %2.2f%% </TD>", $ratio);


		echo "</TR>";
		$rank++;
	}
	?>		
	</tbody>
	</table>
	</div>
	</div>



	<?php include_once("includes/footer.php"); ?>

