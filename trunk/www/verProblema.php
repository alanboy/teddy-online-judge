<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Ver Problema");

	require_once("head.php");

	$prob = array( "probID" => $_GET["id"]);

?>
<div class="post">

	<?php
		$result = c_problema::problema($prob);

		if (SUCCESS($result))
		{
			// es un problema privado ?
			if (($result["problema"]["publico"] == "NO") && !c_sesion::isAdmin())
			{
				echo "<div align='center'><h2>El problema " . $_GET["id"] . " no es publico.</h2></div>";
				echo "</div>";
				include_once("post_footer.php");
				exit;
			}

			c_problema::problemaAddView($prob);
			$row = $result["problema"];
			$tiempo = $row['tiempoLimite'] / 1000;

			echo "<h2>" . $_GET["id"] . ". " . $row['titulo'] ."</h2>";
			echo "<p>Limite de tiempo : <b>" . $tiempo . "</b> seg. &nbsp;&nbsp;";
			echo "Total runs : <b>" . $row['intentos'] . "</b>&nbsp;&nbsp;";
			echo "Aceptados : <b>" . $row['aceptados'] . "</b></p> ";
			echo  $row['problema'] ;

			?>
				<div align="center">
					<form action="enviar.php" method="get">
						<input type="hidden" name="send_to" value="<?php echo $_GET['id']; ?>">
					<?php
					if (isset($_REQUEST['cid'])) {
					?>
						<input type="hidden" name="cid" value="<?php echo $_REQUEST['cid']; ?>">
					<?php
					}
					?>
						<input type="submit" value="enviar solucion">
					</form>
				</div>
			<?php
		}
		else
		{
			echo "<div align='center'><h2>El problema " . $_GET["id"] . " no existe.</h2></div>";
		}
	?>
</div>
<?php
$result = c_sesion::usuarioActual();

if (SUCCESS($result))
{
	$result = c_usuario::problemasResueltos($result);
}

if (SUCCESS($result))
{
	$resuelto = false;
	for ($i = 0; $i < sizeof($result["problemas"]); $i++)
	{
		if ($result["problemas"][$i] == $_GET["id"])
		{
			$resuelto = true;
			break;
		}
	}

	if ($resuelto)
	{
	?>
		<div >
			<ul id="subtabs" class="new-style">
				<li  class="subtab selected">
					<a href="#codigos" onclick="ShowTab( 'tab-verproblema-codigos', this);">
					<span>Codigos</span>
					</a>
				</li>
				<li  class="subtab">
					<a href="#casos" onclick="ShowTab( 'tab-verproblema-casos', this);">
					<span>Casos</span>
					</a>
				</li>
				<li  class="subtab rightmost-tab">
					<a href="#stats" onclick="ShowTab( 'tab-verproblema-stats', this);">
					<span>Estadisticas</span>
					</a>
				</li>
			</ul>
		</div>
		<div class="post_blanco tab" id="tab-verproblema-codigos">
			<h2>Mejores tiempos para este problema</h2>
			<?php
				if (!isset($_REQUEST['cid']))
				{
					$res = c_problema::mejoresTiempos($prob);
					if (SUCCESS($res))
					{
						$runs = $res["tiempos"];
						echo "<div style='padding:15px'>";
						include ("parcial_listadeejecucionesconcodigo.php");
						echo "</div>";
					}
				}
			?>
		</div>
		<div class="post_blanco tab" id="tab-verproblema-stats">
		</div>
		<script>
			// Mostrar el tab de rank
			ShowTab("tab-verproblema-codigos", $("li.subtab a")[0]);
		</script>
	<?php
	}
}


	include_once("post_footer.php");
?>
