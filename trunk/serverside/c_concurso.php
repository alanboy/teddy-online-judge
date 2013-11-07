<?php

class c_concurso extends c_controller
{
	public static function info()
	{
	{
	global $CONTEST;
	global $STATUS;
	global $CDATA;	
	
	if($CONTEST == NULL) {
		echo  "<div align='center'><h2>Este concurso no es valido.</h2></div>" ;
		return;
	}

	?>
	<div align=center>
		
	<div><h2><?php echo $CDATA["Titulo"]; ?></h2></div>
	<div><?php echo $CDATA["Descripcion"]; ?></div>
	
	<table border='0' cellspacing="5" style="font-size: 14px;" > 
	<thead>
		<tr align=center>
		<th >Organizador</th>
		<?php
		if($STATUS == "NOW" || $STATUS == "PAST"){
			echo "<th >Problemas</th>";
		}
		?>
		<th >Inicia</th>
		<th >Termina</th>
		</tr> 
	</thead> 
	<tbody >
		<tr align=center style="background-color: #e7e7e7">
			<td><?php echo $CDATA["Owner"]; ?></td>
			
			<?php
			// Si ya comenzo o esta en el pasado
			if($STATUS == "NOW" || $STATUS == "PAST"){
				echo "<td>";
				$probs = explode(' ', $CDATA["Problemas"]);
				for ($i=0; $i< sizeof( $probs ); $i++) {
					echo "<a target='_blank' href='verProblema.php?id=". $probs[$i]  ."&cid=". $_REQUEST['cid'] ."'>". $probs[$i] ."</a>&nbsp;";
				}		
				echo "</td>";			
			}
			?>

			<td><?php echo $CDATA["Inicio"]; ?></td>
			<td><?php echo $CDATA["Final"]; ?></td>
		</tr>
	</tbody>
	</table>
	<a href="showcase.php?cid=<?php echo $_REQUEST["cid"]; ?>">[showcase/tablero para proyectar resultados]</a>
	</div>
	<?php

	
}
	
	}

	public static function canshow()
	{
		//validar el concurso que voy a renderear
		if(!isset($_REQUEST["cid"])){
			die(header("Location: contest.php"));
		}

		//validar que el concurso exista
		$q = "SELECT * from Concurso where CID = ". mysql_real_escape_string( $_REQUEST['cid'] ) .";";
		$resultado = mysql_query($q) or pretty_die("Error al buscar este concurso.");

		if(mysql_num_rows($resultado) != 1) {
			die("Este concurso no existe.");
		}

		$CONTEST = NULL;
		$STATUS = null;
		$CDATA = null;

		//este concurso existe
		$CONTEST = $_REQUEST['cid'] ;

		//revisar si, es pasado, actual, o en el futuro
		$row = mysql_fetch_array($resultado);

		// cdata contiene los datos de este concurso que trae el sql
		$CDATA = $row;	

		if( (time() > strtotime($row["Inicio"])) && ( time() < strtotime($row["Final"]) ) ){
			// activo
			$STATUS = "NOW";
		}

		if( (time() > strtotime($row["Final"])) ){
			// ya termino
			$STATUS = "PAST";		
		}

		if( time() < strtotime($row["Inicio"]) ){
			// activo
			$STATUS = "FUTURE";
		}
	}

	public static function lista()
	{
		//obtener fecha
		$timestamp = date( "Y-m-d H:i:s" );

		//obtener concusros de ahorita
		echo "<h2>Concursos Activos</h2>&nbsp;&nbsp;";
		$consulta = "select * from Concurso where BINARY ( '{$timestamp}' > Inicio AND  '{$timestamp}' < Final )";
		$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());

	}



	public static nuevo()
	{
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
		}
}
