<?php
//public static function listaDeConcursos($concursos)
?>
<?php

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