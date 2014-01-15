<?php

	require_once("../serverside/bootstrap.php");

	define("PAGE_TITLE", "Problemas");

	require_once("head.php");

?>
<div class="post_blanco">
	<h2>Problem-Set</h2>

	<table style="width:100%">
		<thead>
		<tr>
			<?php
				if(isset($_GET["userID"]))
				{
					$res = c_usuario::getByNick($_GET);

					if (SUCCESS($res))
					{
						$user = $res["user"];
						?>
						<th width='5%'>
						<a href="runs.php?user=<?php echo $_GET['userID']; ?>">
							<img id="avatar" src="https://secure.gravatar.com/avatar/<?php echo md5($user['mail']);	?>?s=140" alt="" width="20" height="20"  />
							<?php echo $_GET['userID']; ?>
						</a>
						</th>
						<?php	
					}
				}
				elseif (c_sesion::isLoggedIn())
				{
					echo "<th width='5%'>Resuelto</th>";
				}
			?>
			<th width='5%'>ID</th>
			<th >Titulo</th>
			<th width='12%'><a href="problemas.php?orden=vistas">Vistas</a></th>
			<th width='12%'><a href="problemas.php?orden=aceptados">Aceptados</a></th>
			<th width='12%'><a href="problemas.php?orden=intentos">Intentos</a></th>
			<th width='12%'>Radio</th>
			</tr>
		</thead>
		<tbody>
		<?php
		
		$params = array("public" => "SI");

		if (isset($_GET["orden"])) {
			$params["orden"] = $_GET["orden"];
		}

		$result = c_problema::lista($params);

		$resueltos = null;
		$intentados = null;

		if(isset($_GET["userID"]) || c_sesion::isLoggedIn())
		{
			if (isset($_GET["userID"]))
			{
				$user = $_GET;
			}
			else
			{
				$user = c_sesion::usuarioActual();
			}
			
			$res = c_usuario::problemasResueltos($user);

			if (SUCCESS($res))
			{
				$resueltos = $res["problemas"];
			}

			$res = c_usuario::problemasIntentados($user);

			if (SUCCESS($res))
			{
				$intentados = $res["problemas"];
			}
		}
		
		if (SUCCESS($result))
		{
			$problemas = $result["problemas"];
			for ($i = 0; $i < sizeof($problemas); $i++)
			{
				$prob = $problemas[$i];

				if ($i %2 ==0) {
					echo "<TR style='background:#e7e7e7;' align=center>";
				}else{
					echo "<TR align=center>";
				}
			
				if (c_sesion::isLoggedIn() || isset($_GET["userID"]))
				{
					echo "<TD >";
					if(in_array($prob['probID'], $resueltos))
					{
						echo "<img title=\"Problema resuelto\" src=\"img/10.png\">";
					} elseif(in_array($prob['probID'], $intentados)) {
						echo "<img title=\"Problema intentado\" src=\"img/12.png\">";
					}
					echo "</td>";
				}
			
				echo "<TD align='center' >". $prob['probID'] ."</TD>";
				echo "<TD align='left' ><a href='verProblema.php?id=". $prob['probID']  ."'>". $prob['titulo']   ."</a> </TD>";
				echo "<TD align='center' >". $prob['vistas']   ." </TD>";
				echo "<TD align='center' >". $prob['aceptados']   ." </TD>";
				echo "<TD align='center' >". $prob['intentos']   ." </TD>";

				if ( $prob['intentos'] != 0 ) {
					printf("<TD align='center' >%2.2f%%</TD>",  ($prob['aceptados'] / $prob['intentos']) *100);
				}else{
					printf("<TD align='center' >%2.2f%%</TD>", 0);
				}

				echo "</TR>";
			}
		}

		?>
		</tbody>
	</table>
	</div>

<?php include_once("post_footer.php"); ?>

