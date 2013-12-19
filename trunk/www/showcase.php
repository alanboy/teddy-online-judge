<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Concurso");

	require_once("head.php");

//validar el concurso que voy a renderear
if(!isset($_REQUEST["cid"]))
{
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

if( (time() > strtotime($row["Inicio"])) && ( time() < strtotime($row["Final"]) ) )
{
	$STATUS = "NOW";
}

if( (time() > strtotime($row["Final"])) ){
	// ya termino
	$STATUS = "PAST";
}

if( time() < strtotime($row["Inicio"]) )
{
	// activo
	$STATUS = "FUTURE";
}


?>

	<div class="post_blanco" >
		<?php
		if($CONTEST == NULL)
		{
			echo  "<div align='center'><h2>Este concurso no es valido.</h2></div>" ;
			return;
		}
		else
		{
		?>
			<div>
				<div><h2><?php echo $CDATA["Titulo"]; ?></h2></div>
				<div><?php echo $CDATA["Descripcion"]; ?></div>
			</div>
		<?php
		}
		?>
	</div>

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
					$datetime1 = date_create( $CDATA['Final']);
					$datetime2 = date_create(date("Y-m-d H:i:s"));
					$interval = date_diff($datetime1, $datetime2);
					echo "<span id='time_left'>" . $interval->format('%H:%I:%S') . "</span> restante.";					
					?>
					<script>
						setInterval("updateTime()", 1000);
					</script>
					<?php
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

						for ($i=0; $i< sizeof( $PROBLEMAS ); $i++)
						{
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
			askforruns();
			</script>
		</div>
		<?php
	}
	?>
	
	
	<?php include_once("footer.php"); ?>

