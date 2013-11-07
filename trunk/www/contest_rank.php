<?php 

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("includes/head.php");

?>
	<div class="post_blanco" >
		<!-- informacion del concurso -->
	</div>
	
	<div class="post" >
		<!-- ENVIAR SOLUCION -->
		<div style="font-size: 18px" align=center>
			<?php
			switch($STATUS)
			{
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

