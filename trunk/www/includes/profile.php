<?php

//concursos
$sql = 'SELECT DISTINCT concurso FROM  `Ejecucion` WHERE concurso > 0 AND userID =  "' . addslashes($_GET['user']) . '"';
$resultado = mysql_query($sql) or die('Algo anda mal: ' . mysql_error());
$ncontests = mysql_num_rows($resultado);

//vamos a imprimir cosas del usuario
$query = "select userID, nombre, solved, tried, escuela, ubicacion, twitter, mail from Usuario where userID = '" . addslashes($_GET['user']) . "'";
$resultado = mysql_query($query) or die('Algo anda mal: ' . mysql_error());

if(mysql_num_rows($resultado) != 1)
{
	echo "<h2>Ups</h2>";
	echo "Este usuario no existe";
	return;
}

$row = mysql_fetch_array($resultado);
?>
			<table border=0><tr>
			<td>
				<img 
					id="" 
					src="https://secure.gravatar.com/avatar/<?php echo md5( $row['mail']); ?>?s=140" 
					alt="" 
					width="75" 
					height="75"  />
			</td>
			<td width='400px'>

<?php
echo "		<h2>" . htmlentities(utf8_decode( $_GET['user'])) . "</h2>";
echo "		<b>" .  htmlentities(utf8_decode( $row['nombre'])) . "</b><br>". htmlentities(utf8_decode($row['ubicacion'])) ." <b> - </b> ". htmlentities(utf8_decode($row['escuela'])) ;
echo "</td><td>";		

if( $row[3] != 0 ){
	$rat = ($row[2]/$row[3])*100;
	$rat = substr( $rat , 0 , 5 ) . "%";
}else
	$rat = "0.0%";

if(strlen($row[6]) > 0){
	$twitter = "<a href='http://twitter.com/{$row[6]}'>{$row[6]}</a>";
}else{
	$twitter = "";
}

echo "		<table>";
echo "		<tr><td width='100px'><b>Enviados</b></td><td width='100px'><b>Resueltos</b></td><td width='100px'><b>Radio</b></td><td><b>Concursos</b>&nbsp;&nbsp;</td><td><b>Twitter</b></td></tr>";
echo "		<tr><td>{$row[3]}</td><td><b>{$row[2]}</b></td><td>{$rat}</td><td>{$ncontests}</td><td>{$twitter}</td></tr>";
echo "		</table>";
echo "</td></tr></table>";


//problemas resultos
$query = "select distinct probID from Ejecucion where userID = '" . $_GET['user'] . "' AND status = 'OK' order by probID";
$resultado = mysql_query($query) or die('Algo anda mal: ' . mysql_error());

if( mysql_num_rows( $resultado ) == 0 )
	echo "<div align=center><br><h3>Problemas resueltos</h3><b>" . $_GET["user"] . "</b> no ha resuelto ningun problema hasta ahora.<br>";
else
	echo "<div align=center><br><h3>Problemas resueltos</h3><br>";


while($row = mysql_fetch_array($resultado)){
	echo " <a title='{$probset[$row['probID'] ]}' href=\"verProblema.php?id={$row['probID']}\">{$row['probID']}</a> &nbsp;";
}


echo "</div><br><br>";
?>
			<div align="center">
				<h3>Run-Status</h3>
				Estos son TODOS los envios que ha hecho <?php echo $_GET["user"]; ?> :
			</div>

