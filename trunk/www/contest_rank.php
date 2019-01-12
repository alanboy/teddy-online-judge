<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Rank");

	require_once("head.php");
?>
<div class="post_blanco"  >
	<!-- informacion del concurso -->
	<?php
	$result = c_concurso::info($_GET);
	$concurso = $result["concurso"];
	if (SUCCESS($result))
	{
		if (!is_null($concurso))
		{
			include("parcial_informaciondeconcurso.php");
		} else {
			echo "Este concurso no existe";
		}
	}
	?>
</div>

<div class="">
	<ul id="subtabs" class="new-style">
		<li  class="subtab selected">
			<a href="#rank" onclick="ShowTab( 'tab-concurso-rank', this);">
			<span>Rank</span>
			</a>
		</li>
		<li  class="subtab">
			<a href="#runs" onclick="ShowTab( 'tab-concurso-runs', this);">
			<span>Envios</span>
			</a>
		</li>
		<li  class="subtab rightmost-tab">
			<a href="#enviar" onclick="ShowTab( 'tab-concurso-enviar', this);">
			<span>Enviar solucion</span>
			</a>
		</li>
	</ul>
</div>

	
	<div class="post_blanco tab" id="tab-concurso-enviar">
		<!-- ENVIAR SOLUCION -->
		<div style="font-size: 18px" align=center>
			<?php
			if (!is_null($concurso))
			{
				switch($concurso["status"])
				{
				case "PAST":
					echo "Este concurso ha terminado.";
					break;

				case "FUTURE":
					echo "Este concurso iniciar&aacute; en ";
					$datetime1 = date_create( $concurso['Inicio']);
					$datetime2 = date_create(date("Y-m-d H:i:s"));
					$interval = date_diff($datetime1, $datetime2);

					if ($interval->format('%D') > 0)
					{
						echo "<b>" . $interval->format('%D') . "</b> dias.";
					}
					else
					{
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
					$datetime1 = date_create( $concurso['Final']);
					$datetime2 = date_create(date("Y-m-d H:i:s"));
					$interval = date_diff($datetime1, $datetime2);
					echo "<br><span id='time_left'>" . $interval->format('%H:%I:%S') . "</span> restante.";

					if (!isset($_SESSION['userID']))
					{
						?> <div align="center">Debes iniciar sesion en la parte de arriba para poder enviar problemas a <b>Teddy</b>.</div> <?php
					}else{
					}
					break;
				}
			}
			?>
		</div>
	</div>
	<?php
	if (!is_null($concurso)) {
		$STATUS = $concurso["status"];
		if ( $STATUS == "NOW" || $STATUS  == "PAST" ) {
		?>
		<!--
			RANK
		-->
		<div class="post_blanco tab" id="tab-concurso-rank">
			<div style="font-size: 18px" align=center>Ranking</div>	
			<div id='ranking_div' align=center>
				<table border='0' style="font-size: 14px;" > 
				<thead> <tr >
					<th width='50px'>Rank</th>
					<th width='12%'>Usuario</th>
					<th width='50px'>Envios</th>
					<th width='50px'>Resueltos</th> 
<?php

			$PROBLEMAS = explode(' ', $concurso["Problemas"]);

			for ($i=0; $i< sizeof( $PROBLEMAS ); $i++)
			{
				echo "<th width='100px'><a target='_blank' href='verProblema.php?id=" . $PROBLEMAS[$i]. "&cid=". $_REQUEST['cid']."'>Problema ".$PROBLEMAS[$i]."</a></th> ";
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
	}
	/***********************************************
			RUNS
	 ***********************************************/
	if ($STATUS == "NOW" || $STATUS  == "PAST" )
	{
		?>
		<!-- 
			RUNS
		-->
		<div class="post_blanco tab" id="tab-concurso-runs">
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
				CurrentProblems = [<?php foreach($PROBLEMAS as $p){ echo $p . ","; } ?>];
				RenderContest(<?php echo $_REQUEST['cid']; ?>);
			</script>
		</div>
		<?php
	}
	?>
	<script>
		// Mostrar el tab de rank
		ShowTab("tab-concurso-rank", $("li.subtab a")[0]);
	</script>
	<?php include_once("post_footer.php"); ?>

