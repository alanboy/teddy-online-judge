<?php 

	require_once("../../serverside/bootstrap.php");

	define("PAGE_TITLE", "Editar perfil");

	require_once("head.php");
	require_once("require_login.php");
	require_once("require_admin.php");

?>
<div class="post_blanco"> <h2>Revisar un codigo fuente</h2>

<?php
	function mostrarCodigo( $lenguaje, $execID , $row){
		$file  = "../../codigos/" . $execID  ;
		switch($lenguaje)
		{
			case "JAVA": $file .= ".java"; $sintaxcolor = "java"; break;
			case "C": $file .= ".c"; $sintaxcolor = "c"; break;
			case "C++": $file .= ".cpp"; $sintaxcolor = "cpp"; break;
			case "C#": $file .= ".cs"; $sintaxcolor = "csharp"; break;
			case "Python": $file .= ".py"; $sintaxcolor = "py"; break;
			case "Perl": $file .= ".pl"; $sintaxcolor = "py"; break;
			default : $file .= ".java"; $sintaxcolor = "java";
		}

		$lines = file($file);
			$codigo = "";
			$lineas_num = "";
			foreach( $lines as $line_num => $line ){
			$codigo .= htmlspecialchars( $line );
			$lineas_num .= ($line_num + 1) . "<br>";
		}

		
		?>
		<div class="post">
			<div align=center >
				<table border='0' style="font-size: 14px;" > 
				<thead> <tr >
					<th width='12%'>execID</th> 
					<th width='12%'>Usuario</th> 
					<th width='12%'>Lenguaje</th> 
					<th width='12%'>Resultado</th> 
					<th width='10%'>Tiempo</th> 
					<th width='14%'>Fecha</th>
					</tr> 
				</thead> 
				<tbody>
				<?php
						$nick = $row['userID'];
			        	echo "<TR style=\"background:#e7e7e7;\">";
						$cuando = date("F j, Y h:i:s A", strtotime($row['fecha']));
						echo "<TD align='center' >". $row['execID'] ."</TD>";
						echo "<TD align='center' ><a href='runs.php?user=". $row['userID']  ."'>". $nick   ."</a> </TD>";
						echo "<TD align='center' >". $row['LANG']   ."</TD>";
						echo "<TD align='center' >". $row['status']   ."</TD>";
						echo "<TD align='center' ><b>". $row['tiempo'] / 1000  ."</b> Segundos </TD>";
						echo "<TD align='center' >". $cuando   ." </TD>";
						echo "</TR>";

				?>		
				</tbody>
				</table>
			</div>
			&nbsp;
		</div>
		
		<?php
		
		echo "<textarea name=\"code\" class=\"$sintaxcolor\" cols=\"60\" rows=\"10\">{$codigo}</textarea>";
	}


	    $asdf =  mysql_real_escape_string($_REQUEST["execID"]);
		$consulta = "select * from Ejecucion where BINARY ( execID = '{$asdf}' )";
		$resultado = mysql_query($consulta) or die('Algo anda mal: ' . mysql_error());
	
		if(mysql_num_rows($resultado) != 1){
			echo "<b>Este codigo no existe</b>";
			return;
		}
		$row = mysql_fetch_array($resultado);
		mostrarCodigo($row['LANG'], $_REQUEST["execID"] , $row);
?>
	</div>

	<?php include_once("post_footer.php"); ?>

