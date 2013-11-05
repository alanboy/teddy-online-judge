<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");
	require_once("includes/head.php");




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
		




/***** ****************************
	CABECERA
 ***** ****************************/
function start()
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



/***** ****************************
	IMPRIMIR FORMA DE ENVIO
 ***** ****************************/
function imprimirForma(){
	
	global $row;
	
	
	envios::imprimir_forma_de_envio( $_REQUEST['cid'] );
	
	?>
	<!--
	<div align="center" >
	<form action="contest_rank.php?cid=<?php echo $_REQUEST['cid']; ?>" method="POST" enctype="multipart/form-data">
		<br>
		<table border=0>
			 <tr><td  style="text-align: right">Codigo fuente&nbsp;&nbsp;</td><td><input name="userfile" type="file"></td></tr>
			
			 <tr><td style="text-align: right">Problema&nbsp;&nbsp;</td><td>
			 	<select name="prob">	
				<?php

				$probs = explode(' ', $row["Problemas"]);
				for ($i=0; $i< sizeof( $probs ); $i++) {
					echo "<option value=". $probs[$i] .">". $probs[$i] ."</option>"; //"<a href='verProblema.php?id=". $probs[$i]  ."'>". $probs[$i] ."</a>&nbsp;";
				}

				?>
				</select>
			 </td></tr>
			
			 <tr><td></td><td><input type="submit" value="Enviar Solucion"></td></tr>
		</table>
	    <input type="hidden" name="ENVIADO" value="SI">
	    <input type="hidden" name="cid" value="<?php echo $_REQUEST['cid']; ?>">
	    
	</form> 
	</div>
	-->
	<?php
}




/***** ****************************
	ENVIAR PROBLEMA
 ***** ****************************/
function enviando()
{
	global $CDATA;	


	//tomo el valor de un elemento de tipo texto del formulario
	$usuario 		= $_SESSION	["userID"];
	$prob    		= $_POST["prob"];
	$CONCURSO_ID 	= $_REQUEST['cid'];

	//revisar que su ultimo envio sea mayor a 5 minutos

	//revisar que este problema exista para este concurso
	$PROBLEMAS = explode(' ', $CDATA["Problemas"]);						

	$found = false;

	for ($i=0; $i< sizeof( $PROBLEMAS ); $i++) {
		if($prob ==$PROBLEMAS[$i]) $found = true;
	}

	if(!$found){
		echo "<br><div align='center'><b>Ups, este problema no es parte de este concurso.</b><br><br></div>";
		imprimirForma();
		return;
	}



	//revisar si existe este problema
	$consulta = "select probID , titulo from Problema where BINARY ( probID = '{$prob}' ) ";
	$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());

	//si este problema no existe, salir
	if(mysql_num_rows($resultado) != 1) {
		echo "<br><div align='center'><b>Ups, este problema no existe.</b><br>Vuelve a intentar. Recuerda que el id es el numero que acompa&ntilde;a a cada problema.<br><br></div>";
		imprimirForma();
		return;
	}


	$row = mysql_fetch_array( $resultado );
	$TITULO = $row["titulo"];

	//datos del archivo
	$nombre_archivo = $_FILES['userfile']['name'];
	$tipo = $_FILES['userfile']['type'];
	$fname = $_FILES['userfile']['name'];

	//revisar que no existan espacios en blacno en el nombre del archivo
	$fname = strtr($fname, " ", "0");
	$fname = strtr($fname, "_", "0");
	$fname = strtr($fname, "'", "0");

	//compruebo si las características del archivo son las que deseo
	//si (no es text/x-java) y (no termina con .java) tons no es java	

	if ( !(endsWith($fname, ".java") || endsWith($fname, ".c") || endsWith($fname, ".cpp")|| endsWith($fname, ".py") || endsWith($fname, ".pl")) ) {
		echo "<br><br><div align='center'><h2>Error :-(</h2>Debes subir un archivo que contenga un codigo fuente valio y que termine en alguna de las extensiones que <b>teddy</b> soporta.<br>";
		echo "Tipo no permitido: <b>". $tipo . "</b> para <b>". $_FILES['userfile']['name'] ."</b></div><br>";

		imprimirForma();

		return;
	}



	//insertar userID, probID, remoteIP
	mysql_query ( "INSERT INTO Ejecucion (`userID` , `probID` , `remoteIP`, `Concurso`) VALUES ('{$usuario}', {$prob}, '" . $_SERVER['REMOTE_ADDR']. "', " . $_REQUEST['cid'] . "); " ) or die('Algo anda mal: ' . mysql_error());
	$resultado = mysql_query ( "SELECT `execID` FROM `Ejecucion` order by `fecha` desc limit 1;" ) or die('Algo anda mal: ' . mysql_error());
	$row = mysql_fetch_array ( $resultado );

	$execID = $row["execID"];

	//mover el archio a donde debe de estar
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], "../codigos/" . $execID . "_" . $fname)){

	}else{
		//if no problem al subirlo	
		echo "Ocurrio algun error al subir el archivo. No pudo guardarse.";
	}

	imprimirForma();
}


?>
	<!-- 
		INFORMACION DEL CONCURSO
	-->
	<div class="post_blanco" >
	<?php
		//informacion del concurso
		start();
	?>	
	</div>
	
	<!-- 
		ENVIAR SOLUCION
	-->
	<div class="post" >
		<div style="font-size: 18px" align=center>
			<?php

			switch($STATUS){
				case "PAST": 
 					echo "Este concurso ha terminado.";
				break;
				
				case "FUTURE": 
					echo "Este concurso iniciar&aacute; en "; 
					$datetime1 = date_create( $CDATA['Inicio']);
					$datetime2 = date_create(date("Y-m-d H:i:s"));
					$interval = date_diff($datetime1, $datetime2);
					
					if($interval->format('%D') > 0){
						echo "<b>" . $interval->format('%D') . "</b> dias.";	
					}else{

						?>
							<b><span id='time_left'><?php echo $interval->format('%H:%I:%S'); ?></span></b>.
							<script>
								setInterval("updateTime()", 1000);
							</script>
						<?php
					}
					

				break;	
				
				case "NOW": 
					echo "Enviar Soluciones al concurso";
					$datetime1 = date_create( $CDATA['Final']);
					$datetime2 = date_create(date("Y-m-d H:i:s"));
					$interval = date_diff($datetime1, $datetime2);
					echo "<br><span id='time_left'>" . $interval->format('%H:%I:%S') . "</span> restante.";					
					
					if( ! isset($_SESSION['userID'] ) ){
						?> <div align="center">Debes iniciar sesion en la parte de arriba para poder enviar problemas a <b>Teddy</b>.</div> <?php
					}else{
						if( isset($_REQUEST["ENVIADO"]) )
							enviando();
						else
							imprimirForma();
					}
				break;
			}
			

			
			?>	
		</div>
	</div>
	
	
	
	
	<?php

	if( $STATUS == "NOW" || $STATUS  == "PAST" ){
		?>
		<!-- 
			RANK
		-->
		<div class="post_blanco" >
			<div style="font-size: 18px" align=center>Ranking</div>	
			<div id='ranking_div' align=center>
				<table border='0' style="font-size: 14px;" > 
				<thead> <tr >
					<th width='50px'>Rank</th> 
					<th width='12%'>Usuario</th> 
					<th width='50px'>Envios</th> 					
					<th width='50px'>Resueltos</th> 
					<?php
						
						$PROBLEMAS = explode(' ', $CDATA["Problemas"]);						

						for ($i=0; $i< sizeof( $PROBLEMAS ); $i++) {
							echo "<th width='100px'><a target='_blank' href='verProblema.php?id=" . $PROBLEMAS[$i]. "&cid=". $_REQUEST['cid']."'>".$PROBLEMAS[$i]."</a></th> ";
						}
					?>
					<th width='12%'>Penalty</th>
					</tr> 
				</thead> 
				<tbody id="ranking_tabla">
				</tbody>
				</table>
			</div>
		</div>
		<?php
	}
	?>
	
	
	
	
	<?php
	/***********************************************
			RUNS
	 ***********************************************/
	if( $STATUS == "NOW" || $STATUS  == "PAST" ){
		?>
		<!-- 
			RUNS
		-->
		<div class="post" >
			<div style="font-size: 18px" align=center>Envios</div>
			<div id='runs_div' align=center>
				<table border='0' style="font-size: 14px;" > 
				<thead> <tr >
					<th width='12%'>execID</th> 
					<th width='12%'>Problema</th> 
					<th width='12%'>Usuario</th> 
					<th width='12%'>Lenguaje</th> 
					<th width='12%'>Resultado</th> 
					<th width='12%'>Tiempo</th> 
					<th width='12%'>Fecha</th>
					</tr> 
				</thead> 
				<tbody id="runs_tabla">
				</tbody>
				</table>
			</div>
			<script>
				askforruns(<?php echo $_REQUEST['cid']; ?>);
			</script>
		</div>
		<?php
	}
	?>
	
	
	<?php include_once("includes/footer.php"); ?>

