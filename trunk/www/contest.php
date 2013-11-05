<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");
	require_once("includes/head.php");

	function imprimirForma()
	{
		?>
		<form action="" class="form-big" method="post" onsubmit="return validate()">
		<p>	Forma para crear un concurso </p>

		<label for="cname">Nombre del concurso</label>
		<input placeholder="Nombre del concurso" type="text" id="cname" name="cname" class="text"/>

		<label for="cdesc">Descripcion del concurso</label>
		<input placeholder="Descripcion del concurso" type="text" id="cdesc" name="cdesc" class="text" />

		<label for="inicio">Hora actual en Teddy (<?php echo date("d-m-Y H:i:s", mktime(date("H"), date("i") )); ?>)<br><br>
				Inicio del Concurso ( DD-MM-YYYY HH:MM:SS )
			</label>

		<input type="text" id="inicio" name="inicio" class="text" 
			value="<?php echo date("d-m-Y H:i:s", mktime(date("H"), date("i") + 10 )); ?>" />

		<label for="fin">Fin del Concurso ( DD-MM-YYYY HH:MM:SS )</label>
		<input type="text" id="fin" name="fin" class="text" 
			value="<?php echo date("d-m-Y H:i:s", mktime(date("H")+1, date("i") + 10 )); ?>"/>

		<label for="pset">Problemas, ID de los problemas separados por un espacio</label>
		<input placeholder="1 6 7" type="text" id="pset" name="pset" class="text" />

		<input type="submit" class="button" value="Agendar concurso" />
		<input type="hidden" id="form" name="form" value="true" />
		</form>
		<?php
	}

	function validar()
	{
			global $msg;
			
			if (!(isset($_REQUEST["form"]) && ($_REQUEST["form"] == true)))
			{
				$msg = "Mal";
				return false;
			}

			$cname 	= addslashes($_REQUEST["cname"]);
			$cdesc 	= addslashes($_REQUEST["cdesc"]);
			$inicio = addslashes($_REQUEST["inicio"]);
			$fin 	= addslashes($_REQUEST["fin"]);
			$pset 	= addslashes($_REQUEST["pset"]);

			if (strlen($cname) < 5) {
			    $msg =  "Escribe un titulo mas explicativo.";
				return false;
			}
			
			if (strlen($cdesc) < 5) {
			    $msg =  "Escribe una descripcion mas explicativa.";
				return false;
			}
			
					
			//parsear fecha de inicio
			if (($time_inicio = strtotime($inicio)) === false) {
			    $msg =  "La fecha de inicio es invalida.";
				return false;
			} 

			//que no sea en el pasado
			if(time() > $time_inicio){
				$msg = "No puedes iniciar un concurso en el pasado.";
				return false;
			}

			//parsear fecha de final
			if (($time_fin = strtotime($fin)) === false) {
			    $msg =  "La fecha de fin es invalida.";
				return false;
			} 

			if($time_fin < $time_inicio){
				$msg = "El concurso no puede terminar... antes de comenzar.";
				return false;
			}

			$datetime1 = new DateTime($inicio);
			$datetime2 = new DateTime($fin);
			$intervalo = $datetime1->diff($datetime2);
			
			if( (($intervalo->format('%h')*60)+$intervalo->format('%i')) > (60*5)){
				$msg = "No puedes hacer concursos de mas de cinco horas.";
				return false;
			}
			
			
			//verificar los problemas
			$probs = explode(' ', $pset);
			
			if(sizeof($probs) >= 6){
				$msg = "Maximo 6 problemas";
				return false;
			}
			
			if(sizeof($probs) < 2){
				$msg = "Minimo 2 problemas";
				return false;
			}
			
			for ($i=0; $i< sizeof( $probs ); $i++) {
			
				//no puede haber dos problemas iguales
				//todo
				
				$query = "select probID from Problema where probID = '".addslashes($probs[ $i ])."' AND PUBLICO = 'SI'";				
				$rs = mysql_query($query) or die('Algo anda mal: ' . mysql_error());
				
				if(mysql_numrows($rs)!=1){
					$msg = "El problema " . $probs[ $i ] . " no existe.";
					return false;
				}
				
			}
			
			$query = "insert into Concurso(Titulo, Descripcion, Inicio, Final, Problemas, Owner) 
								   values ('$cname','$cdesc','" . date("Y-m-d H:i:s", $time_inicio) . "','" . date("Y-m-d H:i:s", $time_fin) . "','$pset', '" . $_SESSION['userID'] . "')";
			$rs = mysql_query($query) or die("Algo anda mal.");
			return true;

		}//termina validar
	
	global $msg;
	$validate = validar();
?>
<table>
<tr>
<td valign=top>
	<div id="new_contest_form" class="post_blanco" align=center >
	<h2>Crear un concurso</h2>
	<?php
		if(!isset($_SESSION['userID'])){
			//no hay sesion
			echo "<div align=center><h3>Debes iniciar sesion para crear concursos.</h3></div>";
		}else{
			
			//si hay sesion
			//revisar que por lo menos 5 problemas resueltos
			$consulta = "select COUNT( DISTINCT probID ) from Ejecucion where ( userID = '". addslashes( $_SESSION['userID'] ) ."' AND  status = 'OK' )";
			$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());
			$row = mysql_fetch_array($resultado);

			if($row[0] < 5 ){
				
				echo "<div align=center><h3>Debes haber resuelto por lo menos 5 problemas distintos para crear concursos.</h3></div>";				

			}else{
				
				//OK PUEDES CREAR UN CONCURSO

					if(isset($_REQUEST["form"]) && ($_REQUEST["form"] == true)){
						if($validate == true){
						
							echo "<h2>Yeah !!   &nbsp;&nbsp;&nbsp;  :-)</h2>";
							echo "<p> ".$msg."</p>";
							
							//Concurso creado con exito
														
							
						}else{
							echo "<h2>Ups :-(</h2>";
							echo "<p> ".$msg."</p>";
							imprimirForma();
						}
					}else{
						imprimirForma();
					}

			}//si puedo crear un concurso
		}//si tengo sesion
		?>
	</div>
	</td>
	<td>

	<div class="post"  align=center>
		<table style="font-size:12px; border-spacing: 30px 00px;" border=0 >
		<tr valign=top >
		<td>
		<?php
		//obtener fecha
		$timestamp = date( "Y-m-d H:i:s" );

		//obtener concusros de ahorita
		echo "<h2>Concursos Activos</h2>&nbsp;&nbsp;";
		$consulta = "select * from Concurso where BINARY ( '{$timestamp}' > Inicio AND  '{$timestamp}' < Final )";
		$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());

		//revisar si existe un concurso a esta hora
		if(mysql_num_rows($resultado) < 1) {
			//no hay concursos
			echo "<div align='center'>No hay concursos activos.</div>";
		}else{
			//si hay concursos
			while( $row = mysql_fetch_array($resultado) ){
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
		echo "<h2>Concursos Agendados</h2>";
		$consulta = "select * from Concurso where BINARY ( '{$timestamp}' < Inicio )";
		$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());

		if(mysql_num_rows($resultado) > 0){
			while( $row = mysql_fetch_array($resultado) ){
				echo "<div style=\"font-size: 16px\"><a href=\"contest_rank.php?cid=" . $row["CID"] .  "\"><b>".$row["Titulo"]."</b>&nbsp;<img src=\"img/1.png\"></a></div>";
				echo "<b>Descripcion</b> " . $row["Descripcion"] . "<br>";
				echo "<b>Organizador</b> ". $row['Owner'] ."<br>";
				echo "<b>Hora de inicio</b> " . $row["Inicio"] . "<br>";
				echo "<b>Hora de cierre</b> " . $row["Final"] . "<br>";

				$probs = explode(' ', $row["Problemas"]);
				echo "<b>Problemas </b>" . sizeof( $probs ) ;
			
				echo "<br><br>";
			}			
		}else{
			echo "<br><div align='center'>No hay concursos agendados.</div>";
		}


		?>
		</td>
		<td>
		<?php

		//concursos futuros
		echo "<h2>Concursos Pasados</h2>";
		$consulta = "select * from Concurso where BINARY ( '{$timestamp}' > Final ) order by Final desc";
		$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());

		if(mysql_num_rows($resultado) > 0){
			while( $row = mysql_fetch_array($resultado) ){
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

